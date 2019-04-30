## Instrucciones PoccelWEB

- [Descargar e instalar composer](https://getcomposer.org/)
- Para confirmar su instalación escribimos el comando **composer –V** para ver la versión instalada.

- Para ver los detalles de configuración y uso de twigbridge ver: https://github.com/rcrowe/TwigBridge
- Para instalar dependencias del proyecto utilizar: **composer update**
- Para montar la app y poder verla en el navegador usar el comando: **php artisan serve**

En caso de que le aparezca un error 500, puede requerir:

- Elimine la carpeta _vendor_ e instale las dependencias usando **composer install**

- En caso de no existir, cree un archivo .env (puede copiar el archivo .env.example)

- Genere una clave para la aplicación  ejecutando **php artisan key:generate**