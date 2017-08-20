<?php

class UserController extends Controller {
  function afterroute() {
    echo Template::instance()->render('layout.htm');
	}

  function beforeroute() {

    // We check if user is logged in
    if($this->f3->get('SESSION.user') == null) {
      $this->f3->reroute('/');
      exit;
    }

  }

  function detail() {
    $user = new User($this->db);

    $this->f3->set('page_head', $this->f3->get('page_head_user_detail'));
    $this->f3->set('message', $this->f3->get('PARAMS.message'));
    $this->f3->set('message_failed', $this->f3->get('PARAMS.message_failed'));
    $this->f3->set('user', $user->getByName($this->f3->get('PARAMS.username')));
    $this->f3->set('view', 'profile/detail.htm');
  }

}
