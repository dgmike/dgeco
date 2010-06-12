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

class Produto
{
    public function get($slug)
    {
        $con = new Model;
        $produto = $con->produto($slug);
        include 'template/head.php';
        include 'template/produto.php';
        include 'template/footer.php';
    }
}

class Carrinho
{
    public function get()
    {
    	session_start();
        $con = new Model;
        if (!isset($_SESSION['carrinho'])) {
        	$_SESSION['carrinho'] = array();
        }
        include 'template/head.php';
        include 'template/carrinho.php';
        include 'template/footer.php';
    }
}

class Adicionar
{
    public function get($slug)
    {
    	session_start();
    	$con = new Model;
        $produto = $con->produto($slug);
        if (!isset($_SESSION['carrinho'])) {
        	$_SESSION['carrinho'] = array();
        }
        if (!isset($_SESSION['carrinho'][$slug])) {
        	$_SESSION['carrinho'][$slug] = 1;
        } else {
        	$_SESSION['carrinho'][$slug] += 1;
        }
        header('Location: '.url('carrinho'));
    }
}
