<?php 
namespace App\Models;
use App\Databases\IConnection;

abstract class MySQLModel implements IModel
{
	/**
	 * @var IConnection
	 */
	private $db;

	/**
	 * @var boolean
	 */
	protected $exists = false;

	/**
	 * Retrun model table name binding.
	 * 
	 * @return string
	 */
	abstract public function getTableName();

	/**
	 * Return model primary key field name.
	 * 
	 * @return string
	 */
	abstract public function getPrimaryKeyName();

	/**
	 * Return model field names.
	 * 
	 * @return array
	 */
	abstract public function getFields();

	public function __construct(IConnection $db_connection) {
		$this->db = $db_connection;
	}

	/**
	 * Return resource by primary key.
	 * 
	 * @return MySQLModel
	 */
	public function find($primary_key_value)
	{
		$query = "SELECT * FROM {$this->getTableName()} WHERE {$this->getPrimaryKeyName()} = :primary_key ORDER BY id DESC LIMIT 1";
		$statement = $this->db->connection->prepare($query);
		$statement->execute([':primary_key' => $primary_key_value]);

		$result = $statement->fetch($this->db->connection::FETCH_ASSOC);

		return $this->hydrate($result);
	}

	/**
	 * Create or update resource.
	 * 
	 * @return bool TRUE if operation is sucessfull, FALSE otherwise.
	 */
	public function save()
	{
		$field_values = [];
		foreach ($this->getFields() as $field) {
			if (property_exists($this, $field)) {
				$field_values[$field] = $this->$field;
			}
		}

		if ($this->exists) {
			$saved = $this->doUpdateQuery($field_values);
		} else {
			$saved = $this->doInsertQuery($field_values);
		}

		return $this;
	}

	/**
	 * Delete resource.
	 * 
	 * @return bool
	 */
	public function delete()
	{
		$primary_key_name = $this->getPrimaryKeyName(); // name of the model primary key, usually 'id'
        $primary_key_value = $this->{$primary_key_name}; // value of the model primary key, usually of $this->id

		$query = "DELETE FROM {$this->getTableName()} WHERE {$primary_key_name} = :primary_key";
		$statement = $this->db->connection->prepare($query);
		$statement->execute([':primary_key' => $primary_key_value]);

		return $this;
	}

	/**
	 * Perform SQL INSERT query.
	 * 
	 * @param  array  $field_value_map Array where all the keys represent a column in MySQL database and values 
	 *                                 represent the values of those columns.
	 * @return bool
	 */
	private function doInsertQuery(array $field_value_map)
	{
		$params_map = [];
		foreach ($field_value_map as $key => $value) {
			$params_map[':' . $key] = $value;
		}

		$query = "INSERT INTO {$this->getTableName()} (" . implode(', ', array_keys($field_value_map)) . ") VALUES (" . implode(', ', array_keys($params_map))  . ")";

		$statement = $this->db->connection->prepare($query);

		$saved = $statement->execute($params_map);

		if ($saved) {
			$this->exists = true;
			$this->id = $this->db->connection->lastInsertId();
		} 

		return $saved;
	}

	/**
	 * Perform MySQL UPDATE query.
	 * 
	 * @param  array  $field_value_map
	 * @return bool                
	 */
	private function doUpdateQuery(array $field_value_map)
	{		
		$query = "UPDATE {$this->getTableName()} SET ";

		$columns = $params_map = [];

		// make attribute = :attribute_placeholder structure, as well as a params array like :attribute_placeholder => actual_value
	    foreach($field_value_map as $key => $value) 
        {			
        	$param = ':' . $key;
    		$params_map[$param] = $value;
            $columns[] = $key . ' = ' . $param;
        }

        $query .= implode(', ', $columns);
        $primary_key_name = $this->getPrimaryKeyName(); // name of the model primary key, usually 'id'
        $primary_key_value = $this->{$primary_key_name}; // value of the model primary key, usually of $this->id

        $query .= " WHERE {$primary_key_name} = :primary_key";

		$statement = $this->db->connection->prepare($query);
		$statement->execute(array_merge($params_map, [':primary_key' => $primary_key_value]));

		return $this;
	}

	/**
	 * Bind database fields to model properties.
	 * 
	 * @param  array $result
	 */
	private function hydrate($result)
	{
		foreach ($this->getFields() as $field) {
			$this->$field = $result[$field];
		}

		return $this;
	}
}