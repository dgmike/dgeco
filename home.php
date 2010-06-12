<?php
define ('BASE_URL', 'http://local.dgeco.com.br/');

include 'helper.php';
include 'controller.php';
include 'model.php';

$urls = array(
    '^/setup/?'                => 'Setup',
    '^/carrinho/?'             => 'Carrinho',
    '/adicionar/([a-z_-]+)/?'  => 'Adicionar',
    '/produto/([a-z_-]+)/?'    => 'Produto',
    '^/categoria/([a-z_-]+)/?' => 'Categoria',
    '^/?$'                     => 'Home',
);

include 'app.php';
