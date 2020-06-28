<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function usersPaket($no_kontrak)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('users.no_kontrak', $no_kontrak);
		$this->db->join('paket', 'users.paket_id = paket.id');
		$query = $this->db->get()->row_array();

		return $query;
	}

	public function usersCicil($no_kontrak)
	{
		$this->db->select('*');
		$this->db->from('cicilan');
		$this->db->where('no_kontrak',  $no_kontrak);
		$this->db->where('status_bayar',  '');
		$query = $this->db->get()->row_array();

		return $query;
	}
}

