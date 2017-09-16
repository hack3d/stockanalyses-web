<?php

class ExchangeToTrade extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'exchange_to_trade');
	}

  public function getTradingpairByBase($base) {
      $this->load(array('base=? and state = 0', $base));
      return $this->query;
  }

  public function getTradingpairByQuote($quote) {
    $this->load(array('quote=? and state = 0', $quote));
    return $this->query;
  }

  public function getTradingpairByExchange($exchange_id) {
    $this->load(array('exchange_idexchange=? and state = 0', $exchange_id));
    return $this->query;
  }

  public function getTradingpairByExchangeAndBase($exchange_id, $base) {
    $this->load(array('exchange_idexchange=? and base=? and state = 0', array($exchange_id, $base)));
    return $this->query;
  }

  public function all() {
    $this->load();
    return $this->query;
  }

}
