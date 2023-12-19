<?php

use Airam\Tienda\model\Database;

require_once 'model/Database.php';
$db = new Database;
session_start();
if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!empty($email) && !empty($password)) {
        $user = $db->selectUser($email);
        if ($user != null) {
            if ($user->admin) {
                $_SESSION['admin'] = 1;
            } else {
                $_SESSION['admin'] = 0;
            }
            if (password_verify($password, $user->password)) {
                $_SESSION['user'] = $user->name;
                header('Location: shop.php');
            } else {
                $_SESSION['error'] = 'Contraseña incorrecta';
                header('Location: ../public/index.php');
            }
        } else {
            $_SESSION['error'] = 'Usuario incorrecto';
            header('Location: ../public/index.php');
        }
    } else {
        $_SESSION['error'] = 'Debe rellenar todos los campos';
        header('Location: ../public/index.php');
    }
}
