<?php
namespace BlogAdminModule;

use PPI\Module\Module as BaseModule;
use PPI\Autoload;

class Module extends BaseModule
{

    protected $_moduleName = 'BlogAdminModule';

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

            'post.helper' => function ($sm) {

                $helper = new \BlogAdminModule\Classes\BlogPostHelper();

                $helper->setCatsStorage($sm->getService('category.storage'));
                $helper->setTagsStorage($sm->getService('tags.storage'));
                $helper->setPostStorage($sm->getService('post.storage'));
                $helper->setPostCatStorage($sm->getService('post.category.storage'));
                $helper->setPostTagStorage($sm->getService('post.tag.storage'));

                return $helper;
            },

        ));

    }

}