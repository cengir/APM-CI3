<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('AdminModel', 'admin');
	}

	public function index()
	{
		$data['title'] = 'Dashboard Admin';
		$data['page']  = 'Dashboard';
		$data['link']  = [
			'dashboard' => base_url('admin/index')
		];

		$data['totalUser'] = $this->db->get_where('users')->num_rows();
		$data['totalPembayaran'] = $this->db->get_where('pembayaran')->num_rows();
		$data['transaksi'] = $this->db->like('tgl_bayar', date('Y-m-d'))->get('pembayaran')->num_rows();
		$data['totalPaket'] = $this->db->get('paket')->num_rows();

		$this->load->view('layouts/header', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('layouts/footer');
	}

	/*
		Pelanggan ===========================================
	*/
	public function add_pelanggan()
	{
		$data['title'] = 'Tambah Pelanggan';
		$data['page']  = 'Tambah Pelanggan';
		$data['link']  = [
			'home' => base_url('admin/index'),
			'Add Pelanggan' => base_url('admin/add_pelanggan'),
		];
		$data['paket'] = $this->db->get('paket')->result_array();
		$data['id']    = $this->db->order_by('id', 'desc')->get('users')->row_array();
		// $data['paket'] = $this->db->get('paket')->result_array();
		
		$this->load->view('layouts/header', $data);
		$this->load->view('admin/pelanggan/add', $data);
		$this->load->view('layouts/footer');
	}

	/* list_pelanggan */
	public function list_pelanggan()
	{
		$data['title'] = 'Data Pelanggan';
		$data['page']  = 'Data Pelanggan';
		$data['link']  = [
			'Home' => base_url('admin/index'),
			'Data Pelanggan' => base_url('admin/list_pelanggan'),
		];

		$data['data'] = $this->admin->listPelanggan();
		
		$this->load->view('layouts/header', $data);
		$this->load->view('admin/pelanggan/list', $data);
		$this->load->view('layouts/footer');
	}

	/*
		post_add_pelanggan
	*/
	public function post_add_pelanggan()
	{	
		$id = $this->db->order_by('id', 'desc')->get('users')->row_array();
		$no = '';
		if($id == null){
			$no = date('Ymd'). '1';
		}else{
			// $no = date('Ymd').$id->id;
			$no = date('Ymd').($id['id']+1);
		}

		$data = [
			'no_kontrak' => $no,
			'no_ktp' => $this->input->post('no_ktp'),
			'nama' => $this->input->post('nama'),
			'alamat' => $this->input->post('alamat'),
			'no_ktp' => $this->input->post('no_ktp'),
			'email' => $this->input->post('email'),
			'paket_id' => $this->input->post('paket_id'),
			'tgl_tempo' => $this->input->post('tgl_jatuh_tempo'),
			'password' => sha1(substr($this->input->post('no_ktp'), -6))
		];

		$save = $this->admin->addPelanggan($data);
		if(!$save){

			$this->session->set_flashdata('error', true);
			$this->session->set_flashdata('msg', 'Penambahan Pelanggan Gagal');
			$this->session->set_flashdata('title', 'Error data');
		}else{

			$this->session->set_flashdata('error', false);
			$this->session->set_flashdata('msg', 'Penambahan Pelanggan Berhasil');
			$this->session->set_flashdata('title', 'Data Sukses');
		}

		return redirect('admin/add_pelanggan');
	}

	/* load_data_cicilan */
	public function load_data_cicilan($no_kontrak)
	{
		$cek = $this->db->get_where('cicilan', ['no_kontrak' => $no_kontrak])->num_rows();
		$user = $this->admin->usersPaket($no_kontrak);

		if($cek > 0){

		}else{

			// insert data cicilan
			$data = [
				'no_kontrak' => $no_kontrak,
				'tgl_bayar' => '0000-00-00',
				'harga_sisa_cicilan' => $user['total_paket_kredit'],
				'total_bayar' => $user['cicilan_perbulan'],
				'status_bayar' => 0
			];

			$this->db->insert('cicilan', $data);	
		}

		$all = $this->db->get_where('cicilan', ['no_kontrak' => $no_kontrak])->result_array();
		echo json_encode($all);
	}

	/* send_notif */
	public function send_notif($no_kontrak)
	{
		$data = $this->admin->usersPaket($no_kontrak);
		echo json_encode($data);
	}

	/* post_send_notif */
	public function post_send_notif()
	{
		// https://myaccount.google.com/lesssecureapps?pli=1

		$user = $this->db->get_where('users', ['no_kontrak' => $this->input->post('no_kontrak')])->row_array();

		// Konfigurasi email
        $config = [
           'mailtype'  => 'html',
           'charset'   => 'utf-8',
           'protocol'  => 'smtp',
           'smtp_host' => 'ssl://smtp.gmail.com',
           'smtp_user' => 'agungprastyob@gmail.com', 
           'smtp_pass' => 'jhonpetruchi',
           'smtp_port' => 465,
           'crlf'      => "\r\n",
           'newline'   => "\r\n"
       ];

        $this->load->library('email', $config);
        $this->email->from('agungprastyob@gmail.com', 'Manajer Jogja Mobilindo Finance');
        $this->email->to($user['email']);

        $this->email->subject('Pembayaran yang belum Anda bayar');
        $this->email->message($this->input->post('editor1'));
        $save = $this->email->send();

        if(!$save){

			$this->session->set_flashdata('error', true);
			$this->session->set_flashdata('msg', 'Gagal Mengirimkan Notif E-mail');
			$this->session->set_flashdata('title', 'Error data');
		}else{

			$this->session->set_flashdata('error', false);
			$this->session->set_flashdata('msg', 'Berhasil Mengirimkan Notif E-mail');
			$this->session->set_flashdata('title', 'Data Sukses');
		}

		return redirect('admin/list_pelanggan');
	}

	/*
		Add Paket ===============================
	*/
	public function add_paket()
	{
		$data['title'] = 'Tambah Paket';
		$data['page']  = 'Tambah Paket';
		$data['link']  = [
			'Home' => base_url('admin/index'),
			'Add Paket' => base_url('admin/add_paket'),
		];
		
		$data['id']    = $this->db->order_by('id', 'desc')->get('paket')->row_array();

		$this->load->view('layouts/header', $data);
		$this->load->view('admin/paket/add', $data);
		$this->load->view('layouts/footer');
	}

	public function edit_paket($id = null)
	{
		if ($id) {

			$data['title'] = 'Edit Paket ' . $id;
			$data['page']  = 'Edit Paket ' . $id;
			$data['link']  = [
				'Home' => base_url('admin/index'),
				'Edit Paket' => base_url('admin/add_paket'),
				$id 	=> base_url('admin/edit_paket/'.$id)
			];
			
			$data['data']    = $this->db->order_by('id', 'desc')->get_where('paket', ['id' => $id])->row_array();

			$this->load->view('layouts/header', $data);
			$this->load->view('admin/paket/edit', $data);
			$this->load->view('layouts/footer');
		}else{
			redirect('index/error');
		}
	}

	/* List Paket */
	public function list_paket()
	{
		$data['title'] = 'List Paket';
		$data['page']  = 'List Paket';
		$data['link']  = [
			'Home' => base_url('admin/index'),
			'List Paket' => base_url('admin/list_paket'),
		];

		$data['data'] = $this->db->order_by('id', 'desc')->get('paket')->result_array();
		
		$this->load->view('layouts/header', $data);
		$this->load->view('admin/paket/list', $data);
		$this->load->view('layouts/footer');
	}

	/* post_add_paket */
	public function post_add_paket()
	{	
		$data = [
			'kode_paket' => $this->input->post('kode_paket'),
			'nama_mobil' => $this->input->post('nama_mobil'),
			'harga_mobil' => str_replace('.', '', $this->input->post('harga_mobil')),
			'cicilan' 	=> $this->input->post('cicilan'),
			'bunga' 	=> $this->input->post('bunga'),
			'dp' 		=> str_replace('.', '', $this->input->post('dp')),
			'total_paket_kredit' 	=> str_replace(['.', 'Rp '], '', $this->input->post('total_paket_kredit')),
			'cicilan_perbulan' 		=> str_replace(['.', 'Rp '], '', $this->input->post('cicilan_perbulan')),
		];

		$save = $this->admin->addPaket($data);
		if(!$save){

			$this->session->set_flashdata('error', true);
			$this->session->set_flashdata('msg', 'Penambahan Paket Gagal');
			$this->session->set_flashdata('title', 'Error data');
		}else{

			$this->session->set_flashdata('error', false);
			$this->session->set_flashdata('msg', 'Penambahan Paket Berhasil');
			$this->session->set_flashdata('title', 'Data Sukses');
		}

		return redirect('admin/add_paket');
	}

	/* post_update_paket */
	public function post_update_paket($id = null)
	{	
		if ($id) {

			$data = [
				'kode_paket' => $this->input->post('kode_paket'),
				'nama_mobil' => $this->input->post('nama_mobil'),
				'harga_mobil' => str_replace('.', '', $this->input->post('harga_mobil')),
				'cicilan' 	=> $this->input->post('cicilan'),
				'bunga' 	=> $this->input->post('bunga'),
				'dp' 		=> str_replace('.', '', $this->input->post('dp')),
				'total_paket_kredit' 	=> str_replace(['.', 'Rp '], '', $this->input->post('total_paket_kredit')),
				'cicilan_perbulan' 		=> str_replace(['.', 'Rp '], '', $this->input->post('cicilan_perbulan')),
			];

			$save = $this->admin->updatePaket($data, $id);
			if(!$save){

				$this->session->set_flashdata('error', true);
				$this->session->set_flashdata('msg', 'Update Data Paket Gagal');
				$this->session->set_flashdata('title', 'Error data');
			}else{

				$this->session->set_flashdata('error', false);
				$this->session->set_flashdata('msg', 'Update Data Paket Berhasil');
				$this->session->set_flashdata('title', 'Data Sukses');
			}

			return redirect('admin/list_paket');
		}else{

			redirect('index/error');
		}
	}

	/* delete_paket */
	public function delete_paket($id = null)
	{
		if ($id) {

			$delete = $this->admin->deletePaket($id);
			if(!$delete){

				$this->session->set_flashdata('error', true);
				$this->session->set_flashdata('msg', 'Menghapus Data Paket Gagal');
				$this->session->set_flashdata('title', 'Error data');
			}else{

				$this->session->set_flashdata('error', false);
				$this->session->set_flashdata('msg', 'Menghapus Data Paket Berhasil');
				$this->session->set_flashdata('title', 'Data Sukses');
			}

			return redirect('admin/add_paket');

		}else{
			redirect('index/error');
		}
	}

	/* pembayaran */
	public function pembayaran()
	{
		$data['title'] = 'Pembayaran';
		$data['page']  = 'Pembayaran';
		$data['link']  = [
			'Home' => base_url('admin/index'),
			'Pembayaran' => base_url('admin/pembayaran')
		];
		
		$data['data'] = $this->admin->pembayaran();

		$this->load->view('layouts/header', $data);
		$this->load->view('admin/pembayaran/index', $data);
		$this->load->view('layouts/footer');
	}

	/* detail_pembayaran */
	public function detail_pembayaran($pembayaran_id = null)
	{
		if ($pembayaran_id) {
			
			$data['title'] = 'Pembayaran';
			$data['page']  = 'Pembayaran';
			$data['link']  = [
				'Home' => base_url('admin/index'),
				'Pembayaran' => base_url('admin/pembayaran'),
				$pembayaran_id => base_url('admin/detail_pembayaran/'.$pembayaran_id)
			];
			
			$data['data'] = $this->admin->pembayaranDetail($pembayaran_id);
			// var_dump($data['data']); die();

			$this->load->view('layouts/header', $data);
			$this->load->view('admin/pembayaran/detail', $data);
			$this->load->view('layouts/footer');
		}else{

			redirect('index/error');
		}
	}

	private function sendEmail($email, $subject, $text)
	{
		$config = [
           'mailtype'  => 'html',
           'charset'   => 'utf-8',
           'protocol'  => 'smtp',
           'smtp_host' => 'ssl://smtp.gmail.com',
           'smtp_user' => 'agungprastyob@gmail.com', 
           'smtp_pass' => 'jhonpetruchi',
           'smtp_port' => 465,
           'crlf'      => "\r\n",
           'newline'   => "\r\n"
       ];

        $this->load->library('email', $config);
        $this->email->from('agungprastyob@gmail.com', 'Head of Finance Jogja Mobilindo');
        $this->email->to($email);

        $this->email->subject($subject);
        $this->email->message($text);
        $send = $this->email->send();

        return $send;
        
	}

	/* confirm_pembayaran */
	public function confirm_pembayaran($pembayaran_id = null)
	{
		if ($pembayaran_id) {

			$cek = $this->db->get_where('pembayaran', ['pembayaran_id' => $pembayaran_id]);
			
			if($cek->num_rows() > 0){

				$data = $cek->row_array();

				$update = $this->db->set(['status' => 1])->where('pembayaran_id', $pembayaran_id)->update('pembayaran');

				if($update){
					$totalBayar = 
					$this->db->get_where('pembayaran', ['status' => 1, 'no_kontrak' => $data['no_kontrak']])->num_rows();

					$usersPaket = $this->admin->usersPaket($data['no_kontrak']);
					$total_paket_kredit = $usersPaket['total_paket_kredit'];
					$cicilan_perbulan   = $usersPaket['cicilan_perbulan'];

					$sisa = $total_paket_kredit - ($cicilan_perbulan * $totalBayar);
					
					$tgl1 = $usersPaket['tgl_tempo']; // ambil dri colum tgl_tempo // 16 oktober
					$tgl2 = date('Y-m-d', strtotime('+1 month', strtotime($tgl1)));
					$updateUser = $this->db->set(['tgl_tempo' => $tgl2])->where('no_kontrak', $usersPaket['no_kontrak'])->update('users');
					
					$update2 = $this->db->set(['tgl_bayar' => date('Y-m-d'), 'status_bayar' => 1])->where('no_kontrak', $data['no_kontrak'])->update('cicilan');

					$insertNew = [
						'no_kontrak' => $data['no_kontrak'],
						'tgl_bayar'	 => '0000-00-00',
						'harga_sisa_cicilan' => $sisa,
						'total_bayar'=> $cicilan_perbulan,
						'status_bayar' => 0
					];
					$save = $this->db->insert('cicilan', $insertNew);
					if($save){

						$text = '
							<b>Kepada Yth. '.$usersPaket['nama'].'</b> <br><br>
							Pembayaran kredit mobil dengan nomer kontrak '.$usersPaket['no_kontrak'].' telah berhasil. Terima kasih atas kerja samanya, Harapan semoga pembayaran tidak melewati jatuh tempo yang akan berdampak dengan denda anda. <br><br>
							Oki <br>
							Manager Jogja Mobilindo Finan

						';	

						$send = $this->sendEmail($usersPaket['email'], 'Pembayaran Anda telah DiKonfirmasi', $text);
						if ($send) {

							$this->session->set_flashdata('error', false);
							$this->session->set_flashdata('msg', 'Pembayaran telah berhasil di Setujui');
							$this->session->set_flashdata('title', 'Sukses');
						}else{
							$this->session->set_flashdata('error', false);
							$this->session->set_flashdata('msg', 'Pembayaran telah berhasil di Setujui, Notif Tidak terkirim');
							$this->session->set_flashdata('title', 'Sukses');
						}

						return redirect('admin/detail_pembayaran/' . $pembayaran_id);
					}else{

						$this->session->set_flashdata('error', false);
						$this->session->set_flashdata('msg', 'Pembayaran telah gagal di Setujui');
						$this->session->set_flashdata('title', 'Error');
					}
					return redirect('admin/detail_pembayaran/' . $pembayaran_id);
				}

			}else{
				$this->session->set_flashdata('error', false);
				$this->session->set_flashdata('msg', 'Data Pembayaran tidak ditemukan');
				$this->session->set_flashdata('title', 'Error');

				return redirect('admin/detail_pembayaran/' . $pembayaran_id);
			}
		}else{
			redirect('index/error');
		}
	}

	public function get_user($no_kontrak)
	{
		echo json_encode($this->db->get_where('users', ['no_kontrak'=> $no_kontrak])->row_array());
	}

	/* post_tolak_pembayaran */
	public function post_tolak_pembayaran()
	{
		$data = [
			'alasan' => $this->input->post('editor1'),
			'status' => 2
		];
		$save = $this->db->set($data)->where('pembayaran_id', $this->input->post('pembayaran_id'))->update('pembayaran');
		
		if($save){

	        $send = $this->sendEmail($this->input->post('email_user'), 'Pembayaran anda ditolak', $this->input->post('editor1'));
	        
	        if(!$send){

				$this->session->set_flashdata('error', true);
				$this->session->set_flashdata('msg', 'Gagal Mengirimkan Notif E-mail');
				$this->session->set_flashdata('title', 'Error data');
			}else{

				$this->session->set_flashdata('error', false);
				$this->session->set_flashdata('msg', 'Berhasil Mengirimkan Notif E-mail');
				$this->session->set_flashdata('title', 'Data Sukses');
			}

			return redirect('admin/detail_pembayaran/' . $this->input->post('pembayaran_id'));
		}	
	}
}
