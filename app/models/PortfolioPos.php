<?php

class PortfolioPos extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'portfolio_pos');
	}

  public function addPortfolioPos($portfolio_head_id, $base, $quote, $quantity, $unit_price, $exchange) {
    $result = $this->db->exec('call sp_insert_portfolio_pos(@out, ?, ?, ?, ?, ?, ?, ?)', array(1 => $portfolio_head_id, 2 => $base, 3 => $quote, 4 => $unit_price, 5 => $quantity, 6 => $exchange, 7 => 'sp_insert_portfolio_pos'));
    return $result;
  }

  public function getPosByHeadid($portfolio_head_id) {
    $this->load(array('id_portfolio_head = ?', $portfolio_head_id));
    return $this->query;
  }
}
