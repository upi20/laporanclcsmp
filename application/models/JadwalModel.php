<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JadwalModel extends CI_Model {


	public function getAllData($show=null, $start=null, $cari=null, $status=null, $id=null)
	{
		$exe 						= $this->db->select('a.*, b.token, c.nama, d.nama as kota')
		->from('jadwal a')
		->join('soal b','b.id = a.id_soal')
		->join('mata_pelajaran c','c.id = b.id_mata_pelajaran')
		->join('kota_kab d','d.id = a.kota_kab')
		->where("(c.nama LIKE '%".$cari."%' or b.token LIKE '%".$cari."%' or a.waktu_mulai LIKE '%".$cari."%' or a.waktu_selesai LIKE '%".$cari."%' or a.mode_jadwal LIKE '%".$cari."%' or a.status LIKE '%".$cari."%' or d.nama LIKE '%".$cari."%' ) ");

		if ($show == null && $start == null){
			$return = $exe->get();
		}else{
			$exe->limit($show, $start);
			$return = $exe->get();
		}
		return $return;
	}


	public function getSoalData($id)
	{
		$exe 						= $this->db->get_where('soal a', ['a.id_mata_pelajaran' => $id]);

		return $exe->result_array();
	}


	public function getDataDetail($id)
	{
		$exe 						= $this->db->get_where('jadwal', ['id' => $id])->row_array();
		$get_mapel 					= $this->db->get_where('soal', ['id' => $exe['id_soal']])->row_array();

		$exe 						= array_merge($exe, ['id_mapel' => $get_mapel['id_mata_pelajaran']]);

		return $exe;
	}


	public function insert($soal, $kota, $mode_jadwal, $mode_timer, $waktu_mulai, $waktu_selesai, $status)
	{
		$data['id_soal'] 			= $soal;
		$data['kota_kab'] 			= $kota;
		$data['mode_jadwal'] 		= $mode_jadwal;
		$data['mode_timer'] 		= $mode_timer;
		$data['waktu_mulai'] 		= $waktu_mulai;
		$data['waktu_selesai'] 		= $waktu_selesai;
		$data['created_user'] 		= $this->session->userdata('data')['id'];
		$data['user_level'] 		= $this->session->userdata('data')['level_id'];
		$data['status'] 			= $status;

		$exe 						= $this->db->insert('jadwal', $data);

		return $exe;
	}


	public function update($id, $id_soal, $kategori, $jawaban, $keterangan, $file, $status)
	{
		$data['id_soal'] 			= $id_soal;
		$data['kategori'] 			= $kategori;
		$data['jawaban'] 			= $jawaban;
		$data['keterangan'] 		= $keterangan;
		$data['file_audio'] 		= $file;
		$data['status'] 			= $status;	

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('soal_detail', $data);

		return $exe;
	}


	public function delete($id)
	{
		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('soal_detail');

		return $exe;
	}
}

/* End of file JadwalModel.php */
/* Location: ./application/models/JadwalModel.php */