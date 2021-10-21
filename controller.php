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
        header('Location: /');
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


class Comprar
{
    public function get()
    {
        if (!$_SESSION['carrinho']) {
          header('Location: '.url('carrinho'));
          die;
        }
        $con = new Model;
        require_once 'pagseguro/Pagseguro.php';
        $carrinho = Pagseguro::carrinho(array(
            'email_cobranca' => 'mike@visie.com.br',
            'javascript' => true,
            'button' => '',
            'target' => '',
            'encoding' => 'UTF-8',
        ));
        $carrinho->cliente(array(
            'nome' => 'Marcel Verebes',
            'cep' => '03443000',
        ));
        foreach ($_SESSION['carrinho'] as $slug => $qtd) {
            $produto = $con->produto($slug)->fetch();
            $produto = array(
                'id' => $produto['id'],
                'desc' => $produto['nome'],
                'quant' => $qtd,
                'valor' => $produto['preco'],
            );
            $carrinho->produto($produto);
        }
        $_SESSION['carrinho'] = array();
        print '<html><head><title></title></head><body>';
        $carrinho->mostra();
        print '</body></html>';
    }
}

class StaticFiles
{
    public function get($base, $arquivo, $extensao)
    {
        $caminho_completo = implode(DIRECTORY_SEPARATOR, array(__DIR__, $base, $arquivo . '.' . $extensao));
        if (file_exists($caminho_completo)) {
            $this->header($extensao);
            print file_get_contents($caminho_completo);
            return;
        }
        error404();
    }

    private function header($extensao) {
        switch ($extensao) {
          case 'css':
            header('Content-Type: text/css');
            break;
          case 'js':
            header('Content-Type: application/javascript');
            break;
          case 'jpg':
            header('Content-Type: image/jpeg');
            break;
          case 'png':
            header('Content-Type: image/png');
            break;
        }
    }
}
