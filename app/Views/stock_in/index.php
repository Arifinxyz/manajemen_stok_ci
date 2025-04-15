<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>

<main class="h-100">
    <div class="container mt-4 bg-white p-4 rounded shadow-sm">
        <h2>Stock In</h2>

        <div class="mb-3">
            <label>Scan Barcode</label>
            <input type="text" id="barcode" class="form-control" placeholder="Scan barcode..." autofocus autocomplete="off">
            <div id="error-message" class="text-danger mt-2"></div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="100">Qty</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody id="cart-body"></tbody>
        </table>

        <button class="btn btn-success" id="submitBtn">Submit</button>
    </div>
</main>

<script>
    const barcodeInput = document.getElementById('barcode');
    const cartBody = document.getElementById('cart-body');
    const errorMessage = document.getElementById('error-message');
    let cart = [];
    let typingTimer;
    const doneTypingInterval = 500; // 0.5 detik setelah input berhenti

    barcodeInput.addEventListener('input', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(processBarcode, doneTypingInterval);
    });

    barcodeInput.addEventListener('keydown', function () {
        clearTimeout(typingTimer); // reset timer saat user masih mengetik
    });

    function processBarcode() {
        const barcode = barcodeInput.value.trim();
        if (!barcode) return;

        fetch(`<?= base_url('stockin/validateBarcode') ?>?barcode=` + encodeURIComponent(barcode))
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const existing = cart.find(p => p.product_id === data.product.id);
                    if (existing) {
                        existing.quantity += 1;
                    } else {
                        cart.push({ product_id: data.product.id, name: data.product.name, quantity: 1 });
                    }
                    updateCart();
                    errorMessage.textContent = '';
                } else {
                    errorMessage.textContent = data.message || 'Product not found!';
                }

                barcodeInput.value = '';
                barcodeInput.focus();
            })
            .catch(error => {
                errorMessage.textContent = 'Error validating barcode!';
                console.error(error);
                barcodeInput.value = '';
                barcodeInput.focus();
            });
    }

    function updateCart() {
        cartBody.innerHTML = '';
        cart.forEach((item, index) => {
            cartBody.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td><button class="btn btn-danger btn-sm" onclick="removeItem(${index})">Remove</button></td>
                </tr>
            `;
        });
    }

    function removeItem(index) {
        cart.splice(index, 1);
        updateCart();
    }

    document.getElementById('submitBtn').addEventListener('click', () => {
        if (cart.length === 0) return alert('Cart is empty');

        fetch(`<?= base_url('stockin/store') ?>`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ products: cart })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Stock In successful!');
                cart = [];
                updateCart();
                barcodeInput.focus();
            } else {
                alert(data.message || 'Error submitting data!');
            }
        })
        .catch(error => {
            alert('Something went wrong!');
            console.error(error);
        });
    });
</script>

<?= $this->endSection() ?>
