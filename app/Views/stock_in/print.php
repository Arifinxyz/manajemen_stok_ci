<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Stock In Report</title>
</head>
<body>
    <h1>Stock In Report</h1>
    <p>Month: <?= $month ? date('F', mktime(0, 0, 0, $month, 1)) : 'All' ?></p>
    <p>Year: <?= $year ?? 'All' ?></p>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
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
                    <td colspan="4">No data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>