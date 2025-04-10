<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>
<div class="h-100">
    <div class="shadow-sm rounded container bg-white p-3 mb-4">
        <h1>Product</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
            Create
        </button>
        <table class="table" border="1">
            <thead>
                <tr>
                    <th>Products Name</th>
                    <th>Product Code</th>
                    <th>Barcode</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" class="text-center">No products found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['name'] ?></td>
                            <td><?= $product['product_code'] ?></td>
                            <td>
                                <a href="data:image/png;base64,<?= $product['barcode'] ?>" download="barcode.png">
                                    <img src="data:image/png;base64,<?= $product['barcode'] ?>" alt="Barcode">
                                </a>
                            </td>
                            <td><?= $product['stock'] ?></td>
                            <td>
                                <button type="button" class="btn btn-warning edit-product-btn" data-bs-toggle="modal"
                                    data-bs-target="#editProductModal" data-id="<?= $product['id'] ?>"
                                    data-name="<?= $product['name'] ?>" data-code="<?= $product['product_code'] ?>"
                                    data-stock="<?= $product['stock'] ?>">
                                    Edit
                                </button>
                                <a href="/products/delete/<?= $product['id'] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Include Form Create Product -->
<?= $this->include('products/create') ?>

<?php if (!empty($products)): ?>
    
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" action="/products/update/<?= $product['id'] ?>" method="post">
                        <input type="hidden" id="editProductId" name="id">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductCode" class="form-label">Product Code</label>
                            <input type="text" class="form-control" id="editProductCode" name="product_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="editProductStock" name="stock" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.edit-product-btn');
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                var name = this.getAttribute('data-name');
                var code = this.getAttribute('data-code');
                var stock = this.getAttribute('data-stock');

                document.getElementById('editProductId').value = id;
                document.getElementById('editProductName').value = name;
                document.getElementById('editProductCode').value = code;
                document.getElementById('editProductStock').value = stock;
            });
        });
    });
</script>

<?= $this->endSection() ?>