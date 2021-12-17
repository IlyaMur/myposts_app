<?php

declare(strict_types=1);

namespace Ilyamur\PhpMvc\App\Controllers;

use Ilyamur\PhpMvc\Core\View;
use Ilyamur\PhpMvc\App\Models\User;

class Signup extends \Ilyamur\PhpMvc\Core\Controller
{
    public function newAction(): void
    {
        View::renderTemplate('Signup/new.html');
    }

    public function createAction(): void
    {
        $user = new User($_POST);

        if ($user->save()) {
            $user->sendActivationEmail();
            $this->redirect('/signup/success');
        } else {
            View::renderTemplate('Signup/new.html', ['user' => $user]);
        }
    }

    public function successAction(): void
    {
        View::renderTemplate('Signup/success.html');
    }

    public function activateAction(): void
    {
        $tokenValue = $this->routeParams['token'];
        User::activate($tokenValue);

        $this->redirect('/signup/activated');
    }

    public function activatedAction(): void
    {
        View::renderTemplate('signup/activated.html');
    }
}
