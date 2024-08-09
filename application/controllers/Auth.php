<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function index()
	{
		if (is_login()) {
			redirect('Dashboard');
		}
		$data['title'] = 'Login';
		$this->template->views('auths/login', $data, true);
	}

	public function setSessions()
	{
		$id = $this->input->post('id');
		$username = $this->input->post('username');
		$name = $this->input->post('name');
		$roles = $this->input->post('roles');
		$permission = $roles['permissions'];
		$this->session->set_userdata('logged_in_tobacco', true);
		$this->session->set_userdata('name', $name);
		$this->session->set_userdata('id', $id);
		$this->session->set_userdata('username', $username);
		$this->session->set_userdata('position_name', $roles['name']);
		$this->session->set_userdata('position_detail_name', $roles['login_data']['name']);
		$this->session->set_userdata('warehouse_id', $roles['login_data']['warehouse_id']);
		$this->session->set_userdata('permission', $permission);
		$response['success'] = true;
		echo json_encode($response);
	}

	public function Logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('status_login', 'Anda sudah berhasil keluar dari aplikasi');
		redirect('Auth', 'refresh');
	}
}
