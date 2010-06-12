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
        $con = new Model;
        $produtos   = $con->produtos_destaque();
        include 'template/head.php';
        include 'template/home.php';
        include 'template/footer.php';
    }
}

class Categoria
{
    public function get($slug)
    {
    	$con = new Model;
        $categoria = $con->categoria($slug);
        if ($categoria) {
        	$categoria = $categoria->fetch();
        	$id_categoria = $categoria['id'];
            $produtos = $con->produtos($id_categoria);
        }
        include 'template/head.php';
        include 'template/home.php';
        include 'template/footer.php';
    }
}
