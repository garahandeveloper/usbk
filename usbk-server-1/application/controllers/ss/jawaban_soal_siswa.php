<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jawaban_soal_siswa extends CI_Controller {
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
			if($_GET["act"] == "insert"){
			
				$arrayPost = array(
				"NISN" => $this->input->post("NISN"),"no" => $this->input->post("no"),
				"token" => $this->input->post("token"),
				"jawaban" => $this->input->post("jawaban"),
				);
				$this->form_validation->set_rules("NISN", "NISN", "required");$this->form_validation->set_rules("no", "no", "required");$this->form_validation->set_rules("token", "token", "required");$this->form_validation->set_rules("jawaban", "jawaban", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->insertData("jawaban_soal_siswa", $arrayPost);
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
				$queryUjian = array(
					"tampilUjian" =>  $this->crud_function_model->readData("ujian", "", "", "id_ujian desc")
				);
				foreach($queryUjian["tampilUjian"] as $ujian){
					$TOKEN = $ujian["token"];
					echo "
						<div class='panel panel-default'>
							<div class='panel-heading'>Nama Ujian : ".$ujian["nama_ujian"]." Dan Token : $TOKEN</div>
							<div class='panel-body'>
						
					";
					// membaca data siswa
					$queryDataRead = array(
						"tampilData" => $this->Function_model_manually->readDataManuallyController("
						select * from data_siswa
						"),
						"idDb" => "id_jawaban_soal_siswa"
					);
					foreach($queryDataRead["tampilData"] as $item){
						$DATA_SISWA = $item["NISN"];
						echo "$item[nama_lengkap]";
						// membaca jawaban siswa
						$queryDataReadJawaban = array(
							"tampilData" => $this->Function_model_manually->readDataManuallyController("
							
							select distinct 
							a.*, b.*, b.jawaban as jwbn, a.jawaban as jawaban_soal
							from soal as a left join jawaban_soal_siswa as b 
							on a.id_soal = b.no && a.token_id = $TOKEN && b.NISN = $DATA_SISWA 
							where a.token_id = $TOKEN order by id_soal asc limit 50
							
							
							")
						);
						echo "<div class='well'>";
						$no = 0;
						foreach($queryDataReadJawaban["tampilData"] as $jwbnSiswa){
							$no++;
							if(!empty($jwbnSiswa["jawaban"])){
								echo "$no : $jwbnSiswa[jawaban], ";
							} else {
							}
							
						}	
						
						$queryNilaiAhir = array(
							"cetakNilai" => $this->Function_model_manually->readDataManuallyController("
								select sum((a.jawaban = b.jawaban) = 1) * 2 as nilaiAhirSiswa from jawaban_soal_siswa as a 
								join soal as b on a.token = $TOKEN && a.no = b.id_soal where a.NISN = $DATA_SISWA
							")
						);
						foreach($queryNilaiAhir["cetakNilai"] as $nilai);
							
						echo "<br /> NIlai : <span style='font-size:30px; color:red;'>".$nilai["nilaiAhirSiswa"]."</span>";
						echo "</div>";
						echo "<hr />";
					}
					echo "
							</div>
						</div>
					";
				}
				
				
			} // end load
			else if($_GET["act"] == "delete"){
				
				$this->crud_function_model->deleteData("jawaban_soal_siswa", "id_jawaban_soal_siswa = $_GET[id]");
			} // end delete	
			else if($_GET["act"] == "view"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("jawaban_soal_siswa", "", "id_jawaban_soal_siswa = $_GET[id]", "id_jawaban_soal_siswa desc"),
					"idDb" => "id_jawaban_soal_siswa"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
					
						<tr>
							<td>NISN</td>
							<td>"; echo $item["NISN"]; echo "</td>
						</tr>
						
						<tr>
							<td>no</td>
							<td>"; echo $item["no"]; echo "</td>
						</tr>
						
						<tr>
							<td>token</td>
							<td>"; echo $item["token"]; echo "</td>
						</tr>
						
						<tr>
							<td>jawaban</td>
							<td>"; echo $item["jawaban"]; echo "</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view
			else if($_GET["act"] == "viewEdit"){
				$queryDataRead = array(
					"tampilData" => $this->crud_function_model->readData("jawaban_soal_siswa", "", "id_jawaban_soal_siswa = $_GET[id]", "id_jawaban_soal_siswa desc"),
					"idDb" => "id_jawaban_soal_siswa"
				);	
				echo "<table class='table'>"; 
				foreach($queryDataRead["tampilData"] as $item){
					echo "
						<tr>
							<input type='hidden' name='id' class='form-control' style='width:100%;' value='"; echo $item["id_jawaban_soal_siswa"]; echo "' hidden>
						
							<td>NISN</td>
							<td>
							
									<input type='text' name='NISN' class='form-control' style='width:100%;' value='"; echo $item["NISN"]; echo "' >
								
							</td>
						</tr>
						
							<td>no</td>
							<td>
							
									<input type='text' name='no' class='form-control' style='width:100%;' value='"; echo $item["no"]; echo "' >
								
							</td>
						</tr>
						
							<td>token</td>
							<td>
							
									<input type='text' name='token' class='form-control' style='width:100%;' value='"; echo $item["token"]; echo "' >
								
							</td>
						</tr>
						
							<td>jawaban</td>
							<td>
							
									<input type='text' name='jawaban' class='form-control' style='width:100%;' value='"; echo $item["jawaban"]; echo "' >
								
							</td>
						</tr>
						
					"; 
				}
				echo "</table>";
			} // end view edit
			else if($_GET["act"] == "update"){
				
				$id = $this->input->post("id");
				$arrayPost = array(
				"NISN" => $this->input->post("NISN"),"no" => $this->input->post("no"),"token" => $this->input->post("token"),"jawaban" => $this->input->post("jawaban"),
				);
				$this->form_validation->set_rules("NISN", "NISN", "required");$this->form_validation->set_rules("no", "no", "required");$this->form_validation->set_rules("token", "token", "required");$this->form_validation->set_rules("jawaban", "jawaban", "required");
				if($this->form_validation->run() == true){
					$this->crud_function_model->updateData("jawaban_soal_siswa", $arrayPost, "id_jawaban_soal_siswa = '$id'");
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
					"tampilData" => $this->crud_function_model->readData("jawaban_soal_siswa", "", "id_jawaban_soal_siswa like '%$_GET[id]%'  || NISN like '%$_GET[id]%' || no like '%$_GET[id]%' || token like '%$_GET[id]%' || jawaban like '%$_GET[id]%' ", "id_jawaban_soal_siswa desc"),
					"idDb" => "id_jawaban_soal_siswa"
				);
				$this->load->view("admin/content/jawaban_soal_siswa/table", $queryDataRead);
			}// end search
		}// end else // pertama
	}
}
			