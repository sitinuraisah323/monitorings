<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
	/**
	 * The directory that holds the Migrations
	 * and Seeds directories.
	 *
	 * @var string
	 */
	public $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

	/**
	 * Lets you choose which connection group to
	 * use if no other is specified.
	 *
	 * @var string
	 */
	public $defaultGroup = 'default';

	/**
	 * The default database connection.
	 *
	 * @var array
	 */
	public $default = [
		'DSN'      => '',
		'hostname' => 'localhost',
		'username' => 'root',
		'password' => 'aisyah',
		'database' => 'db_ghanet',
		'DBDriver' => 'mysqli',
		'DBPrefix' => '',
		'pConnect' => false,
		'DBDebug'  => (ENVIRONMENT !== 'production'),
		'charset'  => 'utf8',
		'DBCollat' => 'utf8_general_ci',
		'swapPre'  => '',
		'encrypt'  => false,
		'compress' => false,
		'strictOn' => false,
		'failover' => [],
		'port'     => 3306,
	];
		/**
	 * The default database connection.
	 *
	 * @var array
	 */
	public $va = [
		'DSN'      => 'pgsql:host=pgm-d9j27ilqxc110opbko.pgsql.ap-southeast-5.rds.aliyuncs.com;port=1921;dbname=gcore_transaction_db',
		'hostname' => 'locpgm-d9j27ilqxc110opbko.pgsql.ap-southeast-5.rds.aliyuncs.comalhost',
		'username' => 'deploy',
		'password' => 'Doterb2020',
		'database' => 'gcore_transaction_db',
		'DBDriver' => 'Pdo',
		'DBPrefix' => '',
		'pConnect' => false,
		'DBDebug'  => (ENVIRONMENT !== 'production'),
		'charset'  => 'utf8',
		'DBCollat' => 'utf8_general_ci',
		'swapPre'  => '',
		'encrypt'  => false,
		'compress' => false,
		'strictOn' => false,
		'failover' => [],
		// 'port'     => 3306,
	];

	/**
	 * This database connection is used when
	 * running PHPUnit database tests.
	 *
	 * @var array
	 */
	public $tests = [
		'DSN'      => 'Postgre://deploy:Doterb2020@pgm-d9j27ilqxc110opbko.pgsql.ap-southeast-5.rds.aliyuncs.com:1921/gcore_transaction_db',
	];
	
	public $accounting = [
		'DSN'      => 'Postgre://deploy:Doterb2020@pgm-d9j27ilqxc110opbko.pgsql.ap-southeast-5.rds.aliyuncs.com:1921/gcore_accounting_db',
		    // 'dsn'	=> 'pgsql:host=pgm-d9j27ilqxc110opbko.pgsql.ap-southeast-5.rds.aliyuncs.com;port=1921;dbname=gcore_accounting_db',

	];

	// public $ghadis = [
	// 	'DSN'      => 'Postgre://deploy:Doterb2020@pgm-d9j27ilqxc110opbko.pgsql.ap-southeast-5.rds.aliyuncs.com:1921/gcore_transaction_db',
	// ];

	// print_r($tests); exit;
	// $db2 = \Config\Database::connect($tests);
	//--------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		// Ensure that we always set the database group to 'tests' if
		// we are currently running an automated test suite, so that
		// we don't overwrite live data on accident.
		if (ENVIRONMENT === 'testing')
		{
			$this->defaultGroup = 'tests';
		}
	}

	//--------------------------------------------------------------------

}