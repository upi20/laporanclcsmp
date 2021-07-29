<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SoalModel extends Render_Model
{


	public function getAllData($show=null, $start=null, $cari=null, $status=null)
	{
		$exe 						= $this->db->select('*,a.id as id')
		->from('soal a')
		->join('mata_pelajaran b','b.id = a.id_mata_pelajaran')
		->where("(a.jenis_soal LIKE '%".$cari."%' or a.id LIKE '%".$cari."%' or a.token LIKE '%".$cari."%' or a.model LIKE '%".$cari."%' or a.pengaturan LIKE '%".$cari."%' or b.nama LIKE '%".$cari."%' ) ");

		if ($show == null && $start == null){
			$return = $exe->get();
		}else{
			$exe->limit($show, $start);
			$return = $exe->get();
		}
		return $return;
	}

	public function getMataPelajaran($id)
	{
		if($id == null){
			$where = array();
		}else{
			$where = array('id' => $id);
		}

		$exe 			= $this->db->get_where('mata_pelajaran', $where);

		return $exe->result_array();
	}


	public function getDataDetail($id)
	{
		$exe 						= $this->db->get_where('soal', ['id' => $id]);

		return $exe->row_array();
	}


	public function insert($jenis_soal, $id_mata_pelajaran, $model, $pengaturan, $status)
	{
		$data['token'] 				= substr(str_shuffle(str_repeat("ABCDEFGHIJKLNMOPQRSTUVWXYZ", 6)), 0, 6);
		$data['jenis_soal'] 		= $jenis_soal;
		$data['id_mata_pelajaran'] 	= $id_mata_pelajaran;
		$data['model'] 				= $model;
		$data['pengaturan'] 		= $pengaturan;
		$data['status'] 			= $status;

		$exe 						= $this->db->insert('soal', $data);
		$exe2['id'] 				= $this->db->insert_id();
		$detail 					= $this->db->get_where('soal',['id' => $exe2['id']])->row_array();
		$exe2['token'] 				= $data['token'];
		$exe2['jumlah'] 			= $detail['jumlah'];
		$exe2['tanggal'] 			= $detail['tanggal'];
		$exe2['nama'] 				= $this->db->get_where('mata_pelajaran',['id' => $id_mata_pelajaran])->row_array()['nama'];

		return $exe2;
	}


	public function update($id, $jenis_soal, $id_mata_pelajaran, $model, $pengaturan, $status)
	{
		$data['jenis_soal'] 		= $jenis_soal;
		$data['id_mata_pelajaran'] 	= $id_mata_pelajaran;
		$data['model'] 				= $model;
		$data['pengaturan'] 		= $pengaturan;
		$data['status'] 			= $status;

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('soal', $data);
		$detail 					= $this->db->get_where('soal',['id' => $id])->row_array();

		$exe2['id'] 				= $detail['id'];
		$exe2['token'] 				= $detail['token'];
		$exe2['jumlah'] 			= $detail['jumlah'];
		$exe2['tanggal'] 			= $detail['tanggal'];
		$exe2['nama'] 				= $this->db->get_where('mata_pelajaran',['id' => $id_mata_pelajaran])->row_array()['nama'];

		return $exe2;
	}


	public function delete($id)
	{
		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('soal');

		return $exe;
	}
}

/* End of file DataModel.php */
/* Location: ./application/models/mataPelajaranModel.php */