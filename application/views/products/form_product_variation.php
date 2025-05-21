<div class="container mt-4">
    <h2><?= isset($product_variation) ? 'Editar variação' : 'Adicionar variação' ?></h2>

    <form method="post" action="<?= isset($product_variation) 
        ? site_url('index.php/products/update_product_variation/' . $product_variation->product_variation_id) 
        : site_url('index.php/products/insert_product_variation') ?>">

        <?php if (isset($product_variation)): ?>
            <div class="mb-3">
                <label class="form-label">Produto</label>
                <input type="text" class="form-control" value="<?= $product_variation->product_name ?>" disabled>
                <input type="hidden" name="product_id" value="<?= $product_variation->product_id ?>">
            </div>
        <?php else: ?>
            <div class="mb-3">
                <label class="form-label">Selecionar Produto</label>
                <select name="product_id" class="form-control" required>
                    <option value="">Selecione um produto</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product->product_id ?>"><?= $product->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Variação</label>
                <select name="variation_id" id="variationSelect" class="form-control">
                    <option value="">Selecione</option>
                    <?php foreach ($variations as $v): ?>
                        <option value="<?= $v->variation_id ?>" 
                            <?= isset($product_variation) && $product_variation->variation_id == $v->variation_id ? 'selected' : '' ?>>
                            <?= $v->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <input type="text" name="new_variation" id="newVariationInput" class="form-control mt-2" placeholder="Ou digite nova variação">
        </div>

        <div class="mb-3">
            <label class="form-label">Opção</label>
                <select name="variation_option_id" id="optionSelect" class="form-control">
                    <option value="">Selecione</option>
                    <?php foreach ($options as $opt): ?>
                        <option value="<?= $opt->variation_option_id ?>" 
                            <?= isset($product_variation) && $product_variation->variation_option_id == $opt->variation_option_id ? 'selected' : '' ?>>
                            <?= $opt->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <input type="text" name="new_variation_option" id="newOptionInput" class="form-control mt-2" placeholder="Ou digite nova opção">
        </div>

        <div class="mb-3">
            <label class="form-label">Quantidade em estoque</label>
            <input type="number" name="quantity" min="0" class="form-control" 
                value="<?= isset($product_variation) ? $product_variation->quantity : '' ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= isset($product_variation) ? 'Atualizar' : 'Salvar' ?>
        </button>
        <a href="<?= site_url('index.php/products'); ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    const variationInput = document.getElementById('newVariationInput');
    const variationSelect = document.getElementById('variationSelect');
    const optionInput = document.getElementById('newOptionInput');
    const optionSelect = document.getElementById('optionSelect');

    function toggleFields(input, select) {
        if (input.value.trim()) {
            select.style.display = 'none';
        } else {
            select.style.display = 'block';
        }

        if (select.value) {
            input.style.display = 'none';
        } else {
            input.style.display = 'block';
        }
    }

    variationInput.addEventListener('input', () => toggleFields(variationInput, variationSelect));
    variationSelect.addEventListener('change', () => toggleFields(variationInput, variationSelect));

    optionInput.addEventListener('input', () => toggleFields(optionInput, optionSelect));
    optionSelect.addEventListener('change', () => toggleFields(optionInput, optionSelect));

    window.addEventListener('DOMContentLoaded', () => {
        toggleFields(variationInput, variationSelect);
        toggleFields(optionInput, optionSelect);
    });
</script>
