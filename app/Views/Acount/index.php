<?= $this->extend('component/base') ?>
<?= $this->section('content') ?>

<h1>User Management</h1>
<a href="/users/create" class="btn btn-primary">Add User</a>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td>
                    <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="/users/delete/<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>