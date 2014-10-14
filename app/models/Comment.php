<?php

class Comment {
    private $id;
    private $name;
    private $createdTime;
    private $updateTime;
    private $post_id;
    private $content;
    
    public function __construct($id,$name,$createdTime,$updateTime,$post_id,$content)
    {
    		$this->id = $id;
    		$this->name = $name;
    		$this->createdTime = $createdTime;
    		$this->updateTime = $updateTime;
    		$this->post_id = $post_id;
    		$this->content = $content;
    }
   
    function getID() {
        return $id;
    }
    
    function getName() {
        return $name;
    }
    
    function getCreatedTime() {
        return $createdTime;
    }
    
    function getUpdateTime() {
        return $updateTime;
    }
    
    function getPostID() {
        return $post_id;
    }
    
    function getContent() {
        return $content;
    }
    
    function setID($id) {
        $this->id = $id;
    }
    
    function setName($name) {
        $this->name = $name;
    }
    
    function setCreatedTime($createdTime) {
        $this->createdTime = $createdTime;
    }
    
    function setUpdateTime($updateTime) {
        $this->updateTime = $updateTime;
    }
    
    function setPostID($post_id) {
        $this->post_id = $post_id;
    }
    
    function setContent($content) {
        $this->content = $content;
    }
    
    public static function fetch_all_comments($db_instance,$post_id){
		  $connection = $db_instance->get_connection();
		  $result = mysqli_query($connection,"SELECT * FROM comment WHERE post_id={$post_id} Order by createdTime");
		  $comments=array();
		  while($row = mysqli_fetch_assoc($result))
		  {
		  	$comments[]=$row;//new Comment($row['id'],$row['name'],$row['createdTime'],$row['updateTime'],$row['post_id'],$row['content']);
		  }
		  return $comments;
    }
    
    public static function insert_record($db_instance,$name,$content,$id){
		  $connection = $db_instance->get_connection();
		  $name = "\"" . $name . "\""; //mysqli_real_escape_string($connection,$name)
		  $content = "\"" . $content . "\"";
		  $query_str = "INSERT INTO comment(name,createdTime,post_id,content) values($name,CURRENT_TIMESTAMP(),$id,$content)";
		  $result = mysqli_query($connection,$query_str);
		  return $result;
    }
} 

?>
