<?php

namespace System\Database\Statement;

use System\Database\Connection;
use System\Database\Statement;

class Delete extends Statement
{

    /**
     * @var string
     */
    public $where   = '';
    public $orderBy = '';
    public $limit   = '';



    public function where($parameters)
    {
        if ($this->where == '') {
            $this->where = ' ' . $parameters;
        }

        return $this;
    }

    /**
     * @param $orderBy
     * @return $this
     */
    public function orderBy($orderBy)  {

        if ($orderBy !=='') {
            $this->orderBy = ' ORDER BY ' . $orderBy;
        } else {
            $this->orderByLimit = '';
        }

        return $this;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function limit($limit)  {

        if ($limit !== null) {
            $this->limit = ' LIMIT ' . (integer)$limit;
        } else {
            $this->orderByLimit = '';
        }

        return $this;
    }


    public function execute()
    {

        $sql = 'DELETE FROM ' . $this->table;

        if ($this->where !== '') {
            $sql .= ' ' . $this->where;
        }

        if ($this->orderBy !== '') {
            $sql .= ' ' . $this->orderBy;
        }

        if ($this->limit !== ''){
            $sql .= ' ' . $this->limit;
        }

        $result = Connection::getInstance()->getLink()->prepare($sql)->execute();

        if ($result !== false) {
            return true;
        }

        return false;

    }

}