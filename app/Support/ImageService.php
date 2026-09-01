<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageService
{
    /**
     * Largura máxima (px) para imagens de upload. Fotos de câmera/celular
     * costumam ter 4000px+; redimensionar para 1920px reduz drasticamente o
     * peso final sem perda perceptível na web.
     */
    public const MAX_UPLOAD_WIDTH = 1920;

    /**
     * Qualidade padrão (0-100) da conversão para WebP.
     */
    public const WEBP_QUALITY = 85;

    /**
     * Salva um upload de imagem convertido para WebP no disco R2.
     *
     * - Auto-orientação EXIF (fotos de celular);
     * - Redimensiona para no máximo MAX_UPLOAD_WIDTH de largura;
     * - Converte para WebP (WEBP_QUALITY);
     * - Salva no R2 (nome aleatório `.webp`, ou $name se informado).
     *
     * @param  UploadedFile  $file  Arquivo enviado (UploadedFile/TemporaryUploadedFile)
     * @param  string  $directory  Pasta de destino (ex.: properties/123)
     * @param  int|null  $quality  Qualidade WebP (0-100). Default: WEBP_QUALITY
     * @param  string|null  $name  Nome fixo do arquivo (ex.: logo.webp). Default: aleatório
     * @return string Caminho relativo salvo (ex.: properties/123/abc.webp)
     */
    public static function storeAsWebp(UploadedFile $file, string $directory, ?int $quality = null, ?string $name = null): string
    {
        $disk = Storage::disk('r2');

        $manager = new ImageManager(new Driver);
        $image = $manager->read($file->getRealPath());

        // A orientação EXIF é corrigida automaticamente pelo decoder (autoOrientation)

        // Redimensiona mantendo a proporção, se exceder a largura máxima
        if ($image->width() > self::MAX_UPLOAD_WIDTH) {
            $image->scale(self::MAX_UPLOAD_WIDTH);
        }

        // Converte para WebP
        $binary = $image->toWebp($quality ?? self::WEBP_QUALITY);

        // Nome do arquivo: fixo (se informado) ou aleatório
        $fileName = $name ?? Str::random(32).'.webp';
        $path = trim($directory, '/').'/'.$fileName;

        $disk->put($path, (string) $binary, ['visibility' => 'public']);

        return $path;
    }

    /**
     * Gera (e cacheia localmente) uma miniatura em WebP a partir de uma
     * imagem armazenada no R2.
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
        $filename = md5($path.$width.$height).'.webp';
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

        // Gera o binário WebP
        $binary = $image->toWebp(self::WEBP_QUALITY);

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

        // Remove thumbs WebP (atuais) e JPG (legado)
        $pattern = ! empty($path) ? $cachePath.'/'.md5($path).'.*' : $cachePath.'/*.{webp,jpg}';

        foreach (glob($pattern, GLOB_BRACE) ?: [] as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
