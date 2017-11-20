<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('DATABASE', 'nmd33');
define('USERNAME', 'nmd33');
define('PASSWORD', ' sallow37');
define('CONNECTION', 'sql1.njit.edu');

class dbConn{
   protected static $db;

   public function __construct() {
       try {
           // assign PDO object to db variable
           self::$db = new PDO( 'mysql:host=' . CONNECTION .';dbname=' . DATABASE, USERNAME, PASSWORD );

           self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
           echo 'Connected successfully <br>';
       }

       catch (PDOException $e) {
           //Output error - would normally log this to error file rather than output to user.
           echo "Connection Error: " . $e->getMessage();
       }
   }
   // get connection function. Static method - accessible without instantiation
   public static function getConnection() {
       //Guarantees single instance, if no connection object exists then create one.
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
    static public function findAll() {
                    $db = dbConn::getConnection();
                    $tableName = get_called_class();
                    $sql = 'SELECT * FROM ' . $tableName;
                    $statement = $db->prepare($sql);
                    $statement->execute();
                    $class = static::$modelName;
                    $statement->setFetchMode(PDO::FETCH_CLASS, $class);
                    $recordsSet =  $statement->fetchAll();
                    return $recordsSet;
                }
    static public function findOne($id) {
                          $db = dbConn::getConnection();
                          $tableName = get_called_class();
                          $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
                          $statement = $db->prepare($sql);
                          $statement->execute();
                          $class = static::$modelName;
                          $statement->setFetchMode(PDO::FETCH_CLASS, $class);
                          $recordsSet =  $statement->fetchAll();
                          return $recordsSet;
                      }
                  }
class accounts extends collection {
    protected static $modelName = 'accounts';
}
class todos extends collection {
    protected static $modelName = 'todos';
}
class model {
   // protected $tableName;
    static $columnString;
    static $valueString;
    public function save()
    {
        if (static::$id == '') {
            $array = get_object_vars($this);
            static::$columnString = implode(',', $array);
            static::$valueString = implode(',',  array_fill(0,count($array),'?'));
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
        $sql = "INSERT INTO ".static::$tableName." (".self::$columnString.") VALUES (".static::$valueString.")";
        return $sql;
    }
    private function update() {
        $sql = "UPDATE ".static::$tableName." SET ".static::$column." = '".static::$update."' WHERE id=".static::$id;
        return $sql;
    }
    public function delete()
    {
        $db = dbConn::getConnection();
        $sql = 'delete from '.static::$id.' where id='.static::$id;
        $statement = $db->prepare($sql);
        $statement->execute();
        echo 'column with id '.static::$id.' has been deleted from todos table';
    }
}
class account extends model {
    public $email = 'email';
    public $fname = 'fname';
    public $lname = 'lname';
    public $phone = 'phone';
    public $birthday = 'birthday';
    public $gender = 'gender';
    public $password = 'password';
    static $insertRow = array ('nmdesai@njit.edu','Nachiket','Desai','123432432432', '2011-10-10', 'Male', '1');
    static $tableName = 'accounts';
    static $id = '6';
    static $column ='lname';
    static $update ='charles';
}
class todo extends model {
    public $owneremail = 'owneremail';
    public $ownerid = 'ownerid';
    public $createddate = 'createddate';
    public $duedate = 'duedate';
    public $message = 'message';
    public $isdone = 'isdone';
    static $insertRow = array ('nachiket@gmail.com','5','2017-11-15','2017-11-20', 'Hey', '1');
        static $tableName = 'todos';
        static $id = '1';
        static $column ='message';
        static $update ='Updated message';
}
class stringFunction
{
   static function String($string)
    {
        echo '<h1>'.$string.'</h1>';
    }
}
class table
{
    static function makeTable($result)
    {
        echo '<table>';
        foreach ($result as $row)
        {
            echo '<tr>';
            foreach ($row as $column)
            {
                echo '<td>';
                echo $column;
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }
}
          stringFunction::String('Select All Records from Accounts');
          $obj = accounts::create();
              $result = $obj->findAll();
            table::makeTable($result);
            echo '<br>';
          echo '<br>';



            stringFunction::String('Select One Record from Accounts');
            $obj = accounts::create();
            $result = $obj->findOne(8);
            table::makeTable($result);
            echo '<br>';
            echo '<br>';


            stringFunction::String('Select All Records from Todos');
            $obj = todos::create();
            $result = $obj->findAll();
            table::makeTable($result);
            echo '<br>';
            echo '<br>';


            stringFunction::String('Select One Record from Todos');
                  $obj = todos::create();
                  $result = $obj->findOne(7);
                  table::makeTable($result);
                  echo '<br>';
                  echo '<br>';


              stringFunction::String('Update into Todo database');
                    $obj = new Todo;
                    $obj -> save();
                    $obj = todos::create();
                    $result = $obj->findAll();
                    table::makeTable($result);
                    echo '<br>';
                    echo '<br>';


              stringFunction::String('Insert into accounts database');
              $obj = new account;
              $obj -> save();
              $obj = accounts::create();
              $result = $obj->findAll();
              table::makeTable($result);

?>