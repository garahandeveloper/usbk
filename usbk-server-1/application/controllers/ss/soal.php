<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class soal extends CI_Controller {
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
				"pertanyaan" => $this->input->post("pertanyaan"),
				"a" => $this->input->post("a"),"b" => $this->input->post("b"),
				"c" => $this->input->post("c"),"d" => $this->input->post("d"),
				"e" => $this->input->post("e"),
				"jawaban" => $this->input->post("jawaban"),
				"token_id" => $this->input->post("token_id"),
				);
				$this->form_validation->set_rules("pertanyaan", "pertanyaan", "required");$this->form_validation->set_rules("a", "a", "required");$this->form_validation->set_rules("b", "b", "required");$this->form_validation->set_rules("c", "c", "required");$this->form_validation->set_rules("d", "d", "required");$this->form_validation->set_rules("e", "e", "required");$this->form_validation->set_rules("jawaban", "jawaban", "required");$this->form_validation->set_rules("token_id", "token_id", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("soal", $arrayPost);
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
					"tampilData" => $this->crud_function_model->readData("soal", "", "token_id = $_GET[token]", "id_soal asc"),
					"idDb" => "id_soal"
				);
				$this->load->view("admin/content/soal/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("soal", "id_soal = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("soal", "", "id_soal = $_GET[id]", "id_soal desc"),
					"idDb" => "id_soal"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>pertanyaan</td>
							<td>"; echo $item["pertanyaan"]; echo "</td>
						</tr>
						
						<tr>
							<td>a</td>
							<td>"; echo $item["a"]; echo "</td>
						</tr>
						
						<tr>
							<td>b</td>
							<td>"; echo $item["b"]; echo "</td>
						</tr>
						
						<tr>
							<td>c</td>
							<td>"; echo $item["c"]; echo "</td>
						</tr>
						
						<tr>
							<td>d</td>
							<td>"; echo $item["d"]; echo "</td>
						</tr>
						
						<tr>
							<td>e</td>
							<td>"; echo $item["e"]; echo "</td>
						</tr>
						
						<tr>
							<td>jawaban</td>
							<td>"; echo $item["jawaban"]; echo "</td>
						</tr>
						
						<tr>
							<td>token_id</td>
							<td>"; echo $item["token_id"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("soal", "", "id_soal = $_GET[id]", "id_soal desc"),
					"idDb" => "id_soal"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_soal"]; echo "' hidden>
						
							<td>pertanyaan</td>
							<td>
							
									<input type='text' name='pertanyaan' class='form-control' style='width:100%;' value='"; echo $item["pertanyaan"]; echo "' >
								
							</td>
						</tr>
						
							<td>a</td>
							<td>
							
									<input type='text' name='a' class='form-control' style='width:100%;' value='"; echo $item["a"]; echo "' >
								
							</td>
						</tr>
						
							<td>b</td>
							<td>
							
									<input type='text' name='b' class='form-control' style='width:100%;' value='"; echo $item["b"]; echo "' >
								
							</td>
						</tr>
						
							<td>c</td>
							<td>
							
									<input type='text' name='c' class='form-control' style='width:100%;' value='"; echo $item["c"]; echo "' >
								
							</td>
						</tr>
						
							<td>d</td>
							<td>
							
									<input type='text' name='d' class='form-control' style='width:100%;' value='"; echo $item["d"]; echo "' >
								
							</td>
						</tr>
						
							<td>e</td>
							<td>
							
									<input type='text' name='e' class='form-control' style='width:100%;' value='"; echo $item["e"]; echo "' >
								
							</td>
						</tr>
						
							<td>jawaban</td>
							<td>
							
									<input type='text' name='jawaban' class='form-control' style='width:100%;' value='"; echo $item["jawaban"]; echo "' >
								
							</td>
						</tr>
						
							<td>token_id</td>
							<td>
							
									<input type='text' name='token_id' class='form-control' style='width:100%;' value='"; echo $item["token_id"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"pertanyaan" => $this->input->post("pertanyaan"),"a" => $this->input->post("a"),"b" => $this->input->post("b"),"c" => $this->input->post("c"),"d" => $this->input->post("d"),"e" => $this->input->post("e"),"jawaban" => $this->input->post("jawaban"),"token_id" => $this->input->post("token_id"),
				);
				$this->form_validation->set_rules("pertanyaan", "pertanyaan", "required");$this->form_validation->set_rules("a", "a", "required");$this->form_validation->set_rules("b", "b", "required");$this->form_validation->set_rules("c", "c", "required");$this->form_validation->set_rules("d", "d", "required");$this->form_validation->set_rules("e", "e", "required");$this->form_validation->set_rules("jawaban", "jawaban", "required");$this->form_validation->set_rules("token_id", "token_id", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("soal", $arrayPost, "id_soal = '$id'");
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
					"tampilData" => $this->crud_function_model->readData("soal", "", "id_soal like '%$_GET[id]%'  || pertanyaan like '%$_GET[id]%' || a like '%$_GET[id]%' || b like '%$_GET[id]%' || c like '%$_GET[id]%' || d like '%$_GET[id]%' || e like '%$_GET[id]%' || jawaban like '%$_GET[id]%' || token_id like '%$_GET[id]%' ", "id_soal desc"),
					"idDb" => "id_soal"
				);
				$this->load->view("admin/content/soal/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			