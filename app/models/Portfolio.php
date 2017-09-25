<?php

class Portfolio extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'v_portfolio');
	}

  public function getPortfolioByUsername($username) {
      // get a job
      $this->load(array('username = ?', $username));

      // return result
      return $this->query;
  }

  public function getPortfolioByDetail($portfolio_id) {
    $this->load(array('portfolio_head_id=? and pp_delete = 0', $portfolio_id));
    return $this->query;
  }

  public function addPortfolioHead($portfolioname, $capital_start, $portfolio_type, $portfolio_username) {
    $result = $this->db->exec('call sp_insert_portfolio_head(@out, ?, ?, ?, ?, ?)', array(1 => $portfolioname, 2 => $capital_start, 3 => $portfolio_type, 4 => $portfolio_username, 5 => 'sp_insert_portfolio_head'));
    return $result;
  }
}
