<?php 
namespace App\Models;

interface IModel {
	public function find($primary_key_value);
	public function save();
	public function delete();
}