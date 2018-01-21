<?php

class DownloaderJob extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'downloader_jq');
	}

	public function getJob() {
	    // get a job
	    $this->load(array('state=0 and timestamp <= now()'), array('order' => 'timestamp desc', 'limit' => 1));

	    // return result
	    return $this->query;
	}

  public function getJobsByExchange($exchange) {
    $exchange = '%'.$exchange.'%';

    // split exchange and isin
    $this->exchange = "substring_index(`value`, '#', 1)";
    $this->isin = "substring_index(`value`, '#', -1)";

    // filter data
    $this->load(array("value like ? and state = 0", $exchange));

    return $this->query;
  }

	public function setJobState($id, $action) {
	    $result = $this->db->exec('call sp_update_downloader_jq(@out,?,?,?)', array(1 => $id, 2 => $action, 3 => 'sp_update_downloader_jq'));
      return $result;
	}
}
