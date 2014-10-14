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
    
    public static function fetch_all_posts($db_instance){
		  $connection = $db_instance->get_connection();
		  $result = mysqli_query($connection,"SELECT * FROM post Order by createdTime");
		  $posts=array();
		  while($row = mysqli_fetch_assoc($result))
		  {
		  	$posts[] = $row; //new Post($row['id'],$row['title'],$row['createdTime'],$row['updateTime'],$row['content']);
		  }
		  return $posts;
    }
    
    public static function fetch_post_by_id($db_instance,$id){
		  $connection = $db_instance->get_connection();
		  $result = mysqli_query($connection,"SELECT * FROM post WHERE id=$id");
		  $post = mysqli_fetch_assoc($result);
		  return $post;
    }
    
    public static function update_record($db_instance,$id,$title,$content){
		  $connection = $db_instance->get_connection();
		  $title = '\'' . $title . '\''; //mysqli_real_escape_string($connection,$title)
		  $content = '\'' . $content . '\'';
		  $query_str = "UPDATE post SET  title=$title , content=$content WHERE id=$id";
		  $result = mysqli_query($connection,$query_str);
		  if(!$result)
		  {
		    printf("Error: %s\n", mysqli_error($connection));
		  }
		  return $result;
    }
    
    public static function insert_record($db_instance,$title,$content){
		  $connection = $db_instance->get_connection();
		  $title = '\'' . $title . '\'';
		  $content = '\'' . $content . '\'';
		  $query_str = "INSERT INTO post(title,createdTime,content) values($title,CURRENT_TIMESTAMP(),$content)";
		  $result = mysqli_query($connection,$query_str);
		  if(!$result)
		  {
		    printf("Error: %s\n", mysqli_error($connection));
		  }
		  return $result;
    }
    
    public static function delete_record($db_instance,$id){
		  $connection = $db_instance->get_connection();
		  $query_str = "DELETE FROM post WHERE id=$id";
		  $result = mysqli_query($connection,$query_str);
		  if(!$result)
		  {
		    printf("Error: %s\n", mysqli_error($connection));
		  }
		  return $result;
    }
}

?>
