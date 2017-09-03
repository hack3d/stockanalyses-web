<?php

class AdvicerJob extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'advice_queue');
	}

  public function getJob() {
      // get a job
      $this->load(array('timestamp <= now() and state = 1000'), array('order' => 'timestamp desc', 'limit' => 1));

      // return result
      return $this->query;
  }

}
