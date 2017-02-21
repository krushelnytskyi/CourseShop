<?php

namespace System\ORM;

use System\Database\Connection;

class ModelsInstaller
{

    /**
     * @param array|null
     * null for installation default models
     */
    public function installModels()
    {
        foreach ($this->getModels() as $model) {
            $this->installModel($model);
        }
    }

    /**
     * @param string
     */
    public function installModel($modelClass)
    {
        if (class_exists($modelClass)) {
            $reflectionsClass = new \ReflectionClass($modelClass);
            $table = [];
            preg_match('/@table\((.*)\)/', $reflectionsClass->getDocComment(), $table);
            if (isset($table[1])) {
                $table = $table[1];
                $query = 'CREATE TABLE ' . $table . ' (';
                foreach ($reflectionsClass->getProperties() as $property) {
                    $columnType = [];
                    if (preg_match('/@columnType\((.*)\)/', $property->getDocComment(), $columnType)) {
                        if (isset($columnType[1])) {
                            if (preg_match('/@columnName\((.*)\)/', $property->getDocComment(), $matches)){
                                $query = $query . $matches[1] . ' ' . $columnType[1] . ',';
                            } else {
                                $query = $query . $property->getName() . ' ' . $columnType[1] . ',';
                            }
                        }
                    }
                }
                $query = trim($query, ',') . ');';
                //echo $query . PHP_EOL;
                Connection::getInstance()->getLink()->prepare($query)->execute();
            } else {
                echo $modelClass . ' does not match the the requirements of the model, information about table not found, and model not instaled.' . PHP_EOL;
            }
        } else {
            echo $modelClass . ' class does\'t exist.' . PHP_EOL;
        }
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

}