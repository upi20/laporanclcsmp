<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MataPelajaranModel extends Render_Model
{


	public function getAllData()
	{
		$exe 						= $this->db->get('mata_pelajaran');

		return $exe->result_array();
	}



	public function getDataDetail($id)
	{
		$exe 						= $this->db->get_where('mata_pelajaran', ['id' => $id]);

		return $exe->row_array();
	}


	public function insert($nama, $keterangan, $status)
	{
		// Auto code config
		// $config['table'] 			= 'mata_pelajaran';
		// $config['field'] 			= 'id';
		// $config['jumlah'] 			= 3;
		// $config['return'] 			= 'G';


		// Code barang
		// $code 						= $this->_generate($config);

		// $data['kode_gejala'] 		= $code;
		$data['nama'] 				= $nama;
		$data['keterangan'] 		= $keterangan;
		$data['status'] 			= $status;

		$exe 						= $this->db->insert('mata_pelajaran', $data);
		$exe2['id'] 				= $this->db->insert_id();
		// $exe2['code'] 				= $code;

		return $exe2;
	}


	public function update($id, $nama, $keterangan, $status)
	{
		$data['nama'] 				= $nama;
		$data['keterangan'] 		= $keterangan;
		$data['status'] 			= $status;

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('mata_pelajaran', $data);

		// $exe2['code'] 				= $this->_cek('mata_pelajaran', 'id', $id, 'kode_gejala');

		return $exe;
	}


	public function delete($id)
	{
		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('mata_pelajaran');

		return $exe;
	}
}

/* End of file DataModel.php */
/* Location: ./application/models/mataPelajaranModel.php */