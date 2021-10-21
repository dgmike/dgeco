<?php

function error() {
    die('Internal Server Error.');
}

function error404() {
    http_response_code(404);
    die('Not found.');
}

function url($uri) {
    return BASE_URL.$uri;
}

function valor($numero) {
    return "R$ ".number_format($numero, 2, ',', '');
}
