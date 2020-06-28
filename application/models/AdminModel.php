<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	/*
		Add Pelanggan
	*/
	public function addPelanggan($data)
	{
		return $this->db->insert('users', $data);
	}

	/* list pelanggan */
	public function listPelanggan()
	{
		$this->db->select('*');
		$this->db->order_by('users.id', 'desc');
		$this->db->from('users');
		$this->db->join('paket', 'users.paket_id = paket.id');
		$query = $this->db->get()->result_array();

		return $query;
	}

	/* usersPaket */
	public function usersPaket($no_kontrak)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('users.no_kontrak', $no_kontrak);
		$this->db->join('paket', 'users.paket_id = paket.id');
		$query = $this->db->get()->row_array();

		return $query;
	}

	/* addPaket */
	public function addPaket($data)
	{
		return $this->db->insert('paket', $data);
	}

	/* updatePaket */
	public function updatePaket($data, $id)
	{
		return $this->db->set($data)->where('id', $id)->update('paket');
	}

	/* deletePaket */
	public function deletePaket($id)
	{
		return $this->db->delete('paket', ['id' => $id]);
	}

	/* pembayaran */
	public function pembayaran()
	{
		$this->db->select('*');
		$this->db->order_by('pembayaran.pembayaran_id', 'desc');
		$this->db->from('pembayaran');
		$this->db->join('users', 'pembayaran.no_kontrak = users.no_kontrak');
		$query = $this->db->get()->result_array();

		return $query;
	}

	/* pembayaranDetail */
	public function pembayaranDetail($pembayaran_id)
	{
		$this->db->select('*');
		$this->db->from('pembayaran');
		$this->db->where('pembayaran.pembayaran_id', $pembayaran_id);
		$query = $this->db->get()->row_array();

		return $query;
	}
}	
