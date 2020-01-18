<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class transport extends CI_Controller {
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
				"nama_transportasi" => $this->input->post("nama_transportasi"),
				);
				$this->form_validation->set_rules("nama_transportasi", "nama_transportasi", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("transport", $arrayPost);
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
					"tampilData" => $this->crud_function_model->readData("transport", "", "", "id_transport desc"),
					"idDb" => "id_transport"
				);
				$this->load->view("admin/content/transport/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("transport", "id_transport = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("transport", "", "id_transport = $_GET[id]", "id_transport desc"),
					"idDb" => "id_transport"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>nama_transportasi</td>
							<td>"; echo $item["nama_transportasi"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("transport", "", "id_transport = $_GET[id]", "id_transport desc"),
					"idDb" => "id_transport"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_transport"]; echo "' hidden>
						
							<td>nama_transportasi</td>
							<td>
							
									<input type='text' name='nama_transportasi' class='form-control' style='width:100%;' value='"; echo $item["nama_transportasi"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"nama_transportasi" => $this->input->post("nama_transportasi"),
				);
				$this->form_validation->set_rules("nama_transportasi", "nama_transportasi", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("transport", $arrayPost, "id_transport = '$id'");
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
					"tampilData" => $this->crud_function_model->readData("transport", "", "id_transport like '%$_GET[id]%'  || nama_transportasi like '%$_GET[id]%' ", "id_transport desc"),
					"idDb" => "id_transport"
				);
				$this->load->view("admin/content/transport/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			