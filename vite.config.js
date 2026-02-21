import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig(({ mode }) => ({
  root: 'nexus',
  base: './',

  build: {
    outDir: 'assets',
    emptyOutDir: false,
    minify: mode === 'production' ? 'esbuild' : false,

    rollupOptions: {
      input: {
        // CSS-only entries — prefixed with 'css-' so their empty JS wrapper
        // chunks don't conflict with the actual JS entry chunks below.
        'css-nexus-main':        resolve(__dirname, 'nexus/assets/scss/main.scss'),
        'css-nexus-woocommerce': resolve(__dirname, 'nexus/assets/scss/pages/_shop.scss'),
        'css-nexus-dark-mode':   resolve(__dirname, 'nexus/assets/scss/pages/_dark-mode.scss'),
        'css-nexus-elementor':   resolve(__dirname, 'nexus/assets/scss/pages/_elementor.scss'),
        'css-nexus-editor':      resolve(__dirname, 'nexus/assets/scss/pages/_editor.scss'),

        // JS entries — named exactly as the desired output filename.
        'nexus-main':        resolve(__dirname, 'nexus/assets/js/nexus-main.js'),
        'nexus-dark-mode':   resolve(__dirname, 'nexus/assets/js/nexus-dark-mode.js'),
        'nexus-woocommerce': resolve(__dirname, 'nexus/assets/js/nexus-woocommerce.js'),
      },
      output: {
        // CSS assets: strip the 'css-' prefix and the .css extension (re-added via [extname]).
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith('.css')) {
            const baseName = assetInfo.name
              .replace(/\.css$/, '')   // remove extension (added back via [extname])
              .replace(/^css-/, '');   // remove the css- prefix from entry key

            if (mode === 'production') {
              return `css/${baseName}.min[extname]`;
            }
            return `css/${baseName}[extname]`;
          }
          return 'assets/[name][extname]';
        },
        // JS chunks: CSS-only entries produce tiny empty wrapper chunks — route
        // those to a hidden folder so they don't pollute assets/js/.
        entryFileNames: (chunkInfo) => {
          if (chunkInfo.name.startsWith('css-')) {
            return 'js/.css-chunks/[name].js';
          }
          if (mode === 'production') {
            return `js/${chunkInfo.name}.min.js`;
          }
          return `js/${chunkInfo.name}.js`;
        },
        chunkFileNames: 'js/[name].js',
      },
    },

    cssCodeSplit: true,
    sourcemap: mode !== 'production',
    reportCompressedSize: true,
    chunkSizeWarningLimit: 200,
  },

  css: {
    preprocessorOptions: {
      scss: {
        // No global imports here — use @use within each file
      },
    },
    postcss: {
      plugins: [
        require('autoprefixer'),
        ...(mode === 'production' ? [require('cssnano')({ preset: 'default' })] : []),
      ],
    },
  },

  resolve: {
    alias: {
      '@': resolve(__dirname, 'nexus/assets'),
      '@scss': resolve(__dirname, 'nexus/assets/scss'),
      '@js': resolve(__dirname, 'nexus/assets/js'),
    },
  },
}));
