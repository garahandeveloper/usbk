<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jawab_soal extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
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
			if($_GET["act"] == "load"){
				$idSoalRead = array(
					"token_id" => $_SESSION["tokenSession"]
				);
				$queryDataRead = array(
					"tampilData" => $this->Function_model_manually->readDataJawabSoal(),
					"idDb" => "id_soal"
				);
				$this->load->view("admin/content/jawab_soal/table", $queryDataRead);
			} // end load
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("soal", "", "id_soal = $_GET[id]", ""),
					"idDb" => "id_jawab_soal"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					$arrayId = array(
						"no" => $item["id_soal"]
					);
					$queryCekJawaban = array(
						"cekJawaban" => $this->crud_function_model->readData("jawaban_soal_siswa", "", "no = '$item[id_soal]' && token = $item[token_id] && NISN = $_SESSION[username]", "")
					);
					foreach($queryCekJawaban["cekJawaban"] as $cekJawabanSiswa);
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_soal"]; echo "' hidden >
							<input type='hidden' name='NISN' class='form-control' style='width:100%;' value='"; echo $_SESSION['username']; echo "' hidden>
							<input type='hidden' name='token_id' style='width:100%;' value='"; echo $item["token_id"]; echo "' hidden>
							<td>
								"; echo $item["pertanyaan"]; echo "
							</td>
						</tr>
							<td>
							";
							if(empty($cekJawabanSiswa["jawaban"])){
								$cek1 = "";
							}else {
								if($cekJawabanSiswa["jawaban"] == "a"){
									$cek1 = "checked";
								}else {
									$cek1 = "";
								}
							}
							echo "
								<input $cek1 type='radio' name='jawaban' value='a' > "; echo $item["a"];  echo "
							</td>
						</tr>
							<td>
							";
							if(empty($cekJawabanSiswa["jawaban"])){
								$cek2 = "";
							}else {
								if($cekJawabanSiswa["jawaban"] == "b"){
									$cek2 = "checked";
								}else {
									$cek2 = "";
								}
							}
							echo "
								<input $cek2 type='radio' name='jawaban' value='b' > "; echo $item["b"]; echo "
							</td>
						</tr>
							<td>
							";
							if(empty($cekJawabanSiswa["jawaban"])){
								$cek3 = "";
							}else {
								if($cekJawabanSiswa["jawaban"] == "c"){
									$cek3 = "checked";
								}else {
									$cek3 = "";
								}
							}
							echo "
								<input $cek3 type='radio' name='jawaban' value='c' > "; echo $item["c"]; echo "
							</td>
						</tr>
							<td>
							";
							if(empty($cekJawabanSiswa["jawaban"])){
								$cek4 = "";
							}else {
								if($cekJawabanSiswa["jawaban"] == "d"){
									$cek4 = "checked";
								}else {
									$cek4 = "";
								}
							}
							echo "
								<input $cek4 type='radio' name='jawaban' value='d' > "; echo $item["d"]; echo "
							</td>
						</tr>
							<td>
							";
							if(empty($cekJawabanSiswa["jawaban"])){
								$cek5 = "";
							}else {
								if($cekJawabanSiswa["jawaban"] == "e"){
									$cek5 = "checked";
								}else {
									$cek5 = "";
								}
							}
							echo "
								<input $cek5 type='radio' name='jawaban' value='e' > "; echo $item["e"]; echo "
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "insertDataJawabanSiswa"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
					"NISN" => $this->input->post("NISN"),
					"no" => $this->input->post("id"),
					"token" => $this->input->post("token_id"),
					"jawaban" => $this->input->post("jawaban")
				);
				$arrayPost22 = array(
					"NISN" => $this->input->post("NISN"),
					"no" => $this->input->post("id"),
					"token" => $this->input->post("token_id")
				);
				$this->form_validation->set_rules("NISN", "NISN", "required");
				$this->form_validation->set_rules("id", "id", "required");
				$this->form_validation->set_rules("token_id", "token_id", "required");
				$this->form_validation->set_rules("jawaban", "jawaban", "required");
				
				if($this->form_validation->run() == true){
					//$cekRows = $this->crud_function_model->readData("jawaban_soal_siswa", "", $arrayPost, "");
					$cekRows = $this->crud_function_model->login("jawaban_soal_siswa", $arrayPost22);
					if($cekRows == 1 || $cekRows > 0){
						$this->crud_function_model->updateData("jawaban_soal_siswa", $arrayPost, $arrayPost22);
						$message =  array(
							"message" => "Jawaban Berhasil Di Ubah"
						);
					} else {
						$this->crud_function_model->insertData("jawaban_soal_siswa", $arrayPost, "");
						$message =  array(
							"message" => "Jawaban Berhasil Di Simpan"
						);
					}
					
				} else {
					$message =  array(
					"message" => validation_errors()
					);
				}
				$this->load->view("admin/valids/validationmessage", $message);
			
			}// end update 
		}// end else // pertama
	}
}
			