<?php
//Constantes
$configs = new HXPHP\System\Configs\Config;

//configuraçoes de servidor local
$configs->env->add('development');
$configs->env->development->baseURI = '/prfight/';
$configs->env->development->database->setConnectionData(array(
		'host'     => 'localhost',
		'user'     => 'root',
		'password' => '',
		'dbname'   => 'databaseprfight',
	));

$configs->env->development->auth->setURLs('/prfight/home/', '/prfight/login/');

$configs->env->development->menu->setMenus(array(
		'Home/home '         => '%baseURI%/home',
		'Editar Perfil/edit' => '%baseURI%/perfil/editar',
		'Usuarios/users'     => '%baseURI%/usuarios/index',
		'Sair/sign-out'      => '%baseURI%/login/Sair',
	), 'administrator');

$configs->env->development->menu->setMenus(array(
		'Home/home'          => '%baseURI%/home',
		'Editar Perfil/edit' => '%baseURI%/perfil/editar',
		'Sair/sign-out'      => '%baseURI%/login/Sair',
	), 'user');

//configuraçoes de servidor externo
$configs->env->add('production');
$configs->env->production->baseURI = '/';
$configs->env->production->auth->setURLs('/home/', '/login/');
$configs->env->production->database->setConnectionData(array(
		'host'     => 'localhost',
		'user'     => 'u686838159_root',
		'password' => 'wa17lawtUt',
		'dbname'   => 'u686838159_banco',
	));
$configs->env->production->menu->setMenus(array(
		'Home/home '         => '%baseURI%/home',
		'Editar Perfil/edit' => '%baseURI%/perfil/editar',
		'Usuarios/users'     => '%baseURI%/usuarios/index',
		'Sair/sign-out'      => '%baseURI%/login/Sair',
	), 'administrator');

$configs->env->production->menu->setMenus(array(
		'Home/home'          => '%baseURI%/home',
		'Editar Perfil/edit' => '%baseURI%/perfil/editar',
		'Sair/sign-out'      => '%baseURI%/login/Sair',
	), 'user');

return $configs;
