<?php 
require_once(__DIR__ . '/vendor/autoload.php');
use Nette\PhpGenerator\ClassType;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;
use Wirams\FusioCrudGen\GeneratorAbstract;
use Wirams\FusioCrudGen\ActionGenerator;
use Wirams\FusioCrudGen\RepositoryGenerator;
use Wirams\FusioCrudGen\ModelGenerator;
use Wirams\FusioCrudGen\ServiceGenerator;
use Nette\Utils\FileSystem;



/*Init connection */
$connectionParams = array(
    'dbname' => 'fusio202',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);
$conn = DriverManager::getConnection($connectionParams);

$sm = $conn->getSchemaManager();

//$databases = $sm->listDatabases();
//print_r($databases);

//$actiongen = New ActionGenerator($conn,'fusio202');
//echo $actiongen->generate('App_Post',ActionGenerator::ACTION_CLASS_GET);
//$actiongen->test('App_Post');

//$repositoryGen = New RepositoryGenerator($conn,'fusio202');
//echo $repositoryGen->generate('App_Post',null);

//$modelGen = New ModelGenerator($conn,'fusio202');
//echo $modelGen->generate('App_Post',null);

$serviceGen = New ServiceGenerator($conn,'fusio202');
echo $serviceGen->generate('App_Post',null);

/*
$file = new Nette\PhpGenerator\PhpFile;
$file->addComment('This file is auto-generated.');
$file->setStrictTypes(); // adds declare(strict_types=1)

$namespace = $file->addNamespace('Foo');
$class = $namespace->addClass('A');
$class->addMethod('hello');

// or insert an existing namespace into the file
// $file->addNamespace(new Nette\PhpGenerator\PhpNamespace('Foo'));
FileSystem::createDir("output");
FileSystem::write("output\Foo.php",$file);
*/
//echo $file;
/*
$servicegen = New ServiceGenerator($conn,'fusio202');
echo $servicegen->generate('App_Post',ServiceGenerator::SERVICE_CLASS);
*/

/*
$class = new ClassType('Demo');

$class
	->setFinal()
	->setExtends(ParentClass::class)
	->addImplement(Countable::class)
	->addTrait(Nette\SmartObject::class)
	->addComment("Description of class.\nSecond line\n")
	->addComment('@property-read Nette\Forms\Form $form');

// to generate PHP code simply cast to string or use echo:
echo $class;
*/