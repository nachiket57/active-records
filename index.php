<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('DATABASE', 'nmd33');
define('USERNAME', 'nmd33');
define('PASSWORD', ' sallow37');
define('CONNECTION', 'sql1.njit.edu');


class dbConn{
//variable to hold connection object.
	protected static $db;
//private construct - class cannot be instatiated externally.
	private function __construct() {
		try {
// assign PDO object to db variable
		self::$db = new PDO( 'mysql:host=' . CONNECTION .';dbname=' . DATABASE, USERNAME, PASSWORD );
		self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
		catch (PDOException $e) {
//Output error - would normally log this to error file rather than output to user.
		echo "Connection Error: " . $e->getMessage();
}
}

		public static function getConnection() {
	
		if (!self::$db) {
//new connection object.
		new dbConn();
		}
//return connection.
		return self::$db;
		}
	}
			