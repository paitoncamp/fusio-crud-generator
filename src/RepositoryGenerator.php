<?php
namespace Wirams\FusioCrudGen;

use Nette\PhpGenerator;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Constant;
use Nette\PhpGenerator\Printer;
use Nette\Utils\Strings;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema;
use Doctrine\DBAL\Schema\Column;
use Nette\Utils\FileSystem;
use Nette\PhpGenerator\PhpFile;

class RepositoryGenerator extends GeneratorAbstract {
	
	function __construct(Connection $connection, String $dbname){
		$this->dbname = $dbname;
		$this->connection = $connection;
		$this->schemaMgr = $this->connection->getSchemaManager();
		$this->classType=self::REPOSITORY_CLASS;
		$this->appName = $this->_camelCase($this->dbname,true);
		//-- turn off auto-resolving class 
		$this->classPrinter = new Printer; // or PsrPrinter
		$this->classPrinter->setTypeResolving(false);
		
	}
	
	public function generate($tableName,$classType=null){
		if($classType!=null){
			$this->classType = $classType;
		}
		$this->tableName = $tableName;
		$this->_tableCols(); //get the table columns list
		$this->className = $this->_camelCase($tableName,true);
		
		$this->generateNamespace();
		$this->generateUses();
		$this->generateClassType();
		$this->generateProperties();
		$this->generateMethods();
		
		$phpFile = new PhpFile();
		$phpFile->addComment('This file is auto-generated.');
		$phpFile->addNamespace($this->classNamespace);
		
		$location = self::BASE_OUTPUTDIR."\\".$this->classType."\\".$this->appName;
		
		FileSystem::createDir($location);
		FileSystem::write($location."\\".$this->className.".php",$this->classPrinter->printFile($phpFile));
		return self::REPOSITORY_CLASS." - ".$this->className." generated!";
		
		//return $this->classNamespace;
	}
	
	public function generateClassType(){
		$this->classGenerated->addComment("Description of ".$this->className." class from entity ".$this->tableName.".\n\n");

		return $this->classGenerated;
	}
	
	public function generateNamespace(){
		//namespace App\Action\OpenGL;
		$this->classNamespace = New PhpNamespace('App\\Repository\\'.$this->appName); 
		
		$this->classGenerated = $this->classNamespace->addClass($this->className);
		return $this->classNamespace;
	}
	
	public function generateUses(){
		$this->classNamespace->addUse('Doctrine\\DBAL\\Connection');
		$this->classNamespace->addUse('Doctrine\DBAL\DBALException');
	}
	
	public function generateProperties(){
		$this->classGenerated->addProperty('connection')->setPrivate()
		->addComment("@var Connection");
	}
	
	public function generateMethods(){
		//method __construct()
		$this->classMethods = $this->classGenerated->addMethod('__construct');
		//body
		//$this->classMethods->addBody('$this->tenantMemberService=$tenantMemberService;');
		$this->_generateSetupConnectionMethod();
		$this->_generateFindByIdMethod();
		$this->_generateInsertMethod();
		$this->_generateUpdateMethod();
		$this->_generateDeleteMethod();
	}
	
	private function _generateSetupConnectionMethod(){
		$this->classMethods = $this->classGenerated->addMethod('setupConnection');
		$this->classMethods->addParameter("connection")->setType("Connection");
		$this->classMethods->addBody('$this->connection=$connection;');
	}
	
	private function _generateFindByIdMethod(){
		$this->classMethods = $this->classGenerated->addMethod('findById');
		$this->classMethods->addParameter("id")->setType("int");
		$this->classMethods->addBody('return $this->connection->fetchAssoc(\'');
		$this->classMethods->addBody('SELECT ');
		foreach($this->tableCols as $column){
			$this->classMethods->addBody('`'.$column->getName().'`,');	
		}
		$this->classMethods->addBody('		FROM '.$this->tableName.' WHERE `id` = :id\', [');
        $this->classMethods->addBody('    \'id\' => $id,');
        $this->classMethods->addBody(']);');
	}
	
	private function _generateInsertMethod(){
		$this->classMethods = $this->classGenerated->addMethod('insert')->setReturnType('int');
		foreach($this->tableCols as $column){
			$param = $this->classMethods->addParameter($this->_camelCase($column->getName()));
			if($column->getType()->getName()=='integer'){
				$param->setType("int");
			} elseif($column->getType()->getName()=='string' || $column->getType()->getName()=='text' ){
				$param->setType("string");
			} else {
				//other data type need further improvement
				$param->setType($column->getType()->getName());
			}
		}
		$this->classMethods->addBody('$this->connection->insert(\''.$this->tableName.'\', [');
		foreach($this->tableCols as $column){
			$this->classMethods->addBody('\''.$column->getName().'\'=>$'.$this->_camelCase($column->getName()).',');
		}
		$this->classMethods->addBody('],[');
		$this->classMethods->addBody('\'id\'=>$id');
		$this->classMethods->addBody(']);');
		
		$this->classMethods->addBody('return $id;');
	}
	
	private function _generateUpdateMethod(){
		$this->classMethods = $this->classGenerated->addMethod('update')->setReturnType('int');
		foreach($this->tableCols as $column){
			$param = $this->classMethods->addParameter($this->_camelCase($column->getName()));
			if($column->getType()->getName()=='integer'){
				$param->setType("int");
			} elseif($column->getType()->getName()=='string' || $column->getType()->getName()=='text' ){
				$param->setType("string");
			} else {
				//other data type need further improvement
				$param->setType($column->getType()->getName());
			}
		}
		$this->classMethods->addBody('$this->connection->update(\''.$this->tableName.'\', [');
		foreach($this->tableCols as $column){
			$this->classMethods->addBody('\''.$column->getName().'\'=>$'.$this->_camelCase($column->getName()).',');
		}
		$this->classMethods->addBody('],[');
		$this->classMethods->addBody('\'id\'=>$id');
		$this->classMethods->addBody(']);');
		
		$this->classMethods->addBody('return $id;');
	}
	
	private function _generateDeleteMethod(){
		$this->classMethods = $this->classGenerated->addMethod('delete')->setReturnType('int');
		$param = $this->classMethods->addParameter("id")->setType("int");
		$this->classMethods->addBody('$this->connection->delete(\''.$this->tableName.'\', [');
		$this->classMethods->addBody('\'id\'=>$id');
		$this->classMethods->addBody(']);');
		
		$this->classMethods->addBody('return $id;');
	}
}