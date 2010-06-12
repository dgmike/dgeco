<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>dgeco</title>
</head>
<body>

<header>
    <h1>
        <a href="<?php echo url(''); ?>">dgeco</a>
    </h1>
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
        <li><a href="<?php echo url('carrinho') ?>" title="Carrinho de compras">Carrinho (<?php echo $total; ?>)</a></li>
    </ul>
</nav>
    
<article>

