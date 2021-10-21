<?php
$baseUrl = getEnv('BASE_URL') ? getEnv('BASE_URL') : 'http://local.dgeco.com.br';
define ('BASE_URL', $baseUrl . '/');

include 'helper.php';
include 'controller.php';
include 'model.php';

$urls = array(
    '^/comprar/?'                                      => 'Comprar',
    '^/setup/?'                                        => 'Setup',
    '^/atualiza/?'                                     => 'Atualizar',
    '^/carrinho/?'                                     => 'Carrinho',
    '^/remover/([a-z_-]+)/?'                           => 'Remover',
    '^/adicionar/([a-z_-]+)/?'                         => 'Adicionar',
    '^/produto/([a-z_-]+)/?'                           => 'Produto',
    '^/categoria/([a-z_-]+)/?'                         => 'Categoria',
    '^/?$'                                             => 'Home',
    '^/(static|image)/([a-z0-9_-]+)\.(css|js|jpg|png)' => 'StaticFiles',
);

include 'app.php';
