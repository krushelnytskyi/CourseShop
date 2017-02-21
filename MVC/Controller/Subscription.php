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
        if (Session::getInstance()->hasIdentity()) {
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
                $repo = Repository::getInstance();
                if (null === $repo->findOneBy(User::class,['id' => $form->getFieldValue('user')])){
                    $result['message'] = 'Something gone wrong!';
                    $this->json($result);
                }
                /** @var SubscriptionUser $subscription */
                $subscription = $repo->findOneBy(SubscriptionUser::class,['user' => $form->getFieldValue('user'),'subscriber' => UserSession::getInstance()->getIdentity()->getId()]);
                if ($subscription === null){
                    $subscription = new SubscriptionUser();
                    $subscription->setUser($form->getFieldValue('user'));
                    $subscription->setSubscriber(UserSession::getInstance()->getIdentity()->getId());
                    $repo->save($subscription);
                    $result['message'] = 'Subscribed!';
                } else {
                    $repo->delete($subscription);
                    $result['message'] = 'Unubscribed!';
                }
            }
            $this->json($result);
        }
    }
}
