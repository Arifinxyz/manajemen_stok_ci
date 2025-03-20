<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Product</title>
</head>
<body>
    <h1>Create Product</h1>
    <form action="/products/store" method="post">
        <label for="product_code">Product Code</label>
        <input type="text" name="product_code" id="product_code">
        <br>
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <br>
        <label for="stock">Stock</label>
        <input type="text" name="stock" id="stock">
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>