<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_data_soal_usba extends CI_Controller {

	public function __construct(){
		
		parent:: __construct();
		$this->output->set_header( "Access-Control-Allow-Origin: *" );
		$this->output->set_header( "Access-Control-Allow-Credentials: true" );
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( "Access-Control-Max-Age: 604800" );
		$this->output->set_header( "Access-Control-Request-Headers: x-requested-with" );
		$this->output->set_header( "Access-Control-Allow-Headers: x-requested-with, x-requested-by" );
		
		$this->load->database();
		// ini untuk crud automatic
		$this->load->model("crud_function_model");
		// ini untuk crud manually
		$this->load->model("Function_model_manually");
		$response = array();
		
	}
	public function index(){
	}
	public function dataujian(){
		$response = array();
		
		$query = $this->Function_model_manually->readDataManuallyController("
		
		SELECT
		  a.id_ujian,
		  a.`nama_ujian` AS ujian,
		  a.`token`,
		  b.`nama_kelas` AS kelas,
		  c.`nama_materi` AS materi
		FROM
		  `ujian` AS a
		  JOIN `kelas` AS b
		  JOIN `materi` AS c
			ON a.`kelas_id` = b.`id_kelas` && a.`materi_id` = c.`id_materi` ORDER BY a.id_ujian DESC
		
		");
		foreach($query as $item){
			$ujian["id_ujian"] = $item["id_ujian"];
			$ujian["ujian"] = $item["ujian"];
			$ujian["token"] = $item["token"];
			$ujian["kelas"] = $item["kelas"];
			$ujian["materi"] = $item["materi"];
			array_push($response, $item);
		}
		echo json_encode($response);
	}
	public function datasoal(){
		$response = array();
		$id_ujian = $this->input->post("id_ujian");
		
		$query = $this->Function_model_manually->readDataManuallyController("
		
		SELECT
		  a.`id_soal`,
		  a.`soal`,
		  b.`deskripsi_a` AS a,
		  c.`deskripsi_b` AS b,
		  d.`deskripsi_c` AS c,
		  e.`deskripsi_d` AS d,
		  f.`deskripsi_e` AS e,
		  a.`jawaban_soal` AS jawaban
		FROM
		  soal AS a
			LEFT JOIN pilihan_a AS b
			 	ON a.`id_soal` = b.`soal_id`
			LEFT JOIN pilihan_b AS c
			  	ON a.`id_soal` = c.`soal_id`
			LEFT JOIN pilihan_c AS d
			 	ON a.`id_soal` = d.`soal_id`
			LEFT JOIN pilihan_d AS e
			  	ON a.`id_soal` = e.`soal_id`
			LEFT JOIN pilihan_e AS f
			 	ON a.`id_soal` = f.`soal_id`
		WHERE a.`ujian_id` = '$id_ujian'
			ORDER BY id_soal DESC
		
		");
		foreach($query as $item){
			$ujian["id_soal"] = $item["id_soal"];
			$ujian["soal"] = $item["soal"];
			$ujian["b"] = $item["b"];
			$ujian["c"] = $item["c"];
			$ujian["d"] = $item["d"];
			$ujian["e"] = $item["e"];
			$ujian["jawaban"] = $item["jawaban"];
			array_push($response, $item);
		}
		echo json_encode($response);
	}
	public function inputDataSoal(){
		if(empty($this->input->post("id_ujian")) || empty($this->input->post("soal")) || empty($this->input->post("jawabanA")) || empty($this->input->post("jawabanB")) || empty($this->input->post("jawabanC")) || empty($this->input->post("jawabanD")) || empty($this->input->post("jawabanE")) || empty($this->input->post("jawabanBenar"))){

		} else {
			$response = array();
			
			//input soal
			$arraySoal = array(
					"soal" => $this->input->post("soal"),
					"ujian_id" => $this->input->post("id_ujian"),
					"jawaban_soal" => $this->input->post("jawabanBenar")
				);
			
			
			//$chech = $this->crud_function_model->login("soal", $arraySoal);
			//if ($chech == 0) {
				// input soal ke tbl soal
				$this->crud_function_model->insertData("soal", $arraySoal);

				$result = $this->crud_function_model->readData("soal", "id_soal", $arraySoal, "id_soal desc");
				foreach ($result as $item) {
					$arrayA = array(
							"deskripsi_a" => $this->input->post("jawabanA"),
							"soal_id" => $item["id_soal"]
						);
					$this->crud_function_model->insertData("pilihan_a", $arrayA);
					$arrayB = array(
							"deskripsi_b" => $this->input->post("jawabanB"),
							"soal_id" => $item["id_soal"]
						);
					$this->crud_function_model->insertData("pilihan_b", $arrayB);
					$arrayC = array(
							"deskripsi_c" => $this->input->post("jawabanC"),
							"soal_id" => $item["id_soal"]
						);
					$this->crud_function_model->insertData("pilihan_c", $arrayC);
					$arrayD = array(
							"deskripsi_d" => $this->input->post("jawabanD"),
							"soal_id" => $item["id_soal"]
						);
					$this->crud_function_model->insertData("pilihan_d", $arrayD);
					$arrayE = array(
							"deskripsi_e" => $this->input->post("jawabanE"),
							"soal_id" => $item["id_soal"]
						);
					$this->crud_function_model->insertData("pilihan_e", $arrayE);
				}
				$soal["status"] = "1";
			//} else {
			//	$soal["status"] = "0";
			//}

			array_push($response, $soal);
			echo json_encode($response);
		}
		
	}
	public function deleteSoal(){
		if (!empty($this->input->post("id_soal"))) {
			$response = array();
			$arraySoalId = array(
					"id_soal" => $this->input->post("id_soal")
				);
			$arrayPilihan = array(
					"soal_id" => $this->input->post("id_soal")
				);
			$this->crud_function_model->deleteData("soal", $arraySoalId);
			$this->crud_function_model->deleteData("pilihan_a", $arrayPilihan);
			$this->crud_function_model->deleteData("pilihan_b", $arrayPilihan);
			$this->crud_function_model->deleteData("pilihan_c", $arrayPilihan);
			$this->crud_function_model->deleteData("pilihan_d", $arrayPilihan);
			$this->crud_function_model->deleteData("pilihan_e", $arrayPilihan);
			$soal["status"] = "1";
			array_push($response, $soal);
			echo json_encode($response);
		} else {

		}
		
	}
}