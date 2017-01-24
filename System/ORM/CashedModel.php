<?php

namespace System\ORM;

class CashedModel
{
    /**
     * @var string
     */
    private $tableName;

    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $primaryKeyField;

    /**
     * @var array
     */
    private $fields = [];

    /**
     * @var array
     */
    private $modelSelectors = [];

    /**
     * @var array
     */
    private $uniqueFields = [];

    /**
     * @var array
     */
    private $foreignFields = [];

    /**
     * @var array
     */
    private $foreignModels = [];

    /**
     * CashedModel constructor.
     * @param string $tableName
     * @param string $class
     * @param string $primaryKeyField
     * @param array $fields
     * @param array $modelSelectors
     * @param array $uniqueFields
     * @param array $foreignFields
     * @param array $foreignModels
     */
    public function __construct($tableName, $class, $primaryKeyField, array $fields, array $uniqueFields, array $modelSelectors, array $foreignFields, array $foreignModels)
    {
        $this->tableName = $tableName;
        $this->class = $class;
        $this->primaryKeyField = $primaryKeyField;
        $this->fields = $fields;
        $this->modelSelectors = $modelSelectors;
        $this->uniqueFields = $uniqueFields;
        $this->foreignFields = $foreignFields;
        $this->foreignModels = $foreignModels;
    }

    /**
     * @return array
     */
    public function getModelSelectors(): array
    {
        return $this->modelSelectors;
    }

    /**
     * @return array
     */
    public function getUniqueFields(): array
    {
        return $this->uniqueFields;
    }


    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function getForeignFields(): array
    {
        return $this->foreignFields;
    }

    /**
     * @return array
     */
    public function getForeignModels(): array
    {
        return $this->foreignModels;
    }


    /**
     * @return string
     */
    public function getPrimaryKeyField()
    {
        return $this->primaryKeyField;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }


}