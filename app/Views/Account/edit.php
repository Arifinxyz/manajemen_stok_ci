<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <h2>Edit User</h2>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/users/update/<?= $user['id'] ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="<?= old('name', $user['name']) ?>">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= old('email', $user['email']) ?>">
        </div>

        <div class="mb-3">
            <label>Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="petugas" <?= $user['role'] === 'petugas' ? 'selected' : '' ?>>Petugas</option>
                <option value="hrd" <?= $user['role'] === 'hrd' ? 'selected' : '' ?>>HRD</option>
                <option value="pabrik" <?= $user['role'] === 'pabrik' ? 'selected' : '' ?>>Pabrik</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/users" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?= $this->endSection() ?>
