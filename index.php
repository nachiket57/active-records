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
	class collection {


			static public function create() {
								$model = new static::$modelName;
				return $model;
				}
				static public function findAll() 
				{

				$db = dbConn::getConnection();
				$tab = get_called_class();
				$sql = 'SELECT * FROM ' . $tab;
				$statement = $db->prepare($sql);
				$statement->execute();
				$class = static::$modelName;
				$statement->setFetchMode(PDO::FETCH_CLASS, $class);
				$record = $statement->fetchAll();
				
				return $record;
				}


				static public function findOne($id)
				 {
				$db = dbConn::getConnection();
				$tab = get_called_class();
				$sql = 'SELECT * FROM ' . $tab . ' WHERE id =' . $id;
				$statement = $db->prepare($sql);
				$statement->execute();
				$class = static::$modelName;
				$statement->setFetchMode(PDO::FETCH_CLASS, $class);
				$record = $statement->fetchAll();
				
				return $record;
				}
			}

			class accounts extends collection {
				protected static $modelName = 'accounts';
				}
						class todos extends collection {
						protected static $modelName = 'todos';
				}
						class model {
				
							static $column;
							static $value;
							public function save()
							{
						
						 (static::$id == '') {
						$array = get_object_vars($this);
						static::$column = implode(',', $array);
						static::$value = implode(',', array_fill(0,count($array),'?'));
						$db = dbConn::getConnection();
						$sql = $this->insert();
						$statement = $db->prepare($sql);
						$statement->execute(static::$insertRow);
						}
						else
						{
						$db = dbConn::getConnection();
						$sql = $this->update();
						$statement = $db->prepare($sql);
						$statement->execute();
						}
					
						private function insert() {
						$sql = "INSERT INTO ".static::$tab." (".self::$column.") VALUES (".static::$value.")";
						return $sql;
						}
						private function update() {
						$sql = "UPDATE ".static::$tab." SET ".static::$column." = '".static::$update."' WHERE id=".static::$id;
						return $sql;
						}
						public function delete()
						{
						$db = dbConn::getConnection();
						$sql = 'delete from '.static::$id.' where id='.static::$id;
						$statement = $db->prepare($sql);
						$statement->execute();
						echo 'Column with Id '.static::$id.' has been deleted from todos';
						}
						}



