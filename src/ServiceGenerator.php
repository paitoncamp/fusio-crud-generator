<?php
namespace Wirams\FusioCrudGen;

use Nette\PhpGenerator;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Nette\Utils\Strings;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema;
use Doctrine\DBAL\Schema\Column;
use Nette\Utils\FileSystem;
use Nette\PhpGenerator\PhpFile;

//TO DO need to tuning !!!!!
class ServiceGenerator extends GeneratorAbstract {
	
	function __construct(Connection $connection, String $dbname){
		
		$this->dbname = $dbname;
		$this->connection = $connection;
		$this->schemaMgr = $this->connection->getSchemaManager();
		$this->classType=self::SERVICE_CLASS;
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
		return $this->classType." - ".$this->className." generated!";
		
		//return $this->classNamespace;
	}
	
	public function generateClassType(){
		$this->classGenerated->addComment("Description of ".$this->className." class from entity ".$this->tableName.".\n\n");

		return $this->classGenerated;
	}
	
	public function generateNamespace(){
		//namespace App\Action\OpenGL\Group;
		$this->classNamespace = New PhpNamespace('App\\Service\\'.$this->appName.'\\'.$this->className); 
		
		
		$this->classGenerated = $this->classNamespace->addClass($this->className);
		return $this->classNamespace;
		
		
	}
	public function generateUses(){

		$this->classNamespace->addUse('App\\Model\\'.$this->appName.'\\'.$this->className,$this->className.'Model');
		$this->classNamespace->addUse('App\\Repository\\'.$this->appName.'\\'.$this->className,$this->className.'Repository');
		$this->classNamespace->addUse('Fusio\\Engine\\ContextInterface');
		$this->classNamespace->addUse('Fusio\\Engine\\DispatchInterface');
		//$this->classNamespace->addUse('Fusio\\Engine\\DispatchInterface');
		//$this->classNamespace->addUse('Fusio\\Engine\\DispatchInterface');
		$this->classNamespace->addUse('Fusio\\Engine\\Connector');
		$this->classNamespace->addUse('PSX\\CloudEvents\\Builder');
		$this->classNamespace->addUse('PSX\\Framework\\Util\\Uuid');
		$this->classNamespace->addUse('PSX\\Http\\Exception','StatusCode');
		$this->classNamespace->addUse('Doctrine\\DBAL\\Connection');
	}
	
	public function generateProperties(){
		$this->classGenerated->addConstant("APP_NAME",'app-'.$this->appName);
		$this->classGenerated->addProperty('repository')->setPrivate()
		->addComment('@var Repository\\'.$this->appName.'\\'.$this->className);
		$this->classGenerated->addProperty('dispatcher')->setPrivate()
		->addComment('@var DispatcherInterface');
		$this->classGenerated->addProperty('connector')->setPrivate()
		->addComment('@var Fusio\\Engine\\Connector');
	}
	
	public function generateMethods(){
		//method __construct()
		$this->classMethods = $this->classGenerated->addMethod('__construct');
		$this->classMethods->addParameter('repository')->setType($this->className.'Repository');
		$this->classMethods->addParameter('dispatcher')->setType('DispatcherInterface');
		$this->classMethods->addParameter('connector')->setType('ConnectorInterface');
		//body
		$this->classMethods->addBody('$this->repository=$repository;');
		$this->classMethods->addBody('$this->dispatcher=$dispatcher;');
		$this->classMethods->addBody('$this->connector=$connector;');
		
		$this->_generateSetupTenantConnectionMethod();
		$this->_generateCreateMethod();
		$this->_generateUpdateMethod();
		$this->_generateDeleteMethod();
		$this->_generateDispatchEventMethod();
		$this->_generateAssertMethod();
	}
	
	private function _generateSetupTenantConnectionMethod(){
		$this->classMethods = $this->classGenerated->addMethod('setupTenantConnection');
		$this->classMethods->addParameter('tenantId');
		
		$this->classMethods->addBody('if (empty($tenantId)) {');
		$this->classMethods->addBody('	throw new StatusCode\\NotFoundException(\'Provided request does not include with tenantId!\');');
		$this->classMethods->addBody('}');
		$this->classMethods->addBody('$this->repository->setupConnection($this->connector->getConnection(self::APP_NAME.\'-\'.$tenantId));');
	}
	
	private function _generateCreateMethod(){
		$this->classMethods = $this->classGenerated->addMethod('create')->setReturnType('int');
		$this->classMethods->addParameter(Strings::firstLower($this->className))->setType($this->className.'Model');
		$this->classMethods->addParameter('context')->setType('ContextInterface');
		$this->classMethods->addParameter('tenantId')->setType('string');
		
		$this->classMethods->addBody('$this->assert'.$this->className.'($'.Strings::firstLower($this->className).');');
		$this->classMethods->addBody('if ($tenantId === null) {');
		$this->classMethods->addBody('	throw new StatusCode\\BadRequestException(\'No TenantId provided\');');
		$this->classMethods->addBody('}');
		$this->classMethods->addBody('$this->setupTenantConnection($tenantId);');
		$this->classMethods->addBody('$id = $this->repository->insert(');
		foreach($this->tableCols as $column){
			$this->classMethods->addBody('	$'.Strings::firstLower($this->className).'->get'.$this->_camelCase($column->getName(),true).'(),');
		}
		$this->classMethods->addBody(');');
		
		$this->classMethods->addBody('$row = $this->repository->findById($id);');
		$this->classMethods->addBody('$this->dispatchEvent(\''.$this->appName.'_'.$this->className.'_created\', $row, $id);');
		$this->classMethods->addBody('return $id;');
	}
	
	private function _generateUpdateMethod(){
		$this->classMethods = $this->classGenerated->addMethod('update');
		$this->classMethods->addParameter('id')->setType('int');
		$this->classMethods->addParameter(Strings::firstLower($this->className))->setType($this->className.'Model');
		$this->classMethods->addParameter('tenantId')->setType('string');
		
		$this->classMethods->addBody('$this->assert'.$this->className.'($'.Strings::firstLower($this->className).');');
		$this->classMethods->addBody('if ($tenantId === null) {');
		$this->classMethods->addBody('	throw new StatusCode\\BadRequestException(\'No TenantId provided\');');
		$this->classMethods->addBody('}');
		$this->classMethods->addBody('$this->setupTenantConnection($tenantId);');
		
		$this->classMethods->addBody('$row = $this->repository->findById($id);');
		$this->classMethods->addBody('if (empty($row)) {');
		$this->classMethods->addBody('	throw new StatusCode\\NotFoundException(\'Provided \'.$id.\' does not exist\');');
		$this->classMethods->addBody('}');
		
		$this->classMethods->addBody('$this->repository->update($id,');
		foreach($this->tableCols as $column){
			if($column->getName()!=='id'){
				$this->classMethods->addBody('	$'.Strings::firstLower($this->className).'->get'.$this->_camelCase($column->getName(),true).'(),');
			}
		}
		$this->classMethods->addBody(');');
		
		
		$this->classMethods->addBody('$row = $this->repository->findById($id);');
		$this->classMethods->addBody('$this->dispatchEvent(\''.$this->appName.'_'.$this->className.'_updated\', $row, $id);');
		$this->classMethods->addBody('return $id;');
		
	}
	
	private function _generateDeleteMethod(){
		$this->classMethods = $this->classGenerated->addMethod('delete');
		$this->classMethods->addParameter('id')->setType('int');
		$this->classMethods->addParameter('tenantId')->setType('string');
		
		$this->classMethods->addBody('if ($tenantId === null) {');
		$this->classMethods->addBody('	throw new StatusCode\\BadRequestException(\'No TenantId provided\');');
		$this->classMethods->addBody('}');
		$this->classMethods->addBody('$this->setupTenantConnection($tenantId);');
		
		$this->classMethods->addBody('$row = $this->repository->findById($id);');
		$this->classMethods->addBody('if (empty($row)) {');
		$this->classMethods->addBody('	throw new StatusCode\\NotFoundException(\'Provided \'.$id.\' does not exist\');');
		$this->classMethods->addBody('}');
		
		$this->classMethods->addBody('$this->repository->delete($id);');
		
		$this->classMethods->addBody('$this->dispatchEvent(\''.$this->appName.'_'.$this->className.'_deleted\', $row, $id);');
		$this->classMethods->addBody('return $id;');
	}
	
	private function _generateDispatchEventMethod(){
		$this->classMethods = $this->classGenerated->addMethod('dispatchEvent');
		$this->classMethods->addParameter('type')->setType('string');
		$this->classMethods->addParameter('data')->setType('array');
		$this->classMethods->addParameter('id')->setType('int');
		
		$this->classMethods->addBody('$event = (new Builder())');
		$this->classMethods->addBody('->withId(Uuid::pseudoRandom())');
		$this->classMethods->addBody('->withSource(\'/'.$this->appName.'/'.$this->className.'/\' . $id)');
		$this->classMethods->addBody('->withType($type)');
		$this->classMethods->addBody('->withDataContentType(\'application/json\')');
		$this->classMethods->addBody('->withData($data)');
		$this->classMethods->addBody('->build();');
		$this->classMethods->addBody('$this->dispatcher->dispatch($type, $event);');
		
	}
	
	private function _generateAssertMethod(){
		$this->classMethods = $this->classGenerated->addMethod('assert'.$this->className)
		->addComment('Need to customize to your needs and entity model');
		$this->classMethods->addParameter(Strings::firstLower($this->className))->setType($this->className.'Model');
		foreach($this->tableCols as $column){
			$this->classMethods->addBody('$'.$this->_camelCase($column->getName()).'=$'.Strings::firstLower($this->className).'->get'.$this->_camelCase($column->getName(),true).'();');
			//$id = $group->getId();
			$this->classMethods->addBody('if ($'.$this->_camelCase($column->getName()).' === null) {');
			$this->classMethods->addBody('	throw new StatusCode\BadRequestException(\'No '.$column->getName().' provided\');');
			$this->classMethods->addBody('}');
		}
	}
}