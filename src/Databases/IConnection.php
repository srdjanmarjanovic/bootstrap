<?php 
namespace App\Databases;

interface IConnection {
	public function connect();
	public function disconnect();
}