<?php

class Currency extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'currency');
	}

  public function getCurrencyBySymbol($symbol) {
      // get a job
      $this->load(array('symbol_currency=?', $symbol), array('limit' => 1));

      // return result
      return $this->query;
  }

}
