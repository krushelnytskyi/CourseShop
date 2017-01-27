<?php

namespace System\Auth;

use System\Pattern\Singleton;

/**
 * Class Session
 * @package System\Auth
 *
 * @method static Session getInstance()
 */
class Session
{

    use Singleton;

    /**
     * Identity
     */
    const IDENTITY = 'IDENTITY';

    /**
     * Session constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $_SESSION[static::IDENTITY];
    }

    public function setIdentity($identity)
    {
        $_SESSION[static::IDENTITY] = $identity;
    }

    /**
     * @return bool
     */
    public function hasIdentity()
    {
        return isset($_SESSION[static::IDENTITY])
            && $_SESSION[static::IDENTITY];
    }

    /**
     * Clear session
     */
    public function clearIdentity()
    {
        session_unset();
    }
    
}