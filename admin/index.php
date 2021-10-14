<?php
include_once 'Utilidades/main.php';

if (isset($_SESSION['idUserAdmin'])) {
  session_regenerate_id(true);
  include_once 'vistas/home.php';
} else if (isset($_POST['btn-login']) && isset($_POST['email']) && isset($_POST['password'])) {

  $txtEmail = $_POST['email'];
  $txtPassword = $_POST['password'];

  if ($activeUser->login($_POST['email'], $_POST['password'])) {
    try {
      $adminUser = $activeUser->getUserByEmail($_POST['email']);

      $session->setCurrentId($adminUser->getIdUsuario());
      $session->setCurrentEmail($adminUser->getEmail());
      $session->setCurrentName($adminUser->getNombre(), $adminUser->getApellido());
      $session->setCurrentPhoto($adminUser->getFoto());

      include_once 'vistas/home.php';
    } catch (Exception $e) {
      echo "<script> alert('Usuarios y contraseña invalidos') </script>";
      include_once 'vistas/login.php';
    }
  } else {
    echo "<script> alert('Usuarios y contraseña invalidos') </script>";
    include_once 'vistas/login.php';
  }
} else {
  include_once 'vistas/login.php';
}
