<?php

require_once 'init.php';
use Wirams\FusioCrudGen\DatabaseRepository;
//
if($_SERVER['REQUEST_METHOD'] == 'POST'){
//if($_REQUEST['databaseName']){
	$databaseName = filter_input(INPUT_POST, 'databaseName');
	//echo $databaseName;
	if($databaseName != ''){
		$databaseRepository = new DatabaseRepository($connection);
		
		$databaseRepository->setDatabaseName($databaseName);
		$tables = $databaseRepository->getTables($databaseName);
		echo json_encode(array('tables' => $tables), true);
		
	}
}