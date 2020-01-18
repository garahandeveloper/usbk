	$(document).ready(function(){
		if(localStorage.getItem("link") == "" || localStorage.getItem("link") == null){
			$(".body-load-all").load("link?dashboard=dashboard");
		}else {
			$(".body-load-all").load(localStorage.getItem("link"));
		}
		$("#pekerjaan").click(function(){
			localStorage.setItem("link", "link?dashboard=pekerjaan");
			$(".body-load-all").load("link?dashboard=pekerjaan");
		});
		$("#user").click(function(){
			localStorage.setItem("link" , "link?dashboard=user");
			$(".body-load-all").load("link?dashboard=user");
		});
		$("#jenis_pegawai").click(function(){
			localStorage.setItem("link" , "link?dashboard=jenis_pegawai");
			$(".body-load-all").load("link?dashboard=jenis_pegawai");
		});
		$("#transport").click(function(){
			localStorage.setItem("link" , "link?dashboard=transport");
			$(".body-load-all").load("link?dashboard=transport");
		});
		$("#jenis_tinggal").click(function(){
			localStorage.setItem("link" , "link?dashboard=jenis_tinggal");
			$(".body-load-all").load("link?dashboard=jenis_tinggal");
		});
		$("#data_siswa").click(function(){
			localStorage.setItem("link" , "link?dashboard=data_siswa");
			$(".body-load-all").load("link?dashboard=data_siswa");
		});
		$("#data_kelas").click(function(){
			localStorage.setItem("link" , "link?dashboard=data_kelas");
			$(".body-load-all").load("link?dashboard=data_kelas");
		});
		$("#mapel").click(function(){
			localStorage.setItem("link" , "link?dashboard=mapel");
			$(".body-load-all").load("link?dashboard=mapel");
		});
		$("#ujian").click(function(){
			localStorage.setItem("link" , "link?dashboard=ujian");
			$(".body-load-all").load("link?dashboard=ujian");
		});	
		$("#data_sekolah").click(function(){
			localStorage.setItem("link" , "link?dashboard=data_sekolah");
			$(".body-load-all").load("link?dashboard=data_sekolah");
		});
		$("#data_pegawai").click(function(){
			localStorage.setItem("link" , "link?dashboard=data_pegawai");
			$(".body-load-all").load("link?dashboard=data_pegawai");
		});
		$("#soal").click(function(){
			localStorage.setItem("link" , "link?dashboard=soal");
			$(".body-load-all").load("link?dashboard=soal");
		});
		$("#status_login_siswa").click(function(){
			localStorage.setItem("link" , "link?dashboard=status_login_siswa");
			$(".body-load-all").load("link?dashboard=status_login_siswa");
		});
		$("#jawaban_soal_siswa").click(function(){
			localStorage.setItem("link" , "link?dashboard=jawaban_soal_siswa");
			$(".body-load-all").load("link?dashboard=jawaban_soal_siswa");
		});
		$("#jawab_soal").click(function(){
			localStorage.setItem("link" , "link?dashboard=jawab_soal");
			$(".body-load-all").load("link?dashboard=jawab_soal");
		});
		$("#jumlah_soal_ujian").click(function(){
			localStorage.setItem("link" , "link?dashboard=jumlah_soal_ujian");
			$(".body-load-all").load("link?dashboard=jumlah_soal_ujian");
		});
			
	});