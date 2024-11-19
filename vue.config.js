module.exports = {
        devServer: {
            proxy: {
                '/api': {
                target: 'http://farmaciaesperanza.top',  // URL de tu backend
                changeOrigin: true,               // Cambiar el origen de la solicitud
                secure: false,                    // Desactivar SSL (si es necesario)
                logLevel: 'debug',                // Esto es útil para depurar problemas
            },
        },
    },
};
