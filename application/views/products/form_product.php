<div class="container mt-4">
    <h2><?= isset($product) ? 'Editar Produto' : 'Criar Produto' ?></h2>

    <form method="post" action="<?= isset($product) 
        ? site_url('index.php/products/update_product/' . $product->product_id) 
        : site_url('index.php/products/insert_product') ?>">
        
        <?php if (isset($product)): ?>
            <input type="hidden" name="id" value="<?= $product->product_id ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">Nome do Produto</label>
            <input type="text" name="name" class="form-control" required 
                   value="<?= isset($product) ? $product->name : '' ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Preço</label>
            <input type="number" name="price" step="0.01" class="form-control" required 
                   value="<?= isset($product) ? $product->price : '' ?>">
        </div>

        <hr>
        <button type="submit" class="btn btn-primary">
            <?= isset($product) ? 'Atualizar' : 'Salvar' ?>
        </button>
        <a href="<?= site_url('index.php/products'); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
