<?php
namespace Wirams\FusioCrudGen;

use Nette\PhpGenerator;
use Nette\PhpGenerator\ClassType;
use Nette\Utils\Strings;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema;
use Doctrine\DBAL\Schema\Column;

abstract class GeneratorAbstract {
	const ACTION_CLASS='ACTION_CLASS';
	const ACTION_CLASS_CREATE = "Create";
	const ACTION_CLASS_DELETE = "Delete";
	const ACTION_CLASS_GET = "Get";
	const ACTION_CLASS_GETALL = "GetAll";
	const ACTION_CLASS_UPDATE = "Update";
	const MODEL_CLASS='MODEL_CLASS';
	const REPOSITORY_CLASS='REPOSITORY_CLASS';
	const SERVICE_CLASS='SERVICE_CLASS';
	
	const BASE_OUTPUTDIR='Output';
	
	protected $classPrinter;
	protected $appName;
	protected $className;
	protected $classNamespace;
	protected $classUses;
	protected $classProperties;
	protected $classMethods;
	protected $classType;
	protected $dbname;
	protected $tableName;
	protected $classGenerated;
	
	/*
	* Doctrine\DBAL\Schema\Column
	*/
	protected $tableCols;
	
	/*
	* Doctrine\DBAL\Connection
	*/
	public $connection;
	/*
	* Doctrine\DBAL\Schema
	*/
	public $schemaMgr;
	
	abstract function __construct(Connection $connection, String $dbname);
	
	abstract public function generate($tableName,$classType);
	
	abstract public function generateNamespace();
	abstract public function generateUses();
	abstract public function generateProperties();
	abstract public function generateMethods();
	abstract public function generateClassType();
	
	protected function _tableCols(){
		//TO DO : return array of table columns 
		$this->tableCols = $this->schemaMgr->listTableColumns($this->tableName);
		return $this->tableCols;
	}
	
	
	protected function _camelCase($c,$capitalizeFirstCharacter=false){
		$a= array("_","-");
		$str = str_replace(' ', '', ucwords(str_replace($a, ' ', $c)));

		if (!$capitalizeFirstCharacter) {
			$str[0] = strtolower($str[0]);
		}

		return $str;
	}
	/*
	protected private function _olType($colName){
		
	}*/
}
