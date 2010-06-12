<?php

class Model
{
	var $con = null;

    public function __construct()
    {
    	$file = dirname(__FILE__).DIRECTORY_SEPARATOR.'banco.db';
        $this->con = new PDO('sqlite:'.$file);
    }

    public function setup()
    {
        $loren = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.  Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

    	// Criando tabela categoria
        $sql = 'CREATE TABLE categoria (id INTEGER PRIMARY KEY, slug, nome)';
        $this->con->exec($sql);

        // Inserindo dados
        $sql = 'INSERT INTO categoria (slug, nome) VALUES ("%s", "%s")';
        $this->con->exec(sprintf($sql, 'camisa', 'Camisa'));
        $this->con->exec(sprintf($sql, 'calca', 'Calça'));
        $this->con->exec(sprintf($sql, 'jaqueta', 'Jaqueta'));

        // Criando tabela produto
        $sql = 'CREATE TABLE produto (id INTEGER PRIMARY KEY, slug, nome, descricao, preco FLOAT, categoria INT, destaque INT)';
        $this->con->exec($sql);

        // Inserindo dados
        $sql = 'INSERT INTO produto (slug, nome, descricao, preco, categoria, destaque) VALUES ("%s", "%s", "'.$loren.'", %s, %s, %s)';
        $this->con->exec(sprintf($sql, 'camisa-careca',      'Camisa Careca',         34.5,  1, 0));
        $this->con->exec(sprintf($sql, 'camisa-polo',        'Camisa Polo',           67.9,  1, 1));
        $this->con->exec(sprintf($sql, 'camisa-corinthians', 'Camisa do Corinthians', 99.34, 1, 1));
        $this->con->exec(sprintf($sql, 'camisa-social',      'Camisa social',         34.5,  1, 1));

        $this->con->exec(sprintf($sql, 'calca-jeans',        'Calça Jeans',           85.34, 2, 1));
        $this->con->exec(sprintf($sql, 'calca-social',       'Calça Social',          124.5, 2, 1));
        $this->con->exec(sprintf($sql, 'calca-grande',       'Calça Grande',          124.5, 2, 0));

        $this->con->exec(sprintf($sql, 'jaqueta-couro',      'Jaqueta de couro',      224.5, 3, 0));
        $this->con->exec(sprintf($sql, 'jaqueta-martini',    'Jaqueta Martini',       524.5, 3, 1));
        $this->con->exec(sprintf($sql, 'jaqueta-jean',       'Jaqueta Jeans',         178.2, 3, 1));
    }

    public function categorias()
    {
        return $this->con->query('SELECT * FROM categoria');
    }

    public function produtos_destaque()
    {
        return $this->con->query('SELECT * FROM produto WHERE destaque = 1 ORDER BY RANDOM()');
    }

    public function categoria($slug)
    {
        return $this->con->query('SELECT * FROM categoria WHERE slug = "'.$slug.'"');
    }

    public function produtos($categoria_id)
    {
        $sql = 'SELECT * FROM produto WHERE categoria = '.$categoria_id;
        print '<pre class="debug" style="text-align:left;">'.print_r($sql, true)."</pre>";
        return $this->con->query($sql);
    }
}
