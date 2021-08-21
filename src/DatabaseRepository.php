<?php
namespace Wirams\FusioCrudGen;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\DriverManager;

class DatabaseRepository implements DatabaseRepositoryInterface{
	protected $connection;
	public function __construct(Connection $connection){
		$this->connection = $connection;
	}
	
	public function setDatabaseName($dbname){
		$connectionParams = array(
			'dbname' => $dbname,
			'user' => 'root',
			'password' => '',
			'host' => 'localhost',
			'driver' => 'pdo_mysql',
		);
		$this->connection = DriverManager::getConnection($connectionParams);

	}

	/* Function to get all the databases from the schema */
	public function getDatabases(){
		$sm = $this->connection->getSchemaManager();
		$databases = $sm->listDatabases();
		return $databases;
	}

	/* Get all the tables related to specific database */
	public function getTables($database){
		$result = $this->connection->query("SELECT TABLE_NAME as tableName FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$database'");
		return $result->fetchAllAssociative();

	}

	/* Return all the coloumn names of table */
	public function getColoumnNamesOfTable($tableName){
		
			$coloumnResult = $this->connection->query("DESC $tableName");
			
			return $coloumnResult->fetchAllAssociative();
		
	}

	/* Gets the primary key for the respective table */
	public function getPrimaryKey($tableName){

	}
}