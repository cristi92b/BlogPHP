<?php

class TwigEnvironmentLoader {
    private static $instance;
    private $loader;
    private $twig;
    private function __construct()
    {
        $this->loader = new Twig_Loader_String(array('/','./Views','/var/www/blog/Views'));
        $this->twig = new Twig_Environment($this->loader,array('debug' => true));
        $this->twig->addExtension(new Twig_Extension_StringLoader());
    }
    public static function getInstance(){
            if( !(self::$instance instanceof self) ){
                            self::$instance = new self();           
            }
            return self::$instance;
    }
    public function getEnvironment(){  
        return $this->twig;
    }
    
}

?>