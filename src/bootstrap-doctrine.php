<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/../vendor/autoload.php';

/* ----------------------------------------------------------------------- */
/*
 * configuração do doctrine
 */
$cache = new Doctrine\Common\Cache\ArrayCache ();
$annotationReader = new Doctrine\Common\Annotations\AnnotationReader ();
$cachedAnnotationReader = new Doctrine\Common\Annotations\CachedReader ( $annotationReader, $cache );
$annotationDriver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver ( $cachedAnnotationReader, array (
		__DIR__ . DIRECTORY_SEPARATOR . '../src'
) );
$driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain ();
$driverChain->addDriver ( $annotationDriver, 'Digital' );
$config = new Doctrine\ORM\Configuration ();
$config->setProxyDir ( '/tmp' );
$config->setEntityNamespaces(['Digital\Entity']);
$config->setProxyNamespace ( 'Proxy' );
$config->setAutoGenerateProxyClasses ( true );
$config->setMetadataDriverImpl ( $driverChain );
$config->setMetadataCacheImpl ( $cache );
$config->setQueryCacheImpl ( $cache );
AnnotationRegistry::registerFile ( __DIR__ . DIRECTORY_SEPARATOR . '../vendor' . DIRECTORY_SEPARATOR . 'doctrine' . DIRECTORY_SEPARATOR . 'orm' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Doctrine' . DIRECTORY_SEPARATOR . 'ORM' . DIRECTORY_SEPARATOR . 'Mapping' . DIRECTORY_SEPARATOR . 'Driver' . DIRECTORY_SEPARATOR . 'DoctrineAnnotations.php' );
$evm = new Doctrine\Common\EventManager ();
$em = EntityManager::create ( array (
		'driver' => 'pdo_mysql',
		'host' => '127.0.0.1',
		'port' => '3306',
		'user' => 'root',
		'password' => 'root',
		'dbname' => 'site'
), $config, $evm );