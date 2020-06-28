<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('UsersModel', 'users');
	}

	public function index()
	{
		$data['title'] = 'Dashboard Users';
		$data['page']  = 'Dashboard';
		$data['link']  = [
			'dashboard' => base_url('users/index')
		];

		$data['cicilan'] = $this->db->get_where('cicilan', ['no_kontrak' => $_SESSION['no_kontrak']])->result_array();

		$this->load->view('layouts/header2', $data);
		$this->load->view('users/index', $data);
		$this->load->view('layouts/footer');
	}

	/* bayar */
	public function bayar()
	{
		$data['title'] = 'Bayar Cicilan';
		$data['page']  = 'Bayar Cicilan';
		$data['link']  = [
			'Bayar Cicilan' => base_url('users/bayar')
		];

		$cicilan = $this->db->order_by('id', 'desc')->get_where('cicilan', ['no_kontrak' => $_SESSION['no_kontrak']]);;

		$data['total_cicilan'] = $cicilan->num_rows()+1;
		$data['cicilan'] = $cicilan->row_array();
		$data['users']   = $this->users->usersPaket($_SESSION['no_kontrak']);
		$data['cicil']   = $this->users->usersCicil($_SESSION['no_kontrak']);

		$data['bayar'] = $this->db->get_where('pembayaran', ['status' => 0])->num_rows();

		$this->load->view('layouts/header2', $data);
		$this->load->view('users/bayar', $data);
		$this->load->view('layouts/footer');
	}


	/* post_bayar_cicilan */
	public function post_bayar_cicilan()
	{
		$config['upload_path']          = './foto_resi/';
	    $config['allowed_types']        = 'gif|jpg|png';
	    $config['overwrite']			= true;
	    $config['max_size']             = 1024;

	    $this->load->library('upload', $config);

	    if ($this->upload->do_upload('foto_resi')) {

	    	$file = $this->upload->data("file_name");
	    	
			$data = [
				'no_kontrak' => $_SESSION['no_kontrak'],
				'nama_rekening' => $this->input->post('nama_rekening'),
				'no_rekening' => $this->input->post('no_rekening'),
				'jumlah_bayar' => str_replace(".", '', $this->input->post('jumlah_bayar')),
				'foto_resi' => $file,
				'alasan' => '',
				'tgl_bayar' => date('Y-m-d H:i:s'),
				'status' => 0,
				'denda' => $this->input->post('denda')
			];

			$save = $this->db->insert('pembayaran', $data);
			if(!$save){

				$this->session->set_flashdata('error', true);
				$this->session->set_flashdata('msg', 'Pembayaran Anda Gagal');
				$this->session->set_flashdata('title', 'Error data');
			}else{

				$this->session->set_flashdata('error', false);
				$this->session->set_flashdata('msg', 'Pembayaran Anda Berhasil');
				$this->session->set_flashdata('title', 'Data Sukses');
			}
			return redirect('users/bayar');
	    }else{

			$this->session->set_flashdata('error', false);
			$this->session->set_flashdata('msg', 'Kesalahan Mengirim Foto resi');
			$this->session->set_flashdata('title', 'Upload Error');
		
			return redirect('users/bayar');
	    }   
	}

	public function history()
	{
		$data['title'] = 'History Pembayaran';
		$data['page']  = 'History Pembayaran';
		$data['link']  = [
			'History Pembayaran' => base_url('users/history')
		];

		$data['pembayaran'] = $this->db->get_where('pembayaran', ['no_kontrak' => $_SESSION['no_kontrak']])->result_array();

		$this->load->view('layouts/header2', $data);
		$this->load->view('users/history', $data);
		$this->load->view('layouts/footer');
	}

	/* info */
	public function info()
	{
		$data['title'] = 'Info Profile';
		$data['page']  = 'Info Profile';
		$data['link']  = [
			'Info Profile' => base_url('users/info')
		];

		$data['user'] = $this->users->usersPaket($_SESSION['no_kontrak']);
		$data['sisa'] = $this->db->get_where('cicilan', ['no_kontrak' => $_SESSION['no_kontrak'], 'status_bayar' => 1])->num_rows();

		$this->load->view('layouts/header2', $data);
		$this->load->view('users/info', $data);
		$this->load->view('layouts/footer');
	}
}