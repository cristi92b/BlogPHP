<?php
require 'vendor/autoload.php';
$app = new \Slim\Slim();

class Database{

	//variable to hold db connection
	private $connection;
	//note we used static variable,beacuse an instance cannot be used to refer this
	public static $instance;

	//note constructor is private so that classcannot be instantiated
	private function __construct(){
	//code connect to database  
		$connection=mysqli_connect("localhost","root","admin","PHPDB");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    return $connection;
	}
	
	function db_disconnect()
	{
		mysqli_close($connection);
	}     

	//to prevent loop hole in PHP so that the class cannot be cloned
	private function __clone() {}
	//used static function so that, this can be called from other classes
	public static function getInstance(){
		if( !(self::$instance instanceof self) ){
				self::$instance = new self();           
		}
	 return self::$instance;
	}


	public function fetch_latest7_post(){
		  $result = mysqli_query($connection,"SELECT * FROM post LIMIT 7 Order by createdTime");
		  $posts=array();
		  while($row = mysqli_fetch_array($result))
		  {
		  	$posts[]=new Post($row['id'],$row['title'],$row['createdTime'],$row['updateTime'],$row['content']);
		  }
		  return $posts;
	}
	
	public function fetch_all_comments($post_id){
		  $result = mysqli_query($connection,"SELECT * FROM comment WHERE post_id={$post_id} Order by createdTime");
		  $posts=array();
		  while($row = mysqli_fetch_array($result))
		  {
		  	$posts[]=new Post($row['id'],$row['name'],$row['createdTime'],$row['updateTime'],$row['post_id'],$row['content']);
		  }
		  return $posts;
	}

}



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
} 



$app->get('/', function () {
echo "Hello!";
});
$app->run();
?>
