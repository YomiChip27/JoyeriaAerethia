<?php

class Config{

    public static $host = 'sql112.infinityfree.com';
    public static $db = 'if0_42122107_joyeria'; 
    public static $user = 'if0_42122107';
    public static $pass = 'Ex2dw4xK0wW44';
    public static $charset = "utf8mb4";
    public static $base_url = "https://aerethia.infinityfree.io/";
    public static $env = "production";
}

if(Config::$env == "development"){
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

date_default_timezone_set('Europe/Madrid');