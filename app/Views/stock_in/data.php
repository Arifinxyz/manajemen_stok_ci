<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>
<main class="h-100">
    <div class="container mt-4 bg-white p-4 rounded shadow-sm">
        <h2>Stock In Data</h2>

        <!-- Filter Form -->
        <form id="filterForm" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="month" class="form-label">Filter by Month</label>
                <select name="month" id="month" class="form-select">
                    <option value="">All</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>" <?= $month == $i ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="year" class="form-label">Filter by Year</label>
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
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="stockInTableBody">
                <?php if (!empty($stock_in)): ?>
                    <?php foreach ($stock_in as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['product_name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $item['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Print Button -->
        <div class="mt-3">
            <a id="printButton" href="<?= base_url('stockin/print') ?>" class="btn btn-success">Print Excel</a>
        </div>
    </div>
</main>
<script>
    const filterForm = document.getElementById('filterForm');
    const stockInTableBody = document.getElementById('stockInTableBody');
    const printButton = document.getElementById('printButton');

    // Event listener untuk filter form
    filterForm.addEventListener('change', function () {
        const month = document.getElementById('month').value || ''; // Default ke string kosong jika null
        const year = document.getElementById('year').value || ''; // Default ke string kosong jika null

        // Update URL print agar sesuai dengan filter
        printButton.href = `<?= base_url('stockin/print') ?>/${month}/${year}`;

        // Fetch data menggunakan AJAX
        fetch(`<?= base_url('stockin/filter') ?>?month=${month}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                // Kosongkan tabel
                stockInTableBody.innerHTML = '';

                // Tambahkan data baru ke tabel
                if (data.stock_in && data.stock_in.length > 0) {
                    data.stock_in.forEach(item => {
                        stockInTableBody.innerHTML += `
                            <tr>
                                <td>${item.id}</td>
                                <td>${item.product_name}</td>
                                <td>${item.quantity}</td>
                                <td>${item.created_at}</td>
                            </tr>
                        `;
                    });
                } else {
                    stockInTableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center">No data available</td>
                        </tr>
                    `;
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                stockInTableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-danger">Error loading data</td>
                    </tr>
                `;
            });
    });
</script>
<?= $this->endSection() ?>