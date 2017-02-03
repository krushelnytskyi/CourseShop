<?php

namespace System\Database\Statement;

use PDO;
use System\Database\Connection;
use System\Database\Statement;

/**
 * Class Select
 * @package System\Database\Statement
 */
class Select extends Statement
{

    /**
     * @var string
     */
    protected $selected = '*';

    /**
     * @var string
     */
    protected $orderBy;

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
     * @return $this
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
        return $this;
    }

    /**
     * @param array $selected
     * @return $this
     */
    public function columns(array $selected)
    {
        $this->selected = implode(',', $selected);
        return $this;
    }

    /**
     * @param string $field
     */
    public function count($field = '*')
    {
        $this->selected = 'COUNT(' . $field . ')';
    }

    /**
     * @return Condition
     */
    public function where()
    {
        return new Condition($this);
    }

    /**
     * @param $columnName
     * @param bool $desc
     * @return $this
     */
    public function orderBy($columnName, $desc = true)
    {
        $this->orderBy = ' ORDER BY ';
        $this->orderBy .= ($desc === false) ? $columnName . ' DESC' : $columnName;
        return $this;
    }

    /**
     * @param $numberRecords
     * @return $this
     */
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
                'LIMIT %s, %s',
                $from,
                $numberRecords
            );
        }
        return $this;
    }

    /**
     * @return array|null
     */
    public function execute()
    {
        $connection = Connection::getInstance()->getLink();

        if(true ===  empty($connection)) {
            return null;
        }

        if ((true === empty($this->selected) && (true === empty($this->table)))) {
            return null;
        }

        $sql = sprintf(
            'SELECT %s FROM %s %s %s %s',
            $this->selected,
            $this->table,
            $this->condition,
            $this->orderBy,
            $this->limit
        );

        $result = $connection->prepare($sql);
        $result->execute();
        $rowsArray = [];

        if (false !== $result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $rowsArray[] = $row;
            }
        }
        return $rowsArray;
    }

}
