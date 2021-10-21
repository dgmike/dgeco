<?php

$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

$url = $_SERVER['REQUEST_URI'];

# $url = $_GET['url'];

foreach ($urls as $regexp => $class) {
    if (preg_match("@$regexp@", $url, $atributos)) {
        if (class_exists($class)) {
            array_shift($atributos);
            $method = $_POST ? 'post' : 'get';
            $class  = new $class;
            call_user_func_array(array($class, $method), $atributos);
            die();
        }
    }
}
error404();
