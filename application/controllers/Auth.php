<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('AuthModel', 'auth');
	}

	public function index()
	{
		$this->load->view('auth/index');
	}

	public function admin()
	{
		$this->load->view('auth/admin');
	}

	/*
		login_admin
	*/
	public function login_admin()
	{
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password'));

		$model = $this->auth->LoginAdmin($username, $password);
		if($model->num_rows() > 0){

			$data = $model->row_array();

			$user = [
				'id' => $data['id'],
				'username' => $data['username'],
				'password' => $data['password'],
				'nama' 	   => $data['nama']
			];

			$save = $this->session->set_userdata($user);
			return redirect(base_url('admin/index'));
		}else{
			$this->session->set_flashdata('error', 'Akun Admin tidak ditemukan');
			redirect(base_url('auth/admin'));
		}
	}

	/* login_user */
	public function login_user()
	{
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password'));

		$model = $this->auth->LoginUser($username, $password);
		if($model->num_rows() > 0){

			$data = $model->row_array();

			$user = [
				'id' 	=> $data['id'],
				'nama' 	=> $data['nama'],
				'no_kontrak' 	=> $data['no_kontrak']
			];

			$save = $this->session->set_userdata($user);
			return redirect(base_url('users/index'));
		}else{
			$this->session->set_flashdata('error', 'Akun Users tidak ditemukan');
			redirect(base_url('auth'));
		}
	}

	/*
		Logout
	*/
	public function logout()
	{	
		session_destroy();
		$this->session->sess_destroy();

		return redirect(base_url('auth'));
	}
}
