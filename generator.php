<?php
require_once(__DIR__ . '/vendor/autoload.php');
use Nette\PhpGenerator\ClassType;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;
use Wirams\FusioCrudGen\GeneratorAbstract;
use Wirams\FusioCrudGen\ActionGenerator;
use Nette\Utils\FileSystem;






if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$database 	= filter_input(INPUT_POST,'database');
	$tables 	= explode(',',filter_input(INPUT_POST,'tables'));
	$genType    = filter_input(INPUT_POST,'gentype');
	
	/*Init connection */
	$connectionParams = array(
		'dbname' => $database,
		'user' => 'root',
		'password' => '',
		'host' => 'localhost',
		'driver' => 'pdo_mysql',
	);
	$conn = DriverManager::getConnection($connectionParams);

	
	if($genType=="action"){
		$actionGen = New ActionGenerator($conn,$database);
		foreach($tables as $table){
			echo $actionGen->generate($table,ActionGenerator::ACTION_CLASS_GET)."\n";
			echo $actionGen->generate($table,ActionGenerator::ACTION_CLASS_GETALL)."\n";
			echo $actionGen->generate($table,ActionGenerator::ACTION_CLASS_CREATE)."\n";
			echo $actionGen->generate($table,ActionGenerator::ACTION_CLASS_UPDATE)."\n";
			echo $actionGen->generate($table,ActionGenerator::ACTION_CLASS_DELETE)."\n";
		}
	}
}