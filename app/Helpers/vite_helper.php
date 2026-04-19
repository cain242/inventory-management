<?php

/**
 * Vite Helper
 * ------------------------------------------------------------------
 * View'larda Tailwind + JS asset'lerini yüklemek için kullanılır.
 *
 * Geliştirme modunda: http://localhost:5173/ üzerinden HMR aktif
 * Production modunda: public/build/.vite/manifest.json üzerinden
 *                     versiyonlanmış dosyalar yüklenir.
 *
 * Kullanım:
 *   <?= vite(['resources/css/app.css', 'resources/js/app.js']) ?>
 */

if (! function_exists('vite')) {
    function vite(array $entries): string
    {
        $devServerUrl = 'http://localhost:5173';
        $isDev = false;

        // Geliştirme modunda mıyız?
        if (ENVIRONMENT === 'development') {
            // Vite dev server çalışıyor mu kontrol et
            $ctx = stream_context_create(['http' => ['timeout' => 0.2]]);
            $hotCheck = @file_get_contents($devServerUrl . '/@vite/client', false, $ctx);
            $isDev = $hotCheck !== false;
        }

        $html = '';

        if ($isDev) {
            // Dev modu — Vite HMR client + entry dosyaları
            $html .= '<script type="module" src="' . $devServerUrl . '/@vite/client"></script>' . "\n";
            foreach ($entries as $entry) {
                $html .= '<script type="module" src="' . $devServerUrl . '/' . $entry . '"></script>' . "\n";
            }
            return $html;
        }

        // Production modu — manifest'ten oku
        $manifestPath = FCPATH . 'build/.vite/manifest.json';
        if (! file_exists($manifestPath)) {
            // Henüz build yapılmamış
            if (ENVIRONMENT === 'development') {
                $html .= '<!-- Vite: dev server kapalı ve build yok. `npm run dev` veya `npm run build` çalıştır. -->';
            }
            return $html;
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);

        foreach ($entries as $entry) {
            if (! isset($manifest[$entry])) {
                continue;
            }

            $item = $manifest[$entry];
            $file = $item['file'];

            if (str_ends_with($file, '.css')) {
                $html .= '<link rel="stylesheet" href="' . base_url('build/' . $file) . '">' . "\n";
            } else {
                $html .= '<script type="module" src="' . base_url('build/' . $file) . '"></script>' . "\n";
            }

            // Beraberinde yüklenen CSS dosyaları (JS entry'nin import ettiği)
            foreach ($item['css'] ?? [] as $css) {
                $html .= '<link rel="stylesheet" href="' . base_url('build/' . $css) . '">' . "\n";
            }
        }

        return $html;
    }
}
