<?php

namespace System\ORM;


use System\Database\Statement\Condition;
use System\Database\Statement\IndpndtConditions;
use System\Database\Statement\Select;
use System\Database\Connection;
use System\Pattern\Singleton;


/**
 * Class Repository
 * @package System\ORM
 *
 * @method static Repository getInstance()
 */
class Repository
{
    use Singleton;



    /**
     * @var \ReflectionClass
     */
    protected $reflection;

    /**
     * @var string
     */
    protected $storage;

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @param $modelClass
     */
    public function useModel($modelClass)
    {
        $this->reflection = new \ReflectionClass($modelClass);

        $docComment = $this->reflection->getDocComment();

        if (preg_match('/@table\((.+)\)/', $docComment, $matches) === 1) {
            $this->storage = $matches[1];
        }

        foreach ($this->reflection->getProperties() as $property) {
            if (preg_match('/@columnType\((.*)\)/', $property->getDocComment(), $tempResult)) {
                $this->columns[] = $property->getName();
            }
        }

    }

    /**
     * @param $model
     * @return int
     */
    public function save($model)
    {
        $statement = Connection::getInstance()
            ->insert()
            ->from($this->storage);
        
        $values = [];

        foreach ($this->columns as $column) {
            $property = $this->reflection->getProperty($column);
            $property->setAccessible(true);

            $value = $property->getValue($model);
            
            if ($value !== null) {
                $values[$property->getName()] = $value;
            }

            $property->setAccessible(false);
        }

        return $statement->values($values)->execute();

    }

    /**
     * @param $model
     * @return int
     */
    public function delete($model)
    {

        $statement = Connection::getInstance()
            ->delete()
            ->from($this->storage);
        
        $where = new IndpndtConditions();

        foreach ($this->columns as $column) {
            $property = $this->reflection->getProperty($column);
            $property->setAccessible(true);

            $value = $property->getValue($model);
            if ($value !== null) {
                $where->conditionAnd();
                $where->compare($property->getName(),$value,'=');
            }

            $property->setAccessible(false);
        }

        return $statement->where($where->closeCondition())->execute();

    }

    /**
     * @param array $criteria
     * @param int|null $limit
     * @param int|null $offset
     * @param string|null $order
     * @return array
     */
    public function findBy($criteria = [], $limit = null, $offset = 0, $order = null)
    {
        $models = [];

        $statement = Connection::getInstance()
            ->select()
            ->from($this->storage);
        

        if ($limit !== null) {
            $statement->limitFrom($offset,$limit);
        }
        if ($order !== null) {
            $statement->orderBy($order);
        }

        if (empty($criteria) === false) {
             /** @var Condition $condition */
            $condition = $statement->where();

            foreach ($criteria as $field => $value) {
                $condition->conditionAnd()->compare($field, $value, '=');
            }

            /** @var Select $statement */
            $statement = $condition->closeCondition();
        }

        $rows = $statement->execute();

        foreach ($rows as $row) {
            /** @var Model $model */
            $model = $this->reflection->newInstance();
            $model->setNew(false);

            foreach ($this->columns as $column) {
                $reflectionProperty = $this->reflection->getProperty($column);
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($model, $row[$column]);
                $reflectionProperty->setAccessible(false);
            }

            $models[] = $model;
        }

        return $models;
    }
    
    /**
     * @param array $criteria
     * @return object|null
     */
    public function findOneBy(array $criteria)
    {
        $models = $this->findBy($criteria, 1);
        return (isset($models[0]) === true) ? $models[0] : null;
    }

}
