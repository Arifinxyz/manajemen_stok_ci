<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>
<div class="h-100">
    <div class="shadow-sm rounded container bg-white p-3 mb-4">
        <h1>Daftar Produk</h1>

        <?php if (productAdminRole()):?>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createProductModal">
            Tambah
        </button>
        <?php endif; ?>
        <table class="table" border="1">
            <thead>
                <tr>
                    <th>Nama Produk
                    <th>Kode Produk</th>
                    <th>Barcode</th>
                    <th>Stok</th>
                    <?php if (productAdminRole()):?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak Ada Produk Yang Tersedia</td>
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
                            <?php if (productAdminRole()):?>
                            <td>
                                <button type="button" class="btn btn-warning edit-product-btn" data-bs-toggle="modal"
                                    data-bs-target="#editProductModal" data-id="<?= $product['id'] ?>"
                                    data-name="<?= $product['name'] ?>" data-code="<?= $product['product_code'] ?>"
                                    data-stock="<?= $product['stock'] ?>">
                                    Edit
                                </button>
                                <a href="/products/delete/<?= $product['id'] ?>" class="btn btn-danger">Hapus</a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if (productAdminRole()){ ?>

<?= $this->include('products/create') ?>

<?php if (!empty($products)){ ?>
    
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" action="/products/update/<?= $product['id'] ?>" method="post">
                        <input type="hidden" id="editProductId" name="id">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="editProductName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductCode" class="form-label">Kode Produk</label>
                            <input type="text" class="form-control" id="editProductCode" name="product_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductStock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="editProductStock" name="stock" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php }} ?>

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