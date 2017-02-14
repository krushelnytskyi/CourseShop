<?php

namespace System\Database\Statement;

use System\Database\Connection;
use System\Database\Statement;

/**
 * Class Insert
 * @package System\Database\Statement
 */
class Insert extends Statement
{

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $values = [];
    
    /**
     * @param   array   $values  values list
     * @return  $this
     */
    public function values(array $values)
    {
        $this->columns = array_keys($values);
        $this->values = array_values($values);
        
        return $this;
    }

    /**
     * @return bool
     */
    public function execute()
    {
        $sql = 'INSERT INTO ' . $this->table;

        $this->columns = array_map(
            function ($column) {
                return '`' . $column . '`';
            },
            $this->columns
        );

        $this->values = array_map(
            function ($value) {
                return '\'' . addcslashes($value, '\''). '\'';
            },
            $this->values
        );

        $fields = ' (' . implode(', ', $this->columns) . ')';
        $values = '(' . implode(', ', $this->values) . ')';

        $sql .= $fields . ' VALUES ' . $values;

        $result = Connection::getInstance()->getLink()->prepare($sql)->execute();

        return (false === $result) ? false : Connection::getInstance()->getLink()->lastInsertId();
    }

}




