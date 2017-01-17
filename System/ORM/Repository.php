<?php

namespace System\ORM;

/**
 * Class Repository
 * @package System\ORM
 */
class Repository
{

    /**
     * @return array
     */
    public function getModels()
    {
        return [];
    }

    /**
     * @param $modelClass
     */
    public function installModel($modelClass)
    {

    }

    /**
     *
     */
    public function installModels()
    {
        foreach ($this->getModels() as $model) {
            $this->installModel($model);
        }
    }

}
