<?php
define ('BASE_URL', 'http://local.dgeco.com.br/');

include 'helper.php';
include 'controller.php';
include 'model.php';

$urls = array(
    '^/setup/?' => 'Setup',
    '^/?$' => 'Home',
);

include 'app.php';
