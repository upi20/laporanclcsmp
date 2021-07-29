<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KursModel extends Render_Model
{


	public function getAllData($show=null, $start=null, $cari=null, $status=null)
	{
		$exe 						= $this->db->select('*')
											   ->from('kurs a')
											   ->where("(a.ringgit LIKE '%".$cari."%' or a.rupiah LIKE '%".$cari."%' ) ");

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
		$exe 						= $this->db->get_where('kurs', ['id' => $id]);

		return $exe->row_array();
	}


	public function insert($ringgit, $rupiah, $status)
	{
		// Auto code config
		// $config['table'] 			= 'kota_kab';
		// $config['field'] 			= 'id';
		// $config['jumlah'] 			= 1;
		// $config['return'] 			= '';


		// Code barang
		// $code 						= $this->_generate($config);

		$data['ringgit'] 			= $ringgit;
		$data['rupiah'] 			= $rupiah;
		$data['status'] 			= $status;

		$exe 						= $this->db->insert('kurs', $data);
		$exe2['id'] 				= $this->db->insert_id();
		return $exe2;
	}


	public function update($id, $ringgit, $rupiah, $status)
	{
		$data['ringgit'] 			= $ringgit;
		$data['rupiah'] 			= $rupiah;
		$data['status'] 			= $status;

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('kurs', $data);
		$detail 					= $this->db->get_where('kurs',['id' => $id])->row_array();

		$exe2['id'] 				= $detail['id'];
		// $exe2['tanggal'] 			= $detail['tanggal'];
		return $exe2;
	}


	public function delete($id)
	{
		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('kurs');

		return $exe;
	}
}

/* End of file DataModel.php */
/* Location: ./application/models/mataPelajaranModel.php */