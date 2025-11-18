import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  root: 'source',
  build: {
    outDir: '../build_local',
    emptyOutDir: false,
    rollupOptions: {
      input: resolve(__dirname, 'source/resources/js/app.js'),
      output: {
        entryFileNames: 'assets/[name].js',
        chunkFileNames: 'assets/[name].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith('.css')) {
            return 'assets/app.css';
          }
          return 'assets/[name][extname]';
        },
      },
    },
  },
  resolve: {
    alias: {
      '@': resolve(__dirname, './source'),
    },
  },
});

