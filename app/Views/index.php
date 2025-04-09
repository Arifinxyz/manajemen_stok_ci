<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Total Produk</h5>
                    <h3><?= $productCount ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Stock In Bulan Ini</h5>
                    <h3><?= $stockInTotal ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Stock Out Bulan Ini</h5>
                    <h3><?= $stockOutTotal ?></h3>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mt-5">Statistik Stock In & Out Selama 1 Tahun</h4>
    <canvas id="stockChart"></canvas>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlyLabels = <?= json_encode(array_column($monthlyStockIn, 'month')) ?>;
    const stockInData = <?= json_encode(array_column($monthlyStockIn, 'total')) ?>;
    const stockOutData = <?= json_encode(array_column($monthlyStockOut, 'total')) ?>;

    const ctx = document.getElementById('stockChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'Stock In',
                    data: stockInData,
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                },
                {
                    label: 'Stock Out',
                    data: stockOutData,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>
