<?php

use Airam\Tienda\model\Database;

require_once 'model/Database.php';

if (isset($_GET['email'], $_GET['user_number'])) {
    $email = $_GET['email'];
    $user_number = $_GET['user_number'];
    $database = new Database();
    $user = $database->selectUser($email);
    if ($user != null) {
        if ($user->user_number == $user_number) {
            require_once '../public/top.php';
            $database->validateUser($email);
?>
            <h1>Verificación finalizada</h1>
            <a href="../public/index.php">Ir a inicio</a>
<?php
            require_once '../public/bottom.php';
        } else {
            $_SESSION['error'] = 'Ha habido un error';
            header('Location: ../public/index.php');
        }
    }
} else {
    $_SESSION['error'] = 'No hay email';
    header('Location: ../public/index.php');
}
