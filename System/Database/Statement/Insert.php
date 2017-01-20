<?php

namespace System\Database\Statement;

use System\Database\Statement;

class Insert extends Statement
{

    /**
     * @var array
     */
    protected $values = array();

    /**
     * @var array
     */
    protected $variables = array();


    /**
     * @param   array   $values  values list
     * @param   ...
     * @return  $this
     */
    public function values(array $values)
    {
        if ( ! is_array($this->values))
        {
            throw new Exception('INSERT INTO ... SELECT statements cannot be combined with INSERT INTO ... VALUES');
        }
        $this->variables = array_values($values);
        $this->values = array_values($values);

        return $this;
    }


    /**
     * @param array $variables
     * @return bool
     */

    public function execute()
    {
        $sql = "INSERT INTO " . $this->table;
        $fields = array();
        $values = array();
        foreach ($this->variables as $field => $value) {
            $fields[] = $field;
            $values[] = "'" . $value . "'";
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '(' . implode(', ', $values) . ')';

        $sql .= $fields . ' VALUES ' . $values;

        $result = $this->connection->getLink()->query($sql);

        return (false === $result) ? false : $this->connection->getLink()->insert_id;
    }
}




