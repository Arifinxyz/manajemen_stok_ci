<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>
<main class="h-100 m-5">
    <div class="container mt-4 bg-white p-4 rounded shadow-sm">
        <h2>Data Stok Keluar</h2>

        <!-- Filter Form -->
        <!-- Filter Form -->
<form id="filterForm" class="row g-3 mb-4" method="get" action="">
    <div class="col-md-4">
        <label for="month" class="form-label">Filter Bulan</label>
        <select name="month" id="month" class="form-select">
            <option value="">All</option>
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <option value="<?= $i ?>" <?= $month == $i ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label for="year" class="form-label">Filter Tahun</label>
        <select name="year" id="year" class="form-select">
            <option value="">All</option>
            <?php for ($i = 2020; $i <= date('Y'); $i++): ?>
                <option value="<?= $i ?>" <?= $year == $i ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>
</form>

        <!-- Stock In Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <yak>Banyak Produk</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody id="stockInTableBody">
                <?php if (!empty($stock_out)): ?>
                    <?php foreach ($stock_out as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['product_name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $item['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Data Tidak Tersedia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Print Button -->
        <div class="mt-3">
            <a id="printButton" href="<?= base_url('stockout/print') ?>" class="btn btn-success">Print Excel</a>
        </div>
    </div>
</main>
<script>
    const filterForm = document.getElementById('filterForm');
    const month = document.getElementById('month');
    const year = document.getElementById('year');
    const printButton = document.getElementById('printButton');

    function updatePrintLink() {
        const m = month.value || '';
        const y = year.value || '';
        printButton.href = `<?= base_url('stockout/print') ?>/${m}/${y}`;
    }

    // Update print link saat dropdown berubah
    month.addEventListener('change', () => {
        updatePrintLink();
        filterForm.submit();
    });

    year.addEventListener('change', () => {
        updatePrintLink();
        filterForm.submit();
    });

    // Panggil saat awal load untuk set print link
    updatePrintLink();
</script>

<?= $this->endSection() ?>  