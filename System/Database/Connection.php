<?php

namespace System\Database;

use System\Config;
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
       /*        $config = Config::get('database');

        $dsn = sprintf(
            'mysql:host=%s;port=%s;database=%s;',
            $config['host'],
            $config['port'],
            $config['database']
        );

        $this->link = new \PDO($dsn, $config['username'], $config['password']);  */

        $servername = Config::get('database','host');
        $dbname = Config::get('database','database');
        $username = Config::get('database','username');
        $password = Config::get('database','password');

        $this->link = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      
        $this->link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return \PDO
     */
    public function getLink()
    {
        return $this->link;
    }

    public function select()
    {

        return new Select();
    }

    public function insert()
    {
        return new Insert();
    }

    public function delete()
    {
    }

    public function update()
    {
        return new Update();
    }

}