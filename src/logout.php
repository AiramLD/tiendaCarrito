<?php
// Cerrar la sesión y eliminar la cookie
session_start();
session_unset();
session_destroy();
header('Location: ../public/index.php');
