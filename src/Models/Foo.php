<?php 
namespace App\Models;
use App\Databases\IConnection;
use App\Models\MySQLModel as Model;

class Foo extends Model
{
	/**
	 * @var string
	 */
	private $table_name = 'users';

	/**
	 * @var array
	 */
	private $fields = ['id', 'first_name', 'last_name'];

	/**
	 * @var string
	 */
	private $primary_key_name = 'id';

	/**
	 * @param IConnection $name
	 */
	public function __construct(IConnection $db)
	{
		parent::__construct($db);
	}

	public function getTableName() 
	{
		return $this->table_name;
	}

	public function getFields() {
		return $this->fields;
	}

	public function getPrimaryKeyName()
	{
		return $this->primary_key_name;
	}
}