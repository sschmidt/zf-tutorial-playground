<?php

namespace Product;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 *
 * @package Product
 */
class Module implements ConfigProviderInterface
{

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\Table\AlbumTable::class     => function ($container) {
                    $tableGateway = $container->get(Model\AlbumTableGateway::class);

                    return new Model\Table\AlbumTable($tableGateway);
                },
                Model\AlbumTableGateway::class    => function ($container) {
                    $dbAdapter          = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album());

                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
                Model\Table\BookTable::class      => function ($container) {
                    $tableGateway = $container->get(Model\BookTableGateway::class);

                    return new Model\Table\BookTable($tableGateway);
                },
                Model\BookTableGateway::class     => function ($container) {
                    $dbAdapter          = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Book());

                    return new TableGateway('book', $dbAdapter, null, $resultSetPrototype);
                },
                Model\Table\ThrillerTable::class  => function ($container) {
                    $tableGateway = $container->get(Model\ThrillerTableGateway::class);

                    return new Model\Table\ThrillerTable($tableGateway);
                },
                Model\ThrillerTableGateway::class => function ($container) {
                    $dbAdapter          = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Thriller());

                    return new TableGateway('thriller', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AlbumController::class    => function ($container) {
                    return new Controller\AlbumController(
                        $container->get(Model\Table\AlbumTable::class)
                    );
                },
                Controller\HomeController::class     => function ($container) {
                    return new Controller\HomeController(
                        $container->get(Model\Table\AlbumTable::class),
                        $container->get(Model\Table\BookTable::class)
                    );
                },
                Controller\BookController::class     => function ($container) {
                    return new Controller\BookController(
                        $container->get(Model\Table\BookTable::class)
                    );
                },
                Controller\ThrillerController::class => function ($container) {
                    return new Controller\ThrillerController(
                        $container->get(Model\Table\ThrillerTable::class),
                        $container->get(Model\Table\BookTable::class)
                    );
                },
            ],
        ];
    }
}