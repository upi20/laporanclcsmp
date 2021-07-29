<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modelperiode extends Render_Model
{


	public function getAllData($show=null, $start=null, $cari=null, $status=null)
	{
		$exe 						= $this->db->select('*')
											   ->from('periodes a')
											   ->where("(a.tahun_awal LIKE '%".$cari."%' or a.tahun_akhir LIKE '%".$cari."%' or a.status LIKE '%".$cari."%' ) ");

		if ($show == null && $start == null){
			$return = $exe->get();
		}else{
			$exe->limit($show, $start);
			$return = $exe->get();
		}
		return $return;
	}

	public function getDataDetail($id)
	{
		$exe 						= $this->db->get_where('periodes', ['id' => $id]);

		return $exe->row_array();
	}


	public function insert($tahun_awal, $tahun_akhir, $status)
	{
		// Auto code config
		// $config['table'] 			= 'periodes';
		// $config['field'] 			= 'id';
		// $config['jumlah'] 			= 1;
		// $config['return'] 			= '';


		// Code barang
		// $code 						= $this->_generate($config);

		$data['tahun_awal'] 		= $tahun_awal;
		$data['tahun_akhir'] 		= $tahun_akhir;
		$data['status'] 			= $status;
		$data['created_date'] 		= date("Y-m-d H:i:s");

		$exe 						= $this->db->insert('periodes', $data);
		$exe2['id'] 				= $this->db->insert_id();
		return $exe2;
	}


	public function update($id, $tahun_awal, $tahun_akhir, $status)
	{
		$data['tahun_awal'] 		= $tahun_awal;
		$data['tahun_akhir'] 		= $tahun_akhir;
		$data['status'] 			= $status;
		$data['updated_date'] 		= date("Y-m-d H:i:s");

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('periodes', $data);
		$detail 					= $this->db->get_where('periodes',['id' => $id])->row_array();

		$exe2['id'] 				= $detail['id'];
		return $exe2;
	}


	public function delete($id)
	{
		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('periodes');

		return $exe;
	}
}

/* End of file DataModel.php */
/* Location: ./application/models/mataPelajaranModel.php */