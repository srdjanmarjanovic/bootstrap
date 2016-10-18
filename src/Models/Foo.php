<?php 
namespace App\Models;
use App\Databases\IConnection;

class Foo extends BaseModel
{
	/**
	 * @param IConnection $name
	 */
	public function __construct(IConnection $db)
	{
		parent::__construct($db);
	}
}