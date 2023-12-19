<?php
session_start();

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    echo 'No tienes acceso a esta página';
    exit();
}
echo "Bienvenido al área administrativa.";
