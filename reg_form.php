<?php
$errors = array();
require 'db.php';
require 'function.php';
if (isset($_POST['submitMember'])) { // registering new user
    require 'validate.php';
    validateUsername($errors, $_POST, 'usrname', $pdo);
	validateName($errors, $_POST, 'name');
    validateEmail($errors, $_POST, 'email');
	validatePassword($errors, $_POST, 'pass');
    if ($errors) {
        include 'registration.php';
    } else {
        $memberUsername = $_POST['usrname'];
        $memberName = $_POST['name'];
        $memberEmail = $_POST['email'];
        $memberPassword = salt($_POST['pass']);
        $insertMember = $pdo->prepare('INSERT INTO members(memberUsername, memberName, memberEmail, memberPassword) VALUES(:memberUsername, :memberName, :memberEmail, :memberPassword)');
        $insertMember->bindValue(':memberUsername', $memberUsername);
        $insertMember->bindValue(':memberName', $memberName);
        $insertMember->bindValue(':memberEmail', $memberEmail);
        $insertMember->bindValue(':memberPassword', $memberPassword);
        $insertMember->execute();
        include 'index.php';
    }
} else if (isset($_POST['loginMember'])){ // logging into existing use
    require 'validate.php';
    validateLogin($errors, $_POST, 'loginUsername', $pdo);
    if ($errors){
        include 'registration.php';
    } else {
        include 'index.php';
    }
} else {
    include 'registration.php';
}
?>