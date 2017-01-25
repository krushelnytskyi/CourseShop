<?php

namespace System\Database;

use System\Config;
use System\Database\Statement\Delete;
use System\Database\Statement\Insert;
use System\Database\Statement\Select;
use System\Database\Statement\Update;
use System\Pattern\Singleton;

/**
 * Class Connection
 * @package System\Database
 * @method static Connection getInstance()
 */
class Connection
{
    use Singleton;

    /**
     * @var \PDO
     */
    private $link;

    public function __construct()
    {
        $config = Config::get('database');

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;',
            $config['host'],
            $config['port'],
            $config['database']
        );

        $this->link = new \PDO($dsn, $config['username'], $config['password']);
    }

    /**
     * @return \PDO
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return Select
     */
    public function select()
    {
        return new Select();
    }

    public function insert()
    {
        return new Insert();
    }

    /**
     * @return Delete
     */
    public function delete()
    {
        return new Delete();
    }


    public function update()
    {
        return new Update();
    }

}