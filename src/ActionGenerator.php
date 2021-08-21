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

class ActionGenerator extends GeneratorAbstract {
	
	function __construct(Connection $connection, String $dbname){
		$this->dbname = $dbname;
		$this->connection = $connection;
		$this->schemaMgr = $this->connection->getSchemaManager();
		$this->classType=self::ACTION_CLASS;
		$this->appName = $this->_camelCase($this->dbname,true);
		//Strings::replace(Strings::capitalize($this->dbname),[
		//	'~[\_]+~i' => '',
		//	'~\s+~' => '',
		//	]); //camel case it 
		//$this->classType=$classType;
		//-- turn off auto-resolving class 
		$this->classPrinter = new Printer; // or PsrPrinter
		$this->classPrinter->setTypeResolving(false);
		
	}
	
	public function generate($tableName,$classType){
		$this->classType = $classType;
		$this->tableName = $tableName;
		$this->_tableCols(); //get the table columns list
		$this->className = $this->_camelCase($tableName,true);
		/*Strings::replace(Strings::capitalize($tableName),[
			'~[\_]+~i' => '',
			'~\s+~' => '',
			]); //camel case it 
		*/
		$this->generateNamespace();
		$this->generateUses();
		$this->generateClassType();
		$this->generateProperties();
		$this->generateMethods();
		$phpFile = new PhpFile();
		$phpFile->addComment('This file is auto-generated.');
		$phpFile->addNamespace($this->classNamespace);
		
		$location = self::BASE_OUTPUTDIR."\\".self::ACTION_CLASS."\\".$this->appName."\\".$this->className;
		FileSystem::createDir($location);
		FileSystem::write($location."\\".$this->classType.".php",$this->classPrinter->printFile($phpFile));
		return self::ACTION_CLASS." - ".$this->classType." - ".$this->className." generated!";//$this->classNamespace;
	}
	
	public function generateClassType(){
		//$this->classGenerated = new ClassType($this->className);
		$this->classGenerated->setExtends("ActionAbstract");
		$this->classGenerated->addComment("Description of ".$this->classType." class from entity ".$this->tableName.".\n\n");

		// to generate PHP code simply cast to string or use echo:
		return $this->classGenerated;
	}
	
	public function generateNamespace(){
		//namespace App\Action\OpenGL\Group;
		$this->classNamespace = New PhpNamespace('App\Action\\'.$this->appName.'\\'.$this->className); // new PhpNamespace('App\\Action\\'.$this->appName);
		$this->classNamespace->addUse('App\\Model\\Message');
		$this->classGenerated = $this->classNamespace->addClass($this->classType);
		return $this->classNamespace;
		//$this->classGenerated->addNamespace($this->classNamespace);
		
	}
	public function generateUses(){

		$this->classNamespace->addUse('App\\Model\\Message');
		$this->classNamespace->addUse('App\\Service\\'.$this->appName.'\\'.$this->className);
		$this->classNamespace->addUse('Fusio\\Engine\\ActionAbstract');
		$this->classNamespace->addUse('Fusio\\Engine\\ContextInterface');
		$this->classNamespace->addUse('Fusio\\Engine\\ParametersInterface');
		$this->classNamespace->addUse('Fusio\\Engine\\RequestInterface');
		$this->classNamespace->addUse('PSX\\Http\\Exception\\InternalServerErrorException');
		$this->classNamespace->addUse('PSX\\Http\\Exception\\StatusCodeException');
		$this->classNamespace->addUse('App\\Service\\Tenancy\\TenantMember');
		$this->classNamespace->addUse('PSX\\Http\\Exception as StatusCode');
	}
	
	public function generateProperties(){
		if($this->classType!==self::ACTION_CLASS_GET && $this->classType!==self::ACTION_CLASS_GETALL){
			$this->classGenerated->addProperty(Strings::firstLower($this->className).'Service')->setPrivate();
		} else {
			$this->classGenerated->addConstant("APP_NAME",'app-'.$this->appName);
		}
		$this->classGenerated->addProperty('tenantMemberService')->setPrivate();
	}
	
	public function generateMethods(){
		//method __construct()
		$this->classMethods = $this->classGenerated->addMethod('__construct');
		if($this->classType!==self::ACTION_CLASS_GET && $this->classType!==self::ACTION_CLASS_GETALL){
			$this->classMethods->addParameter(Strings::firstLower($this->className).'Service')->setType($this->className);
			//body
			$this->classMethods->addBody('$this->'.Strings::firstLower($this->className).'Service=$'.Strings::firstLower($this->className).'Service;');
		}
		$this->classMethods->addParameter('tenantMemberService')->setType('TenantMemberService');
		//body
		$this->classMethods->addBody('$this->tenantMemberService=$tenantMemberService;');
		
		//methods handle()
		//RequestInterface $request, ParametersInterface $configuration, ContextInterface $context
		$this->classMethods = $this->classGenerated->addMethod('handle');
		$this->classMethods->addParameter('request')->setType('RequestInterface');
		$this->classMethods->addParameter('configuration')->setType('ParametersInterface');
		$this->classMethods->addParameter('context')->setType('ContextInterface');
		//body
		$this->classMethods->addBody('$tenantId=$request->getHeader("tenantId");');
		$this->classMethods->addBody('$currentUserId = $context->getUser()->getId();');
		$this->classMethods->addBody('$checkUser = $this->tenantMemberService->checkCurrentUserIsTenant($currentUserId,$tenantId);;');
		$this->classMethods->addBody('if(!$checkUser){');
		$this->classMethods->addBody('	throw new StatusCode\NotFoundException("Current user is not in current tenant!");');
		$this->classMethods->addBody('}');
		
		//if method Get/GetAll, generate special code here..
		if($this->classType==self::ACTION_CLASS_GET ||$this->classType==self::ACTION_CLASS_GETALL){
			$this->_generateGetMethod($this->classType);
			if($this->classType==self::ACTION_CLASS_GETALL){
				$this->_generateGetConditionMethod();
			}

		} else {
		// else 
			$this->classMethods->addBody('try {');
			$this->classMethods->addBody('	$id = $this->'.Strings::firstLower($this->className).'Service->'.Strings::firstLower($this->classType).'(');
			//$request->getPayload(),$context,$tenantId');
			if($this->classType==self::ACTION_CLASS_UPDATE || $this->classType==self::ACTION_CLASS_DELETE){
				$this->classMethods->addBody('		(int) $request->get("'.Strings::lower($this->className).'_id"),');
			}
			if($this->classType==self::ACTION_CLASS_UPDATE || $this->classType==self::ACTION_CLASS_CREATE){
				$this->classMethods->addBody('		$request->getPayload(),');
				if($this->classType==self::ACTION_CLASS_CREATE){
					$this->classMethods->addBody('		$context,');
				} 
			}
			$this->classMethods->addBody('		$tenantId');
			$this->classMethods->addBody('	);');

			$this->classMethods->addBody('	$message = new Message();');
			$this->classMethods->addBody('	$message->setSuccess(true);');
			$this->classMethods->addBody('	$message->setMessage("'.$this->tableName.'successful created");');
			$this->classMethods->addBody('	$message->setId($id);');
			$this->classMethods->addBody('} catch (StatusCodeException $e) {');
			$this->classMethods->addBody('	throw $e;');
			$this->classMethods->addBody('} catch (\Throwable $e) {');
			$this->classMethods->addBody('	throw new InternalServerErrorException($e->getMessage());');
			$this->classMethods->addBody('}');

			$this->classMethods->addBody('return $this->response->build(201, [],$message);');
		}
	}
	
	public function test($tableName){
		$this->tableName = $tableName;
		$this->_tableCols(); //get the table columns list
		foreach($this->tableCols as $c){
			echo $c->getName()." - type: ".$c->getType()->getName();
		}
	}
	
	/*
	* generate method Get/GetAll type
	*/
	private function _generateGetMethod($gt){
		$this->classMethods->addBody('$connection = $this->connector->getConnection(self::APP_NAME."-".$tenantId);');
		$this->classMethods->addBody('$builder    = new Builder($connection);');
		if($gt==self::ACTION_CLASS_GET){
			$this->classMethods->addBody('$sql = "SELECT \'$tenantId\' as `tenantId`,');
			//iterate to all table column
			//---here. ...
			foreach ($this->tableCols as $column) {
				$this->classMethods->addBody('		'.$this->tableName.'.'.$column->getName().',');
			}
			$this->classMethods->addBody('		FROM '.$this->tableName);
			$this->classMethods->addBody('		WHERE '.$this->tableName.'.id=:id";');
			
			$this->classMethods->addBody('$parameters = ["id" => (int) $request->get("'.Strings::lower($this->className).'_id")];');
			$this->classMethods->addBody('$definition=$builder->doEntity($sql, $parameters, [');
			$this->classMethods->addBody("	'tenantId' => 'tenantId' ,");
			foreach ($this->tableCols as $column) {
				if($column->getType()->getName()=='integer'){
					$this->classMethods->addBody("	'".$this->_camelCase($column->getName())."' => \$builder->fieldInteger('".$column->getName()."'),");
				}
				if($column->getType()->getName()=='datetime'){
					$this->classMethods->addBody("	'".$this->_camelCase($column->getName())."' => \$builder->fieldDateTime('".$column->getName()."'),");
				} 
				if($column->getType()->getName()=='string') {
					$this->classMethods->addBody("	'".$this->_camelCase($column->getName())."' => '".$column->getName()."',");
				}
			}
			
		} elseif ($gt==self::ACTION_CLASS_GETALL){
			$this->classMethods->addBody('$startIndex = (int)\$request->get(\'startIndex\');')
			->addBody('$startIndex = $startIndex <= 0 ? 0 : $startIndex;')
			->addBody('$condition  = $this->getCondition($request);')
			
			->addBody('$sql = "SELECT \'$tenantId\' as `tenantId`,');
			//iterate to all table column
			//---here. ...
			foreach ($this->tableCols as $column) {
				$this->classMethods->addBody('		'.$this->tableName.'.'.$column->getName().',');
			}
			$this->classMethods->addBody('		FROM '.$this->tableName)
			->addBody('		WHERE ".$condition->getExpression($connection->getDatabasePlatform())."')
			->addBody('		ORDER BY '.$this->tableName.'.id ASC";')
			->addBody('$parameters = array_merge($condition->getValues(), [\'startIndex\' => $startIndex]);')
			->addBody('$definition = [')
			->addBody('	\'totalResults\' => $builder->doValue(\'SELECT COUNT(*) AS cnt FROM '.$this->tableName.'\', [],')
			->addBody('	$builder->fieldInteger(\'cnt\')),')
			->addBody('	\'startIndex\' => $startIndex,')
			->addBody('	\'entries\' => $builder->doCollection($sql, $parameters, [')
			->addBody('	\'tenantId\' => \'tenantId\' ,');
			foreach ($this->tableCols as $column) {
				if($column->getType()->getName()=='integer'){
					$this->classMethods->addBody("	'".$this->_camelCase($column->getName())."' => \$builder->fieldInteger('".$column->getName()."'),");
				}
				if($column->getType()->getName()=='datetime'){
					$this->classMethods->addBody("	'".$this->_camelCase($column->getName())."' => \$builder->fieldDateTime('".$column->getName()."'),");
				} 
				if($column->getType()->getName()=='string') {
					$this->classMethods->addBody("	'".$this->_camelCase($column->getName())."' => '".$column->getName()."',");
				}
			}
			
		}
		$this->classMethods->addBody("	'links'=>[")
		->addBody("		'self'=>\$builder->fieldReplace('/".Strings::lower($this->appName)."/".Strings::lower($this->className)."/{id}'),")
		->addBody("	]")
		->addBody("]);")
		->addBody('return $this->response->build(200, [], $builder->build($definition));');
		
	}
	
	private function _generateGetConditionMethod(){
		$this->classMethods = $this->classGenerated->addMethod('getCondition')
				->setPrivate()
				->setReturnType('Condition')
				->addComment('below, should you customize for your needs!');
		
		$this->classMethods->addParameter('request')->setType('RequestInterface');
		$this->classMethods->addBody('$condition = new Condition();')
		->addBody('$ref = $request->get(\'id\');')
		->addBody('if (!empty($ref)) {')
		->addBody('	$condition->equals(\''.Strings::lower($this->className).'.id\', (int) $ref);')
		->addBody('}')
		->addBody('$name = $request->get(\'name\');')
		->addBody('if (!empty($name)) {')
		->addBody('	$condition->like(\''.Strings::lower($this->className).'.name\', \'%\' . $name . \'%\');')
		->addBody('}')
		->addBody('return $condition;');
		
	}
}