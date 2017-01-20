<?php
namespace System\Database\Statement;

use System\Config;
use System\Database\Connection;
use System\Database\Statement;

/**
 * Class Update
 * @package System\Database\Statement
 */
class Update extends Statement
{
    /**
     * @var array
     */
    protected $values = [];
    /**
     * @var string
     */
    protected $limit;
    /**
     * @var string
     */
    protected $condition;


    /**
     * @param string $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }
    public function setValues($values=array())
    {
        $updates[] = null;
        if (!empty($values)){
            foreach( $values as $field => $value )
            {
                $updates[] = "$field = '$value'";
            }
            $this->values = ltrim(implode(',', $updates),',');
        }
        return $this;
    }
    /**
     * @return Condition
     */
    public function where()
    {
        return new Condition($this);
    }

    public function limit($numberRecords)
    {
        if (true === empty($this->limit)) {
            $this->limit = 'LIMIT ' . $numberRecords;
        }
        return $this;
    }
    /**
     * @param $from
     * @param $numberRecords
     * @return $this
     */
    public function limitFrom($from, $numberRecords)
    {
        if (true === empty($this->limit)) {
            $this->limit = sprintf(
                'LIMIT %s, $s',
                $from,
                $numberRecords
            );
        }
        return $this;
    }

    /**
     * @return int
     */
    public function execute()
    {

       $db = Connection::getInstance();
       $connection = $db->getLink();


        if(true ===  empty($connection)) {
            return null;
        }

       $sql = sprintf(
            'UPDATE %s SET %s %s %s',
            $this->table,
            $this->values,
            $this->condition,
            $this->limit
        );
        
        $query = $connection->prepare($sql);
        $query->execute();


        return $query->rowCount();


   /*     $servername = Config::get('database','host');
        $dbname = Config::get('database','database');
        $username = Config::get('database','username');
        $password = Config::get('database','password');
        $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        var_dump($conn);
        
        $stmt = $conn->prepare($sql);

        var_dump($sql);

        $stmt->execute();

        echo $stmt->rowCount() . " records UPDATED successfully";*/

   

    }
}