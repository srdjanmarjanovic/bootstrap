<?php
use App\Models\Foo;
use App\Config\Configurator as Config;
use App\Databases\MySQLConnection;

require_once __DIR__ . '/vendor/autoload.php';

$db_config = (new Config())->getDatabasesConfig()['mysql'];
$mysql_connection = (new MySQLConnection($db_config['host'], null, $db_config['username'], $db_config['password'], $db_config['db_name']))->connect();

$foo = new Foo($mysql_connection);