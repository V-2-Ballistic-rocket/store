<?php

use App\common\Validators\ProductSchemeValidator;
use App\common\Validators\ProductValidator;
use App\common\Validators\UserSchemeValidator;
use App\common\Validators\UserValidator;
use App\Controller\ProductController;
use App\Controller\UserController;
use App\Core\Body;
use App\Core\Logger;
use App\Core\Request;
use App\Core\Route;
use App\Core\Router;
use App\Core\Uri;
use App\Service\DbDto;
use App\Service\Product\ProductDbManager;
use App\Service\User\UserDbManager;
require_once '../conf/settings.php';
header('Content-Type: application/json; charset=utf-8');

require_once "../vendor/autoload.php";

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$uri = new Uri($uri);

$method = $_SERVER['REQUEST_METHOD'];

$dbManagerDTO = new DbDto(
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

$productDBManager = new ProductDbManager;
$productController = new ProductController($productValidator, $productSchemeValidator, $productDBManager);
$userDBManager = new UserDbManager;
$userController = new UserController($userDBManager, $userValidator, $userSchemeValidator);

$productRoute = new Route(PRODUCT_URI, $productController, $request->getBody());
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
    if (LOGGER_ON) {
        $logger->writeLog(
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getFile(),
            $exception->getLine(),
            LOG_FILE
        );
    }
    http_response_code($exception->getCode());
    echo json_encode(
        [
            "success" => false,
            "response" => [$exception->getMessage()]
        ],
        JSON_UNESCAPED_UNICODE
    );
}