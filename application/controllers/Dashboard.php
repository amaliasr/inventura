<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!is_login()) {
			redirect('Auth');
		}
		$this->user_id = $this->session->userdata('id');
		$this->username = $this->session->userdata('username');
		$this->position_name = $this->session->userdata('position_name');
		$this->position_detail_name = $this->session->userdata('position_detail_name');
		$this->permission = $this->session->userdata('permission');
		$this->warehouse_id = $this->session->userdata('warehouse_id');
	}
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['position_detail_name'] = $this->position_detail_name;
		$data['permission'] = $this->permission;
		$data['username'] = $this->username;
		$this->template->views('index', $data);
	}
}
