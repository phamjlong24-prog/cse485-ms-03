<?php
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/data.php';

if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [];
}

// Xu ly form dat thu (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_sku'])) {
    $orderSku = $_POST['order_sku'];
    $orderQty = (int) ($_POST['order_qty'] ?? 0);

    if ($orderQty > 0) {
        $_SESSION['orders'][] = [
            'sku' => $orderSku,
            'qty' => $orderQty,
        ];
    }

    // Chong gui lai form khi F5 (Post/Redirect/Get pattern)
    header('Location: dashboard.php');
    exit;
}

$totalValue = 0;
foreach ($productObjects as $product) {
    $totalValue += $product->lineTotal();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MiniShop — Dashboard (Buoi 3)</title>
</head>
<body>
    <h1>MiniShop — Dashboard (Buoi 3)</h1>
    <p>Xin chao, <?php echo htmlspecialchars($_SESSION['username']); ?>!
       (<a href="logout.php">Dang xuat</a>)</p>

    <table border="1">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Ten</th>
                <th>Gia</th>
                <th>So luong</th>
                <th>Thanh tien</th>
                <th>Muc ton</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productObjects as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product->getSku()); ?></td>
                <td><?php echo htmlspecialchars($product->getName()); ?></td>
                <td><?php echo number_format($product->getPrice()); ?></td>
                <td><?php echo $product->getQty(); ?></td>
                <td><?php echo number_format($product->lineTotal()); ?></td>
                <td><?php echo $product->stockLevel(); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>Tong gia tri kho = <?php echo $totalValue; ?></p>

    <h2>Dat thu san pham</h2>
    <form method="POST" action="dashboard.php">
        <label>Chon SKU:</label>
        <select name="order_sku">
            <?php foreach ($productObjects as $product): ?>
                <option value="<?php echo htmlspecialchars($product->getSku()); ?>">
                    <?php echo htmlspecialchars($product->getSku() . ' - ' . $product->getName()); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>So luong:</label>
        <input type="number" name="order_qty" min="1" value="1">

        <button type="submit">Dat thu</button>
    </form>

    <h2>Danh sach order (Session)</h2>
    <?php if (empty($_SESSION['orders'])): ?>
        <p>Chua co order nao.</p>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>So luong dat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['orders'] as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['sku']); ?></td>
                    <td><?php echo (int) $order['qty']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>