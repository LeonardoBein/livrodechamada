<?php

$install = false;

if (!define('VERSION'))
	define('VERSION', '0.0.0-beta');
// URL princiapl http://exemple.com
define('URL_PRINCIPAL', 'http://%siteP%');
//DOMINIO exemple.com
define('DOMINIO', '%siteP%');
//codigo do cadastro
define('CODE_LOGIN', '%code%');
// email para validar e trocar a Senha
define('MAIL_SENDER', '%mailSender%');
//email de resposta
define('MAIL_RESPOSTA', '');;

if ( !defined('RECAPTCHA') )
	//%recaptcha%

if ( !defined('RECAPTCHA_site_key') )
	define('RECAPTCHA_site_key', '%RECAPTCHA_site_key%');

if ( !defined('RECAPTCHA_secret_key') )
	define('RECAPTCHA_secret_key', '%RECAPTCHA_secret_key%');

if ( !defined('RAIZ') )
	define('RAIZ', dirname(__DIR__) . '/');

if ( !defined('DEBUG') )
	define('DEBUG', true);

?>
