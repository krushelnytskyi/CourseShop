<?php

namespace MVC\Controller;

use MVC\Models\SubscriptionUser;
use MVC\Models\User;
use System\Auth\Session;
use System\Auth\UserSession;
use System\Form;
use System\MVC\Controller\Controller;
use System\ORM\Repository;
use System\Validators\Regular;
use System\View;

class Subscription extends Controller
{

    public function userAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'
            && true === Session::getInstance()->hasIdentity()
        ) {
            $result = [];

            $form = new Form(
                $_POST,
                [
                    'user' => [
                        new Regular('[0-9]+')
                    ]
                ]
            );

            if (false === $form->execute()) {
                $result['messages'] = $form->getErrors();
            } else {

                $subscription = new SubscriptionUser();
                $user = Repository::getInstance()
                    ->findOneBy(
                        User::class, ['id' => $form->getFieldValue('user')]
                    );

                $subscription->setUser($user);
                $subscription->setSubscriber(UserSession::getInstance()->getIdentity());

                if (false !== Repository::getInstance()->save($subscription)) {
                    $result['message'] = 'Subscribed';
                } else {
                    $result['message'] = 'Can not subscribe user';
                }

            }

            $this->json($result);
        } else {
            return new View('errors/404');
        }

    }

}
