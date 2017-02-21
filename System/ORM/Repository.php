<?php

namespace System\ORM;

use System\Database\Statement\Condition;
use System\Database\Statement\IndpndtConditions;
use System\Database\Connection;
use System\Database\Statement\Update;
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
     * @var array
     */
    protected $cache;


    /**
     * @param string $modelClass
     * @return array
     */
    public function getCashedModel($modelClass)
    {
        if (isset($this->cache[$modelClass])) {
            return $this->cache[$modelClass];
        }
        $model = [];
        $reflection = new \ReflectionClass($modelClass);
        if (preg_match('/@table\((.+)\)/', $reflection->getDocComment(), $matches)) {
            $model['tableName'] = $matches[1];
        }
        if (preg_match('/@updateBy\((.+)\)/', $reflection->getDocComment(), $matches)) {
            $model['updateBy'] = explode(',', $matches[1]);
        }
        $colNames = []; $foreignModels = []; $foreignFields = []; $selectors = [];
        foreach ($reflection->getProperties() as $property) {
            if (preg_match('/@columnName\((.*)\)/', $property->getDocComment(), $matches)) {
                $colNames[$property->getName()] = $matches[1];
            } else {
                $colNames[$property->getName()] = $property->getName();
            }
            if (preg_match('/@foreignModel\((.*)\)/', $property->getDocComment(), $matches)) {
                $foreignModels[$property->getName()] = $matches[1];
            }
            if (preg_match('/@foreignField\((.*)\)/', $property->getDocComment(), $matches)) {
                $foreignIds[$property->getName()] = $matches[1];
            }
            if (preg_match('/@foreignField\((.*)\)/', $property->getDocComment(), $matches)) {
                $foreignFields[$property->getName()] = $matches[1];
            }
            if (preg_match('/@selector\((.*)\)/', $property->getDocComment(), $matches)) {
                $selectors[$property->getName()] = $matches[1];
            }
        }
        $model['colNames'] = $colNames;
        $model['foreignModels'] = $foreignModels;
        $model['foreignFields'] = $foreignFields;
        $model['selectors'] = $selectors;
        $this->cache[$modelClass] = $model;
        return $model;
    }

    /**
     * @param $model
     * @return int
     */
    public function update(Model $model)
    {
        $cachedModel = $this->getCashedModel(get_class($model));
        if (!isset($cachedModel['updateBy']) || $model->isNew()) {
            return -1;
        }
        $reflection = new \ReflectionClass(get_class($model));
        $statement = Connection::getInstance()->update()->from($cachedModel['tableName'])->limit(1);
        /** @var Condition $conditions */
        $conditions = $statement->where();
        foreach ($cachedModel['updateBy'] as $propertyName) {
            $property = $reflection->getProperty($propertyName);
            $property->setAccessible(true);
            $value = $property->getValue($model);
            if (isset($cachedModel['foreignFields'][$propertyName]) && is_object($value)) {
                $foreignField = $cachedModel['foreignFields'][$propertyName];
                $reflectForeign = new \ReflectionClass(get_class($value));
                $propertyForeign = $reflectForeign->getProperty($foreignField);
                $propertyForeign->setAccessible(true);
                $value = $propertyForeign->getValue($value);
                $propertyForeign->setAccessible(false);
            }
            $conditions->conditionAnd()->compare($cachedModel['colNames'][$propertyName], $value, '=');
        }
        /** @var Update $statement */
        $statement = $conditions->closeCondition();
        $values = [];
        foreach ($cachedModel['colNames'] as $propName => $column) {
            $property = $reflection->getProperty($propName);
            $property->setAccessible(true);
            $value = $property->getValue($model);
            if ($value !== null) {
                if (isset($cachedModel['foreignFields'][$propName]) && is_object($value)) {
                    $foreignField = $cachedModel['foreignFields'][$propName];
                    $reflectForeign = new \ReflectionClass(get_class($value));
                    $propertyForeign = $reflectForeign->getProperty($foreignField);
                    $propertyForeign->setAccessible(true);
                    $value = $propertyForeign->getValue($value);
                    $propertyForeign->setAccessible(false);
                }
                $values[$column] = $value;
            }
            $property->setAccessible(false);
        }
        return $statement->setValues($values)->execute();
    }

    /**
     * @param $model
     * @return int
     */
    public function save($model)
    {
        $reflection = new \ReflectionClass(get_class($model));
        $cachedModel = $this->getCashedModel(get_class($model));
        $statement = Connection::getInstance()->insert()->from($cachedModel['tableName']);
        $values = [];
        foreach ($cachedModel['colNames'] as $propName => $column) {
            $property = $reflection->getProperty($propName);
            $property->setAccessible(true);
            $value = $property->getValue($model);
            if ($value !== null) {
                if(isset($cachedModel['foreignFields'][$propName]) && is_object($value)){
                    $foreignField = $cachedModel['foreignFields'][$propName];
                    $reflectForeign = new \ReflectionClass(get_class($value));
                    $propertyForeign = $reflectForeign->getProperty($foreignField);
                    $propertyForeign->setAccessible(true);
                    $value = $propertyForeign->getValue($value);
                    $propertyForeign->setAccessible(false);
                }
                $values[$column] = $value;
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
        $reflection = new \ReflectionClass(get_class($model));
        $cachedModel = $this->getCashedModel(get_class($model));
        $statement = Connection::getInstance()->delete()->from($cachedModel['tableName']);
        $where = new IndpndtConditions();
        foreach ($cachedModel['colNames'] as $propName => $column) {
            $property = $reflection->getProperty($propName);
            $property->setAccessible(true);
            $value = $property->getValue($model);
            if ($value !== null) {
                if(isset($cachedModel['foreignFields'][$propName]) && is_object($value)){
                    $foreignField = $cachedModel['foreignFields'][$propName];
                    $reflectForeign = new \ReflectionClass($value);
                    $propertyForeign = $reflectForeign->getProperty($foreignField);
                    $propertyForeign->setAccessible(true);
                    $value = $propertyForeign->getValue($value);
                    $propertyForeign->setAccessible(false);
                }
                $where->conditionAnd();
                $where->compare($column, $value, '=');
            }
            $property->setAccessible(false);
        }
        return $statement->where($where->closeCondition())->execute();
    }

    /**
     * @param string $model::class
     * @param array $criteria
     * @param int|null $limit
     * @param int|null $offset
     * @param string|null $order
     * @return array
     */
    public function findBy($model, $criteria = [], $limit = null, $offset = 0, $order = null)
    {
        $reflection = new \ReflectionClass($model);
        $cachedModel = $this->getCashedModel($model);
        $models = [];
        $statement = Connection::getInstance()->select()->from($cachedModel['tableName']);
        if ($limit !== null) {
            $statement->limitFrom($offset, $limit);
        }
        if ($order !== null) {
            $statement->orderBy($order);
        }
        if (is_array($criteria)) {
            if (empty($criteria) === false) {
                $condition = new Condition($statement);
                foreach ($criteria as $field => $value) {
                    $condition->conditionAnd()->compare($field, $value, '=');
                }
                $statement = $condition->closeCondition();
            }
        } else {
            $statement->setCondition($criteria);
        }
        $rows = $statement->execute();
        foreach ($rows as $row) {
            $model = $reflection->newInstance();
            $model->setNew(false);
            foreach ($cachedModel['colNames'] as $propName => $column) {
                $reflectionProperty = $reflection->getProperty($propName);
                $reflectionProperty->setAccessible(true);
                $value = $row[$column];
                if(isset($cachedModel['foreignModels'][$propName])){
                    if(isset($cachedModel['selectors'][$propName])){
                        $selectorValue = $row[$cachedModel['selectors'][$propName]];
                        $foreignModel = explode(',', $cachedModel['foreignModels'][$propName])[$selectorValue];
                    } else {
                        $foreignModel = $cachedModel['foreignModels'][$propName];
                    }
                    $foreignField = $cachedModel['foreignFields'][$propName];
                    $value = $this->findOneBy($foreignModel,[$foreignField => $value]);
                }
                $reflectionProperty->setValue($model, $value );
                $reflectionProperty->setAccessible(false);
            }
            $models[] = $model;
        }
        return $models;
    }

    /**
     * @param string $model::class
     * @param array $criteria
     * @return object|null
     */
    public function findOneBy($model, $criteria = [])
    {
        $models = $this->findBy($model, $criteria, 1);
        return (isset($models[0]) === true) ? $models[0] : null;
    }

}
