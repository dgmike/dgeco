<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>dgeco</title>
    <link rel="stylesheet" type="text/css" href="<?php echo url('static/style.css'); ?>" />
</head>
<body>

<header>
    <h1>
        <a href="<?php echo url(''); ?>">dgeco</a>
    </h1>
    <p>Sua loja da vuvuzela</p>
</header>

<?php 
$total=0;
foreach($_SESSION['carrinho'] as $item) 
        $total+=$item;
?>

<nav>
    <ul>
        <li><a href="<?php echo url('') ?>" title="dgeco">Home</a></li>
        <?php foreach ($con->categorias() as $c): settype($c, 'object') ?>
        <li><a href="<?php echo url('categoria/'.$c->slug); ?>" title="Categoria: <?php echo $c->nome; ?>"><?php echo $c->nome; ?></a></li>
        <?php endforeach ?>
        <li class="carrinho"><a href="<?php echo url('carrinho') ?>" title="Carrinho de compras">Carrinho (<?php echo $total; ?>)</a></li>
    </ul>
</nav>
    
<article>

