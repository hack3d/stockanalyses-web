<?php

class UserAuthtoken extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'user_authtoken');
	}

  public function getByName($user_id) {
    $this->load(array('user_id=?'), $user_id);
    return $this->query;
  }

}
