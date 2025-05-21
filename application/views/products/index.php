<div class="container mt-5">
    <h2 class="mb-4 text-center" style="color: #ff4d88;">Lista de Produtos</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="<?= site_url('index.php/products/insert'); ?>" class="btn btn-custom">Criar Novo Produto</a>
    </div>

    <div class="table-responsive shadow rounded">
        <table class="table table-dark table-hover align-middle text-center">
            <thead style="background-color: #2a2a2a;">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Variação</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                    <th>Comprar</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p->product_id ?></td>
                        <td style="color: #4cd137;"><?= $p->name ?></td>
                        <td>R$ <?= number_format($p->price, 2, ',', '.') ?></td>
                        <td>
                            <?php
                            $stock = $this->Product_model->get_all_products_with_variations($p->product_id);
                            ?>
                        </td>
                        <td><?= $stock ? $stock->total_quantity : '0' ?></td>
                        <td>
                            <a href="<?= site_url('index.php/products/update_product/' . $p->product_id); ?>"
                                class="btn btn-outline-rose btn-sm">Editar</a>
                        </td>
                        <td>
                            <button class="btn btn-outline-rose btn-sm btn-add-cart" data-id="<?= $p->product_id ?>"
                                data-name="<?= $p->name ?>" data-price="<?= $p->price ?>">
                                Comprar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="container mt-4">
        <div id="cart-info" class="mb-3"></div>
        <button id="clear-cart" class="btn btn-danger mb-4">Limpar Carrinho</button>
        <div class="mb-4 row align-items-center">
            <label for="cep-input" class="col-auto col-form-label">Digite seu CEP:</label>
            <div class="col-auto">
            <input type="text" id="cep-input" maxlength="8" placeholder="Ex: 70000000" class="form-control" style="width: 150px;">
            </div>
            <div class="col-auto">
            <button id="check-cep" class="btn btn-primary btn-sm">Verificar CEP</button>
            </div>
            <div id="cep-result" class="col-12 mt-2 text-secondary"></div>
        </div>
        <div class="mb-4 row align-items-center">
            <label for="coupon-code" class="col-auto col-form-label">Cupom de Desconto:</label>
            <div class="col-auto">
            <input type="text" id="coupon-code" placeholder="Digite o código do cupom" class="form-control" style="width: 150px;">
            </div>
            <div class="col-auto">
            <button id="apply-coupon" class="btn btn-success btn-sm">Aplicar</button>
            </div>
            <div id="coupon-message" class="col-12 mt-2 text-success"></div>
        </div>
        </div>


    </div>
</div>

<script>
    document.querySelectorAll('.btn-add-cart').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.id;
            const price = parseFloat(button.dataset.price);

            let cart = JSON.parse(localStorage.getItem('cart')) || {};

            if (cart[productId]) {
                cart[productId].quantity += 1;
            } else {
                cart[productId] = { quantity: 1, price: price };
            }

            localStorage.setItem('cart', JSON.stringify(cart));

            let subtotal = 0;
            Object.values(cart).forEach(item => {
                subtotal += item.price * item.quantity;
            });

            let frete = 20;
            if (subtotal >= 52 && subtotal <= 166.59) {
                frete = 15;
            } else if (subtotal > 200) {
                frete = 0;
            }

            document.getElementById('cart-info').innerHTML = `
            <p><strong>Subtotal:</strong> R$ ${subtotal.toFixed(2)}</p>
            <p><strong>Frete:</strong> R$ ${frete.toFixed(2)}</p>
            <p><strong>Total:</strong> R$ ${(subtotal + frete).toFixed(2)}</p>
        `;
        });
    });  

    document.getElementById('apply-coupon').addEventListener('click', () => {
        const code = document.getElementById('coupon-code').value.trim();

        if (!code) {
            document.getElementById('coupon-message').textContent = 'Por favor, digite um código.';
            return;
        }

        fetch('<?= site_url("index.php/coupons/validate_coupon") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `code=${encodeURIComponent(code)}`
        })
            .then(res => res.json())
            .then(data => {
                if (data && data.valid) {
                    document.getElementById('coupon-message').style.color = 'green';
                    document.getElementById('coupon-message').textContent = data.message;

                    updateCartWithCoupon(data.discount_value);
                } else {
                    document.getElementById('coupon-message').style.color = 'red';
                    document.getElementById('coupon-message').textContent = data.message || 'Cupom inválido.';
                }
            })
            .catch((error) => {
                console.error('Erro na requisição do cupom:', error);
                document.getElementById('coupon-message').style.color = 'red';
                document.getElementById('coupon-message').textContent = 'Erro ao validar o cupom.';
            });
    });

    function updateCartWithCoupon(discountPercent) {
        let cart = JSON.parse(localStorage.getItem('cart')) || {};
        let subtotal = 0;

        for (const id in cart) {
            subtotal += cart[id].price * cart[id].quantity;
        }

        let frete = 20;
        if (subtotal >= 52 && subtotal <= 166.59) {
            frete = 15;
        } else if (subtotal > 200) {
            frete = 0;
        }

        let totalSemDesconto = subtotal + frete;
        let discountValue = totalSemDesconto * discountPercent;
        let totalComDesconto = totalSemDesconto - discountValue;

        let html = `
            <p><strong>Subtotal:</strong> R$ ${subtotal.toFixed(2).replace('.', ',')}</p>
            <p><strong>Frete:</strong> R$ ${frete.toFixed(2).replace('.', ',')}</p>
            <p><strong>Desconto:</strong> R$ ${discountValue.toFixed(2).replace('.', ',')}</p>
            <p><strong>Total com desconto:</strong> R$ ${totalComDesconto.toFixed(2).replace('.', ',')}</p>
        `;

        document.getElementById('cart-info').innerHTML = html;
    }

    document.getElementById('clear-cart').addEventListener('click', () => {
        localStorage.removeItem('cart');
        document.getElementById('cart-info').innerHTML = '<p>O carrinho está vazio.</p>';
    });

    document.getElementById('check-cep').addEventListener('click', () => {
        const cep = document.getElementById('cep-input').value.replace(/\D/g, '');

        if (cep.length !== 8) {
            document.getElementById('cep-result').textContent = 'Por favor, digite um CEP válido com 8 números.';
            return;
        }

        document.getElementById('cep-result').textContent = 'Consultando...';

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(res => res.json())
            .then(data => {
                if (data.erro) {
                    document.getElementById('cep-result').textContent = 'CEP não encontrado.';
                } else {
                    document.getElementById('cep-result').innerHTML = `
                    <strong>Endereço:</strong> ${data.logradouro || '-'}<br>
                    <strong>Bairro:</strong> ${data.bairro || '-'}<br>
                    <strong>Cidade:</strong> ${data.localidade || '-'}<br>
                    <strong>Estado:</strong> ${data.uf || '-'}
                `;
                }
            })
            .catch(() => {
                document.getElementById('cep-result').textContent = 'Erro ao consultar o CEP. Tente novamente.';
            });
    });

</script>