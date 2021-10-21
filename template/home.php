
<h1><?php echo $title; ?></h1>

<?php foreach($produtos as $p): settype($p, 'object') ?>

<dl>
    <a href="<?php echo url('produto/'.$p->slug); ?>" title="Produto: <?php echo $p->nome; ?>"><img src="<?php echo url('image/'.$p->slug.'.jpg'); ?>" width="150" height="150" /></a>
    <dt><a href="<?php echo url('produto/'.$p->slug); ?>" title="Produto: <?php echo $p->nome; ?>"><?php echo $p->nome; ?></a></dt>
    <dd>Preço: <strong><?php echo valor($p->preco); ?></strong></dd>
    <dd><a href="<?php echo url('adicionar/'.$p->slug); ?>" title="Adicionar este produto ao carrinho">Comprar</a></dd>
</dl>

<?php endforeach ?>

<br class="clear" />
