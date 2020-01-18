<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_lihat_soal_client_usba extends CI_Controller {

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

		$nisnPost = $this->input->post("nisn");
		$nikPost = $this->input->post("nik");
		$token = $this->input->post("token");
		
		$query = $this->Function_model_manually->readDataManuallyController("
		
				SELECT
				  a.`id_soal`,
				  a.`soal`,
				  a.`jawaban_soal`,
				  b.`deskripsi_a`,
				  c.`deskripsi_b`,
				  d.`deskripsi_c`,
				  e.`deskripsi_d`,
				  f.`deskripsi_e`
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
				  JOIN ujian AS g
				    ON a.`ujian_id` = g.`id_ujian`
				    AND g.`token` = $token
				  LEFT JOIN jawaban_siswa AS h
				    ON a.`id_soal` = h.`no_soal`
				    AND h.`nisn` = $nisnPost
				    AND h.`nik` = $nikPost

				WHERE h.`nisn` IS NULL
				GROUP BY a.`soal`
				ORDER BY RAND()
				LIMIT 1

		");
		foreach($query as $item){
			$soal["no_soal"] = $item["id_soal"];
			$soal["soal"] =  $item["soal"];
			$soal["a"] = $item["deskripsi_a"];
			$soal["b"] = $item["deskripsi_b"];
			$soal["c"] = $item["deskripsi_c"];
			$soal["d"] = $item["deskripsi_d"];
			$soal["e"] = $item["deskripsi_e"];
			
			$jumlahDiJawab = $this->Function_model_manually->readDataManuallyController("
				SELECT
				  COUNT(*) as jumlah_jawab
				FROM
				  jawaban_siswa AS a
				WHERE a.`nisn` = $nisnPost
				  AND a.`nik` = $nikPost
				  AND a.`token` = $token
				");
			foreach ($jumlahDiJawab as $key) {
				$soal["jumlah_jawab"] = $key["jumlah_jawab"] + 1;
			}
			array_push($response, $soal);
		}
		$queryNilai = $this->Function_model_manually->readDataManuallyController("
			
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
					ON a.`no_soal` = b.`id_soal` && a.`token` = c.`token` && b.`ujian_id` = c.`id_ujian`
				WHERE a.`nisn` = '$nisnPost' && a.`nik` = '$nikPost' && a.`token` = '$token'
			
			");
		foreach($queryNilai as $nilaiSiswa){
			$soal["jumlah_soal_ujian"] = $nilaiSiswa["jumlah_soal_ujian"];
			$soal["jumlah_jawab"] = $nilaiSiswa["jumlah_jawab"] + 1;
			$soal["nilai"] = $nilaiSiswa["nilai"];
			if($nilaiSiswa["jumlah_jawab"] == null || empty($nilaiSiswa["jumlah_jawab"]) || $nilaiSiswa["jumlah_jawab"] == ""){
				$soal["status_nilai"] = "0";
			} else {
				if($nilaiSiswa["jumlah_soal_ujian"] == $nilaiSiswa["jumlah_jawab"] || $nilaiSiswa["jumlah_soal_ujian"] <= $nilaiSiswa["jumlah_jawab"]){
					$soal["status_nilai"] = "1";
				} else {
					$soal["status_nilai"] = "0";
				}
			}
				
			array_push($response, $soal);	
		}
		echo json_encode($response);
	}
	public function dataUjianGabungan(){
		if (empty($this->input->post("token"))) {
			# code...
		} else {
			$response = array();
		
			$postToken = $this->input->post("token");
			$query = $this->Function_model_manually->readDataManuallyController("
			
				SELECT
				  a.`nama_ujian` AS nama_ujian,
				  b.`nama_kelas` AS kelas,
				  c.`nama_materi` AS materi,
				  d.`nama_guru` AS guru
				FROM
				  ujian AS a
				  JOIN kelas AS b
				  JOIN materi AS c
				  JOIN guru AS d
				    ON a.kelas_id = b.id_kelas
				    AND a.materi_id = c.id_materi
				    AND a.`guru_id` = d.`id_guru`
				WHERE a.token = $postToken
			
			");
			foreach($query as $item){
				
					$data["nama_ujian"] = $item["nama_ujian"];
					$data["kelas"] = $item["kelas"];
					$data["materi"] = $item["materi"];
					$data["guru"] = $item["guru"];
					array_push($response, $data);
			}
			echo json_encode($response);
		}
		
	}
}