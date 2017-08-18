<?php

class Exchange extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'exchange');
	}

  public function getExchangeBySymbol($symbol) {
      // get a job
      $this->load(array('exchange_symbol=?', $symbol), array('limit' => 1));

      // return result
      return $this->query;
  }

}
