<?php
define ('BASE_URL', 'http://local.dgeco.com.br/');

include 'helper.php';
include 'controller.php';
include 'model.php';

$urls = array(
    '^/comprar/?'              => 'Comprar',
    '^/setup/?'                => 'Setup',
    '^/atualiza/?'             => 'Atualizar',
    '^/carrinho/?'             => 'Carrinho',
    '/remover/([a-z_-]+)/?'    => 'Remover',
    '/adicionar/([a-z_-]+)/?'  => 'Adicionar',
    '/produto/([a-z_-]+)/?'    => 'Produto',
    '^/categoria/([a-z_-]+)/?' => 'Categoria',
    '^/?$'                     => 'Home',
);

include 'app.php';
