<?php

/**
 * My Application bootstrap file.
 */
use Nette\Application\Routers\Route,
	Nette\Application\Routers\RouteList;


// Load Nette Framework
require LIBS_DIR . '/Nette/loader.php';


// Configure application
$configurator = new Nette\Config\Configurator;

// Enable Nette Debugger for error visualisation & logging
//$configurator->setProductionMode($configurator::AUTO);
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	->addDirectory(LIBS_DIR)
	->register();

\Nella\Addons\Doctrine\Config\Extension::register($configurator);
\Nella\Addons\Doctrine\Config\MigrationsExtension::register($configurator);
	
// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon');
$container = $configurator->createContainer();

// Setup router
$container->router[] = new Route('index.php', 'Homepage:Backend:default', Route::ONE_WAY);

$container->router[] = new Route('admin/<action (login)>', array(
    'module' => 'Security',
    'presenter' => 'Frontend',
));

$container->router[] = new Route("admin/<module>/[<action>/]<id>", array(
    'module' => 'Homepage',
    'presenter' => 'Backend',
    'action' => 'default',
    'id' => NULL,
));

$container->router[] = new Route("<module>/[<action>/]<id>", array(
    'module' => 'Homepage',
    'presenter' => 'Frontend',
    'action' => 'default',
    'id' => NULL,
));

// Configure and run the application!
if(PHP_SAPI == 'cli')
{
	$container->console->run();
}
else
{
	$container->application->run();
}
