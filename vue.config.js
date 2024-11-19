module.exports = {
        devServer: {
            proxy: {
                '/api': {
                target: 'http://127.0.0.1:8000',  // URL de tu backend
                changeOrigin: true,               // Cambiar el origen de la solicitud
                secure: false,                    // Desactivar SSL (si es necesario)
                logLevel: 'debug',                // Esto es útil para depurar problemas
            },
        },
    },
};
