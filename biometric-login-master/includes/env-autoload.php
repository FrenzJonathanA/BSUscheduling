<?php

  class DotEnv {
    
    public function __construct(string $path) {
      if(file_exists($path)) {
        $enviromentVariables = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($enviromentVariables as $key) {
          if (strpos(trim($key), '#') === 0) {
            continue;
          }
    
          list($name, $value) = explode('=', $key, 2);
          putenv(sprintf('%s=%s', $name, $value));
        }
    
        // function env($key, $default = null) {
        //   $value = getenv($key);
    
        //   if ($value === false) {
        //     return $default;
        //   }
    
        //   return $value;
        // }
    
      } else {
        echo "DotEnv file could not be found or doesn't exists";
        return false;
      }
    }

  }
  
