<div class="container mt-5">
    <h2 class="mb-4 text-center" style="color: #ff4d88;">Lista de Variações de Produtos</h2>

    <div class="table-responsive shadow rounded">
        <table class="table table-dark table-hover align-middle text-center">
            <thead style="background-color: #2a2a2a;">
                <tr>
                    <th>ID do Produto</th>
                    <th>Produto</th>
                    <th>Variação</th>
                    <th>Opção</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product_variations as $pv): ?>
                    <tr>
                        <td><?= $pv->product_variation_id ?></td>
                        <td style="color: #ffeaa7;"><?= $pv->product_name ?></td>
                        <td style="color: #81ecec;"><?= $pv->variation_name ?></td>
                        <td style="color: #fab1a0;"><?= $pv->option_name ?></td>
                        <td style="color: #55efc4;"><?= $pv->quantity ?></td>
                        <td>
                            <a href="<?= site_url('index.php/products/update_product_variation/'.$pv->product_variation_id); ?>" class="btn btn-outline-rose btn-sm">
                                Editar
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        <h4>Carrinho</h4>
        <div id="cart-container">
            <p>Carrinho vazio.</p>
        </div>
    </div>
</div>
