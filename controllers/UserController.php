<?php
class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function signUp($username, $password, $confirmPassword) {
        return $this->userModel->register($username, $password, $confirmPassword);
    }

    public function signIn($username, $password) {
        return $this->userModel->login($username, $password);
    }
}
?>
