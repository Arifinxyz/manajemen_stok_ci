<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>
<div class="container bg-white p-4">
    <h2>Stock In</h2>

    <div class="mb-3">
        <label for="barcode">Scan Barcode</label>
        <input type="text" class="form-control" id="barcode" placeholder="Scan barcode here" autofocus>
        <div id="error-message" class="text-danger mt-2"></div>
        <!-- CSRF token -->
        <input type="hidden" id="csrf-token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th width="120">Qty</th>
                <th width="100">Action</th>
            </tr>
        </thead>
        <tbody id="cart-body"></tbody>
    </table>

    <button id="submitBtn" class="btn btn-success">Submit</button>
</div>

<script>
    const barcodeInput = document.getElementById('barcode');
    const cartBody = document.getElementById('cart-body');
    const errorMessage = document.getElementById('error-message');
    const csrfToken = document.getElementById('csrf-token');
    const cart = [];

    barcodeInput.addEventListener('change', function () {
        const barcode = barcodeInput.value.trim();
        if (!barcode) return;

        fetch('<?= base_url('stockin/validateBarcode') ?>?barcode=' + encodeURIComponent(barcode))
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const exists = cart.find(p => p.product_id === data.product.id);
                    if (exists) {
                        exists.quantity += 1;
                    } else {
                        cart.push({
                            product_id: data.product.id,
                            name: data.product.name,
                            quantity: 1
                        });
                    }
                    updateCartTable();
                    errorMessage.textContent = '';
                } else {
                    errorMessage.textContent = data.message || 'Product not found.';
                }
                barcodeInput.value = '';
                barcodeInput.focus();
            })
            .catch(err => {
                errorMessage.textContent = 'Error validating barcode. Please try again.';
                console.error(err);
                barcodeInput.focus();
            });
    });

    function updateCartTable() {
        cartBody.innerHTML = '';
        cart.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.name}</td>
                <td>
                    <input type="number" class="form-control form-control-sm quantity-input" 
                           data-product-id="${product.product_id}" 
                           value="${product.quantity}" min="1">
                </td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="removeItem(${product.product_id})">Delete</button>
                </td>
            `;
            cartBody.appendChild(row);
        });

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function () {
                const id = parseInt(this.dataset.productId);
                const qty = parseInt(this.value) || 1;
                if (qty < 1) {
                    alert('Quantity must be at least 1');
                    this.value = 1;
                    return;
                }
                const item = cart.find(p => p.product_id === id);
                if (item) item.quantity = qty;
            });
        });
    }

    function removeItem(id) {
        const index = cart.findIndex(p => p.product_id === id);
        if (index !== -1) cart.splice(index, 1);
        updateCartTable();
        barcodeInput.focus();
    }

    document.getElementById('submitBtn').addEventListener('click', () => {
        if (cart.length === 0) {
            alert('Cart is empty');
            barcodeInput.focus();
            return;
        }

        fetch('<?= base_url('stockin/store') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                [csrfToken.name]: csrfToken.value
            },
            body: JSON.stringify({ products: cart })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Stock in successful');
                cart.length = 0;
                updateCartTable();
                if (data.csrfToken) {
                    csrfToken.value = data.csrfToken; // update token dari server
                }
            } else {
                alert(data.message || 'Failed to submit stock in.');
            }
        })
        .catch(err => {
            alert('Error submitting stock in. Please try again.');
            console.error(err);
        })
        .finally(() => {
            barcodeInput.focus();
        });
    });
</script>
<?= $this->endSection() ?>
