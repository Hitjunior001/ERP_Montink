<div class="container mt-5">
    <h2>Cadastrar Nova Variação</h2>

    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?php echo form_open(base_url('index.php/variations/create')); ?>

    <div class="mb-3">
        <label for="name" class="form-label">Nome da Variação</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Ex: Tamanho G, Cor Azul" required>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>

    <?php echo form_close(); ?>
</div>