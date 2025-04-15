<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>

<h1>Edit User</h1>
<form action="/users/update/<?= $user['id'] ?>" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
        <small>Leave blank if you don't want to change the password</small>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?= $this->endSection() ?>