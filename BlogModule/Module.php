<?php
namespace BlogModule;

use PPI\Module\Module as BaseModule;
use PPI\Autoload;

class Module extends BaseModule
{

    protected $_moduleName = 'BlogModule';

    public function init($e)
    {
        Autoload::add(__NAMESPACE__, dirname(__DIR__));
    }

    /**
     * Get the configuration for this module
     *
     * @return array
     */
    public function getConfig()
    {
        return include(__DIR__ . '/resources/config/config.php');
    }

    /**
     * Get the routes for this module
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function getRoutes()
    {
        return $this->loadYamlRoutes(__DIR__ . '/resources/config/routes.yml');
    }

    public function getServiceConfig()
    {

        return array('factories' => array(

            'post.storage' => function($sm) {
                return new \BlogModule\Storage\BlogPost($sm->getService('datasource'));
            },

            'tags.storage' => function($sm) {
                return new \BlogModule\Storage\BlogTag($sm->getService('datasource'));
            },

            'category.storage' => function($sm) {
                return new \BlogModule\Storage\BlogCategory($sm->getService('datasource'));
            },

            'post.category.storage' => function ($sm) {
                return new \BlogModule\Storage\BlogPostCategory($sm->getService('datasource'));
            },

            'post.tag.storage' => function ($sm) {
                return new \BlogModule\Storage\BlogPostTag($sm->getService('datasource'));
            }

        ));

    }

}