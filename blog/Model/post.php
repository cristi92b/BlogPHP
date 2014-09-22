<?php

class Post {
    private $id;
    private $title;
    private $createdTime;
    private $updateTime;
    private $content;
    
    public function __construct($id,$title,$createdTime,$updateTime,$content)
    {
    		$this->id = $id;
    		$this->title = $title;
    		$this->createdTime = $createdTime;
    		$this->updateTime = $updateTime;
    		$this->content = $content;
    }
   
    function getID() {
        return $id;
    }
    
    function getTitle() {
        return $title;
    }
    
    function getCreatedTime() {
        return $createdTime;
    }
    
    function getUpdateTime() {
        return $updateTime;
    }
    
    function getContent() {
        return $content;
    }
    
    function setID($id) {
        $this->id = $id;
    }
    
    function setTitle($title) {
        $this->title = $title;
    }
    
    function setCreatedTime($createdTime) {
        $this->createdTime = $createdTime;
    }
    
    function setUpdateTime($updateTime) {
        $this->updateTime = $updateTime;
    }
    
    function setContent($content) {
        $this->content = $content;
    }
}

?>
