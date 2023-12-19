<?php
require 'top.php';
?>
<h2>Bienvenido a la tienda virtual</h2>
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
    <legend>Login</legend>
    <form action="../src/login.php" method="post">
        <p>
            <input type="email" name="email" placeholder="Introduzca su email...">
        </p>
        <p>
            <input type="password" name="password" placeholder="Introduzca su contraseña...">
        </p>
        <p>
            <input type="submit" value="Iniciar Sesión">
        </p>
        <p><a href="../src/register.php">No tengo cuenta</a></p>
    </form>
</fieldset>

<?php
require 'bottom.php';
