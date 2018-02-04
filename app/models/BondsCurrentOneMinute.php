<?php

class BondsCurrentOneMinute extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
    parent::__construct($db, 'bonds_current_one_minute');
	}

  public function getPriceById($id, $period) {
    $this->load(array('idbonds_current_one_minute <= ? and bonds_idbonds=(select bonds_idbonds from bonds_current_one_minute where idbonds_current_one_minute = ?) and exchanges_idexchanges = (select exchanges_idexchanges from bonds_current_one_minute where idbonds_current_one_minute = ?)', array($id, $id, $id)), array('order' => 'utctime', 'limit' => $period));
    return $this->query;
  }

  public function aggregate() {
    $result = $this->db->exec('call sp_stockdata_aggregate_1min(@out)');
    return $result;
  }
}
