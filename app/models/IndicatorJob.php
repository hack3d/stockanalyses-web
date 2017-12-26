<?php

class IndicatorJob extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'indicator_jq');
	}

  public function getJob() {
      // get a job
      $this->load(array('timestamp <= now() and state = ?', 'open'), array('order' => 'timestamp', 'limit' => 1));

      // return result
      return $this->query;
  }

  public function setJobState($job_id, $new_action) {
      $result = $this->db->exec('call sp_update_indicator_jq(@out,?,?,?)', array(1 => $job_id, 2 => $new_action, 3 => 'sp_update_indicator_jq'));
      return $result;
  }

}
