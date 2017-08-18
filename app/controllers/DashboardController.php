<?php

class DashboardController extends Controller {
  function afterroute() {
    echo Template::instance()->render('layout.htm');
	}

  function dashboard() {
    $this->f3->set('page_head', $this->f3->get('page_head_dashboard'));
    $this->f3->set('message', $this->f3->get('PARAMS.message'));
    $this->f3->set('message_failed', $this->f3->get('PARAMS.message_failed'));
    $this->f3->set('view', 'dashboard.htm');
  }

}
