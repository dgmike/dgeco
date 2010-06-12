<?php
session_start();

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

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
        $title = 'Produtos em destaque';
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
        $title = 'Produtos da categoria '.$categoria['nome'];
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
        $con = new Model;
        include 'template/head.php';
        include 'template/carrinho.php';
        include 'template/footer.php';
    }
}

class Adicionar
{
    public function get($slug)
    {
    	$con = new Model;
        $produto = $con->produto($slug);
        if (!isset($_SESSION['carrinho'][$slug])) {
        	$_SESSION['carrinho'][$slug] = 1;
        } else {
        	$_SESSION['carrinho'][$slug] += 1;
        }
        header('Location: '.url('carrinho'));
    }
}

class Remover
{
    public function get($slug)
    {
        if (isset($_SESSION['carrinho'][$slug])) {
        	unset($_SESSION['carrinho'][$slug]);
        }
        header('Location: '.url('carrinho'));
    }
}

class Atualizar
{
    public function get()
    {

    }
    public function post()
    {
        $_SESSION['carrinho'] = array();
        foreach ($_POST['produto'] as $slug => $qtd) {
            $qtd = (int) $qtd;
            if ($qtd>0) {
            	$_SESSION['carrinho'][$slug] = $qtd;
            }
        }
        header('Location: '.url('carrinho'));
    }
}
