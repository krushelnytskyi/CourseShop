<?php

namespace System\ORM;

/**
 * Class Repository
 * @package System\ORM
 */
class Repository
{
    private $databaseConfig;

    function __construct()
    {
        $this->databaseConfig = $this->getDatabaseConfig();
    }

    /**
     * @param string
     * @return array
     */
    public function getModels($directory = 'MVC/Models')
    {
        $clases = [];

        foreach (array_diff(scandir($this->getAppRootDir() . '/' . $directory), array('..', '.')) as $file) {
            $class = str_replace('/', '\\', $directory) . '\\' . str_replace('.php', '', $file);
            if (class_exists($class)) {
                $clases[] = $class;
            }
        }
        return $clases;
    }

    /**
     * @param string
     */
    public function installModel($modelClass)
    {
        $this->installModels((array)$modelClass);
    }

    /**
     * @param array|null
     * null for installation default models
     */
    public function installModels($modelClasses = null)
    {
        if ($modelClasses === null) {
            $modelClasses = $this->getModels();
        }
        $mysqli = $this->connectToDatabase();
        if (!$mysqli->connect_error) {
            foreach ($modelClasses as $modelClass) {
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
                                    $query = $query . $property->getName() . ' ' . $columnType[1] . ',';
                                }

                            }

                        }

                        $query = trim($query, ',') . ');';
                        $mysqli->query($query);
                        if ($mysqli->error) {
                            echo 'Table ' . $table . ' doesn\'t instaled. Error: ' . $mysqli->error . PHP_EOL;
                        } else echo 'Table ' . $table . ' successfully instaled.' . PHP_EOL;


                    } else echo $modelClass . ' does not match the the requirements of the model, information about table not found, and model not instaled.' . PHP_EOL;

                } else echo $modelClass . ' class does\'t exist.' . PHP_EOL;

            }

            $mysqli->close();

        } else echo 'Models are totally not instaled. Failed to connect to database. Error: ' . $mysqli->connect_error . PHP_EOL;

    }

    /**
     * @return \mysqli
     */
    private function connectToDatabase()
    {
        return new \mysqli($this->databaseConfig['host'], $this->databaseConfig['username'], $this->databaseConfig['password'], $this->databaseConfig['database'], $this->databaseConfig['port']);
    }

    /**
     * @return array
     */
    private function getDatabaseConfig()
    {
        return include $this->getAppRootDir() . '/config/database.php';
    }

    /**
     * @return string
     */
    private function getAppRootDir()
    {
        return dirname(__DIR__, 2);
    }

}