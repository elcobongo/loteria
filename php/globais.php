<?php
error_reporting(E_ERROR | E_WARNING);

require_once __DIR__.'/vendor/Template_pt-br/Template.class.php';
require_once __DIR__."/bootstrap.php";
require_once __DIR__."/utils.php";

require_once __DIR__."/dto/Usuario.php";
require_once __DIR__."/dto/Jogo.php";

require_once __DIR__."/dao/UsuarioDAO.php";
require_once __DIR__."/dao/JogoDAO.php";


use Illuminate\Database\Capsule\Manager as DB;

