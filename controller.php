<?php

class Setup
{
    public function get()
    {
        @unlink('banco.db');
        $con = new Model();
        $con->setup();
    }
}

class Home
{
    public function get()
    {
        $con = new Model();
        $produtos   = $con->produtos_destaque();
        include 'template/head.php';
        include 'template/home.php';
        include 'template/footer.php';
    }
}
