<?php
require_once(__DIR__ . '/vendor/autoload.php');
use Nette\PhpGenerator\ClassType;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;
use Wirams\FusioCrudGen\GeneratorAbstract;
use Wirams\FusioCrudGen\ActionGenerator;
use Wirams\FusioCrudGen\ServiceGenerator;
use Wirams\FusioCrudGen\ModelGenerator;
use Wirams\FusioCrudGen\RepositoryGenerator;
use Nette\Utils\FileSystem;






if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$database 	= filter_input(INPUT_POST,'database');
	echo $database;
	//$database 	= filter_input(INPUT_POST,'database1');
	//$database 	= filter_input(INPUT_POST,'database2');
	//$database 	= filter_input(INPUT_POST,'database3');
	$tables 	= explode(',',filter_input(INPUT_POST,'tables'));
	print_r($tables);
	//$tables 	= explode(',',filter_input(INPUT_POST,'tables1'));
	//$tables 	= explode(',',filter_input(INPUT_POST,'tables2'));
	//$tables 	= explode(',',filter_input(INPUT_POST,'tables3'));
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
	}elseif($genType=="service"){
		$serviceGen = New ServiceGenerator($conn,$database);
		foreach($tables as $table){
			echo $serviceGen->generate($table)."\n";
		}
	}elseif($genType=="model"){
		$modelGen = New ModelGenerator($conn,$database);
		foreach($tables as $table){
			echo $modelGen->generate($table)."\n";
		}
	}elseif($genType=="repository"){
		$repositoryGen = New RepositoryGenerator($conn,$database);
		foreach($tables as $table){
			echo $repositoryGen->generate($table)."\n";
		}
	}
}
