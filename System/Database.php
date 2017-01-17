<?php

namespace System;


/**
 * Class Database
 * @package System
 */


class Database
{

    /**
     * @var \mysqli|null
     */
    private $link = null;

    /**
     * @var null
     */
    static $inst = null;

    /**
     * @var int
     */
    public static $counter = 0;

    /**
     * Allow the class to send admins a message alerting them to errors
     * on production sites
     *
     * @access public
     * @param string $error
     * @param string $query
     * @return mixed
     */

    public function log_db_errors( $error, $query )
    {
        $message = '<p>Error at '. date('Y-m-d H:i:s').':</p>';
        $message .= '<p>Query: '. htmlentities( $query ).'<br />';
        $message .= 'Error: ' . $error;
        $message .= '</p>';
        if( defined( 'SEND_ERRORS_TO' ) )
        {
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'To: Admin <'.SEND_ERRORS_TO.'>' . "\r\n";
            $headers .= 'From: Yoursite <system@'.$_SERVER['SERVER_NAME'].'.com>' . "\r\n";
            mail( SEND_ERRORS_TO, 'Database Error', $message, $headers );
        }
        else
        {
            trigger_error( $message );
        }
        if( !defined( 'DISPLAY_DEBUG' ) || ( defined( 'DISPLAY_DEBUG' ) && DISPLAY_DEBUG ) )
        {
            echo $message;
        }
    }




    public function __construct()
    {
        mb_internal_encoding( 'UTF-8' );
        mb_regex_encoding( 'UTF-8' );
        mysqli_report( MYSQLI_REPORT_STRICT );
        try {
            $this->link = new \mysqli( HOST, USERNAME, PASSWORD, DATABASE );
            $this->link->set_charset( "utf8" );
        } catch ( Exception $e ) {
            die( 'Unable to connect to database' );
        }
    }


    public function __destruct()
    {
        if( $this->link)
        {
            $this->disconnect();
        }
    }


    /**
     * Perform queries
     * All following functions run through this function
     *
     * @access public
     * @param string
     * @return string
     * @return array
     * @return bool
     *
     */

    public function query( $query )
    {
        $full_query = $this->link->query( $query );
        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $query );
            return false;
        }
        else
        {
            return true;
        }
    }


    /**
     * Count number of rows found matching a specific query
     *
     * @access public
     * @param string
     * @return int
     *
     */

    public function num_rows( $query )
    {
        self::$counter++;
        $num_rows = $this->link->query( $query );
        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $query );
            return $this->link->error;
        }
        else
        {
            return $num_rows->num_rows;
        }
    }


    /**
     * Return specific row based on db query
     *
     * @access public
     * @param string
     * @param bool $object (true returns results as objects)
     * @return array
     *
     */

    public function get_row( $query, $object = false )
    {
        self::$counter++;
        $row = $this->link->query( $query );
        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $query );
            return false;
        }
        else
        {
            $r = ( !$object ) ? $row->fetch_row() : $row->fetch_object();
            return $r;
        }
    }


      /**
     * Insert data into database table
     *
     * @access public
     * @param string table name
     * @param array table column => column value
     * @return bool
     *
     */
    public function insert( $table, $variables = array() )
    {
        self::$counter++;
        //Make sure the array isn't empty
        if( empty( $variables ) )
        {
            return false;
        }

        $sql = "INSERT INTO ". $table;
        $fields = array();
        $values = array();
        foreach( $variables as $field => $value )
        {
            $fields[] = $field;
            $values[] = "'".$value."'";
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '('. implode(', ', $values) .')';

        $sql .= $fields .' VALUES '. $values;
        $query = $this->link->query( $sql );

        if( $this->link->error )
        {
            //return false;
            $this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
        {
            return true;
        }
    }


     /**
     * Update data in database table
     *
     * @access public
     * @param string table name
     * @param array values to update table column => column value
     * @param array where parameters table column => column value
     * @param int limit
     * @return bool
     *
     */
    public function update( $table, $variables = array(), $where = array(), $limit = '' )
    {
        self::$counter++;
        if( empty( $variables ) )
        {
            return false;
        }
        $sql = "UPDATE ". $table ." SET ";
        foreach( $variables as $field => $value )
        {

            $updates[] = "`$field` = '$value'";
        }
        $sql .= implode(', ', $updates);

        if( !empty( $where ) )
        {
            foreach( $where as $field => $value )
            {
                $value = $value;
                $clause[] = "$field = '$value'";
            }
            $sql .= ' WHERE '. implode(' AND ', $clause);
        }

        if( !empty( $limit ) )
        {
            $sql .= ' LIMIT '. $limit;
        }
        $query = $this->link->query( $sql );
        if( $this->link->error )
        {
            $this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
        {
            return true;
        }
    }


    /**
     * Delete data from table
     *
     * @access public
     * @param string table name
     * @param array where parameters table column => column value
     * @param int max number of rows to remove.
     * @return bool
     *
     */
    public function delete( $table, $where = array(), $limit = '' )
    {
        self::$counter++;
        if( empty( $where ) )
        {
            return false;
        }

        $sql = "DELETE FROM ". $table;
        foreach( $where as $field => $value )
        {
            $value = $value;
            $clause[] = "$field = '$value'";
        }
        $sql .= " WHERE ". implode(' AND ', $clause);

        if( !empty( $limit ) )
        {
            $sql .= " LIMIT ". $limit;
        }

        $query = $this->link->query( $sql );
        if( $this->link->error )
        {

            $this->log_db_errors( $this->link->error, $sql );
            return false;
        }
        else
        {
            return true;
        }
    }


    /**
     * Get last auto-incrementing ID associated with an insertion
     *
     * @access public
     * @param none
     * @return int
     *
     */
    public function lastid()
    {
        self::$counter++;
        return $this->link->insert_id;
    }


     /**
     * Get field names associated with a table
     *
     * @access public
     * @param query
     * @return array
     */
    public function list_fields( $query )
    {
        self::$counter++;
        $query = $this->link->query( $query );
        $listed_fields = $query->fetch_fields();
        return $listed_fields;
    }


    /**
     * Disconnect from db server
     * Called automatically from __destruct function
     */
    public function disconnect()
    {
        $this->link->close();
    }
}
