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

  public function getPriceById($id, $period) {
    $this->load(array('stock_current_id <= ? and bonds_idbonds=(select bonds_idbonds from bonds_current where stock_current_id = ?) and exchanges_idexchanges = (select exchanges_idexchanges from bonds_current where stock_current_id = ?)', array($id, $id, $id)), array('order' => 'stock_current_id desc', 'limit' => $period));
    return $this->query;
  }

}
