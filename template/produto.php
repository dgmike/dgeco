
<?php foreach ($produto as $p): settype($p, 'object') ?>

<h1><?php echo $p->nome; ?></h1>

<img src="<?php echo url('image/' . $p->slug . '.jpg'); ?>" width="300" height="300" class="big" />

<p><?php echo $p->descricao; ?></p>

<p class="preco">
    só <?php echo valor($p->preco); ?>
    <a href="<?php echo url('/adicionar/'.$p->slug); ?>" title="Adicionar este produto ao carrinho">Adicionar</a>
</p>

<?php endforeach; ?>

