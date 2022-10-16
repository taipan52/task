<?


header("Access-Control-Allow-Orgin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json");

//error_reporting(0);

require_once 'config.php';
require_once 'Route.php';

$route = new Task\Api\Route();
$handler = $route->getHandler();

if($handler->last_error) {
    $route->responce(500, $handler->last_error);
}
else {

    $route->responce(200, $handler->getMessage(), $handler->getResult());
}

//print_r($handler);