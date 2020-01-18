<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Valids extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model("crud_function_model");
	}
	public function index()
	{
		redirect('login/');
		//echo "<p>Directory access is forbidden.</p>";
	}
	public function siswa($pageName){
		if(empty($pageName)){
			echo "<p>Directory access is forbidden.</p>";
		}
	}
	public function login_validation(){
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if($this->form_validation->run() == true){
				$data = array(
					"username" => $this->input->post('username'),
					"password" => $this->input->post('password')
				 );
				$query1 = $this->crud_function_model->login("user", $data);
				if($query1 == 1 || $query1 > 0){
					$query2 = array(
					"tampilData" => $this->crud_function_model->readData("user", "", $data, "")
					);
					foreach($query2["tampilData"] as $item);
						
					// set session
					$newdata = array(
						'username'  => $item['username'],
						'id_session_on'     => rand(0000, 9999),
						'status' => "admin",
						'logged_in' => TRUE
					);
					$this->session->set_userdata($newdata);
					//untuk manggil session  $_SESSION['username'].'--'.$_SESSION['id_session_on']
					$message =  array(
						"message" => ""
					);
					 //redirect('/login/form/');
					$this->load->view('admin/valids/login_success', $query2);
					
				} else {
					// ini untuk mengecek di data_siswa apa ada apa tidak
					$data2 = array(
						"NISN" => $this->input->post('username'),
						"NIK" => $this->input->post('password')
					 );
					$cekDataSiswa = $this->crud_function_model->login("data_siswa", $data2);
					if($cekDataSiswa == 1 || $cekDataSiswa > 0){
						$queryDataSiswaRead = array(
								"tampilData" =>$this->crud_function_model->readData("data_siswa", "", $data2, "")
							);
						foreach($queryDataSiswaRead["tampilData"] as $item2);
						$newdata2 = array(
							'username'  => $item2['NISN'],
							'id_session_on'     => rand(0000, 9999),
							'status' => "siswa",
							'logged_in' => TRUE
						);
						$this->session->set_userdata($newdata2);
						$message =  array(
							"message" => ""
						);
						
						$this->load->view('admin/valids/token_sukses', $queryDataSiswaRead);
					} else {
						$message =  array(
							"message" => "Username Atau Password Salah"
						);
						$this->load->view('admin/valids/validationmessage', $message);
					}
					
				}		
			} else {
				$message =  array(
					"message" => validation_errors()
				);
				$this->load->view('admin/valids/validationmessage', $message);
			}
		}
		public function token(){
			$data22 = array(
				"token" => $this->input->post("token")
			);
			$tokenCek = $this->crud_function_model->login("ujian", $data22);
			if($tokenCek == 1 || $tokenCek > 0){
				$tokenSave = array(
					"tokenSession" => $this->crud_function_model->readData("ujian", "", $data22, "")
				);
				foreach($tokenSave["tokenSession"] as $itemToken);
				$dataSession = array(
					"tokenSession" => $itemToken['token'],
					'logged_in' => TRUE
				);
				$this->session->set_userdata($dataSession);
				redirect("dashboard");
			} else {
				redirect("login");
			}
			
		}
}
