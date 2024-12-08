<?php
require_once "../app/models/Model.php";
require_once "../app/models/User.php";
require_once "../app/controllers/UserController.php";
require_once "../app/controllers/PostController.php";
require_once "../app/models/Post.php";

//set our env variables
$env = parse_ini_file('../.env');
define('DBNAME', $env['DBNAME']);
define('DBHOST', $env['DBHOST']);
define('DBUSER', $env['DBUSER']);
define('DBPASS', $env['DBPASS']);

use app\controllers\UserController;

//get uri without query strings
$uri = strtok($_SERVER["REQUEST_URI"], '?');

//get uri pieces
$uriArray = explode("/", $uri);
//0 = ""
//1 = users
//2 = 1


//get all or a single user
if ($uriArray[1] === 'api' && $uriArray[2] === 'users' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    //only id
    $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
    $userController = new UserController();

    if ($id) {
        $userController->getUserByID($id);
    } else {
        $userController->getAllUsers();
    }
}

//save user
if ($uriArray[1] === 'api' && $uriArray[2] === 'users' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController = new UserController();
    $userController->saveUser();
}

//update user
if ($uriArray[1] === 'api' && $uriArray[2] === 'users' && $_SERVER['REQUEST_METHOD'] === 'PUT') {
    $userController = new UserController();
    $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
    $userController->updateUser($id);
}

//delete user
if ($uriArray[1] === 'api' && $uriArray[2] === 'users' && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $userController = new UserController();
    $id = isset($uriArray[3]) ? intval($uriArray[3]) : null;
    $userController->deleteUser($id);
}

//views


if ($uri === '/users-add' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersAddView();
}

if ($uriArray[1] === 'users-update' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersUpdateView();
}

if ($uriArray[1] === 'users-delete' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersDeleteView();
}

if ($uriArray[1] === '' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $userController = new UserController();
    $userController->usersView();
}

use app\controllers\PostController;

if ($uri === '/posts' && $method === 'GET') {
    // List all posts
    $controller = new app\controllers\PostController();
    $controller->index();
}

if ($uri === '/posts/create' && $method === 'GET') {
    // Display the create post form
    $controller = new app\controllers\PostController();
    $controller->create();
} 

if ($uri === '/posts/store' && $method === 'POST') {
    // Handle storing a new post
    $controller = new app\controllers\PostController();
    $controller->store();
} 

if (preg_match('#^/posts/edit/(\d+)$#', $uri, $matches) && $method === 'GET') {
    // Display the edit form for a specific post
    $controller = new app\controllers\PostController();
    $controller->edit($matches[1]);
} 

if (preg_match('#^/posts/update/(\d+)$#', $uri, $matches) && $method === 'POST') {
    // Handle updating a specific post
    $controller = new app\controllers\PostController();
    $controller->update($matches[1]);
} 

if (preg_match('#^/posts/delete/(\d+)$#', $uri, $matches) && $method === 'POST') {
    // Handle deleting a specific post
    $controller = new app\controllers\PostController();
    $controller->delete($matches[1]);
} 

else {
    // Default route or 404
    http_response_code(404);
    echo 'Page not found';
}

include '../public/assets/views/notFound.html';
exit();

?>


