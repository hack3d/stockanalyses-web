<?php

class ImporterJob extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'import_jq');
	}

  public function getJob() {
      // get a job
      $this->load(array('timestamp <= now() and action in (1000)'), array('order' => 'timestamp desc', 'limit' => 1));

      // return result
      return $this->query;
  }

  public function setJobState($current_action, $new_action, $filename) {
      $result = $this->db->exec('call sp_update_import_jq(@out,?,?,?,?)', array(1 => $current_action, 2 => $new_action, 3 => $filename, 4 => 'sp_update_downloader_jq'));
      return $result;
  }

  function add($action, $id_stock, $filename) {
    $result = $this->db->exec('call sp_insert_import_jq(@out, ?, ?, ?, ?)', array(1 =>$action, 2 =>$id_stock, 3 => $filename, 4 => 'sp_insert_import_jq'));
    return $result;
  }

}
