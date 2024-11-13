<?php
require_once '../config/config.php';
require_once '../models/User.php';
require_once '../controllers/UserController.php';

// Démarrer la session
session_start(); 

// Initialiser le contrôleur des utilisateurs
$userController = new UserController($db);
$error = '';

// Traiter les actions d'inscription ou de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    if ($action === 'signup') {
        $result = $userController->signUp($username, $password, $confirmPassword);
        if ($result !== true) {
            $error = $result; // Récupérer le message d'erreur
        } else {
            // Rediriger vers la page de connexion après l'inscription réussie
            header("Location: index.php?action=signin");
            exit();
        }
    } elseif ($action === 'signin') {
        $result = $userController->signIn($username, $password);
        if ($result === true) {
            // Connexion réussie, stocker le nom d'utilisateur en session
            $_SESSION['username'] = $username;
            header("Location: ../views/home.php"); // Rediriger vers la page d'accueil
            exit();
        } else {
            $error = $result; // Récupérer le message d'erreur
        }
    }
}

// Inclure la vue HTML
require_once '../views/login.php';
?>
