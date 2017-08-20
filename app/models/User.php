<?php

class User extends DB\SQL\Mapper {
    public function __construct(DB\SQL $db) {
		$this->db = $db;
		parent::__construct($db, 'users');
	}

  public function getByName($username) {
    $this->load(array('username=?', $username), array('limit' => 1));

    // return result
    return $this->query;
  }

  public function add($username, $email, $password) {
    // hash the password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $result = $this->db->exec('call sp_insert_user(@out, ?, ?, ?, ?);', array(1 => $username, 2 => $email, 3 => $password, 4 => 'sp_insert_user'));
    return $result;
  }

  public function log_login() {
    $result = $this->db->exec('call sp_insert_log_login(@out, )');
    return $result;
  }

}
