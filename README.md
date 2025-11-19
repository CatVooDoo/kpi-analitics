# Настройка vite.config.js 
firewall-cmd --permanent --add-port=5173/tcp
firewall-cmd --reload

``server: {
  port: 5173,
  host: '0.0.0.0' 
}``

``
    server: {
        port: 5173,
        host: '0.0.0.0',
        allowedHosts: [
            'develop.luxecorp.ru',
            '.luxecorp.ru'
        ]
    }
``