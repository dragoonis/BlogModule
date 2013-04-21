<?php
namespace BlogAdminModule\Controller;

use PPI\Module\Controller as BaseController;
use AdminModule\Entity\User as UserEntity;
use AdminModule\Entity\AuthUser as AuthUserEntity;

class Shared extends BaseController
{
    
    protected function isLoggedIn()
    {
        return $this->getService('user.security')->isLoggedIn();
    }

    /**
     * Render a template
     *
     * @param  string $template The template to render
     * @param  array  $params   The params to pass to the renderer
     * @param  array  $options  Extra options
     * @return string
     */
    protected function render($template, array $params = array(), array $options = array())
    {
        $options['helpers'][] = $this->getService('user.security.templating.helper');
        $this->addTemplateGlobal('activeRouteName', $this->helper('routing')->getActiveRouteName());
        return parent::render($template, $params, $options);
    }

    /**
     * Add a template global variable
     * 
     * @param string $param
     * @param mixed $value
     */
    protected function addTemplateGlobal($param, $value)
    {
        $this->getService('templating')->addGlobal($param, $value);
    }
    
    protected function isAdmin() {
        return $this->isLoggedIn() && in_array($this->getService('user.security')->getUser()->getLevelTitle(), array('Administrator', 'Developer'));
    }

    function slug($string)
    {
        $str = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return strtolower($str);
    }

    public function createResponse($data)
    {
        $this->getService('response')->headers->set('Content-type', 'application/json');
        return json_encode($data);
    }

    protected function checkMissingFields($post, $requiredKeys)
    {

        $missingFields   = array();
        foreach ($requiredKeys as $field) {
            if (empty($post[$field])) {
                $missingFields[] = $field;
            }
        }

        return $missingFields;
    }
    
}