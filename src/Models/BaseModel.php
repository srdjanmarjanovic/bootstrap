<?php 
namespace App\Models;
use App\Databases\IConnection;

abstract class BaseModel
{
	/**
	 * @var IConnection
	 */
	private $db;

	public function __construct(IConnection $db_connection) {
		$this->db = $db_connection;
	}
}