<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageService
{
    /**
     * Gera (e cacheia localmente) uma miniatura a partir de uma imagem
     * armazenada no R2.
     *
     * O arquivo original é lido do R2, a miniatura é gerada via Intervention
     * e salva em public/storage/cache (disco local), retornando uma URL pública.
     *
     * @return string URL pública da miniatura (ou fallback)
     */
    public static function makeThumb(string $path, int $width, ?int $height = null): string
    {
        // Disco padrão do sistema (Cloudflare R2)
        $disk = Storage::disk('r2');

        // Se o arquivo não existe no R2
        if (! $disk->exists($path)) {
            return asset('theme/images/image.jpg');
        }

        $cachePath = public_path('storage/cache');
        $filename = md5($path.$width.$height).'.jpg';
        $cachedFile = $cachePath.'/'.$filename;

        // ✅ retorna o cache local se já existir
        if (file_exists($cachedFile)) {
            return asset('storage/cache/'.$filename);
        }

        if (! is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        // Lê arquivo binário do R2
        $original = $disk->get($path);

        // Inicializa o Intervention v3
        $manager = new ImageManager(new Driver);

        // Carrega imagem (binário)
        $image = $manager->read($original);

        // Redimensiona
        if ($height) {
            $image = $image->cover($width, $height);
        } else {
            // Mantém proporção
            $image = $image->scale($width);
        }

        // Gera o binário JPEG
        $binary = $image->toJpeg(85);

        // Salva miniatura no cache local
        file_put_contents($cachedFile, $binary);

        return asset('storage/cache/'.$filename);
    }

    /**
     * Limpa o cache local de miniaturas.
     *
     * @param  string|null  $path  Caminho da imagem original (limpa apenas suas thumbs)
     */
    public static function flush(?string $path = null): void
    {
        $cachePath = public_path('storage/cache');

        if (! is_dir($cachePath)) {
            return;
        }

        if (! empty($path)) {
            $hash = md5($path);
            foreach (glob($cachePath.'/'.$hash.'*.jpg') as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }

            return;
        }

        foreach (glob($cachePath.'/*.jpg') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
