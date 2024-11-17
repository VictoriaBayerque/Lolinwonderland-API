# Lolinwonderland.
Sitio web de reseñas literarias utilizando client side rendering con JavaScript.

# Importar la base de datos.
Importar el archivo 'lolinwonderland_db.sql' dentro de PHPMyAdmin.

# Usuario admin.
Username: webadmin
Password: admin

# Dinámica de la web.
Es un sitio donde se recopilan reseñas literarias de diferentes autores. Se puede acceder al listado completo de libros almacenados en la base de datos, así como ingresar y ver en detalle individualmete. Además, se pueden modificar datos o eliminar cualquiera de ellos. Lo mismo sucede con los autores ingresados en la base de datos, los cuales pueden verse juntos o por separado y modificarse o eliminarse, según se requiera.
Al crear un libro, debe ingresarse el autor mediante un select, por lo que será necesario crear primero el autor de no encontrarse en la base de datos aún.
Las funciones de añadir, modificar y eliminar tanto libros como autores solo podrán ser llevadas a cabo por el usuario administrador logueado. Si no se está logueado, ni siquiera podrán verse los botones correspondientes a cada función y/o vista.

# Endpoints.
La API cuenta con distintos endpoints para poder manipular los datos almacenados en la base de datos.
- DATO IMPORTANTE a tener en cuenta.
En el archivo "public/statics/JS/app.js", la URL base (es decir: 'http://localhost/Web2/3er-entrega/api/') está asignada a la constante apiUrl, por lo que debe ser modificada antes de correr el código.

- endpoint: 'library' y verbo: 'GET'.
Con este endpoint y utilizando un verbo GET, llamamos a la función getAllBooks de LibraryController y conseguimos traer todos los libros que esten en la tabla de library.
Ejemplo:

        http://localhost/Web2/3er-entrega/api/library
                
        (recordando cambiar las carpetas entre 'localhost/' y '/api' según se tenga guardado de manera local dentro de htdocs en la declaracion de la constante apiUrl en app.js)

- endpoint: 'library/:id', verbo: 'GET'.
Con este endpoint y utilizando un verbo GET, llamando a la función getBook de LibraryController y conseguimos traer, de la base de datos, aquel libro que posea el id pasado por parámetro.
Ejemplo:

                
        http://localhost/Web2/3er-entrega/api/library/1
                
        (recordando cambiar las carpetas entre 'localhost/' y '/api' según se tenga guardado de manera local dentro de htdocs en la declaracion de la constante apiUrl)

- endpoint: 'library', verbo: 'POST'.
Con este endpoint y utilizando un verbo POST, llamaremos a la función addBook de LibraryController para poder añadir un libro nuevo a la tabla de library en la base de datos.
Ejemplo:

                
        http://localhost/Web2/3er-entrega/api/library

        (recordando cambiar las carpetas entre 'localhost/' y '/api' según se tenga guardado de manera local dentro de htdocs en la declaracion de la constante apiUrl)

- endpoint: 'library/:id', verbo: 'DELETE'.
Con este endpoint y utilizando el verbo DELETE, llamaremos a la función deleteBook de LibraryController para poder eliminar el libro correspondiente al id pasado por parámetro de la base de datos.
Ejemplo:

        http://localhost/Web2/3er-entrega/api/library/1
            
        (recordando cambiar las carpetas entre 'localhost/' y '/api' según se tenga guardado de manera local dentro de htdocs en la declaracion de la constante apiUrl)
                
- endpoint: 'library/:id', verbo: 'PUT'.
Con este endpoint y utilizando el verbo PUT, llamaremos a la función updateBook de LibraryController para poder cambiar todos los datos -a excepción de la imagen- del libro de la base de datos que corresponda al id proporcionado por parámetro.
Ejemplo:

        http://localhost/Web2/3er-entrega/api/library/1
            
        (recordando cambiar las carpetas entre 'localhost/' y '/api' según se tenga guardado de manera local dentro de htdocs en la declaracion de la constante apiUrl)

- endpoint: 'authors' y verbo: 'GET'.
Con este endpoint y utilizando un verbo GET, llamamos a la función getAll de AuthorsController y conseguimos traer todos los autores que esten en la tabla de authors.
Ejemplo:

        http://localhost/Web2/3er-entrega/api/authors
                
        (recordando cambiar las carpetas entre 'localhost/' y '/api' según se tenga guardado de manera local dentro de htdocs en la declaracion de la constante apiUrl en app.js)

- endpoint: 'authors/:id', verbo: 'GET'.
Con este endpoint y utilizando un verbo GET, llamando a la función getAuthor de AuthorsController y conseguimos traer, de la base de datos, aquel autor que posea el id pasado por parámetro.
Ejemplo:

        http://localhost/Web2/3er-entrega/api/authors/1
                
        (recordando cambiar las carpetas entre 'localhost/' y '/api' según se tenga guardado de manera local dentro de htdocs en la declaracion de la constante apiUrl)

- endpoint: 'authors', verbo: 'POST'.
Con este endpoint y utilizando un verbo POST, llamaremos a la función addAuthor de AuthorsController para poder añadir un autor nuevo a la tabla de autores en la base de datos.
Ejemplo:

        http://localhost/Web2/3er-entrega/api/authors

        (recordando cambiar las carpetas entre 'localhost/' y '/api' según se tenga guardado de manera local dentro de htdocs en la declaracion de la constante apiUrl)

- endpoint: 'authors/:id', verbo: 'DELETE'.
Con este endpoint y utilizando el verbo DELETE, llamaremos a la función deleteAuthor de AuthorController para poder eliminar el autor correspondiente al id pasado por parámetro de la base de datos.
Ejemplo:

        http://localhost/Web2/3er-entrega/api/authors/1
            
        (recordando cambiar las carpetas entre 'localhost/' y '/api' según se tenga guardado de manera local dentro de htdocs en la declaracion de la constante apiUrl)
                
- endpoint: 'authors/:id', verbo: 'PUT'.
Con este endpoint y utilizando el verbo PUT, llamaremos a la función updateAuthor de AuthorsController para poder cambiar los datos del autor -a excepción de la imagen- de la base de datos que corresponda al id proporcionado por parámetro.
Ejemplo:

        http://localhost/Web2/3er-entrega/api/authors/1
            
        (recordando cambiar las carpetas entre 'localhost/' y '/api' según se tenga guardado de manera local dentro de htdocs en la declaracion de la constante apiUrl)

# Adjuntos.
Adjuntos están el archivo SQL exportado de PHPMyAdmin y un diagrama que muestra la relación entre las tablas utilizando FK.