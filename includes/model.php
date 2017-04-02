<?php
include ('db_connection.php');
class model {
	function __construct() {
		$this->DB = new DB_Con ();
	} // __construct()
	function register($username,$password)
	{
		$timestamp= date('Y-m-d H:i:s', substr(time(), 0, -3));
		$qry = "INSERT INTO `login`(`username`, `password`, `createdtime`) VALUES (:username,:password,:timestamp)";
		$prepared_statement=$this->DB->prepare($qry);
		$prepared_statement -> bindValue(':username', $username);
		$prepared_statement -> bindValue(':password', $password);
		$prepared_statement -> bindValue(':timestamp', $timestamp);
		$exe_status = $prepared_statement -> execute();
		return $exe_status;
	}//Registeration
	function login($username,$password)
	{
		$timestamp= date('Y-m-d H:i:s', substr(time(), 0, -3));
		$qry = "Select * from `login` where username like :username AND username like :password";
		$prepared_statement=$this->DB->prepare($qry);
		$prepared_statement -> bindValue(':username', $username);
		$prepared_statement -> bindValue(':password', $password);
		$prepared_statement -> execute();
		return $prepared_statement->fetch();
	}//Login
}
?>