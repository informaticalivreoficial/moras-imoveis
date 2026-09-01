<?php

namespace App\Console\Commands;

use GuzzleHttp\Promise\Each;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateStorageToR2 extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'r2:migrate
                            {--from=storage/app/public : Pasta local de origem (public)}
                            {--dry-run : Apenas lista os arquivos, sem enviar}
                            {--concurrency=15 : Número de uploads simultâneos}
                            {--delete : Remove o arquivo local após enviar ao R2}';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Envia os arquivos do storage local (public) para o Cloudflare R2';

    /**
     * Execute o comando.
     */
    public function handle()
    {
        $from = ltrim(rtrim($this->option('from'), '/'), '/');
        $dryRun = $this->option('dry-run');
        $delete = $this->option('delete');
        $concurrency = (int) $this->option('concurrency');

        if (! is_dir($from)) {
            $this->error("A pasta de origem não existe: {$from}");

            return 1;
        }

        $disk = Storage::disk('r2');
        $client = $disk->getClient();
        $bucket = $disk->getConfig()['bucket'] ?? null;
        $root = rtrim((string) ($disk->getConfig()['root'] ?? ''), '/');

        $this->info("Origem: {$from}");
        $this->info('Destino: R2 (bucket: '.$bucket.', root: '.$root.')');
        $this->info('');

        $files = $this->recursiveFiles($from);

        if (empty($files)) {
            $this->info('Nenhum arquivo encontrado.');

            return 0;
        }

        // Lista única de objetos já presentes no R2 (evita 1 chamada por arquivo)
        $existing = $disk->allFiles();

        $toSend = [];
        $skipped = 0;

        foreach ($files as $file) {
            // Caminho relativo à pasta public (ex.: properties/1/img.jpg)
            $relative = ltrim(substr($file, strlen($from) + 1), '/');

            // Ignora o cache local de thumbs, temporários do Livewire e arquivos de controle
            if (str_starts_with($relative, 'cache/')
                || str_starts_with($relative, 'livewire-tmp/')
                || str_starts_with($relative, 'defaults/')
                || $relative === '.gitignore'
            ) {
                continue;
            }

            if (in_array($relative, $existing, true)) {
                $skipped++;

                continue;
            }

            $toSend[] = ['file' => $file, 'relative' => $relative];
        }

        $this->info('Arquivos a enviar: '.count($toSend));
        $this->info('Já existem no R2 (ignorados): '.$skipped);
        $this->info('');

        if ($dryRun) {
            foreach ($toSend as $item) {
                $this->line("  [dry-run] {$item['relative']}");
            }

            return 0;
        }

        if (empty($toSend)) {
            $this->info('Nada para enviar.');

            return 0;
        }

        $bar = $this->output->createProgressBar(count($toSend));
        $bar->start();

        try {
            // Processa em lotes para não estourar o limite de file handles (fopen)
            foreach (array_chunk($toSend, 30) as $chunk) {
                $promises = [];
                $streams = [];
                $fileByKey = [];

                foreach ($chunk as $item) {
                    $key = $root !== '' ? $root.'/'.$item['relative'] : $item['relative'];

                    $stream = fopen($item['file'], 'r');
                    $streams[$item['relative']] = $stream;
                    $fileByKey[$item['relative']] = $item['file'];

                    $promises[$item['relative']] = $client->putObjectAsync([
                        'Bucket' => $bucket,
                        'Key' => $key,
                        'Body' => $stream,
                        'ContentType' => mime_content_type($item['file']) ?: 'application/octet-stream',
                    ]);
                }

                Each::ofLimit(
                    $promises,
                    max(1, $concurrency),
                    function ($value, $idx) use ($bar, $delete, &$streams, $fileByKey) {
                        // Fecha o stream assim que o upload termina (libera o file handle)
                        if (isset($streams[$idx])) {
                            fclose($streams[$idx]);
                            unset($streams[$idx]);
                        }

                        $bar->advance();

                        if ($delete && isset($fileByKey[$idx])) {
                            unlink($fileByKey[$idx]);
                        }
                    }
                )->wait();

                // Garante o fechamento dos streams restantes do lote
                foreach ($streams as $stream) {
                    fclose($stream);
                }
            }
        } catch (\Throwable $e) {
            $this->newLine(2);
            $this->error('Falha durante a migração: '.$e->getMessage());

            return 1;
        }

        $bar->finish();
        $this->newLine(2);

        $this->info('Migração concluída com sucesso!');

        return 0;
    }

    /**
     * Retorna todos os arquivos de uma pasta, recursivamente.
     */
    private function recursiveFiles(string $dir): array
    {
        $result = [];

        foreach (scandir($dir) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $dir.'/'.$item;

            if (is_dir($path)) {
                $result = array_merge($result, $this->recursiveFiles($path));
            } elseif (is_file($path)) {
                $result[] = $path;
            }
        }

        return $result;
    }
}
