<?php

namespace System\Database\Statement;

/**
 * Class Condition
 * @package System\Database\Statement
 */
class Condition
{

    const comparisonOperator = ['=', '<', '>', '<=', '>=', '!='];

    /**
     * @var Object
     */
    protected $operationDB;

    /**
     * @var string
     */
    protected $condition;

    /**
     * @var bool
     */
    protected $blocked = false;

    /**
     * Condition constructor.
     * @param $instance
     */
    public function __construct($instance)
    {
        $this->operationDB = $instance;
    }

    /**
     * @param $nameColumn
     * @param $value
     * @param $comparisonOperator
     * @return $this|null
     */
    public function compare($nameColumn, $value, $comparisonOperator)
    {
        if (in_array($comparisonOperator, static::comparisonOperator) === false) {
            return null;
        }

        if (false === $this->blocked) {
            $this->condition .= sprintf(
                '`%s` %s \'%s\'',
                $nameColumn,
                $comparisonOperator,
                $value
            );
            $this->blocked = true;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function conditionAnd()
    {
        if (true === $this->blocked) {
            $this->condition .= ' AND ';
            $this->blocked = false;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function conditionOr()
    {
        if (true === $this->blocked) {
            $this->condition .= ' OR ';
            $this->blocked = false;
        }
        return $this;
    }

    /**
     * Select rows that have values in the specified field
     *
     * @param $nameColumn
     * @return $this
     */
    public function isNotNull($nameColumn)
    {
        if (false === $this->blocked) {
            $this->condition .= $nameColumn . ' IS NOT NULL';
            $this->blocked = true;
        }
        return $this;
    }

    /**
     * Select rows that don`t have value in the specified field
     *
     * @param $nameColumn
     * @return $this
     */
    public function isNull($nameColumn)
    {
        if (false === $this->blocked) {
            $this->condition .= $nameColumn . ' IS NULL';
            $this->blocked = true;
        }
        return $this;
    }

    /**
     * Select rows between specified values
     *
     * @param $nameColumn
     * @param $from
     * @param $to
     * @return $this
     */
    public function between($nameColumn, $from, $to)
    {
        if (false === $this->blocked) {
            $this->condition .= sprintf(
                '%s BETWEEN %s AND %s',
                $nameColumn,
                $from,
                $to
            );
            $this->blocked = true;
        }
        return $this;
    }

    /**
     * Select rows that match the specified values
     *
     * @param $nameColumn
     * @param $valueArray
     * @return $this
     */
    public function in($nameColumn, $valueArray)
    {
        if (false === $this->blocked) {

            $this->condition .= $nameColumn . ' IN (';

            if (is_array($valueArray) === true) {
                $this->condition .= '\'' . implode('\',\'', $valueArray) . '\'';
            } else {
                $this->condition .= '\'' . $valueArray . '\'';
            }
            $this->condition .= ')';
            $this->blocked = true;
        }
        return $this;
    }

    /**
     * Select rows other than those specified values
     *
     * @param $nameColumn
     * @param $valueArray
     * @return $this
     */
    public function notIn($nameColumn, $valueArray)
    {
        if (false === $this->blocked) {
            $this->condition .= $nameColumn . ' NOT IN (';

            if (is_array($valueArray) === true) {
                $this->condition .= implode(',', $valueArray);
            } else {
                $this->condition .= $valueArray;
            }
            $this->condition .= ')';
            $this->blocked = true;
        }
        return $this;
    }

    /**
     * Select rows that match the pattern
     *
     * @param $nameColumn
     * @param $pattern
     * @return $this
     */
    public function like($nameColumn, $pattern)
    {
        if (false === $this->blocked) {
            $this->condition .= $nameColumn . ' LIKE ' . $pattern;
            $this->blocked = true;
        }
        return $this;
    }

    /**
     * Select rows that don`t match the pattern
     *
     * @param $nameColumn
     * @param $pattern
     * @return $this
     */
    public function notLike($nameColumn, $pattern)
    {
        if (false === $this->blocked) {
            $this->condition .= $nameColumn . ' NOT LIKE ' . $pattern;
            $this->blocked = true;
        }
        return $this;
    }

    /**
     * @return Object
     */
    public function closeCondition()
    {
        if (true === $this->blocked) {
            $this->operationDB->setCondition('WHERE ' . $this->condition);
            return $this->operationDB;
        }
    }
}