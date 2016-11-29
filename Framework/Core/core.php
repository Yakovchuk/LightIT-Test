<?php

namespace App\Core;

use Twig_Loader_Filesystem;
use Twig_Environment;

class Core
{
    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * Core constructor.
     * @param string $config
     */
    public function __construct($config = 'config')
    {
        $config = dirname(__FILE__) . "/Config/{$config}.php";
        if ( file_exists($config) ) {
            require_once $config;
        }else{
            'Не могу загрузить файл конфигурации';
            exit();
        }

        $loader = new Twig_Loader_Filesystem(TWIG_TEMPLATES_PATH);
        $this->twig = new Twig_Environment($loader, TWIG_OPTIONS);
    }

    /**
     * Метод определяющий вызов нужного контроллера
     *
     * @param $uri
     */
    public function handleRequest($uri)
    {
		$request = explode('/', $uri);

        $className = CONTROLLERS_PATH . ucfirst(array_shift($request));
        /** @var Controller $controller */
        if (!class_exists($className)) {
            $controller = new Controllers\Home($this);
        }
        else {
            $controller = new $className($this);
        }

        if ( isset($request[0]) && method_exists($controller, ucfirst($request[0])) ){
            $methodName = ucfirst(array_shift($request));
        }

        $initialize = $controller->initialize($request);

        //определяем есть ли данные в POST
        $controller->isPost = !empty($_POST);
        if ($controller->isPost) {
            $controller->dataPost = $_POST;
        }

        if ($initialize === true) {
            $response = isset($methodName) ? $controller->$methodName() : $controller->index();
        }
        elseif (is_string($initialize)) {
            $response = $initialize;
        }
        else {
            $response = 'Неизвестная ошибка при загрузке страницы';
        }

        echo $response;
	}

    /**
     * @return Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
}
