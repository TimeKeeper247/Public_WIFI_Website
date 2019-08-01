<?php
    function salt($password){
      $salt = uniqid();
      return hash('sha256', $password . $salt);
    }
?>