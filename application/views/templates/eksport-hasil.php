<?php

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_ujian-siswa-".date('Y-M-D').".xls");

?>

<h3>Data Siswa</h3>
    
<table border="1" cellpadding="5">
  	<tr>
    	<th>Login</th>
    	<th>Lama</th>
    	<th>User ID</th>
    	<th>Token</th>
    	<th>Jawaban</th>
  	</tr>
  	<?php $no = 1; foreach($record->result_array() as $r) : ?>
  	<tr>
      	<td><?= $r['mulai'] ?></td>
      	<td><?= $r['lama_pengerjaan'] ?></td>
      	<td><?= $r['user_id'] ?></td>
      	<td><?= $r['token'] ?></td>
      	<td>

      		<?php  
      			$detail = $detail($r['idjawaban']);
	      		$detail = $detail->result_array();
	      		
				if(count($detail) > 0)
				{
					$jawaban = [];
					foreach($detail as $d)
					{
						array_push($jawaban, $d['jawaban_pilihan_ganda']);
					}

					echo implode($jawaban, ',');
				}
			?>
				
		</td>
  	</tr>
  	<?php endforeach; ?>
</table>