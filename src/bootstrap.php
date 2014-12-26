<?php
use Digital\Service\LoginService;
use Digital\Database;
use Digital\Service\RotaService;
use Digital\Service\MenuService;
use Doctrine\ORM\Tools\Setup,
Doctrine\ORM\EntityManager,
Doctrine\Common\EventManager as EventManager,
Doctrine\ORM\Events,
Doctrine\ORM\Configuration,
Doctrine\Common\Cache\ArrayCache as Cache,
Doctrine\Common\Annotations\AnnotationRegistry,
Doctrine\Common\Annotations\AnnotationReader,
Doctrine\Common\ClassLoader;
use Digital\Service\ProdutoService;
use Digital\Service\Validator\ProdutoValidator;
use Digital\Service\Validator\CategoriaValidator;
use Digital\Service\CategoriaService;

if (empty(session_id())) {
	session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/settings.php';

/* ----------------------------------------------------------------------- */
/*
 * confituracao do twig
 */
$loader = new Twig_Loader_Filesystem(__DIR__ . '/Digital/View');
$twig = new Twig_Environment($loader, array('debug' => true));
$function = new Twig_SimpleFunction('path', function () {
	return "http://{$_SERVER['HTTP_HOST']}/";
});
$twig->addFunction($function);
/* ----------------------------------------------------------------------- */
/*
 * configurações gerais
 */
$loginService = new LoginService();
$database = new Database($driver);
$rotaService = new RotaService();
$menuService = new MenuService($database);
$dados = ['title'=>'Doctrine Rules', 'menu' => $menuService->montaMenu($database),'ano' => date('Y'),'logado' => $loginService->logado(),'uri' => $rotaService->currentUri()];
/* ----------------------------------------------------------------------- */
/* 
 * configuração do doctrine 
*/
$cache = new Doctrine\Common\Cache\ArrayCache;
$annotationReader = new Doctrine\Common\Annotations\AnnotationReader;
$cachedAnnotationReader = new Doctrine\Common\Annotations\CachedReader(
    $annotationReader,
    $cache);
$annotationDriver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
    $cachedAnnotationReader,
    array(__DIR__ . DIRECTORY_SEPARATOR . '../src'));
$driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();
$driverChain->addDriver($annotationDriver,'Digital');
$config = new Doctrine\ORM\Configuration;
$config->setProxyDir('/tmp');
$config->setProxyNamespace('Proxy');
$config->setAutoGenerateProxyClasses(true);
$config->setMetadataDriverImpl($driverChain);
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);
AnnotationRegistry::registerFile(__DIR__. DIRECTORY_SEPARATOR . '../vendor' . DIRECTORY_SEPARATOR . 'doctrine' . DIRECTORY_SEPARATOR . 'orm' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Doctrine' . DIRECTORY_SEPARATOR . 'ORM' . DIRECTORY_SEPARATOR . 'Mapping' . DIRECTORY_SEPARATOR . 'Driver' . DIRECTORY_SEPARATOR . 'DoctrineAnnotations.php');
$evm = new Doctrine\Common\EventManager();
$em = EntityManager::create(
    array(
        'driver'  => 'pdo_mysql',
        'host'    => '127.0.0.1',
        'port'    => '3306',
        'user'    => 'root',
        'password'  => 'root',
        'dbname'  => 'site',
    ),
    $config,
    $evm
);
/* ----------------------------------------------------------------------- */
/*
 * configuracao do Silex
 */
$app = new \Silex\Application();
$app['debug'] = true;
$app['em'] = $em;
$app['database'] = new Database($driver);
$app['produtoservice'] = function () use ($app) {
	return new ProdutoService($app['database']);
};
$app['produtovalidator'] = function () {
	return new ProdutoValidator();
};
$app['categoriaservice'] = function () use ($app){
	return new CategoriaService($app['database']);
};
$app['categoriavalidator'] = function () {
	return new CategoriaValidator();
};