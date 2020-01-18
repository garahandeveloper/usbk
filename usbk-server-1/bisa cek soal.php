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
				    AND a.`ujian_id` = g.`id_ujian`
				    AND g.`token` = $token
				  LEFT JOIN jawaban_siswa AS h
				    ON a.`id_soal` = h.`no_soal`
				    AND h.`nisn` = $nisnPost
				    AND h.`nik` = $nikPost

				WHERE h.`nisn` IS NULL
				GROUP BY a.`soal`
				ORDER BY RAND()
				LIMIT 1