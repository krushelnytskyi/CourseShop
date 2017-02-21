<?php

namespace MVC\Controller;

use MVC\Models\AboutOther;
use MVC\Models\Article;
use MVC\Models\SubscriptionUser;
use MVC\Models\User;
use System\Auth\Session;
use System\Auth\UserSession;
use System\Form;
use System\MVC\Controller\Controller;
use System\ORM\Repository;
use System\Validators\Email;
use System\Validators\Regular;
use System\Validators\Strings;
use System\View;

/**
 * Class Users
 * @package MVC\Controller
 */
class Users extends Controller
{

    /**
     * @action users/login
     */
    public function loginAction()
    {
        return new View('pages/home');
    }

    /**
     * Register action
     */
    public function registerAction()
    {
        return new View('pages/home');
    }

    public function jsonLoginAction()
    {
        $result = [];

        $form = new Form(
            $_POST,
            [
                'email' => [
                    new Email(),
                ],
                'password' => [
                    new Strings(1, 6),
                ]
            ]
        );

        if (false === $form->execute()) {
            $result = [
                'messages' => $form->getErrors()
            ];
        } else {
            $repository = Repository::getInstance();
            $user = $repository->findOneBy(User::class,
                [
                    'email' => $form->getFieldValue('email'),
                    'password' => User::encodePassword($form->getFieldValue('password'))
                ]
            );

            if ($user !== null) {
                UserSession::getInstance()->setIdentity($user->getId());
                $result = [
                    'title' => 'login',
                    'text' => 'Sign in',
                    'redirect' => '/'
                ];
            } else {
                $result = [
                    'message' => 'Email or password invalid'
                ];
            }
        }

        $this->json($result);

    }

    public function jsonRegisterAction()
    {
        $result = [];

        $form = new Form(
            $_POST,
            [
                'username' => [
                    new Strings(8, 64),
                ],
                'email' => [
                    new Email(),
                ],
                'password' => [
                    new Strings(1, 6),
                ],
                'repeat_password' => [
                    new Strings(1, 6),
                ],
            ]
        );

        if (false === $form->execute()) {
            $result = [
                'messages' => $form->getErrors()
            ];
        } else {
            $repository = Repository::getInstance();
            $user = $repository->findOneBy(User::class,
                [
                    'email' => $form->getFieldValue('email'),
                ]
            );

            if ($user === null) {
                $user = new User();
                $user->setNickname($form->getFieldValue('username'));
                $user->setEmail($form->getFieldValue('email'));
                $user->setPassword(User::encodePassword($form->getFieldValue('password')));

                if (($id = $repository->save($user)) !== false) {
                    UserSession::getInstance()->setIdentity($id);
                    $result = [

                        'title' => 'register',
                        'text' => 'Registration is completed',
                        'redirect' => '/'
                    ];
                } else {
                    $result = [
                        'message' => 'Something gone wrong'
                    ];
                }
            } else {
                $result = [
                    'message' => 'User exists'
                ];
            }
        }
        $this->json($result);
    }

    /**
     * Logout action
     */
    public function logoutAction()
    {
        UserSession::getInstance()->clearIdentity();
        $this->forward('users/login');
    }

    /**
     * User Settings action
     */
    public function saveAboutOtherAction()
    {
        $result = [];
        if (Session::getInstance()->hasIdentity()) {
            $form = new Form($_POST, [
                'value' => [
                    new Strings(-1, 500),
                ],
                'user' => [
                    new Regular('[0-9]+'),
                ],
            ]);
            if ($form->execute()) {
                $repo = Repository::getInstance();
                /** @var User $user */
                $user = UserSession::getInstance()->getIdentity();
                /** @var AboutOther $aboutOther */
                $aboutOther = $repo->findOneBy(AboutOther::class, ['user' => $user->getId(), 'target_user' => $form->getFieldValue('user')]);
                $value = $form->getFieldValue('value');
                if ($value === null || $value === ''){
                    if ($aboutOther !== null){
                        $repo->delete($aboutOther);
                    }
                }else{
                    if ($aboutOther === null) {
                    $aboutOther = new AboutOther();
                    $aboutOther->setValue($value)->setTargetUser($form->getFieldValue('user'))->setUser($user);
                    $repo->save($aboutOther);
                    } else {
                    $aboutOther->setValue($form->getFieldValue('value'));
                    $repo->update($aboutOther);
                    }
                }
                $result = ['message' => 'Saved!'];
            } else {
                $result = $form->getErrors();
            }
        } else {
            $result = ['message' => 'You must log-in for this action!'];
        }
        $this->json($result);
    }

    /**
     * User Settings action
     */
    public function settingsAction()
    {
    }

    /**
     * User profile action
     */
    public function profileAction()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        list(, $id) = explode('/', $url);
        $repo = Repository::getInstance();
        /** @var User $user */
        $user = $repo->findOneBy(User::class, ['id' => $id]);
        if ($user === null) {
            return new View('errors/404');
        } else {
            $view = new View('users/profile');
            $view->assign('user', $user);
            $view->assign('subscribed', false);
            $articles = $repo->findBy(Article::class,['user'=>$user->getId()]);
            $view->assign('articles', $articles);

            $subscriptions = Repository::getInstance()->findBy(
                    SubscriptionUser::class,
                    ['user' => $user->getId()]
            );
            if (Session::getInstance()->hasIdentity()) {
                /** @var User $currentUser */
                $currentUser = UserSession::getInstance()
                    ->getIdentity();
                $subscribers = array_map(
                    function ($subscription) use ($currentUser, $view) {

                        if ($subscription->getSubscriber()->getId() === $currentUser->getId()) {
                            $view->assign('subscribed', true);
                        }

                        return $subscription->getSubscriber();
                    },
                    $subscriptions
                );

                $view->assign('subscribers', $subscribers);
                /** @var AboutOther $aboutOther */
                $aboutOther = $repo->findOneBy(AboutOther::class, ['user' => $currentUser->getId(), 'target_user' => $id]);
                if ($aboutOther !== null) {
                    $view->assign('aboutOtherValue', $aboutOther->getValue());
                }
            } else {
                $subscribers = array_map(
                    function ($subscription) {
                        return $subscription->getSubscriber();
                    },
                    $subscriptions
                );
                $view->assign('subscribers', $subscribers);
            }

            return $view;
        }
    }

    public function testAction()
    {
    }
}