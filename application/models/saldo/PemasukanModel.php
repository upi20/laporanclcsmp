<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PemasukanModel extends Render_Model
{


	public function getAllData($show=null, $start=null, $cari=null, $status=null, $id_cabang=null)
	{
		$exe = $this->db->select('*, b.kode as cabang_kode, b.nama as cabang_nama, c.user_nama, d.nama as rab_nama, a.status');
					$this->db->from('saldo_pemasukans a');
					$this->db->join(' cabangs b ', ' b.id = a.id_cabang ', ' left ');
					$this->db->join(' users c ', ' c.user_id = a.id_user ', ' left ');
					$this->db->join(' rabs d ', ' d.id = a.id_rab ', ' left ');
					$this->db->where("(a.id LIKE '%".$cari."%' or a.status LIKE '%".$cari."%' ) ");
					if($id_cabang != null){
						$this->db->where('a.id_cabang', $id_cabang);
					}
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
		$exe 						= $this->db->get_where('saldo_pemasukans', ['id' => $id]);

		return $exe->row_array();
	}

	public function getCabang($id)
	{
		if($id == null){
			$where = array();
		}else{
			$where = array('id' => $id);
		}

		$exe 			= $this->db->get_where('cabangs', $where);

		return $exe->result_array();
	}


	public function insert($id_user, $id_cabang, $id_rab, $keterangan, $total_ringgit, $total_rupiah, $status)
	{
		// // Auto code config
		// $config['table'] 			= 'saldo_pemasukans';
		// $config['field'] 			= 'id';
		// $config['jumlah'] 			= 1;
		// $config['return'] 			= '';


		// Code barang
		// $code 						= $this->_generate($config);

		$data['id_user'] 				= $id_user;
		$data['id_cabang'] 				= $id_cabang;
		$data['id_rab'] 				= $id_rab;
		$data['keterangan']				= $keterangan;
		$data['total_ringgit']			= $total_ringgit;
		$data['total_rupiah']			= $total_rupiah;
		$data['status'] 				= $status;

		$exe 						= $this->db->insert('saldo_pemasukans', $data);
		$exe2['id'] 				= $this->db->insert_id();
		return $exe2;
	}


	public function update($id, $nama, $status)
	{
		$data['id_user'] 				= $id_user;
		$data['id_cabang'] 				= $id_cabang;
		$data['id_rab'] 				= $id_rab;
		$data['keterangan']				= $keterangan;
		$data['total_ringgit']			= $total_ringgit;
		$data['total_rupiah']			= $total_rupiah;
		$data['status'] 				= $status;

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('saldo_pemasukans', $data);
		$detail 					= $this->db->get_where('saldo_pemasukans',['id' => $id])->row_array();

		$exe2['id'] 				= $detail['id'];
		$exe2['tanggal'] 			= $detail['tanggal'];
		return $exe2;
	}


	public function delete($id)
	{
		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('saldo_pemasukans');

		return $exe;
	}
}

/* End of file DataModel.php */
/* Location: ./application/models/mataPelajaranModel.php */