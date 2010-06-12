
<h1>Produtos em destaque</h1>



<?php foreach($produtos as $p): settype($p, 'object') ?>

<dl>
    <img src="<?php echo url('image/'.$p->slug); ?>" width="150" height="150" />
    <dt><a href="<?php echo url('produto/'.$p->slug); ?>" title="Produto: <?php echo $p->nome; ?>"><?php echo $p->nome; ?></a></dt>
    <dd>Preço: <strong><?php echo $p->preco; ?></strong></dd>
</dl>

<?php endforeach ?>

