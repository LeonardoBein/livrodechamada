#!/bin/bash

cd config/
echo "<?php

// configuração do banco de dados
define('LOCALHOSTDB' , '%host%');
define('USERNAMEDB', '%userDB%');
define('PASSWORDDB', '%passwordDB%');
define('BANCDB',  '%bancDB%');


?>" > db_inc.php
echo "<?php

\$install = false;

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

?>" > main_inc.php
cd ..
#chown -R www-data:www-data config/
wget https://raw.githubusercontent.com/google/recaptcha/1.0.0/php/recaptchalib.php -O classes/recaptchalib.php
wget https://gist.githubusercontent.com/TiuTalk/3438461/raw/6be0ec3d4b81f91284e38ee89cf0c02158f1db85/Bcrypt.php -O classes/bcrypt.php
wget http://www.mpdfonline.com/repos/MPDF_6_0.zip -O /tmp/MPDF.zip
unzip /tmp/MPDF.zip -d include/
mv include/mpdf60 include/mpdf
