<?php
namespace Wirams\FusioCrudGen;

use Nette\PhpGenerator;
use Nette\PhpGenerator\ClassType;
use Nette\Utils\Strings;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema;
use Doctrine\DBAL\Schema\Column;

class Generator extends GeneratorAbstract {
	
	function __construct(Connection $connection, String $dbname){
		$this->dbname = $dbname;
		$this->connection = $connection;
		$this->schemaMgr = $this->connection->getSchemaManager();
		//$this->classType=$classType;
	}
	
	public function generate($tableName){
		
		$this->tableName = $tableName;
		$this->className = Strings::replace(Strings::capitalize($tableName),[
			'~[\_]+~i' => '',
			'~\s+~' => '',
			]); //camel case it 
		$rest = $this->generateClassType();
		return $rest;
	}
	
	public function generateClassType(){
		$this->classGenerated = new ClassType($this->className);

		$this->classGenerated->addComment("Description of ".$this->className." class.\n\n");

		// to generate PHP code simply cast to string or use echo:
		return $this->classGenerated;
	}
	
	public function test(){
		echo "test";
	}
}