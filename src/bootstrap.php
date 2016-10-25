<?php 
use App\Config\Configurator as Config;
use App\Databases\MySQLConnection;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$db_config = (new Config())->getDatabasesConfig()['mysql'];
$db_connection = (new MySQLConnection($db_config['host'], null, $db_config['username'], $db_config['password'], $db_config['db_name']))->connect();
