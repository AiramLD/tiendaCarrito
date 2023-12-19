<?php

include '../public/top.php';

use Airam\Tienda\model\Database;

require_once '../src/model/Database.php';
$db = new Database();

if (isset($_SESSION['user'])) {
    echo "<h2>Hola" . $_SESSION['user'] . "</h2>";
}

// Verificar si se ha enviado el formulario para agregar productos al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Obtener el ID del producto enviado desde el formulario
    $product_id = $_POST['product_id'];

    // Verificar si el producto ya está en el carrito y aumentar la cantidad si es así
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        // Obtener los detalles del producto desde la base de datos
        $product_details = $db->selectById('products', $product_id);

        // Agregar el producto al carrito con cantidad 1
        $_SESSION['cart'][$product_id] = [
            'name' => $product_details['name'],
            'price' => $product_details['price'],
            'quantity' => 1
        ];
    }
}

if ($_SESSION['admin']) {
    echo '<a href="admin.php">Menú administrador</a><br>';
}
?>
<a href="logout.php">Cerrar sesión</a>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $db->selectAll('products');
        while ($product = $result->fetch(PDO::FETCH_OBJ)) {
        ?>
            <tr>
                <td><?= $product->name ?></td>
                <td><?= $product->description ?></td>
                <td><?= $product->price ?>€</td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="<?= $product->id ?>">
                        <button type="submit">Añadir al Carrito</button>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?php
include 'cart.php';
include '../public/bottom.php';
?>