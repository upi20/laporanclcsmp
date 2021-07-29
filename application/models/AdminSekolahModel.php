<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminSekolahModel extends Render_Model
{


	public function getAllData($show=null, $start=null, $cari=null, $status=null)
	{
		$exe 						= $this->db->select('*,a.id as id,a.nama as nama,c.nama as kota_kab, a.kode as kode,a.status, a.kota_kab as kota_text')
		->from('sekolah a')
		->join('users b','b.user_id = a.id_user')
		->join('kota_kab c','c.id = a.kota_kab', 'left')
		->where("(a.kode LIKE '%".$cari."%' or a.nama LIKE '%".$cari."%' or a.kota_kab LIKE '%".$cari."%' or b.user_email LIKE '%".$cari."%' or a.jumlah_siswa LIKE '%".$cari."%') ");

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
		$exe 						= $this->db->join('users b','b.user_id = a.id_user')->get_where('sekolah a', ['a.id' => $id]);

		return $exe->row_array();
	}


	public function insert($kode, $nama, $kota_kab, $email, $password, $status)
	{
		// Auto code config
		// $config['table'] 			= 'soal';
		// $config['field'] 			= 'token';
		// $config['jumlah'] 			= 5;
		// $config['return'] 			= '';

		$user['user_nama'] 			= $nama;
		$user['user_email'] 		= $email;
		$user['user_password'] 		= $password;
		$exe_user 					= $this->db->insert('users', $user);
		$id_user 					= $this->db->insert_id();


		$role_user['role_user_id'] 	= $id_user;
		$role_user['role_lev_id'] 	= 4;
		$exe_role_user 				= $this->db->insert('role_users', $role_user);

		// Code barang
		// $code 						= $this->_generate($config);

		$data['kode'] 				= $kode;
		$data['nama'] 				= $nama;
		$data['kota_kab'] 			= $kota_kab;
		$data['id_user'] 			= $id_user;
		$data['status'] 			= $status;

		$exe 						= $this->db->insert('sekolah', $data);
		$exe2['id'] 				= $this->db->insert_id();
		return $exe2;
	}


	public function update($id, $id_user, $kode, $nama, $kota_kab, $email, $password, $status)
	{
		$user['user_nama'] 			= $nama;
		$user['user_email'] 		= $email;
		$user['user_password'] 		= $password;
		$exe_user 					= $this->db->where('user_id', $id_user);
		$exe_user 					= $this->db->update('users', $user);

		$data['kode'] 				= $kode;
		$data['nama'] 				= $nama;
		$data['kota_kab'] 			= $kota_kab;
		$data['id_user'] 			= $id_user;
		$data['status'] 			= $status;

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('sekolah', $data);
		$exe2['id'] 				= $id;
		return $exe2;
	}


	public function delete($id)
	{
		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('sekolah');

		return $exe;
	}
}

/* End of file DataModel.php */
/* Location: ./application/models/mataPelajaranModel.php */