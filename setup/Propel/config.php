<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('Higgs', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'settings' =>
  array (
    'charset' => 'utf8',
  ),
  'dsn' => 'mysql:host=localhost;dbname=Higgs',
  'user' => 'root',
  'password' => '',
));
$manager->setName('Higgs');
$serviceContainer->setConnectionManager('Higgs', $manager);
$serviceContainer->setDefaultDatasource('Higgs');