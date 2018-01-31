<?php

class Version extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
    parent::__construct($db, 'version');
	}

  public function getVersion() {
    $this->load();
    return $this->query;
  }
}
