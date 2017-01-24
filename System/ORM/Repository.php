<?php

namespace System\ORM;


use System\Database\Statement\IndpndtConditions;
use System\Pattern\Singleton;
use System\Database\Connection;


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
     * @var Connection
     */
    protected $connection;

    /**
     * @var CashedModel[]
     */
    protected $cache = [];

    /**
     * @var string conditions
     */
    protected $conditions;

    /**
     * Repository constructor.
     */
    public function __construct()
    {
        $this->connection = Connection::getInstance();
        $this->cacheModels();
    }

    /**
     * @param string
     * @return array string mo
     */
    public function getModels($directory = 'MVC/Models')
    {
        $classes = [];

        foreach (array_diff(scandir(APP_ROOT . $directory), array('..', '.')) as $file) {
            $class = str_replace('/', '\\', $directory) . '\\' . str_replace('.php', '', $file);
            if (class_exists($class)) {
                $classes[] = $class;
            }
        }
        return $classes;
    }

    /**
     * @param $model
     * @return int
     */
    public function save($model)
    {       
        $cachedModel = $this->getCachedModel(get_class($model));
        if (isset($cachedModel)) {
            if ($cachedModel->getPrimaryKeyField() !== null) {

                //I just didn't have enought time. I goint to finisf this method to friday.
                //Check unique fields and update

            } else {

                //Check unique fields and insert

            }
        }

        return 0;

    }

    /**
     * @param $class
     * @return CashedModel
     */
    public function getCachedModel($class)
    {
        return $this->cache[$class];
    }

    /**
     * Usage:
     * $repository = \System\ORM\Repository::getInstance();
     * $condition = new \System\Database\Statement\IndpndtConditions();
     * $condition = $condition->compare('id',10,'<')->closeCondition();
     * $repository->findBy(\MVC\Models\Tag::class,$condition,5);
     *
     * Also, this class supports the old condition class
     *
     * @param class
     * @param string $conditions
     * @param int $limit
     * @return array
     */
    public function findBy($model, $conditions = null, $limit = null)
    {
        $models = [];
        $cashedModel = $this->getCachedModel($model);

        if ($conditions !== null) {
            $this->conditions = $conditions;
        }

        if ($cashedModel !== null) {
            $select = $this->connection->select()->from($this->getCachedModel($model)->getTableName())->setCondition($this->conditions);

            if ($limit !== null) {
                $select->limit($limit);
            }
            $rows = $select->execute();
            $reflectionClass = new \ReflectionClass($model);
            foreach ($rows as $row) {

                foreach ($row as $field => $value) {

                    //recursive filling parameters by foreign objects

                    if (isset($cashedModel->getForeignFields()[$field])) {

                        if (isset($cashedModel->getModelSelectors()[$field])) {             // --===<<<3
                            $selectorValue = $cashedModel->getModelSelectors()[$field];
                            $foreignModels = explode(',', $cashedModel->getForeignModels()[$field])[$selectorValue];
                        } else {
                            $foreignModels = $cashedModel->getForeignModels()[$field];
                        }

                        $condition = new IndpndtConditions();
                        $condition->compare($cashedModel->getForeignFields()[$field], $value, '=')->closeCondition();
                        $row[$field] = $this->findBy($foreignModels, $condition)[0];
                    }
                }

                $models[] = $reflectionClass->newInstanceArgs($row);
            }
        }
        return $models;
    }

    /**
     * ...
     */
    protected function cacheModels()
    {
        foreach ($this->getModels() as $class) {
            $reflectionClass = new \ReflectionClass($class);
            $table = null;
            $primaryKeyField = null;
            $fields = [];
            $uniqueFields = [];
            $modelSelectors = [];
            $foreignModels = [];
            $foreignFields = [];
            $tempResult = [];
            $tempResult2 = [];
            preg_match('/@table\((.*)\)/', $reflectionClass->getDocComment(), $tempResult);
            if (isset($tempResult[1])) {
                $table = $tempResult[1];
                foreach ($reflectionClass->getProperties() as $property) {
                    if (preg_match('/@columnType\((.*)\)/', $property->getDocComment(), $tempResult)) {
                        $fields[] = $property->getName();

                        if (preg_match('/AUTO_INCREMENT/', $tempResult[1])) {

                            $primaryKeyField = $property->getName();
                        }
                        if (preg_match('/UNIQUE/', $tempResult[1])) {
                            $uniqueFields[] = $property->getName();
                        }
                        if (preg_match('/@selector\((.*)\)/', $property->getDocComment(), $tempResult)) {     // --==<<3
                            $modelSelectors[$property->getName()] = $tempResult[1];
                        }
                        if (preg_match('/@foreignModel\((.*)\)/', $property->getDocComment(), $tempResult) and
                            preg_match('/@foreignField\((.*)\)/', $property->getDocComment(), $tempResult2)){

                            $foreignModels[$property->getName()] = [$tempResult[1]];
                            $foreignFields[$property->getName()] = [$tempResult2[1]];
                        }
                    }
                }
            }

            $this->cache[$class] = new CashedModel($table, $class, $primaryKeyField, $fields, $uniqueFields, $modelSelectors, $foreignFields, $foreignModels);
        }
    }

    /**
     * @param string $conditions
     * @return $this
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }
}
