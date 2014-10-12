<?php

class TwigEnvironmentLoader {
    private static $instance;
    private $loader;
    private $twig;
    private function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem(array('/var/www/app/views'));
        //$this->loader->exists("posts_index.html.twig");
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
