<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="/products/update/<?= $product['id'] ?>" method="post">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?= $product['name'] ?>">
        <br>
        <label for="stock">Stock</label>
        <input type="text" name="stock" id="stock" value="<?= $product['stock'] ?>">
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>