<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MonitoringModel extends CI_Model {


	public function getAllData($where = null)
	{
		$sekolah 					= $this->db->get_where('sekolah', ['id_user' => $this->session->userdata('data')['id']])->row_array();

		$exe 						= $this->db->select('f.nama,f.id,d.token,e.nama as mapel,a.mulai,a.lama_pengerjaan,a.status,a.id as idjawaban')
		->from('siswa f')
		->join('jawaban a', 'a.id_siswa = f.id_user', 'left')
		->join('users b','b.user_id = a.id_siswa', 'left')
		->join('jadwal c','c.id = a.id_jadwal', 'left')
		->join('soal d','d.id = c.id_soal', 'left')
		->join('mata_pelajaran e','d.id_mata_pelajaran = e.id', 'left')
		->where('f.id_sekolah', $sekolah['id']);

		if($where != null)
		{
			$exe = $exe->where(' ' . $where . ' ');
		}

		if(isset($_GET['paket_soal']) || isset($_GET['tanggal']))
		{
			if($_GET['paket_soal'] != null || $_GET['tanggal'] != null)
			{
				$exe = $exe->where(" c.id_soal = '".$_GET['paket_soal']."' or c.waktu_mulai LIKE '%".$_GET['tanggal']."%' ");
			}
		}


		return $exe->get();
	}

}

/* End of file MonitoringModel.php */
/* Location: ./application/models/MonitoringModel.php */