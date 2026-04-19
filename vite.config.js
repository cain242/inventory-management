import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [tailwindcss()],

  build: {
    // CI4 public klasörüne üretim çıktısı
    outDir: 'public/build',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
    },
  },

  server: {
    host: 'localhost',
    port: 5173,
    strictPort: true,
    cors: true,
    // CI4 dev server'ı 8080'de koşarken Vite assetlerini doğru sunması için
    origin: 'http://localhost:5173',
  },
})
