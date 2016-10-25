<?php 
namespace App\Databases;
use PDO;
class MySQLConnection implements IConnection
{
	/**
	 * @param string $host     If not provided, defaults to 'localhost'
	 * @param int $port        If not provided, defaults to 3306
	 * @param string $username
	 * @param string $password 
	 * @param string $db_name
	 */
	public function __construct($host = null, $port = null, $username, $password, $db_name)
	{
		$this->host = $host ?: 'localhost';
		$this->port = $port ?: 3306;
		$this->username = $username;
		$this->password = $password;
		$this->db_name = $db_name;
	}

	/**
	 * Connect to MySQL database.
	 * 
	 * @return MySQLConnection
	 */
	public function connect()
	{
		if (empty($this->connection)) {
        	$this->connection = new PDO("mysql:host={$this->host}:{$this->port};dbname={$this->db_name}", $this->username, $this->password);
        	$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

        return $this;
	}

	/**
	 * Disconnect from MySQL database.
	 */
	public function disconnect() 
	{
		unset($this->connection);
	}
}