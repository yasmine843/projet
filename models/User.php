<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function userExists($username) {
        $query = $this->db->prepare("SELECT COUNT(*) FROM " . (substr($username, -6) === ".admin" ? "admin" : "visitor") . " WHERE username = :username");
        $query->execute(['username' => $username]);
        return $query->fetchColumn() > 0;
    }

    public function register($username, $password, $confirmPassword) {
        // Vérification que les mots de passe correspondent
        if ($password !== $confirmPassword) {
            return "Les mots de passe ne correspondent pas ! "; // Les mots de passe ne correspondent pas
        }

        if ($this->userExists($username)) {
            return "Nom d'utilisateur déjà pris ! "; // Nom d'utilisateur déjà pris
        }

        $table = (substr($username, -6) === ".admin") ? "admin" : "visitor";
        $query = $this->db->prepare("INSERT INTO $table (username, password) VALUES (:username, :password)");
        $query->execute(['username' => $username, 'password' => password_hash($password, PASSWORD_BCRYPT)]);
        return true; // Inscription réussie
    }

    public function login($username, $password) {
        $table = (substr($username, -6) === ".admin") ? "admin" : "visitor";
        $query = $this->db->prepare("SELECT * FROM $table WHERE username = :username");
        $query->execute(['username' => $username]);
        $user = $query->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return "Nom d'utilisateur ou mot de passe incorrect ! "; // Erreur de connexion
    }
}
?>
