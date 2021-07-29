<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SiswaModel extends Render_Model
{


	public function getAllData($show=null, $start=null, $cari=null, $status=null, $id_sekolah=null)
	{
		$exe 						= $this->db->select('a.*,b.user_email,c.nama as sekolah')
		->from('siswa a')
		->join('users b','b.user_id = a.id_user')
		->join('sekolah c','c.id = a.id_sekolah')
		->where("(a.nama LIKE '%".$cari."%' or a.rombel LIKE '%".$cari."%' or a.grup LIKE '%".$cari."%' or b.user_email LIKE '%".$cari."%' or c.nama LIKE '%".$cari."%') ")
		->where('a.id_sekolah', $id_sekolah);

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
		$exe 						= $this->db->join('users b','b.user_id = a.id_user')->get_where('siswa a', ['a.id' => $id]);

		return $exe->row_array();
	}


	public function insert($nis, $nama, $rombel, $grup, $email, $password, $status, $sekolah)
	{
		$user['user_nama'] 			= $nama;
		$user['user_email'] 		= $email;
		$user['user_password'] 		= $password;
		$exe_user 					= $this->db->insert('users', $user);
		$id_user 					= $this->db->insert_id();


		$role_user['role_user_id'] 	= $id_user;
		$role_user['role_lev_id'] 	= 6;
		$exe_role_user 				= $this->db->insert('role_users', $role_user);

		$data['id'] 				= $nis;
		$data['id_sekolah'] 		= $sekolah;
		$data['id_user'] 			= $id_user;
		$data['nama'] 				= $nama;
		$data['rombel'] 			= $rombel;
		$data['grup'] 				= $grup;
		$data['status'] 			= $status;

		$exe 						= $this->db->insert('siswa', $data);
		$exe2['id'] 				= $this->db->insert_id();

		$update_jumlah 				= $this->db->get_where('sekolah', ['id_user', $this->session->userdata('data')['id']])->row_array();
		$update_jumlah 				= $this->db->where('id', $update_jumlah['id'])
		->update('sekolah', [
			'jumlah_siswa' => (int)$update_jumlah['jumlah_siswa'] + 1,
		]);
		return $exe2;
	}


	public function update($nis, $id, $id_user, $nama, $rombel, $grup, $email, $password, $status)
	{
		$user['user_nama'] 			= $nama;
		$user['user_email'] 		= $email;
		$user['user_password'] 		= $password;
		$exe_user 					= $this->db->where('user_id', $id_user);
		$exe_user 					= $this->db->update('users', $user);

		$data['id'] 				= $nis;
		$data['id_user'] 			= $id_user;
		$data['nama'] 				= $nama;
		$data['rombel'] 			= $rombel;
		$data['grup'] 				= $grup;
		$data['status'] 			= $status;

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('siswa', $data);
		$exe2['id'] 				= $id;
		return $exe2;
	}


	public function delete($id)
	{
		$siswa 						= $this->db->get_where('siswa', ['id' => $id])->row_array();

		$siswa 						= $siswa['id_user'];
		$delete_user 				= $this->db->where('user_id', $siswa);
		$delete_user 				= $this->db->delete('users');

		$role_user 					= $this->db->where('role_user_id', $siswa);
		$role_user 					= $this->db->delete('role_users');

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('siswa');


		$update_jumlah 				= $this->db->get_where('sekolah', ['id_user', $this->session->userdata('data')['id']])->row_array();
		$update_jumlah 				= $this->db->where('id', $update_jumlah['id'])
		->update('sekolah', [
			'jumlah_siswa' => (int)$update_jumlah['jumlah_siswa'] - 1,
		]);

		return $exe;
	}
}

/* End of file DataModel.php */
/* Location: ./application/models/mataPelajaranModel.php */