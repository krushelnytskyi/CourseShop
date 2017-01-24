<?php

namespace System\Auth;

/**
 * Class Session
 * @package System\Auth
 */
class Session 
{
	
	/**
     * @var bool
     */
	private static $isStarted = false;
	
	
	public static function start() {
        if (self::$isStarted == false) {
            @session_start();
            self::$isStarted = true;
        }
    }
	
	 /**
     * @param $name
     * @return bool
     */
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }
	
	/**
     * @param string $name
     * @param string $value
     */
    public static function set($name, $value) {
        $_SESSION[$name] = $value;
    }
	
	/**
     * @param $name
     * @return null|string
     */
    public static function get($name) {
        return (isset($_SESSION[$name])) ? $_SESSION[$name] : null;
    }
	
	/**
     * @param $name
     */
    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }
	
	/**
     * @param $name
     * @param $string
     * @return null|string
     */
    public static function flash ($name, $string = 'null') {
        if(self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
                return $session;
        } else {
            self::set($name, $string);
        }
    }

    public static function destroy() {
        if (self::$isStarted == TRUE) {
            session_unset();
            session_destroy();
        }
    }
	
}