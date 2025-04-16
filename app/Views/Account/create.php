<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="my-4">Tambah User</h2>

    <!-- Tampilkan error jika ada -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Tampilkan success message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/user/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="petugas" <?= old('role') == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                <option value="hrd" <?= old('role') == 'hrd' ? 'selected' : '' ?>>HRD</option>
                <option value="pabrik" <?= old('role') == 'pabrik' ? 'selected' : '' ?>>Pabrik</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tambah User</button>
    </form>
</div>

<?= $this->endSection() ?>
