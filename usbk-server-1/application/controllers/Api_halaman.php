<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_halaman extends CI_Controller {

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
		$response = array();


		$query1 = $this->Function_model_manually->readDataManuallyController("
			SELECT
			  *
			FROM
			  `kelas` AS a
			  JOIN `ujian` AS b
			    ON a.`id_kelas` = b.`kelas_id`
			 
			");
		foreach ($query1 as $ujian) {
			$persentase["nama_ujian"] = $ujian["nama_ujian"];
			$persentase["kelas"] = $ujian["nama_kelas"];

			$query2 = $this->Function_model_manually->readDataManuallyController("

				SELECT
				  COUNT(*) AS jumlah_jawab,
				  c.`jumlah_ujian` AS jumlah_soal_ujian,
				  FLOOR(
				    SUM((b.`jawaban_soal` = a.`jawaban`) = 1) * (100 / c.`jumlah_ujian`)
				  ) AS nilai
				FROM
				  `jawaban_siswa` AS a
				  JOIN `soal` AS b
				  JOIN `ujian` AS c
				    ON a.`no_soal` = b.`id_soal`
				    AND a.`token` = c.`token`
				    AND b.`ujian_id` = c.`id_ujian`
				WHERE c.`id_ujian` = '$ujian[id_ujian]'

				");
			foreach($query2 as $item){
				$persentase["nilai"] = $item["nilai"];
			}
			
			array_push($response, $persentase);
		}
		echo json_encode($response);

	}
}