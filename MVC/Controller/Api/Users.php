<?php

namespace MVC\Controller\Api;

use System\MVC\Controller\Controller;

/**
 * Class Users
 * @package MVC\Controller\Api
 */
class Users extends Controller
{

    public function testAction()
    {
        $this->json(['message' => 'success']);
    }

}