<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>

<h1>Add User</h1>
<form action="/users/create" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>

<?= $this->endSection() ?>