<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>


<main class="h-100 bg-white p-4 rounded shadow-sm m-5">
    <div class="container mt-4">
        <h2>Dashboard</h2>
        <p>Selamat datang di halaman dashboard. Anda dapat mengelola data produk, stock in, stock out, dan user di sini.</p>
    </div>
<div class="container">
    <h2 class="my-4">Daftar User</h2>

    <a href="<?= base_url('/user/create') ?>" class="btn btn-success mb-3">+ Tambah User</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)) : ?>
                    <tr>
                        <td colspan="4" class="text-center">Belum ada user.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($users as $index => $user) : ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($user['name']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td><span class="badge bg-info text-dark"><?= esc($user['role']) ?></span></td>
                            <td>
    <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
    <a href="/users/delete/<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus user ini?')">Hapus</a>
</td>

                        </tr>
                        
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</main>
<?= $this->endSection() ?>
