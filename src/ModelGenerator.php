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


class ModelGenerator extends GeneratorAbstract {
	
	function __construct(Connection $connection, String $dbname){
		$this->dbname = $dbname;
		$this->connection = $connection;
		$this->schemaMgr = $this->connection->getSchemaManager();
		$this->classType=self::MODEL_CLASS;
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
		//$this->generateUses();
		$this->generateClassType();
		$this->generateProperties();
		$this->generateMethods();
		
		$phpFile = new PhpFile();
		$phpFile->setStrictTypes();  //set Model as strict mode = 1
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
		//namespace App\Model\OpenGL;
		$this->classNamespace = New PhpNamespace('App\\Model\\'.$this->appName); 
		//$this->classNamespace->addImplement("JsonSerializable");
		$this->classGenerated = $this->classNamespace->addClass($this->className)->addImplement("JsonSerializable");
		return $this->classNamespace;
	}
	
	public function generateUses(){
		//TO DO if needed!!
	}
	
	public function generateProperties(){
		$this->classGenerated->addProperty('tenantId')->setProtected()
		->addComment("@var string|null");
		foreach($this->tableCols as $column){
			$prop = $this->classGenerated->addProperty($this->_camelCase($column->getName()))->setProtected();
			$allowNull = $column->getNotNull()?'':'|null';
			if($column->getType()->getName()=='string' || $column->getType()->getName()=='text'){
				$prop->addComment('@var string'.$allowNull);
			} elseif($column->getType()->getName()=='integer'){
				$prop->addComment('@var int'.$allowNull);
			} else{
				$prop->addComment('@var '.$column->getType()->getName().$allowNull);
			}
				
		}
	}
	public function generateMethods(){
		$this->classMethods= $this->classGenerated->addMethod('setTenantId')->setPublic()->setReturnType('void')
		->addComment("@param string|null \$tenantId");
		$this->classMethods->addParameter('tenantId')->setType('?string');
		$this->classMethods->addBody('$this->tenantId=$tenantId;');
		$this->classMethods= $this->classGenerated->addMethod('getTenantId')->setPublic()->setReturnType('?string')
		->addComment("@return string|null");
		$this->classMethods->addBody('return $this->tenantId;');
		
		foreach($this->tableCols as $column){
			$setMethod= $this->classGenerated->addMethod('set'.$this->_camelCase($column->getName(),true))->setPublic()->setReturnType('void');
			$getMethod= $this->classGenerated->addMethod('get'.$this->_camelCase($column->getName(),true))->setPublic();
			
			$allowNull = $column->getNotNull()?'':'|null';
			if($column->getType()->getName()=='string' || $column->getType()->getName()=='text'){
				$setMethod->addComment("@param string$allowNull \$".$this->_camelCase($column->getName()));
				$setMethod->addParameter($this->_camelCase($column->getName()))->setType('?string');
				
				$getMethod->setReturnType('?string')->addComment("@return string$allowNull");
			} elseif($column->getType()->getName()=='integer'){
				$setMethod->addComment("@param int$allowNull \$".$this->_camelCase($column->getName()));
				$setMethod->addParameter($this->_camelCase($column->getName()))->setType('?int');
				
				$getMethod->setReturnType('?int')->addComment("@return int$allowNull");
			} else{
				$setMethod->addComment("@param ".$column->getType()->getName().$allowNull." \$".$this->_camelCase($column->getName()));
				$setMethod->addParameter($this->_camelCase($column->getName()))->setType('?'.$column->getType()->getName());
				
				$getMethod->setReturnType('?'.$column->getType()->getName())->addComment("@return ".$column->getType()->getName().$allowNull);
			}
			
			$setMethod->addBody('$this->'.$this->_camelCase($column->getName()).'=$'.$this->_camelCase($column->getName()).';');
			$getMethod->addBody('return $this->'.$this->_camelCase($column->getName()).';');	
		}
		$this->_generateJsonSerializeMethod();
	}
	
	private function _generateJsonSerializeMethod(){
		$this->classMethods = $this->classGenerated->addMethod("jsonSerialize")->setPublic();
		$this->classMethods->addBody('return (object) array_filter(array(');
		foreach($this->tableCols as $column){
			$this->classMethods->addBody("'".$this->_camelCase($column->getName())."'=>\$this->".$this->_camelCase($column->getName()).",");
		}
		$this->classMethods->addBody("static function(\$value):bool{");
		$this->classMethods->addBody("return \$value!==null;");
		$this->classMethods->addBody("});");
		/*
		 return (object) array_filter(array('tenantId'=>$this->tenantId, 'id' => $this->id, 'parentId' => $this->parentId,'name' => $this->name, 'code' => $this->code, 'affectsGross' => $this->affectsGross), static function ($value) : bool {
            return $value !== null;
        });
		*/
		
	}
}