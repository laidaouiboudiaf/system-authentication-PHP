<?php
session_start(); // Démarrage de la session
// verifier si  les champs  existent et ils ne sont pas vide
if (isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    // cross-site scripting
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $email = strtolower($email);
    require_once '../config.php';
    require 'fonctions.php';
    // On regarde si l'utilisateur est inscrit dans la table utilisateurs
    $query = checkUser($email);
    var_dump($data);
    $exist = count($data);
    if ($exist > 0) {
        // Si le mail est bon niveau format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // verfier si le mot passe est identique
            if (password_verify($password, $data['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['pseudo'] = $query['pseudo'];

                header('Location: ../profil.php');
                exit;
            } else {
                header('Location: ../index.php?connexion_erreur=password');
                exit;
            }
        } else {
            header('Location: ../index.php?connexion_erreur=email');
            exit;
        }
    } else {
        header('Location: ../index.php?connexion_erreur=existe');
        exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}
