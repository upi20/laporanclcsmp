<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StandardModel extends Render_Model
{


  public function getAllData($show = null, $start = null, $cari = null, $filter_data_kode = null, $filter_data_tanggal = null, $filter_data_cabang = null)
  {
    // cek proposal acc terbaru
    $id_proposal = $this->db->query("SELECT id FROM `proposal` WHERE (`proposal`.`status` = '4') and (`proposal`.`id_cabang` = '$filter_data_cabang')  ORDER BY `proposal`.`tanggal` DESC")->row_array();

    // where tambah join
    $tanggal_proposal = 'a.tanggal';
    if ($id_proposal) {
      $tanggal_proposal = "a.tanggal_administrasi as tanggal";
    }

    $this->db->select("$tanggal_proposal ,a.id,c.kode, a.nama as uraian, d.nama, d.kode as npsn, a.harga_ringgit, a.harga_rupiah");
    $this->db->from(' realisasis a ');
    $this->db->join(' rabs b ', ' a.id_rab = b.id ', ' left ');
    $this->db->join('aktifitas c', 'b.id_aktifitas = c.id', 'left');
    $this->db->join('cabangs d', 'b.id_cabang = d.id');
    $this->db->order_by('a.id', 'asc');

    if ($filter_data_kode != null) {
      $this->db->like('b.kode', $filter_data_kode, 'after');
    }

    if ($filter_data_tanggal != null) {
      $tanggals = json_decode($filter_data_tanggal);
      $start = $tanggals->start;
      $end = $tanggals->end;
      $this->db->where("(a.tanggal BETWEEN '$start' and '$end')");
    }
    if ($filter_data_cabang != null) {
      $this->db->where('d.id', $filter_data_cabang);
    }



    $result = $this->db->get();
    // var_dump($this->db->last_query());
    return  $result;
  }

  public function getAllDataCetak($show = null, $start = null, $cari = null, $filter_data_kode = null, $filter_data_tanggal = null, $filter_data_cabang = null)
  {
    // cek proposal acc terbaru
    $id_proposal = $this->db->query("SELECT id FROM `proposal` WHERE (`proposal`.`status` = '4') and (`proposal`.`id_cabang` = '$filter_data_cabang')  ORDER BY `proposal`.`tanggal` DESC")->row_array();

    // where tambah join
    $tanggal_proposal = 'a.tanggal';
    if ($id_proposal) {
      $tanggal_proposal = "a.tanggal_administrasi as tanggal";
    }

    $this->db->select("a.harga_ringgit, $tanggal_proposal, b.id_aktifitas, a.nama as uraian, c.kode");
    $this->db->from(' realisasis a ');
    $this->db->join(' rabs b ', ' a.id_rab = b.id  ', ' left ');
    $this->db->join('aktifitas c', 'c.id = b.id_aktifitas', 'left');

    $this->db->join('cabangs d', 'b.id_cabang = d.id');
    $this->db->order_by('a.id', 'asc');

    if ($filter_data_kode != null) {
      $this->db->like('b.kode', $filter_data_kode, 'after');
    }

    if ($filter_data_tanggal != null) {
      $tanggals = json_decode($filter_data_tanggal);
      $start = $tanggals->start;
      $end = $tanggals->end;
      $this->db->where("(a.tanggal BETWEEN '$start' and '$end')");
    }
    if ($filter_data_cabang != null) {
      $this->db->where('d.id', $filter_data_cabang);
    }

    return $this->db->get();
  }

  public function getByKode()
  {
    return $this->db->select('kode')->from('rabs')->get();
  }

  public function getDataKode($kode)
  {
    $exe    = $this->db->select('a.*,b.kode,c.uraian')
      ->from(' realisasis a ')
      ->join(' rabs b ', ' a.id_rab = b.id ', ' left ')
      ->join('aktifitas c', 'b.id_aktifitas = c.id', 'left')
      ->order_by('a.id', 'asc')
      ->get()->where(['b.kode' => $kode]);
    return $exe->row_array();
  }
  public function getDataDetail($id)
  {
    $exe             = $this->db->get_where('aktifitas', ['id' => $id]);

    return $exe->row_array();
  }

  public function insert($id_pengkodeans, $kode, $uraian, $status)
  {
    $data['id_pengkodeans']   = $id_pengkodeans;
    $data['kode']         = $kode;
    $data['uraian']       = $uraian;
    $data['status']       = $status;

    $exe             = $this->db->insert('aktifitas', $data);
    $exe             = $this->db->insert_id();

    return $exe;
  }


  public function update($id, $id_pengkodeans, $kode, $uraian, $status)
  {
    $data['id_pengkodeans']   = $id_pengkodeans;
    $data['kode']         = $kode;
    $data['uraian']       = $uraian;
    $data['status']       = $status;

    $exe             = $this->db->where('id', $id);
    $exe             = $this->db->update('aktifitas', $data);

    return $exe;
  }


  public function delete($id)
  {
    $exe             = $this->db->where('id', $id);
    $exe             = $this->db->delete('aktifitas');

    return $exe;
  }

  public function getCabang()
  {
    return $this->db->get_where('cabangs', [''])->result_array();
  }
}

/* End of file LevelModel.php */
/* Location: ./application/models/pengaturan/LevelModel.php */