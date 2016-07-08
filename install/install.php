<?php
require("include/header.php");

$_A['host'] = $_POST['host'];
$_A['bancDB'] = $_POST['bancDB'];
$_A['userDB'] = $_POST['userDB'];
$_A['passwordDB'] = $_POST['passwordDB'];
$_B['siteP'] = $_POST['siteP'];
$_B['emailSender'] = $_POST['emailSender'];
$_B['code'] = $_POST['code'];

$config_db = array( '%host%',
                    '%bancDB%',
                    '%passwordDB%',
                    '%userDB%');
$config_main = array( '%siteP%',
                      '%mailSender%',
                      '%code%',
                      '//%recaptcha%');

if ($_POST['recaptcha'] == 'on') {
  array_push( $config_main , '%RECAPTCHA_site_key%', '%RECAPTCHA_secret_key%');
  $_B['recaptcha'] = "define('RECAPTCHA', true);";
  $_B['recaptcha_key_site'] = $_POST['recaptcha_key_site'];
  $_B['recaptcha_key_secret'] = $_POST['recaptcha_key_secret'];
}
else {
  $_B['recaptcha'] = "define('RECAPTCHA', false);";
}

$file_db = RAIZ."config/db_inc.php";
$file_main = RAIZ."config/main_inc.php";

if (!file_exists($file_db) || !file_exists($file_main)) {
  die("Error: the file configuration not exist");
}
if (!is_writable($file_main) || !is_writable($file_db)) {
  $error = chmod($file_main, 0766);
  $error = chmod($file_db, 0766);
}

//read files
$read_db = file_get_contents($file_db);
$read_main = file_get_contents($file_main);

//open files
$file_db_open = fopen($file_db,"w");
$file_main_open = fopen($file_main,"w");
 if (!($file_main_open) || !($file_db_open)) {
   die("Error: it was not possible to create or read file<br>run in the terminal as root: <br># chown -R www-data:www-data config/");

 }


$read_db_end = str_replace($config_db, $_A, $read_db);
$read_main_end = str_replace($config_main , $_B , $read_main);
$read_main_end = str_replace("\$install = false;" , "\$install = true;" , $read_main_end);


if(!fwrite($file_db_open,$read_db_end) || !fwrite($file_main_open,$read_main_end)){
  die("Error: write");

}
fclose($file_db_open);
fclose($file_main_open);

sleep(3);
header("Location: ../index.php");

?>
