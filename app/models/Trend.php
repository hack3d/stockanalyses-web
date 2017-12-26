<?php

class Trend extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
    parent::__construct($db, 'trend');
	}

  public function add($bond_id, $currency_flag, $stock_flag, $indicator, $value) {
    $result = $this->db->exec('call sp_insert_trend(@out, ?, ?, ?, ?, ?, ?)',
      array(1 =>$bond_id, 2 =>$currency_flag, 3 => $stock_flag, 4 => $indicator,
      5 => $value, 6 => 'sp_insert_trend'));
    return $result;
  }
}
