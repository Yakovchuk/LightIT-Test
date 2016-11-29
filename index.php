<?php

namespace App;

use App\Core\Core;

session_start();

require_once dirname(__FILE__) . '/vendor/autoload.php';

$Core = new Core();

$req = !empty($_REQUEST['q'])
	? trim($_REQUEST['q'])
	: '';

$Core->handleRequest($req);
