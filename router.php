<?php

require_once "libs/router.php";
require_once "app/controllers/library.api.controller.php";
require_once "app/controllers/authors.api.controller.php";
require_once "app/controllers/user.api.controller.php";


$router = new Router();

$router->addRoute('library','GET', 'LibraryController', 'getAllBooks');
$router->addRoute('library/:id', 'GET', 'LibraryController', 'getBook');
$router->addRoute('library', 'POST', 'LibraryController', 'addBook');
$router->addRoute('library/:id', 'DELETE', 'LibraryController', 'deleteBook');
$router->addRoute('library/:id', 'PUT', 'LibraryController', 'updateBook');

$router->addRoute('authors','GET', 'AuthorsController', 'getAll');
$router->addRoute('authors/:id', 'GET', 'AuthorsController', 'getAuthor');
$router->addRoute('authors', 'POST', 'AuthorsController', 'addAuthor');
$router->addRoute('authors/:id', 'DELETE', 'AuthorsController', 'deleteAuthor');
$router->addRoute('authors/:id', 'PUT', 'AuthorsController', 'updateAuthor');

$router->addRoute('user/token', 'GET', 'UserController', 'getPermissionWithToken');
$router->addRoute('user/token', 'POST', 'UserController', 'getSessionWithLogin');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
