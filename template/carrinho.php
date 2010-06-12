

<?php if (!$_SESSION['carrinho']): ?>

<p>Seu carrinho está vazio.</p>

<?php else: ?>


<form action="<?php echo url('atualiza'); ?>" method="post">
<table>
    <thead>
        <tr>
            <th>Descrição</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
<?php $total=0;foreach ($_SESSION['carrinho'] as $slug => $qtd): foreach($con->produto($slug) as $p): settype($p, 'object'); $total+=$p->preco*$qtd ?>
        <tr>
            <td><?php echo $p->nome; ?></td>
            <td>
                <input type="text" name="produto[<?php echo $p->slug; ?>]" value="<?php echo $qtd; ?>" />
                <a href="<?php echo url('remover/'.$slug); ?>" title="Remover este item do carrinho">remover</a>
            </td>
            <td><?php echo valor($p->preco); ?></td>
            <td><?php echo valor($qtd * $p->preco); ?></td>
        </tr>
<?php endforeach; endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total</th>
            <td><?php echo valor($total); ?></td>
        </tr>
    </tfoot>
</table>
<input type="submit" value="Atualizar Carrinho" />
<form>

<?php endif ?>
