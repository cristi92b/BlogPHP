<?php

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
	
	function get_connection()
	{
		return $this->connection;
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
}

?>
