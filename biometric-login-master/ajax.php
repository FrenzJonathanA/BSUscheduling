<?php
  include 'includes/env-autoload.php';
  new DotEnv('./.env');

  require_once 'includes/class-autoloader.php';
  $users = new Users();

  
  if(isset($_POST['createUser'])){
    $user = $users->createUser();
    echo $user;
    return;
  }
  

  if(isset($_POST['logUser'])){
    $user = $users->loginByFace();
    echo $user;
    return;
  }