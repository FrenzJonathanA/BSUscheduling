<?php
  spl_autoload_register('myAutoloader');

  function myAutoloader($className) {
    $path = "core/" . strtolower($className) . ".class.php";

    if(!file_exists('./'.$path)) {
      echo("<h3>". $className . " class could not be included because it does not exist.</h3>");
      return;
    }
    
    include_once $path;
  }