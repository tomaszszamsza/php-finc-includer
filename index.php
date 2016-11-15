<?php


//Konfiguracja skryptu
error_reporting(E_ALL);
date_default_timezone_set("Europe/Warsaw");
define('DOCROOT',realpath(__DIR__));
define('FINC_DOCROOT',realpath(__DIR__)."/site");
define('FINC_DEFAULT_FILE',"_default.php");


//Załaduj potrzebne biblioteki
include(__DIR__."/vendor/PHPMailer/PHPMailerAutoload.php");
include(__DIR__."/_framework/includer.php");

//Dorób funcje:// finc_uri - do tworzenia linków/sciezek
//Zaladuj właściwą stronę (wg ścieżki URL)
$finc_path = str_replace(  str_replace("/index.php","",$_SERVER['PHP_SELF'])  ,  "",  $_SERVER['REQUEST_URI']  );
$page = finc_includer_buffer($finc_path,"layout",array());

//Podmiana linków, źródeł (action,href,src)
$finc_path_prefix = preg_replace("/^(.*)\/index\.php.*$/","\\1",$_SERVER['PHP_SELF']);
$page = preg_replace("/(src|href|action)=\"\//siU","\\1=\"{$finc_path_prefix}/",$page);

//Wyświetlenie strony
echo $page;

?>
