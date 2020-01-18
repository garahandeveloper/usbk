<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class data_sekolah extends CI_Controller {
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
				"nama_sekolah" => $this->input->post("nama_sekolah"),"NSS" => $this->input->post("NSS"),"alamat_sekolah" => $this->input->post("alamat_sekolah"),
				);
				$this->form_validation->set_rules("nama_sekolah", "nama_sekolah", "required");$this->form_validation->set_rules("NSS", "NSS", "required");$this->form_validation->set_rules("alamat_sekolah", "alamat_sekolah", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("data_sekolah", $arrayPost);
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
					"tampilData" => $this->crud_function_model->readData("data_sekolah", "", "", "id_data_sekolah desc"),
					"idDb" => "id_data_sekolah"
				);
				$this->load->view("admin/content/data_sekolah/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("data_sekolah", "id_data_sekolah = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_sekolah", "", "id_data_sekolah = $_GET[id]", "id_data_sekolah desc"),
					"idDb" => "id_data_sekolah"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>nama_sekolah</td>
							<td>"; echo $item["nama_sekolah"]; echo "</td>
						</tr>
						
						<tr>
							<td>NSS</td>
							<td>"; echo $item["NSS"]; echo "</td>
						</tr>
						
						<tr>
							<td>alamat_sekolah</td>
							<td>"; echo $item["alamat_sekolah"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("data_sekolah", "", "id_data_sekolah = $_GET[id]", "id_data_sekolah desc"),
					"idDb" => "id_data_sekolah"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_data_sekolah"]; echo "' hidden>
						
							<td>nama_sekolah</td>
							<td>
							
									<input type='text' name='nama_sekolah' class='form-control' style='width:100%;' value='"; echo $item["nama_sekolah"]; echo "' >
								
							</td>
						</tr>
						
							<td>NSS</td>
							<td>
							
									<input type='text' name='NSS' class='form-control' style='width:100%;' value='"; echo $item["NSS"]; echo "' >
								
							</td>
						</tr>
						
							<td>alamat_sekolah</td>
							<td>
							
									<input type='text' name='alamat_sekolah' class='form-control' style='width:100%;' value='"; echo $item["alamat_sekolah"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"nama_sekolah" => $this->input->post("nama_sekolah"),"NSS" => $this->input->post("NSS"),"alamat_sekolah" => $this->input->post("alamat_sekolah"),
				);
				$this->form_validation->set_rules("nama_sekolah", "nama_sekolah", "required");$this->form_validation->set_rules("NSS", "NSS", "required");$this->form_validation->set_rules("alamat_sekolah", "alamat_sekolah", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("data_sekolah", $arrayPost, "id_data_sekolah = '$id'");
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
					"tampilData" => $this->crud_function_model->readData("data_sekolah", "", "id_data_sekolah like '%$_GET[id]%'  || nama_sekolah like '%$_GET[id]%' || NSS like '%$_GET[id]%' || alamat_sekolah like '%$_GET[id]%' ", "id_data_sekolah desc"),
					"idDb" => "id_data_sekolah"
				);
				$this->load->view("admin/content/data_sekolah/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			