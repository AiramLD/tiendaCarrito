<?php

use Airam\Tienda\model\Database;

require_once '../src/model/Database.php';
$db = new Database();
if (isset($_SESSION['user'])) {
    echo "<h2>Hola" . $_SESSION['user'] . "</h2>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_product_id'])) {
    $remove_product_id = $_POST['remove_product_id'];
    if (isset($_SESSION['cart'][$remove_product_id])) {
        $_SESSION['cart'][$remove_product_id]['quantity']--;
        if ($_SESSION['cart'][$remove_product_id]['quantity'] <= 0) {
            unset($_SESSION['cart'][$remove_product_id]);
        }
    }
}
$total = 0;

?>

<h3>Carrito de Compras</h3>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Precio Unitario</th>
            <th>Cantidad</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

            foreach ($_SESSION['cart'] as $product_id => $item) {
        ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['price'] ?>€</td>
                    <td><?= $item['quantity'] ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="remove_product_id" value="<?= $product_id ?>">
                            <button type="submit">Quitar del Carrito</button>
                        </form>
                    </td>
                </tr>
            <?php
                // Calcular el subtotal de cada producto y sumarlo al total
                $subtotal = floatval($item['price']) * $item['quantity'];
                $total += $subtotal;
            }
            ?>
            <tr>
                <td colspan="3">Total</td>
                <td><?= $total . "€" ?></td>
            </tr>
        <?php
        } else {
            echo "<tr><td colspan='4'>No hay productos en el carrito</td></tr>";
        }
        ?>
    </tbody>
</table>