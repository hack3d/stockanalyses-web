<?php

class BondsCurrent extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
    parent::__construct($db, 'bonds_current');
	}

  public function add($isin, $exchange, $high, $low, $bid, $ask, $volume, $datetime, $last) {
    $result = $this->db->exec('call sp_insert_bonds_current(@out, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array(1 =>$isin, 2 => $high, 3 => $volume, 4 => $datetime, 5 => $bid, 6 => $ask, 7 => $low, 8 => $exchange, 9 => $last, 10 => 'sp_insert_currency_now'));
    return $result;
  }
}
