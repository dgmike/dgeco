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

<nav>
    <ul>
        <?php foreach ($con->categorias() as $c): settype($c, 'object') ?>
        <li><a href="<?php echo url('categoria/'.$c->slug); ?>" title="Categoria: <?php echo $c->nome; ?>"><?php echo $c->nome; ?></a></li>
        <?php endforeach ?>
    </ul>
</nav>
    
<article>

