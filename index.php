<?php

// On génère une constante contenant le chemin vers la racine publique du projet (on enlève le index.php)
define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));


// On appelle le modèle et le contrôleur principaux
require_once(ROOT.'app/Model.php');
require_once(ROOT.'app/Controller.php');

// On sépare les paramètres et on les met dans le tableau $params
$params = explode('/', $_GET['p']);


// Si au moins 1 paramètre existe
if($params[0] != "") {
    // On sauvegarde le 1er paramètre dans $controller en mettant sa 1ère lettre en majuscule
    $controller = ucfirst($params[0]);

    // On sauvegarde le 2ème paramètre dans $action si il existe, sinon index
    $action = isset($params[1]) ? $params[1] : 'index';

    // On appelle le contrôleur
    require_once(ROOT.'controllers/'.$controller.'.php');

    // On instancie le contrôleur
    $controller = new $controller();

    if(method_exists($controller, $action)) {
        // On supprime les 2 premiers paramètres pour ne pas les avoir en doublon
        unset($params[0]);
        unset($params[1]);

        // On appelle la méthode
        call_user_func_array([$controller,$action], $params);
        // Pour avoir un 3eme paramètre dans le routeur la fonction ci-dessus remplace : $controller->$action();

    } else {
        // On envoie le code réponse 404
        die();
        http_response_code(404);
        echo "La page recherchée n'existe pas";
    }
} else {
    // Ici aucun paramètre n'est défini
    // On appelle le contrôleur par défaut
    require_once(ROOT . 'controllers/Employees.php');

    // On instancie le contrôleur
    $controller = new Employees();

    // On appelle la méthode index
    $controller->getAll();
}