<?php

class AuthController extends Controller {
  function afterroute() {
    echo Template::instance()->render('layout.htm');
	}

  function welcome() {
    $this->f3->set('page_head', $this->f3->get('page_head'));
    $this->f3->set('message', $this->f3->get('PARAMS.message'));
    $this->f3->set('message_failed', $this->f3->get('PARAMS.message_failed'));
    $this->f3->set('view', 'welcome.htm');
  }

	function render() {
		$this->f3->set('page_head', $this->f3->get('page_head_login'));
		$this->f3->set('message', $this->f3->get('PARAMS.message'));
		$this->f3->set('message_failed', $this->f3->get('PARAMS.message_failed'));
		$this->f3->set('view', 'login.htm');
	}

  function register() {
    $this->f3->set('page_head', $this->f3->get('page_head_registration'));
    $this->f3->set('message', $this->f3->get('PARAMS.message'));
    $this->f3->set('message_failed', $this->f3->get('PARAMS.message_failed'));
    $this->f3->set('view', 'registration.htm');

  }

  function register_process() {
    if($this->f3->exists('POST.create')) {
      $data['username'] = $this->f3->get('POST.username');
      $data['password'] = $this->f3->get('POST.password');
      $data['email'] = $this->f3->get('POST.email');

      $user = new User($this->db);
      $result = $user->add($data['username'], $data['email'], $data['password']);

      if($result == 1) {
        $this->f3->reroute('/success/'.$this->f3->get('reroute_registration_success'));
      } else {
        $this->f3->reroute('/failed/'.$this->f3->get('reroute_registration_failed'));
      }
    }
  }


	function authenticate() {
    if($this->f3->exists('POST.create')) {
		    $username = $this->f3->get('POST.username');
		    $password = $this->f3->get('POST.password');

		    $user = new User($this->db);
		    $user->getByName($username);

                // Debugging
                //print_r($user);
                //echo "clear text password: ".$password."<br/>";
                //echo "hashed password: ".password_hash($password, PASSWORD_DEFAULT);


		    if($user->dry()) {
			       $this->f3->reroute('/login/failed/We could not found any match for your input!');
		    }

		    if(password_verify($password, $user->password)) {
			       $this->f3->set('SESSION.user', $user->username);
			       $this->f3->reroute('/dashboard');
		    } else {
			       $this->f3->reroute('/login/failed/Failed to login! Please try again.');
		    }
    } else {
      $this->f3->reroute('/failed/'.$this->f3->get('reroute_not_permitted'));
    }
	}

  function logout() {
    $this->f3->clear('SESSION');
    $this->f3->reroute('/success/Successfully logged out');
  }
}
