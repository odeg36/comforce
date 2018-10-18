symfony
========

INSTRUCCIONES PARA EJECUTAR EL PROYECTO


Introducción:

    • El proyecto está desarrollado en Symfony 3
    • Se uso php 7.1
    • Motor de base de datos Mysql
        ◦ Nombre: comforce
        ◦ Usuario: root
    • Se utiliza Sonata Admin Bundle para la creación del área administrativa

Pasos:

    1) Clonar el proyecto de la url https://github.com/odeg36/comforce
    2) Según documentación de Symfony crear y dar permisos de lectura y escritura a las carpetas “var/cache” y “var/logs”
    3) Crear una base de datos con nombre “comforce”
    4) Ejecutar en la raiz del proyecto el comando “composer install” y definir los datos del archivo parameters.ini cuando los pidan.
    5) Ejecutar en la raiz del proyecto el comando “php bin/console doctrine:schema:create”
    6) Ejecutar en la raiz del proyecto el comando “php bin/console doctrine:fixtures:load” y presionar “y” para aceptar la ejecución  (Este comando creará un usuario administrador y las sedes)
    7) Ejecutar el proyecto ya sea creando un host virtual o con el comando “php bin/console server:run”
    8) Ingresar al sistema con
        I. Usuario: admin
        II. Password: admin


Se encuentrá la posibilidad de gestionar: Usuarios, procesos y sedes.

Al crear un proceso y verlo en la lista o en el detalle, se ejecuta la función de twig “cambioADolares” que cambia el presupuesto ingresado a dolares según la tasa representativa del mercado (TRM) mediante el llamado a un API.

Se genera un número de proceso autoincremental basado en 8 caracteres, que empieza por el 00000001, continua con el 00000002, y asi sucesivamente.

La fecha de creación se crea automaticamente mediante @Gedmo\Timestampable

En la lista de procesos existen filtros por: numero de proceso, sede y fecha de creación.

Para todos los titulos y labels se utilizo el archivo de traducción para el locale “es”, ubicado en el bundle AdminBundle.

Las validaciones se encuentran en cada campo del formulario.
