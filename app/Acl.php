<?php

use Zend\Permissions\Acl\Acl as ZendAcl;

class Acl extends ZendAcl
{
    public function __construct()
    {
        // APPLICATION ROLES
        $this->addRole('guest');
        // member role "extends" guest, meaning the member role will get all of 
        // the guest role permissions by default
        //$this->addRole('member', 'guest');
        $this->addRole('admin', 'guest');

        // APPLICATION RESOURCES
        // Application resources == Slim route patterns
        $this->addResource('/');
        $this->addResource('/login');
        $this->addResource('/login/auth');
        $this->addResource('/login/logout');
        $this->addResource('/read');
        $this->addResource('/read/:id');
        $this->addResource('/posts');
        $this->addResource('/posts/create');
        $this->addResource('/posts/new');
        $this->addResource('/posts/:id');
        $this->addResource('/posts/:id/delete');

        // APPLICATION PERMISSIONS
        // Now we allow or deny a role's access to resources. The third argument
        // is 'privilege'. We're using HTTP method for resources.
        $this->allow('guest', '/', 'GET');
        $this->allow('guest', '/read', 'GET');
        $this->allow('guest', '/read/:id', 'GET');
        $this->allow('guest', '/login', array('GET', 'POST'));
        $this->allow('guest', '/login/auth', array('GET', 'POST'));
        //$this->allow('guest', '/logout', 'GET');

        //$this->allow('member', '/member', 'GET');

        // This allows admin access to everything
        $this->allow('admin');
    }
}

?>