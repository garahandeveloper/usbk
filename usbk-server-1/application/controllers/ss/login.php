<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model("crud_function_model");
	}
	public function index(){
		$this->load->view('admin/content/login/login');
	}
	public function logout(){
		unset($_SESSION['username'], $_SESSION['id_session_on']);
		redirect('login');
	}
}
