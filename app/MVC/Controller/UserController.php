<?php
/**
 * @author  Florian Petruschke <f.petruschke@dzh-online.de>
 * @date    12.01.16  -  13:41
 * @version 1.0
 */

class UserController extends Controller {

    function renderLogin() {
        // setting the page title
        $this->f3->set('title', 'Login');

        // instantiating new template object
        $template = new Template();
        $this->f3->set('view', 'login.html');
        echo $template->render('layout.html');
    }

    function beforeroute() {
    }

    function authenticate() {

        // getting username and password from sent POST
        $username = $this->f3->get('POST.username');
        $password = $this->f3->get('POST.password');

        $user = new Users($this->db);
        $user->getByName($username);

        if($user->dry()) {
            $this->f3->reroute('/login');
        }

        if(password_verify($password, $user->password)) {
            $this->f3->set('SESSION.user', $user->username);
            $this->f3->reroute('/user');
        } else {
            $this->f3->reroute('/login');
        }
    }
}