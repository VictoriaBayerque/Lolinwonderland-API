# Lolinwonderland.
Sitio web de reseñas literarias utilizando server side rendering con PHP y MySQL.

# Importar la base de datos.
Importar el archivo 'lolinwonderland_db.sql' dentro de PHPMyAdmin.

# Usuario admin.
Username: webadmin
Password: admin

# Dinámica de la web.
Es un sitio donde se recopilan reseñas literarias de diferentes autores. Se puede acceder al listado completo de libros almacenados en la base de datos, así como ingresar y ver en detalle individualmete. Además, se pueden modificar datos o eliminar cualquiera de ellos. Lo mismo sucede con los autores ingresados en la base de datos, los cuales pueden verse juntos o por separado y modificarse o eliminarse, según se requiera.
Al crear un libro, debe ingresarse el autor mediante un select, por lo que será necesario crear primero el autor de no encontrarse en la base de datos aún.
Las funciones de añadir, modificar y eliminar tanto libros como autores solo podrán ser llevadas a cabo por el usuario administrador logueado. Si no se está logueado, ni siquiera podrán verse los botones correspondientes a cada función y/o vista.

# Adjuntos.
Adjuntos están el archivo SQL exportado de PHPMyAdmin y un diagrama que muestra la relación entre las tablas utilizando FK.