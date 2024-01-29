<?php

use App\Core\Uri;
use App\Core\Body;
use App\Core\Route;
use App\Core\Logger;
use App\Core\Router;
use App\Core\Request;
use App\Service\DBManager;
use App\Controller\UserController;
use App\Controller\ProductController;
use App\Service\DBDTO;
use App\Service\ProductDBManager;
use App\Service\UserDBManager;
use App\Service\Validator\User\UserValidator;
use App\Service\Validator\Product\ProductValidator;
use App\Service\Validator\User\UserSchemeValidator;
use App\Service\Validator\Product\ProductSchemeValidator;

header('Content-Type: application/json; charset=utf-8');

require_once "../vendor/autoload.php";

const PRODUCT_URI = 'product';
const USER_URI = 'user';
const GET_METHOD = 'GET';
const POST_METHOD = 'POST';
const PATCH_METHOD = 'PATCH';
const PUT_METHOD = 'PUT';
const DELETE_METHOD = 'DELETE';
const ACTION_GET_ENTITY = 'getEntity';
const ACTION_ADD_ENTITY = 'addEntity';
const ACTION_DELETE_ENTITY = 'deleteEntity';
const ACTION_EDIT_ENTITY = 'editEntity';
const LOG_FILE = '../var/log/Logs.csv';
const TO_DB_PATH = '../public/database.sql';
const DATABASE_VENDOR = 'pgsql';
const DATABASE_HOST = 'database';
const DATABASE_NAME = 'app';
const DATABASE_USER = 'postgres';
const DATABASE_PASSWORD = 'postgres';

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$uri = new Uri($uri);

$method = $_SERVER['REQUEST_METHOD'];

$dbManagerDTO = new DBDTO(
    DATABASE_VENDOR,
    DATABASE_HOST,
    DATABASE_NAME,
    DATABASE_USER,
    DATABASE_PASSWORD,
    TO_DB_PATH,
    $uri->getId()
);

$body = new Body(json_decode(file_get_contents('php://input'), true), $dbManagerDTO);

$logger = new Logger;

$router = new Router;
$request = new Request($uri, $method, $body);

$productValidator = new ProductValidator;
$productSchemeValidator = new ProductSchemeValidator;

$userValidator = new UserValidator;
$userSchemeValidator = new UserSchemeValidator;

$productDBManager = new ProductDBManager;
$productConroller = new ProductController($productValidator, $productSchemeValidator, $productDBManager);
$userDBManager = new UserDBManager;
$userController = new UserController($userDBManager, $userValidator, $userSchemeValidator);

$productRoute = new Route(PRODUCT_URI, $productConroller, $request->getBody());
$productRoute -> addMethod(GET_METHOD, ACTION_GET_ENTITY);
$productRoute -> addMethod(POST_METHOD, ACTION_ADD_ENTITY);
$productRoute -> addMethod(DELETE_METHOD, ACTION_DELETE_ENTITY);
$productRoute -> addMethod(PATCH_METHOD, ACTION_EDIT_ENTITY);
$productRoute -> addMethod(PUT_METHOD, ACTION_EDIT_ENTITY);

$userRoute = new Route(USER_URI, $userController, $request->getBody());
$userRoute -> addMethod(GET_METHOD, ACTION_GET_ENTITY);
$userRoute -> addMethod(POST_METHOD, ACTION_ADD_ENTITY);
$userRoute -> addMethod(DELETE_METHOD, ACTION_DELETE_ENTITY);
$userRoute -> addMethod(PATCH_METHOD, ACTION_EDIT_ENTITY);
$userRoute -> addMethod(PUT_METHOD, ACTION_EDIT_ENTITY);

$router -> addRoute($productRoute);
$router -> addRoute($userRoute);

try{
    $result = $router->routeToController($request->getUri(), $request->getMethod());

    if (gettype($result) === 'object')
    {
        echo json_encode($result->getArray());
    }
    else
    {
        echo json_encode($result);
    }
}
catch (\Throwable $exception)
{
    $logger->writeLog(
        $exception->getMessage(),
        $exception->getCode(),
        $exception->getFile(),
        $exception->getLine(),
        LOG_FILE
    );
    http_response_code($exception->getCode());
    echo json_encode(
        [
            "success" => false,
            "response" => [$exception->getMessage()]
        ],
        JSON_UNESCAPED_UNICODE
    );
}