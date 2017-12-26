<?php

class CurrencyNow extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
    parent::__construct($db, 'currency_now');
	}

  public function add($base, $quote, $high, $volume, $datetime, $bid, $ask, $vwap, $low, $exchange, $last) {
    $result = $this->db->exec('call sp_insert_currency_now(@out, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array(1 =>$base, 2 =>$quote, 3 => $high, 4 => $volume, 5 => $datetime, 6 => $bid, 7 => $ask, 8 => $vwap, 9 => $low, 10 => $exchange, 11 => $last, 12 => 'sp_insert_currency_now'));
    return $result;
  }

  public function getUnitpriceByBaseQuoteExchange($base, $quote, $exchange) {
    $this->load(array('base_currency=? and quote_currency=? and exchange_idexchange=?', array($base, $quote, $exchange)), array('order' => 'insert_timestamp desc', 'limit' => 1));
    return $this->query;
  }

  public function getPriceById($id, $period) {
    $this->load(array('currency_now_id <= ? and base_currency=(select base_currency from currency_now where currency_now_id = ?) and quote_currency = (select quote_currency from currency_now where currency_now_id = ?)', array($id, $id, $id)), array('order' => 'currency_now_id desc', 'limit' => $period));
    return $this->query;
  }

}
