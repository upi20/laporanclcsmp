<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HutangModel extends Render_Model
{


	public function getAllData($show = null, $start = null, $cari = null, $status = null, $id_cabang = null)
	{
		$exe = $this->db->select('*')
			->from('hutang a')
			->where("(a.id_cabang = '$id_cabang') and (a.nama LIKE '%" . $cari . "%' or a.no_hp LIKE '%" . $cari . "%' or a.keterangan LIKE '%" . $cari . "%' or a.jumlah LIKE '%" . $cari . "%' or a.dibayar LIKE '%" . $cari . "%' or a.sisa LIKE '%" . $cari . "%' or a.status LIKE '%" . $cari . "%' or a.tanggal LIKE '%" . $cari . "%' ) ");
		if ($show == null && $start == null) {
			$return = $exe->get();
		} else {
			$exe->limit($show, $start);
			$return = $exe->get();
		}
		return $return;
	}

	public function getDataDetail($id)
	{
		$exe 						= $this->db->get_where('hutang', ['id' => $id]);

		return $exe->row_array();
	}

	public function bayar($id_cabang, $jumlah)
	{
		$get_kurs					= $this->db->get('kurs')->row_array();
		$kurs						= $get_kurs['rupiah'];

		$get 						= $this->db->get_where('saldos', ['id_cabang' => $id_cabang])->row_array();
		$total_ringgit 				= $get['total_ringgit'];
		$total_rupiah 				= $get['total_rupiah'];

		$get2 						= $this->db->select_sum('sisa')->get_where('hutang', ['id_cabang' => $id_cabang, 'status' => 0])->row_array();
		$jumlah_ringgit				= $get2['sisa'];
		$jumlah_rupiah				= $get2['sisa'] * $kurs;

		$upd_saldo['total_ringgit'] = $total_ringgit - $jumlah_ringgit;
		$upd_saldo['total_rupiah'] 	= $total_rupiah - $jumlah_rupiah;
		$this->db->where('id_cabang', $id_cabang);
		$this->db->update('saldos', $upd_saldo);

		$upd_hutang['status'] 		= 1;
		$this->db->where('id_cabang', $id_cabang);
		$this->db->update('hutang', $upd_hutang);

		return true;
	}

	public function update_tanggal_administrasi($id_cabang, $tanggal)
	{
		$upd_hutang['tanggal_administrasi'] 		= $tanggal;
		$this->db->where('id_cabang', $id_cabang);

		return $this->db->update('realisasis', $upd_hutang);
	}

	public function insert($id_cabang, $nama, $no_hp, $keterangan, $jumlah, $dibayar, $sisa, $status, $tanggal)
	{
		$data['id_cabang'] 			= $id_cabang;
		$data['nama'] 				= $nama;
		$data['no_hp'] 				= $no_hp;
		$data['keterangan'] 		= $keterangan;
		$data['jumlah'] 			= $jumlah;
		$data['dibayar'] 			= $dibayar;
		$data['sisa'] 				= $sisa;
		$data['status'] 			= $status;
		$data['tanggal'] 			= $tanggal;

		$exe 						= $this->db->insert('hutang', $data);
		$exe2['id'] 				= $this->db->insert_id();
		if ($exe) {
			$getKurs				= $this->db->get('kurs')->row_array();
			$get 					= $this->db->get_where('saldos', ['id_cabang' => $id_cabang])->row_array();
			$total_ringgit 			= $get['total_ringgit'] + $jumlah;
			$rupiah   			 	= $getKurs['rupiah'] * $jumlah;
			$total_rupiah			= $get['total_rupiah'] + $rupiah;
			$upd['total_ringgit']	= $total_ringgit;
			$upd['total_rupiah']	= $total_rupiah;
			$this->db->where('id_cabang', $id_cabang);
			$this->db->update('saldos', $upd);
		}
		return $exe2;
	}


	public function update($id, $id_cabang, $nama, $no_hp, $keterangan, $jumlah, $dibayar, $sisa, $status, $tanggal)
	{
		$data['id_cabang'] 			= $id_cabang;
		$data['nama'] 				= $nama;
		$data['no_hp'] 				= $no_hp;
		$data['keterangan'] 		= $keterangan;
		$data['jumlah'] 			= $jumlah;
		$data['dibayar'] 			= $dibayar;
		$data['sisa'] 				= $sisa;
		$data['status'] 			= $status;
		$data['tanggal'] 			= $tanggal;

		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->update('hutang', $data);
		$detail 					= $this->db->get_where('hutang', ['id' => $id])->row_array();

		$exe2['id'] 				= $detail['id'];
		return $exe2;
	}


	public function delete($id)
	{
		$exe 						= $this->db->where('id', $id);
		$exe 						= $this->db->delete('hutang');

		return $exe;
	}
}

/* End of file DataModel.php */
/* Location: ./application/models/mataPelajaranModel.php */