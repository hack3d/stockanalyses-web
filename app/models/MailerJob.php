<?php

class MailerJob extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'email_queue');
	}

  public function getJob() {
      // get a job
      $this->load(array('timestamp <= now() and status = 1000'), array('order' => 'timestamp desc', 'limit' => 1));

      // return result
      return $this->query;
  }

  public function setJobState($job_id, $new_action) {
      $result = $this->db->exec('call sp_update_email_queue(@out,?,?,?)', array(1 => $new_action, 2 => $job_id, 3 => 'sp_update_email_queue'));
      return $result;
  }
}
