<?php
function validateLogin(&$errors, $field_list, $field_name, $pdo) {
	$memberResult = $pdo->query('SELECT * FROM members');
	$match = false;
    foreach($memberResult as $loginDetails){
        $dbUsername = $loginDetails['memberUsername'];
        $loginUsername = $field_list[$field_name];
        if($loginUsername == $dbUsername){
            $match = true;
        }
    }
    if ($match){
    	session_start();
        $_SESSION['loggedIn'] = true;
        $_SESSION['memberUsername'] = $loginUsername;
        //header('location: index.php');
    } else {
    	$errors[$field_name] = 'does not exist';
    }
}
function validateUsername(&$errors, $field_list, $field_name, $pdo) {
	$checkUserQuery = $pdo->prepare("SELECT memberUsername FROM members WHERE memberUsername = :memberUsername");
    $checkUserQuery->bindParam(':memberUsername', $field_list[$field_name]);
    $checkUserQuery->execute();
    if (!isset($field_list[$field_name])|| empty($field_list[$field_name])) {
		$errors[$field_name] = 'required';
	} else if($checkUserQuery->rowCount() > 0){
		$errors[$field_name] = 'already taken';
	}
}
function validateEmail(&$errors, $field_list, $field_name) {
	$pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-z]{2,4}$/';
	if (!isset($field_list[$field_name])|| empty($field_list[$field_name])) {
		$errors[$field_name] = 'required';
	} else if (!preg_match($pattern, $field_list[$field_name])) {
		$errors[$field_name] = 'invalid';
	}
}
function validateName(&$errors, $field_list, $field_name) {
	$pattern = '/^[A-z]+$/';
	if (!isset($field_list[$field_name])|| empty($field_list[$field_name])) {
		$errors[$field_name] = 'required';
	} else if (!preg_match($pattern, $field_list[$field_name])) {
		$errors[$field_name] = 'invalid';
	}
}
function validatePassword(&$errors, $field_list, $field_name) {
	$pattern = '/^([0-9]+[a-zA-Z]+|[a-zA-Z]+[0-9]+)[0-9a-zA-Z]*$/';
	if (!isset($field_list[$field_name])|| empty($field_list[$field_name])) {
		$errors[$field_name] = 'required';
	} else if ($field_list[$field_name] != $field_list[$field_name.'conf']) {
		$errors[$field_name] = 'must match';
	} else if (!preg_match($pattern, $field_list[$field_name])) {
		$errors[$field_name] = 'must contain at least 1 capital letter and number';
	}
}
?>