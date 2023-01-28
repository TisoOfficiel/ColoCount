<?php

use App\Model\Route\Route;

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: authorization");

require_once 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    die;
}

session_start();
// On le path du dossier Controller
$controllerDir = dirname(__FILE__) . '/src/Controller';

// On met les fichiers et sous dossier (si existe) dans un tableau
$dirs = scandir($controllerDir);

$controllers = [];

// Pour chaque éléments on ajoute dans un tableau (controller) en ingorants la navigation . et ..
foreach ($dirs as $dir) {
    if ($dir === "." || $dir === "..") {
        continue;
    }
    $controllers[] = "App\\Controller\\" . pathinfo($controllerDir . DIRECTORY_SEPARATOR . $dir)['filename'];

}

$routesObj = [];

// Pour chaque fichier controller
foreach ($controllers as $controller) {

    // On instancie une reflexion class pour chaque controller afin d'obtenir des informations sur cette class (Controller)
    $reflection = new ReflectionClass($controller);
    // On zoom un peu et on prends chaque méthod dans chaque controller
    foreach ($reflection->getMethods() as $method) {
        //On zoom encore pour avoir tout les attributs
        foreach ($method->getAttributes() as $attribute) {
            /** @var Route $route */
            // ON instancie ici la class Route
            $route = $attribute->newInstance();
            //On associe la route au controller
            $route->setController($controller)
                // On attribut le nom de la méthode (d'ou l'importance de mettre l'attribut route juste au dessus de notre method pour pas associer la route a une autre méthod)
                ->setAction($method->getName());
            // On push chaque route dans notre tableau

            $routesObj[] = $route;
        }
    }
}

// A ce stade on sait quoi faire et quand le faire

// ------------------

// On veut maintenant relier ce que l'utilisateur entre à nos routes.

$url = "/" . trim(explode("?", $_SERVER['REQUEST_URI'])[0], "/");

foreach ($routesObj as $route) {
    if (!$route->match($url) || !in_array($_SERVER['REQUEST_METHOD'], $route->getMethods())) {
        continue;
    }

    $controlerClassName = $route->getController();
    $action = $route->getAction();
    $params = $route->mergeParams($url);

    echo [new $controlerClassName, $action](...$params);
    exit();
    
}

echo "NO MATCH";

die;