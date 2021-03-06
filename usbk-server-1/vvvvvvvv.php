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
		if (empty($this->input->post("nisn")) || empty($this->input->post("nik")) || empty($this->input->post("token"))) {
			# code...
		} else {
				/*
			klok ada eror yang kembalikan ke yang ini

			SELECT
			  *
			FROM
			  soal AS a
			  JOIN pilihan_a AS b
			  JOIN pilihan_b AS c
			  JOIN pilihan_c AS d
			  JOIN pilihan_d AS e
			  JOIN pilihan_e AS f
			  JOIN `ujian` AS g
			    ON a.`id_soal` = b.`soal_id`
			    AND a.`id_soal` = c.`soal_id`
			    AND a.`id_soal` = d.`soal_id`
			    AND a.`id_soal` = e.`soal_id`
			    AND a.`id_soal` = f.`soal_id`
			    AND a.`ujian_id` = g.`id_ujian`
			  LEFT JOIN `jawaban_siswa` AS h
			    ON a.`id_soal` = h.`no_soal` 
			WHERE g.`token` = '$token'
			ORDER BY RAND()
			LIMIT 1


			*/
			$response = array();

			$nisnPost = $this->input->post("nisn");
			$nikPost = $this->input->post("nik");
			$token = $this->input->post("token");
			//query load soal dan
			// mencari soal yang belum di jawab
			$query = $this->Function_model_manually->readDataManuallyController("

				SELECT
			  *
			FROM
			  soal AS a
			  JOIN pilihan_a AS b
			  JOIN pilihan_b AS c
			  JOIN pilihan_c AS d
			  JOIN pilihan_d AS e
			  JOIN pilihan_e AS f
			  JOIN `ujian` AS g
			    ON a.`id_soal` = b.`soal_id`
			    AND a.`id_soal` = c.`soal_id`
			    AND a.`id_soal` = d.`soal_id`
			    AND a.`id_soal` = e.`soal_id`
			    AND a.`id_soal` = f.`soal_id`
			    AND a.`ujian_id` = g.`id_ujian`
			  LEFT JOIN `jawaban_siswa` AS h
			    ON a.`id_soal` = h.`no_soal` 
			WHERE g.`token` = '$token'
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

				// mencari nomer jumlah yang di jawab
				$jumlahyangDiJawabab = $this->Function_model_manually->readDataManuallyController("

					SELECT
					  COUNT(*) as jumlah
					FROM
					  jawaban_siswa AS a
					WHERE a.`nisn` = $nisnPost 
						AND a.`nik` = $nikPost 
						AND a.`token` = $token 

					");
				foreach ($jumlahyangDiJawabab as $key) {
					
					$soal["jumlah_jawab"] = $key["jumlah"] + 1;
				}
				
				array_push($response, $soal);
			}
			// mencari nilai siswa
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
					$soal2["jumlah_soal_ujian"] = $nilaiSiswa["jumlah_soal_ujian"];
					$soal2["jumlah_jawab"] = $nilaiSiswa["jumlah_jawab"];
					$soal2["nilai"] = $nilaiSiswa["nilai"];
					if($nilaiSiswa["jumlah_jawab"] == null || empty($nilaiSiswa["jumlah_jawab"]) || $nilaiSiswa["jumlah_jawab"] == ""){
						$soal2["status_nilai"] = "0";
						//$soal2["jumlah_jawab"] = $nilaiSiswa["jumlah_jawab"];
					} else {
						if($nilaiSiswa["jumlah_soal_ujian"] == $nilaiSiswa["jumlah_jawab"] || $nilaiSiswa["jumlah_soal_ujian"] <= $nilaiSiswa["jumlah_jawab"]){
							$soal2["status_nilai"] = "1";
						} else {
							$soal2["status_nilai"] = "0";
						}
					}
					
					array_push($response, $soal2);
				}
			echo json_encode($response);
		}
		
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