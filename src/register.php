<?php
include '../public/top.php';

use Airam\Tienda\model\Database;


require_once 'model/email.php';



if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password2'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $userNum = rand(100, 10000);
    $message = "<p><a href=\"http://localhost/Dsw2023CarritoDeCompra/src/validate.php?email=$email&user_number=$userNum\">pincha aquí para validarte</a></p>";
    if (!empty($username) && !empty($email) && !empty($password) && !empty($password2)) {
        if ($password == $password2) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            require_once 'model/Database.php';
            $database = new Database();
            if ($database->selectUser($email) == null) {
                $database->insertUser($username, $email, $password, $userNum);
                sendMail($email, $username, $message);
                header('Location: ../public/index.php');
            } else {
                $_SESSION['error'] = 'El usuario ya existe';
                header('Location: register.php');
            }
        } else {
            $_SESSION['error'] = 'Las contraseñas no coinciden';
            header('Location: register.php');
        }
    } else {
        $_SESSION['error'] = 'Debes rellenar todos los campos';
        header('Location: register.php');
    }
}
?>
<h1>Registro de usuario</h1>
<?php
if (isset($_SESSION['error'])) {
?>
    <div class="error">
        <?= $_SESSION['error']; ?>
    </div>
<?php
    unset($_SESSION['error']);
}
?>
<fieldset>
    <legend>Introduce tus datos:</legend>
    <form action="register.php" method="post">
        <p>
            <label for="username">Nombre: </label>
            <input type="text" name="username" required placeholder="Introduce tu nombre...">
        </p>
        <p>
            <label for="email">Email: </label>
            <input type="email" name="email" required placeholder="Introduce tu email...">
        </p>
        <p>
            <label for="password">Contraseña: <input type="password" name="password" required placeholder="Introduce tu contraseña..."></label>
        </p>
        <p>
            <label for="password2">Confirma la contraseña: <input type="password" name="password2" required placeholder="Confirme la contraseña..."></label>
        </p>
        <p><input type="submit" value="Registrarte"></p>
        <p><a href="../public/index.php">Atrás</a></p>
    </form>
</fieldset>

<?php
include '../public/bottom.php';
