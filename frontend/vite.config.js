import {fileURLToPath, URL} from 'node:url'

import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
    plugins: [
        vue(),
        vueDevTools(),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./src', import.meta.url))
        },
    },
    server: {
        port: 5173,
        host: '0.0.0.0',
        allowedHosts: [
            'develop.luxecorp.ru',
            '.luxecorp.ru'
        ]
    },
    proxy: {
        '/local/api/dev/backend': {
            target: 'http://develop.luxecorp.ru',
            changeOrigin: true,
            secure: false
        }
    }

})
