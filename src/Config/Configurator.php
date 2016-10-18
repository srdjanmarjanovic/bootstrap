<?php 
namespace App\Config;

class Configurator
{
	public function __construct()
	{
		if (empty($this->app)) {
			$this->app = require_once(__DIR__ . '/app.php');
		}

		if (empty($this->databases)) {
			$this->databases = require_once(__DIR__ . '/databases.php');
		}
	}

	/**
	 * Get application configuration.
	 * 
	 * @return array
	 */
	public function getAppConfig()
	{
		return $this->app;
	}

	/**
	 * Get databases configuration.
	 * 
	 * @return array
	 */
	public function getDatabasesConfig()
	{
		return $this->databases;
	}
}