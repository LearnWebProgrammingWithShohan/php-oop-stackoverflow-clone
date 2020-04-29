<?php
  namespace Config;

  session_start();

  $GLOBALS['config'] = [
    'mysql' => [
      'host' => '127.0.0.1',
      'username' => 'root',
      'password' => '',
      'db' => 'multiauth_oop'
    ]
  ];

  class Env {
    static function get($path = '') {
      $config = $GLOBALS['config'];
      $path = explode('/', $path);

      foreach($path as $bit) {
        if(isset($config[$bit])) {
          $config = $config[$bit];
        }
      }
      return $config;
    }
  }

 ?>
