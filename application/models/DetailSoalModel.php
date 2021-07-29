<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DetailSoalModel extends CI_Model {


	public function getAllData($show=null, $start=null, $cari=null, $status=null, $id=null)
	{
		$exe 						= $this->db->select('a.*')
		->from('soal_detail a')
		->join('soal c','c.id = a.id_soal')
		->join('mata_pelajaran b','b.id = c.id_mata_pelajaran')
		->where("(a.kategori LIKE '%".$cari."%' or a.jawaban LIKE '%".$cari."%' or a.keterangan LIKE '%".$cari."%' or a.file_audio LIKE '%".$cari."%' or a.status LIKE '%".$cari."%' ) ")
		->where('a.id_soal', $id);

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
		$exe 						= $this->db->join('mata_pelajaran b', 'a.id_mata_pelajaran = b.id')->get_where('soal a', ['a.id' => $id]);

		return $exe->row_array();
	}


	public function getDataDetail($id)
	{
		$exe 						= $this->db->get_where('soal_detail', ['id' => $id]);

		return $exe->row_array();
	}


	public function insert($id_soal, $kategori, $jawaban, $keterangan, $file, $image, $status)
	{
		$data['id_soal'] 			= $id_soal;
		$data['kategori'] 			= $kategori;
		$data['jawaban'] 			= $jawaban;
		$data['keterangan'] 		= $keterangan;
		$data['file_audio'] 		= $file;
		$data['gambar'] 			= $image;
		$data['status'] 			= $status;

		$exe 						= $this->db->insert('soal_detail', $data);

		return $exe;
	}


	public function update($id, $id_soal, $kategori, $jawaban, $keterangan, $file, $image, $status)
	{
		$data['id_soal'] 			= $id_soal;
		$data['kategori'] 			= $kategori;
		$data['jawaban'] 			= $jawaban;
		$data['keterangan'] 		= $keterangan;
		$data['file_audio'] 		= $file;
		$data['gambar'] 			= $image;
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

/* End of file DetailSoalModel.php */
/* Location: ./application/models/DetailSoalModel.php */