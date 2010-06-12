<?php

function error() {
    die('Internal Server Error.');
}

function url($uri) {
    return BASE_URL.$uri;
}

function valor($numero) {
    return "R$ ".number_format($numero, 2, ',', '');
}
