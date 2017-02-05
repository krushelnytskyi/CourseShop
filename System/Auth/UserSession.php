<?php

namespace System\Auth;

use MVC\Models\User;
use System\ORM\Repository;

class UserSession extends Session
{

    public function getIdentity()
    {
        if ($this->hasIdentity() === true) {
            $id = parent::getIdentity();

            $repo = Repository::getInstance();
            return $repo->findOneBy(User::class,
                [
                    'id' => $id
                ]
            );
        }

        return null;
    }

}