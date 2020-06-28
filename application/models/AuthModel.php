<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	/*
		Login Admin
	*/
	public function LoginAdmin($username, $password)
	{
		return $this->db->get_where('admin', ['username' => $username, 'password' => $password]);
	}

	/* LoginUser */
	public function LoginUser($username, $password)
	{
		return $this->db->get_where('users', ['no_kontrak' => $username, 'password' => $password]);
	}
}
