<div class="container mt-4">
    <h2>Criar Cupom</h2>

    <form method="post" action="<?= site_url('index.php/coupons') ?>">
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <div class="mb-3">
            <label for="code" class="form-label">Código</label>
            <input type="text" name="code" id="code" class="form-control" 
                   value="<?= set_value('code') ?>" required>
        </div>

        <div class="mb-3">
            <label for="discount_value" class="form-label">Valor do Desconto (Decimal)</label>
            <input type="number" step="0.01" min="0" name="discount_value" id="discount_value" placeholder="Exemplo: 0.1 (10%)"
                   class="form-control" value="<?= set_value('discount_value') ?>" required>
        </div>

        <div class="mb-3">
            <label for="valid_from" class="form-label">Data Inicial</label>
            <input type="date" name="valid_from" id="valid_from" 
                   class="form-control" value="<?= set_value('valid_from') ?>" required>
        </div>

        <div class="mb-3">
            <label for="valid_until" class="form-label">Data Final</label>
            <input type="date" name="valid_until" id="valid_until" 
                   class="form-control" value="<?= set_value('valid_until') ?>" required>
        </div>

        <div class="mb-3">
            <label for="active" class="form-label">Ativo</label>
            <select name="active" id="active" class="form-control" required>
                <option value="1" <?= set_select('active', '1', TRUE) ?>>Sim</option>
                <option value="0" <?= set_select('active', '0') ?>>Não</option>
            </select>
        </div>

        <hr>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="<?= site_url('index.php/coupons'); ?>" class="btn btn-secondary">Cancelar</a>
    </form>

    <hr class="my-4">

    <h2 class="mb-4 text-center" style="color: #ff4d88;">Cupons</h2>

    <?php if (empty($coupons)): ?>
        <p class="text-muted">Nenhum cupom cadastrado.</p>
    <?php else: ?>
    <div class="table-responsive shadow rounded">
        <table class="table table-dark table-hover align-middle text-center">
            <thead style="background-color: #2a2a2a;">
                <tr>
                    <th>Código</th>
                    <th>Desconto (%)</th>
                    <th>Válido de</th>
                    <th>Até</th>
                    <th>Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($coupons as $coupon): ?>
                    <tr>
                        <td><?= htmlspecialchars($coupon->code) ?></td>
                        <td style="color: #ffeaa7;"><?= number_format($coupon->discount_value*100, 2, ',', '.') ?>%</td>
                        <td><?= date('d/m/Y', strtotime($coupon->valid_from)) ?></td>
                        <td><?= date('d/m/Y', strtotime($coupon->valid_until)) ?></td>
                        <td style="color: <?= $coupon->active ? '#55efc4' : '#d63031' ?>;">
                            <?= $coupon->active ? 'Sim' : 'Não' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
