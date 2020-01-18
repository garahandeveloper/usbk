<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jumlah_soal_ujian extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model("crud_function_model");
		if(empty($_SESSION['username'])){
			redirect('login');
		} else {	
		}
	}
	public function index(){
	}
	public function load(){
		if(empty($_GET["act"])){
							
		} else {
			if($_GET["act"] == "insert"){
			
				$arrayPost = array(
				"token" => $this->input->post("token"),"jumlah" => $this->input->post("jumlah"),
				);
				$this->form_validation->set_rules("token", "token", "required");$this->form_validation->set_rules("jumlah", "jumlah", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("jumlah_soal_ujian", $arrayPost);
					$message =  array(
					"message" => "Data Berhasil Di Simpan"
					);
				} else {
					$message =  array(
					"message" => validation_errors()
					);
				}
				$this->load->view("admin/valids/validationmessage", $message);
			
			} // end insert
			
			else if($_GET["act"] == "load"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("jumlah_soal_ujian", "", "", "id_jumlah_soal_ujian desc"),
					"idDb" => "id_jumlah_soal_ujian"
				);
				$this->load->view("admin/content/jumlah_soal_ujian/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "loadToken"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("ujian", "", "", "id_ujian desc"),
					"idDb" => "id_jumlah_soal_ujian"
				);
				
				echo "<select name='token' class='form-control'>";
				echo "<option value=''>Pilih Nama Ujian</option>";
				foreach($queryDataRead["tampilData"] as $item){
					echo "<option value='$item[token]'>$item[nama_ujian]</option>";
				}	
				echo "</select>";
			} // end loadToken
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("jumlah_soal_ujian", "id_jumlah_soal_ujian = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("jumlah_soal_ujian", "", "id_jumlah_soal_ujian = $_GET[id]", "id_jumlah_soal_ujian desc"),
					"idDb" => "id_jumlah_soal_ujian"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>token</td>
							<td>"; echo $item["token"]; echo "</td>
						</tr>
						
						<tr>
							<td>jumlah</td>
							<td>"; echo $item["jumlah"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("jumlah_soal_ujian", "", "id_jumlah_soal_ujian = $_GET[id]", "id_jumlah_soal_ujian desc"),
					"idDb" => "id_jumlah_soal_ujian"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_jumlah_soal_ujian"]; echo "' hidden>
						
							<td>token</td>
							<td>
							
									<input type='text' name='token' class='form-control' style='width:100%;' value='"; echo $item["token"]; echo "' >
								
							</td>
						</tr>
						
							<td>jumlah</td>
							<td>
							
									<input type='text' name='jumlah' class='form-control' style='width:100%;' value='"; echo $item["jumlah"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"token" => $this->input->post("token"),"jumlah" => $this->input->post("jumlah"),
				);
				$this->form_validation->set_rules("token", "token", "required");$this->form_validation->set_rules("jumlah", "jumlah", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("jumlah_soal_ujian", $arrayPost, "id_jumlah_soal_ujian = '$id'");
					$message =  array(
					"message" => "Data Berhasil Di Simpan"
					);
				} else {
					$message =  array(
					"message" => validation_errors()
					);
				}
				$this->load->view("admin/valids/validationmessage", $message);
			
			}// end update 
			else if($_GET["act"] == "search"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("jumlah_soal_ujian", "", "id_jumlah_soal_ujian like '%$_GET[id]%'  || token like '%$_GET[id]%' || jumlah like '%$_GET[id]%' ", "id_jumlah_soal_ujian desc"),
					"idDb" => "id_jumlah_soal_ujian"
				);
				$this->load->view("admin/content/jumlah_soal_ujian/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			