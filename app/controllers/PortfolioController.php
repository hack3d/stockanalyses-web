<?php

class PortfolioController extends Controller {
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

  function index() {
    $portfolio = new Portfolio($this->db);

    $this->f3->set('page_head', $this->f3->get('page_head_portfolio_overview'));
    $this->f3->set('message', $this->f3->get('PARAMS.message'));
    $this->f3->set('message_failed', $this->f3->get('PARAMS.message_failed'));
    $this->f3->set('portfolios', $portfolio->getPortfolioByUsername($this->f3->get('PARAMS.username')));
    $this->f3->set('view', 'portfolio/list.htm');
  }

  function detail() {
    $portfolio = new Portfolio($this->db);

    $this->f3->set('page_head', $this->f3->get('page_head_portfolio_overview'));
    $this->f3->set('message', $this->f3->get('PARAMS.message'));
    $this->f3->set('message_failed', $this->f3->get('PARAMS.message_failed'));
    $this->f3->set('portfolios', $portfolio->getPortfolioByDetail($this->f3->get('PARAMS.id')));
    $this->f3->set('view', 'portfolio/detail.htm');
  }

  function addPortfolio() {
    if($this->f3->exists('POST.create')) {
      $portfolio = new Portfolio($this->db);

      $data['portfolioname'] = $this->f3->get('POST.portfolioname');
      $data['seed_funding'] = $this->f3->get('POST.seed_funding');
      $data['portfolio_type'] = $this->f3->get('POST.portfolio_type');
      $data['username'] = $this->f3->get('SESSION.user');

      // debugging
      //print_r($data);


      if($portfolio->addPortfolioHead($data['portfolioname'], $data['seed_funding'], $data['portfolio_type'], $data['username']) == '1') {
        $this->f3->reroute('/portfolio/'.$data['username'].'/success/'.$this->f3->get('reroute_portfolio_create_success'));
      } else {
        $this->f3->reroute('/portfolio/'.$data['username'].'/failed/'.$this->f3->get('reroute_portfolio_create_failed'));
      }

    } else {
      $this->f3->set('page_head', $this->f3->get('page_head_portfolio_create'));
      $this->f3->set('message', $this->f3->get('PARAMS.message'));
      $this->f3->set('message_failed', $this->f3->get('PARAMS.message_failed'));
      $this->f3->set('view', 'portfolio/create.htm');
    }
  }

  function addPortfolioPos() {
    if($this->f3->exists('POST.create')) {
      $portfolio = new Portfolio($this->db);
    } else {
      $currency = new Currency($this->db);

      $this->f3->set('page_head', $this->f3->get('page_head_portfolio_pos_create'));
      $this->f3->set('currencies', $currency->getCurrency());
      $this->f3->set('message', $this->f3->get('PARAMS.message'));
      $this->f3->set('message_failed', $this->f3->get('PARAMS.message_failed'));
      $this->f3->set('view', 'portfolio/pos_create.htm');
    }
  }

}
