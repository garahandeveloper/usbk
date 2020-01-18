<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
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
				"username" => $this->input->post("username"),"password" => $this->input->post("password"),"status" => $this->input->post("status"),
				);
				$this->form_validation->set_rules("username", "username", "required");$this->form_validation->set_rules("password", "password", "required");$this->form_validation->set_rules("status", "status", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("user", $arrayPost);
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
					"tampilData" => $this->crud_function_model->readData("user", "", "", "id_user desc"),
					"idDb" => "id_user"
				);
				$this->load->view("admin/content/user/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "delete"){
				$this->crud_function_model->deleteData("user", "id_user = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("user", "", "id_user = $_GET[id]", "id_user desc"),
					"idDb" => "id_user"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>username</td>
							<td>"; echo $item["username"]; echo "</td>
						</tr>
						
						<tr>
							<td>password</td>
							<td>"; echo $item["password"]; echo "</td>
						</tr>
						
						<tr>
							<td>status</td>
							<td>";
							
							if($item["status"] == "1"){
								echo "Administrator";
							} else {
								echo "Admin";
							}
							echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("user", "", "id_user = $_GET[id]", "id_user desc"),
					"idDb" => "id_user"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_user"]; echo "' hidden>
						
							<td>username</td>
							<td><input type='text' name='username' class='form-control' style='width:100%;' value='"; echo $item["username"]; echo "' ></td>
						</tr>
						
							<td>password</td>
							<td><input type='text' name='password' class='form-control' style='width:100%;' value='"; echo $item["password"]; echo "' ></td>
						</tr>
						
							<td>status</td>
							<td>
								<select class='form-control' name='status' id='status'>
									<option value=''>Status</option>
									<option value='1'>Administrator</option>
									<option value='2'>Admin</option>
								</select>
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				$arrayPost = array(
				"username" => $this->input->post("username"),
				"password" => $this->input->post("password"),
				"status" => $this->input->post("status"),
				
				);
				$id = $this->input->post("id");
				
				$this->form_validation->set_rules("username", "username", "required");
				
				$this->form_validation->set_rules("password", "password", "required");
				
				$this->form_validation->set_rules("status", "status", "required");
				
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("user", $arrayPost, "id_user = '$id'");
					$message =  array(
						"message" => "Data Berhasil Di Ubah"
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
					"tampilData" => $this->crud_function_model->readData("user", "", "id_user like '%$_GET[id]%'  || username like '%$_GET[id]%' || password like '%$_GET[id]%' || status like '%$_GET[id]%' ", "id_user desc"),
					"idDb" => "id_user"
				);
				$this->load->view("admin/content/user/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			