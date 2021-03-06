<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */

set_include_path(dirname(__FILE__)
                    .PATH_SEPARATOR.dirname(dirname(__FILE__))
                    .PATH_SEPARATOR.get_include_path()
                );

// Para usar os testes, voce deve ter a biblioteca PEAR PHPUnit
require_once 'config.php';
require_once 'Pagseguro.php';
require_once 'Carrinho.php';
require_once 'PHPUnit/Framework.php';

class WorngCarrinho
{
    private $email_cobranca = 'fake@visie.com.br';
}

class CarrinhoTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $carrinho = new Pagseguro_Carrinho;
        $this->assertEquals('Pagseguro_Carrinho', get_class($carrinho), 'Instanciou o carrinho puro');
        $carrinho = Pagseguro::carrinho();
        $this->assertEquals('Pagseguro_Carrinho', get_class($carrinho), 'Instanciou o carrinho pelo metodo estatico');
        $pagseguro = new Pagseguro;
        $carrinho = $pagseguro->carrinho();
        $this->assertEquals('Pagseguro_Carrinho', get_class($carrinho), 'Instanciou o carrinho pelo metodo publico');
        $carrinho = $pagseguro->carrinho;
        $this->assertEquals('Pagseguro_Carrinho', get_class($carrinho), 'Instanciou o carrinho pelo __get');
        $carrinho = $pagseguro->getModule('carrinho');
        $this->assertEquals('Pagseguro_Carrinho', get_class($carrinho), 'Instanciou o carrinho pelo getModule');
    }

    public function testCallWithArgument()
    {
        $email    = 'mike@visie.com.br';
        $carrinho = new Pagseguro_Carrinho($email);
        $this->assertEquals('Pagseguro_Carrinho', get_class($carrinho), 'Instanciou o carrinho puro');
        $this->assertEquals($email, $carrinho->email_cobranca);

        $carrinho = Pagseguro::carrinho($email);
        $this->assertEquals('Pagseguro_Carrinho', get_class($carrinho), 'Instanciou o carrinho pelo metodo estatico');
        $this->assertEquals($email, $carrinho->email_cobranca);

        $pagseguro = new Pagseguro;
        $carrinho  = $pagseguro->carrinho($email);
        $this->assertEquals('Pagseguro_Carrinho', get_class($carrinho), 'Instanciou o carrinho pelo metodo publico');
        $this->assertEquals($email, $carrinho->email_cobranca);

        $carrinho = $pagseguro->getModule('carrinho', $email);
        $this->assertEquals('Pagseguro_Carrinho', get_class($carrinho), 'Instanciou o carrinho pelo getModule');
        $this->assertEquals($email, $carrinho->email_cobranca);
    }

    public function testPassObjetOrArray()
    {
        $data = array(
            'email_cobranca' => 'mike@visie.com.br',
            'id_formulario' => 'formulario_pagseguro',
        );
        $carrinho = new Pagseguro_Carrinho($data);
        $this->assertEquals($data['email_cobranca'], $carrinho->email_cobranca);
        $this->assertEquals($data['id_formulario'], $carrinho->id_formulario);

        $data = (object) $data;
        $carrinho = new Pagseguro_Carrinho($data);
        $this->assertEquals($data->email_cobranca, $carrinho->email_cobranca);
        $this->assertEquals($data->id_formulario, $carrinho->id_formulario);

        $data_xml = new SimpleXMLElement('<data>'
            . '<email_cobranca>mike@visie.com.br</email_cobranca>'
            . '<id_formulario>formulario_pagseguro</id_formulario>'
            . '</data>');
        $carrinho = new Pagseguro_Carrinho($data_xml);
        $this->assertEquals($data->email_cobranca, $carrinho->email_cobranca);
        $this->assertEquals($data->id_formulario, $carrinho->id_formulario);
    }

    public function testNotAcceptWorngCartArgs()
    {
        $data = new WorngCarrinho;
        $carrinho = new Pagseguro_Carrinho($data);
        $this->assertEquals($carrinho->email_cobranca, null);
    }

    public function testSetBasico()
    {
        $email    = 'mike@visie.com.br';
        $carrinho = new Pagseguro_Carrinho;
        $carrinho->set('email_cobranca', $email);
        $this->assertEquals($email, $carrinho->email_cobranca);
    }

    public function testSetInvalid()
    {
        $carrinho = new Pagseguro_Carrinho;
        $this->setExpectedException('Exception');
        $carrinho->set('invalido', '');
    }

    public function testSetAcceptsObjectsAndArrays()
    {
        $data = array(
            'email_cobranca' => 'mike@visie.com.br',
        );
        $carrinho = new Pagseguro_Carrinho;
        $carrinho->set($data);
        $this->assertEquals($data['email_cobranca'], $carrinho->email_cobranca);
        settype($data, 'object');
        $carrinho = new Pagseguro_Carrinho;
        $carrinho->set($data);
        $this->assertEquals($data->email_cobranca, $carrinho->email_cobranca);
    }

    /**
     * @dataProvider valid_args
     */
    public function testSetValidArgs($key=null, $value=null, $return)
    {
        $carrinho = new Pagseguro_Carrinho;
        $carrinho->set($key, $value);
        $this->assertEquals($carrinho->{$key}, $return);
    }

    public function valid_args()
    {
        return array(
            array('email_cobranca', 'mike@visie.com.br', 'mike@visie.com.br'),
            array('id_formulario' , 'meu_formulario'   , 'meu_formulario'   ),
            array('tipo'          , 'CP'               , 'CP'               ),
            array('moeda'         , 'BRL'              , 'BRL'              ),
            array('frete'         , 26                 , 2600               ),
        );
    }

    /**
     * @dataProvider numbers
     */
    public function testConvertToNumber($entrada, $saida)
    {
        $carrinho = new Pagseguro_Carrinho;
        $this->assertEquals($saida, $carrinho->numero($entrada));
    }

    public function numbers()
    {
        return array(
            array(1     , 100),
            array(12    , 1200),
            array(3.4   , 340),
            array(1.35  , 135),
            array(1.254 , 125),
            array(1.246 , 125),
            array('12'  , 1200),
            array('12,3', 1230),
            array('12,3,8', 1230),
        );
    }

    /**
     * @dataProvider invalid_numbers
     */
    public function testInvalidValuesForConvertToNumbers($value)
    {
        $carrinho = new Pagseguro_Carrinho;
        $this->setExpectedException('Exception');
        $carrinho->numero($value);
    }

    public function invalid_numbers()
    {
        return array(
            array(array()),
            array(new stdClass),
        );
    }

    /**
     * @dataProvider validProducts
     */
    public function testSetValidProducts($produto, $valor)
    {
        $carrinho = Pagseguro::carrinho('mike@visie.com.br');
        $carrinho->produto($produto);
        settype($produto, 'array');
        $this->assertEquals($carrinho->produtos[0]->id, $produto['id']);
        $this->assertEquals($carrinho->produtos[0]->descr, $produto['descr']);
        $this->assertEquals($carrinho->produtos[0]->valor, $valor);
        $this->assertEquals($carrinho->produtos[0]->quant, $produto['quant']);
    }

    public function validProducts()
    {
        return array(
            array(array( 'id' => '0001', 'descr' => 'Veu de noiva', 'valor' => 89.9, 'quant' => 1), 8990),
            array((object) array( 'id' => '0001', 'descr' => 'Veu de noiva', 'valor' => '85,9', 'quant' => 1), 8590),
            array(new SimpleXMLElement('<data><id>201</id><descr>Amigos para sempre</descr><valor>2,90</valor><quant>3</quant></data>'), 290),
            array(new SimpleXMLElement('<data><id>2</id><descr>o Rappa</descr><valor>2.3</valor><quant>12</quant><frete>99</frete></data>'), 230, 9900),
            array(array( 'id' => '0032', 'descr' => 'Veu de noiva', 'valor' => '84,9', 'quant' => 1, 'frete' => 20), 8490, 2000),
            array(array( 'id' => '002', 'descr' => 'Caneta', 'valor' => '4', 'quant' => 3, 'frete' => '320', 'peso' => '200'), 400, 32000),
        );
    }

    /**
     * @dataProvider invalidProdutcs
     * @expectedException Exception
     */
    public function testInvalidProducts($produto)
    {
        $carrinho = new Pagseguro_Carrinho;
        $carrinho->produto($produto);
    }

    public function invalidProdutcs()
    {
        // keys obrigatorias
        return array(
            array(array('id' => '1', 'descr' => 'Meu título', 'valor' => '10,9')),
            array(array('id' => '1', 'descr' => 'Meu título', 'quant' => '2')),
            array(array('id' => '1', 'valor' => '10,9', 'quant' => '2')),
            array(array('descr' => 'Meu título', 'valor' => '10,9', 'quant' => '2')),
            // array(array('id' => '1', 'descr' => 'Meu título', 'valor' => '10,9', 'quant' => '2'))
        );
    }

    /**
     * @dataProvider validProducts
     */
    public function testProdutoFretePeso($produto, $valor, $frete=null)
    {
        $carrinho = Pagseguro::carrinho('mike@visie.com.br');
        $carrinho->produto($produto);
        settype($produto, 'array');
        if ($frete===null) {
            $this->assertFalse(isset($carrinho->produtos[0]->frete));
        } else {
            $this->assertEquals($carrinho->produtos[0]->frete, $frete);
        }
        if (isset($produto['peso'])) {
            $this->assertEquals($carrinho->produtos[0]->peso, $produto['peso']);
        } else {
            $this->assertFalse(isset($carrinho->produtos[0]->peso));
        }
    }

    public function testIgnorandoNameInvalido()
    {
        $carrinho = Pagseguro::Carrinho('mike@visie.com.br');
        $carrinho->produto(array(
            'id' => '002',
            'descr' => 'Arame Farpado',
            'valor'  => .4,
            'quant' => 3,
            'frete' => 300,
            'peso' => '200',
            'ignore' => 'valor invalido'
        ));
        $this->assertFalse(isset($carrinho->produtos[0]->ignore));
    }

    public function testSobrescrevendoInformacoesDescricao()
    {
        $chaves   = array('descricao', 'description', 'desc', 'descr');
        foreach ($chaves as $chave) {
            $carrinho = Pagseguro::Carrinho('mike@visie.com.br');
            $id = uniqid();
            $carrinho->produto(array(
                    'id'    => '003',
                    $chave  => $id.' Assinatura de jornal',
                    'valor' => 210,
                    'quant' => 1,
                ));
            $this->assertEquals(1, count($carrinho->produtos));
            $this->assertEquals($id.' Assinatura de jornal', $carrinho->produtos[0]->descr);
        }
    }

    public function testSobrescrevendoInformacoesValor()
    {
        $chaves   = array('price', 'preco', 'valor');
        foreach ($chaves as $chave) {
            $carrinho = Pagseguro::Carrinho('mike@visie.com.br');
            $valor = rand(1,100);
            $carrinho->produto(array(
                    'id'    => '003',
                    'descr' => 'Assinatura de jornal',
                    $chave  => $valor,
                    'quant' => 1,
                ));
            $this->assertEquals(1, count($carrinho->produtos));
            $this->assertEquals($valor*100, $carrinho->produtos[0]->valor);
        }
    }

    public function testSobrescrevendoInformacoesQuant()
    {
        $chaves   = array('quantity', 'qty', 'qtd', 'quantidade', 'quant');
        foreach ($chaves as $chave) {
            $carrinho = Pagseguro::Carrinho('mike@visie.com.br');
            $quant = rand(1,100);
            $carrinho->produto(array(
                    'id'    => '003',
                    'descr' => 'Assinatura de jornal',
                    'valor' => 123,
                    $chave  => $quant,
                ));
            $this->assertEquals(1, count($carrinho->produtos));
            $this->assertEquals($quant, $carrinho->produtos[0]->quant);
        }
    }

    public function testSobrescrevendoInformacoesID()
    {
        $chaves   = array('code', 'codigo', 'SKU', 'sku', 'uid', 'slug', 'ID', 'Id', 'id');
        foreach ($chaves as $chave) {
            $carrinho = Pagseguro::Carrinho('mike@visie.com.br');
            $id = uniqid();
            $carrinho->produto(array(
                    $chave  => $id,
                    'descr' => 'Assinatura de jornal',
                    'valor' => 123,
                    'quant' => 1,
                ));
            $this->assertEquals(1, count($carrinho->produtos));
            $this->assertEquals($id, $carrinho->produtos[0]->id);
        }
    }

    public function testMultiplosProdutos()
    {
        $produtos  = array();
        $_produtos = $this->validProducts();
        foreach ($_produtos as $item) {
            $produtos[] = $item[0];
        }
        $carrinho = Pagseguro::carrinho('mike@visie.com.br');
        $carrinho->produto($produtos);
        $total = count($produtos);
        $this->assertEquals($total, count($carrinho->produtos));
    }

    function testInsereCliente ()
    {
        $carrinho=Pagseguro::Carrinho('mike@visie.com.br');
        $carrinho->cliente('nome', 'Michael');
        $this->assertEquals($carrinho->cliente, array ('nome' => 'Michael'));
        $carrinho->cliente('cep', '12345678');
        $this->assertEquals($carrinho->cliente, array ('nome' => 'Michael', 'cep' => '12345678'));
        $carrinho->cliente(array(
            'nome' => 'Rafael',
            'end'  => 'R Bela Vista',
        ));
        $this->assertEquals($carrinho->cliente, array('nome' => 'Rafael', 'cep' => '12345678', 'end'  => 'R Bela Vista'));
        $carrinho->cliente(new SimpleXMLElement('<data><bairro>Centro</bairro></data>'));
        $this->assertEquals($carrinho->cliente, array('nome' => 'Rafael', 'cep' => '12345678', 'end'  => 'R Bela Vista', 'bairro' => 'Centro'));
    }

    function testInsereDadosInvalidos()
    {
        $carrinho=Pagseguro::Carrinho('mike@visie.com.br');
        $carrinho->cliente('invalido', 'Michael');
        $this->assertEquals($carrinho->cliente, array());
    }

    public function testInsereSubstitutosCliente()
    {
        $carrinho=Pagseguro::Carrinho('mike@visie.com.br');
        $carrinho->cliente('nome', 'Michael Granados');
        $this->assertEquals($carrinho->cliente, array('nome' => 'Michael Granados'));
        $carrinho->cliente('name', 'André Gonçalves');
        $this->assertEquals($carrinho->cliente, array('nome' => 'André Gonçalves'));
        $carrinho->cliente('end', 'R. Aldair Camargo');
        $this->assertEquals($carrinho->cliente['end'], 'R. Aldair Camargo');
        $carrinho->cliente('endereço', 'Pc. Herois da FEB');
        $this->assertEquals($carrinho->cliente['end'], 'Pc. Herois da FEB');
    }

    function testInsereClienteDadosInvalidos()
    {
        $carrinho=Pagseguro::Carrinho('mike@visie.com.br');
        $carrinho->cliente('invalido', 'Michael');
        $this->assertEquals($carrinho->cliente, array());
    }

    public function testInsereClienteVariosDadosDeUmaVez()
    {
    	$dados = array(
    	    'nome'     => 'Arnaldo Antunes',
    	    'endereco' => 'R. Julio Prestes',
    	    'numero'   => 570,
    	    'bairro'   => 'Campo Limpo',
    	    'cidade'   => 'São Paulo',
    	    'estado'   => 'SP',
        );
    	$verificar = array(
    	    'nome'   => 'Arnaldo Antunes',
    	    'end'    => 'R. Julio Prestes',
    	    'num'    => 570,
    	    'bairro' => 'Campo Limpo',
    	    'cidade' => 'São Paulo',
    	    'uf'     => 'SP',
        );
        $carrinho=Pagseguro::Carrinho('mike@visie.com.br');
        $carrinho->cliente($dados);
        $this->assertEquals($verificar, $carrinho->cliente);
    }

    public function testInsereClienteVariosDadosDeUmaVezSimpleXML()
    {
    	$dados = new SimpleXMLElement('<data>
                                           <nome>Manoel Neto</nome>
                                           <endereco>Pc Cesar Coelho</endereco>
                                           <numero>302</numero>
                                           <bairro>Bella Vista</bairro>
                                           <cid>Rio de Janeiro</cid>
                                           <estado>RJ</estado>
                                       </data>');
    	$verificar = array(
    	    'nome'   => 'Manoel Neto',
    	    'end'    => 'Pc Cesar Coelho',
    	    'num'    => 302,
    	    'bairro' => 'Bella Vista',
    	    'cidade' => 'Rio de Janeiro',
    	    'uf'     => 'RJ',
        );
        $carrinho=Pagseguro::Carrinho('mike@visie.com.br');
        $carrinho->cliente($dados);
        $this->assertEquals($verificar, $carrinho->cliente);
    }

    public function testInput()
    {
        $carrinho = Pagseguro::Carrinho('mike@visie.com.br');
        $this->assertEquals('<input type="hidden" name="idade" value="20" />', $carrinho->input('idade', 20));
    }

}

// Fazendo o sistema rodar sozinho
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    rodaTest('CarrinhoTest');
}
