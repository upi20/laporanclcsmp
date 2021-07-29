<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BkuModel extends Render_Model
{


  public function getAllData($show = null, $start = null, $cari = null, $tanggal = null, $cabang = null)
  {

    // cek proposal acc terbaru
    $id_proposal = $this->db->query("SELECT id FROM `proposal` WHERE (`proposal`.`status` = '4') and (`proposal`.`id_cabang` = '$cabang')  ORDER BY `proposal`.`tanggal` DESC")->row_array();

    // where tambah join
    $tanggal_proposal = 'a.tanggal';
    if ($id_proposal) {
      $tanggal_proposal = "a.tanggal_administrasi as tanggal";
    }

    $this->db->select("d.kode as kode_cabang, d.nama as nama_cabang, $tanggal_proposal, a.id,c.kode,b.nama as uraian, a.harga_ringgit, a.harga_rupiah, a.keterangan, a.nama as nama_uraian");
    $this->db->from(' realisasis a ');
    $this->db->join(' rabs b ', ' a.id_rab = b.id ', ' left ');
    $this->db->join('aktifitas c', 'b.id_aktifitas = c.id', 'left');
    $this->db->join('cabangs d', 'd.id = a.id_cabang', 'left');
    $this->db->order_by('a.id', 'asc');

    if ($tanggal != null) {
      $tanggals = json_decode($tanggal);
      $start = $tanggals->start;
      $end = $tanggals->end;
      $this->db->where("(a.tanggal BETWEEN '$start' and '$end')");
    }

    if ($cabang != null) {
      $this->db->where('a.id_cabang', $cabang);
    }

    return $this->db->get();
  }

  public function getCetakDetail($tanggal = null, $cabang = null)
  {
    $this->db->select('d.kode as kode_cabang, d.nama as nama_cabang, a.tanggal,a.id,c.kode,b.nama as uraian, a.harga_ringgit, a.harga_rupiah, a.keterangan,  c.kode as kode_aktivitas');
    $this->db->from(' realisasis a ');
    $this->db->join(' rabs b ', ' a.id_rab = b.id ', ' left ');
    $this->db->join('aktifitas c', 'b.id_aktifitas = c.id', 'left');
    $this->db->join('cabangs d', 'd.id = a.id_cabang', 'left');
    $this->db->order_by('a.id', 'asc');

    if ($tanggal != null) {
      $tanggals = json_decode($tanggal);
      $start = $tanggals->start;
      $end = $tanggals->end;
      $this->db->where("(a.tanggal BETWEEN '$start' and '$end')");
    }

    if ($cabang != null) {
      $this->db->where('a.id_cabang', $cabang);
    }

    return $this->db->get()->result_array();
  }

  public function getCetakHead($cabang = null)
  {
    return $this->db->get_where('cabangs', ['id' => $cabang])->row_array();
  }

  public function getByKode()
  {
    return $this->db->select('kode')->from('rabs')->get();
  }

  public function getCabang()
  {
    return $this->db->get_where('cabangs', [''])->result_array();
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


  // new
  public function penggunaanDanaOperasional($kodes, $tanggal = null, $cabang = null, $show = null, $start = null, $cari = null)
  {
    // form cari by nspn di hapus
    // form default by date

    // 1 get cabang where cabang di sini

    // 2 buat arrary untuk kode

    // 4 jumlah
    $tanggal = json_decode($tanggal);
    if ($cabang) {
      $cabangs = [$this->getDetailCabangById($cabang)];
    } else {
      $cabangs = $this->getCabangRekap($tanggal);
    }
    $results = [];
    if ($cabangs[0] != null) {
      foreach ($cabangs as $cabang) {
        $jumlah = 0;
        $penggunaan = [];
        foreach ($kodes as $kode) {
          $result_kode = 0;
          foreach ($kode as $k) {
            $result_kode += $this->getRealisasiByIdNTanggalNKode($cabang['id'], $tanggal, $k);
          }
          $penggunaan[] = $result_kode;
          $jumlah += $result_kode;
        }

        $results[] = [
          'id' => $cabang['id'],
          'kode' => $cabang['kode'],
          'nama' => $cabang['nama'],
          'no_urut' => '',
          'program_keahlian' => '',
          'penggunaan' => $penggunaan,
          'jumlah' => $jumlah
        ];
      }
    }
    return $results;
  }

  private function getCabangRekap($tanggal = null)
  {
    $tanggal = $tanggal != null ? $tanggal : date('Y-m-d');
    $cabangs = $this->db->query("SELECT DISTINCT id_cabang FROM realisasis WHERE (tanggal BETWEEN '$tanggal->start' and '$tanggal->end')")->result_array();

    // get informasi cabang
    // nilai default antisipasi error
    $cabangs = $cabangs ? $cabangs : [
      [
        'id_cabang' => 0
      ]
    ];
    $rows = [];
    foreach ($cabangs as $cabang) {
      $rows[] = $this->getDetailCabangById($cabang['id_cabang']);
    }
    return $rows;
  }

  private function getDetailCabangById($id)
  {
    return $this->db->query("SELECT id, nama, kode FROM cabangs WHERE id = '$id'")->row_array();
  }

  private function getRealisasiByIdNTanggalNKode($id_cabang, $tanggal, $kode)
  {
    $result = $this->db->query("SELECT sum(a.harga_ringgit) as harga_ringgit FROM realisasis a join rabs b on a.id_rab = b.id where (a.id_cabang = '$id_cabang' and (a.tanggal BETWEEN '$tanggal->start' and '$tanggal->end'))  and (b.kode like '$kode%')")->row_array();
    return isset($result['harga_ringgit']) ? $result['harga_ringgit'] : 0;
  }

  // export excel baru wkwk
  public function getDanaPenggunaanOperasional($kodes, $tanggal, $cabang, $show = null, $start = null, $cari = null)
  {
    // init jumlah
    $jumlah_penggunaan = [
      '0' => 0,
      '1' => 0,
      '2' => 0,
      '3' => 0,
      '4' => 0,
      '5' => 0,
      '6' => 0,
      '7' => 0,
      '8' => 0,
      '9' => 0,
    ];
    $results = [];
    foreach ($kodes as $key => $kode) {
      $no_urut = "1." . $key;
      $jumlah = 0;
      $uraian = $this->getUraianAktifitasByKode($key);
      $penggunaan = [];
      foreach ($kode as $key_k => $k) {
        $result = $this->getRealisasi($k, $tanggal, $cabang);
        $jumlah += $result;
        $penggunaan[$key_k] = $result;
        $jumlah_penggunaan[$key_k] += $result;
      }

      $results[] = [
        'no_urut' => $no_urut,
        'uraian' => $uraian,
        'penggunaan' => $penggunaan,
        'jumlah' => $jumlah
      ];
    }

    return ['data' => $results, 'jumlah' => $penggunaan];
  }
  private function getUraianAktifitasByKode($kode)
  {
    $return = $this->db->select("uraian")->from("aktifitas")->where("kode", $kode)->get()->row_array();
    return isset($return['uraian']) ? $return['uraian'] : "";
  }

  private function getRealisasi($kode, $tanggal, $id_cabang)
  {
    $tanggal = json_decode($tanggal);
    $result = $this->db->query("SELECT sum(a.harga_ringgit) as harga_ringgit FROM realisasis a join rabs b on a.id_rab = b.id where (a.id_cabang = '$id_cabang' and (a.tanggal BETWEEN '$tanggal->start' and '$tanggal->end'))  and (b.kode like '$kode%')")->row_array();
    return isset($result['harga_ringgit']) ? $result['harga_ringgit'] : 0;
  }


  // cetak bku

  public function bkuCetak($tanggal, $cabang)
  {
    $tanggals = json_decode($tanggal);
    $saldo = $this->getSaldo($cabang);

    $pengeluaran_after = $this->getPengeluaranAfter($tanggals->start, $cabang);
    $pengeluaran_list = $this->getPengeluaranByRange($tanggals->start, $tanggals->end, $cabang);
    $id_proposal = $this->db->query("SELECT id FROM `proposal` WHERE (`proposal`.`status` = '4') and (`proposal`.`id_cabang` = '$cabang')  ORDER BY `proposal`.`tanggal` DESC")->row_array();
    if ($id_proposal == null) {
      $hutang = $this->db->query("SELECT sum(jumlah) as jumlah FROM `hutang` WHERE id_cabang = '$cabang' and tanggal BETWEEN '$tanggals->start' AND '$tanggals->end'")->row_array();
      $hutang = ($hutang['jumlah']) == null ? 0 : (float)($hutang['jumlah']);
      $now_saldo = $hutang;
      $text_uraian = "Total pinjaman hutang";
    } else {
      $now_saldo = ((float)$saldo['total_ringgit'] + $pengeluaran_after);
      $text_uraian = "Saldo sebelumnya";
    }
    return $this->buildBkuCetak($now_saldo, $tanggals->start, $pengeluaran_list, $text_uraian);
  }

  private function buildBkuCetak($saldos, $start, $pengeluaran, $text_uraian)
  {
    $rows = [];
    $saldo = $saldos;
    for ($i = -1; $i < count($pengeluaran); $i++) {
      if ($i == -1) {
        $row = [
          'no' => $i + 2,
          'tanggal' => $start,
          'kode' => '',
          'no_bukti' => '',
          'uraian' => 'Saldo Sebelumnya',
          'debit' => $saldo,
          'kredit' => '',
          'saldo' => $saldo
        ];
      } else {
        $saldo -= (float)$pengeluaran[$i]['harga_ringgit'];
        $row = [
          'no' => $i + 2,
          'tanggal' => $pengeluaran[$i]['tanggal'],
          'kode' => $pengeluaran[$i]['kode'],
          'no_bukti' => '',
          'uraian' => $pengeluaran[$i]['keterangan'],
          'debit' => '',
          'kredit' => $pengeluaran[$i]['harga_ringgit'],
          'saldo' => $saldo
        ];
      }

      $rows[] = $row;
    }

    return $rows;
  }

  private function getSaldo($cabang)
  {
    return $this->db->get('saldos', ['id_cabang' => $cabang])->row_array();
  }

  private function getPengeluaranByRange($start, $end, $cabang)
  {
    // cek proposal acc terbaru
    $id_proposal = $this->db->query("SELECT id FROM `proposal` WHERE (`proposal`.`status` = '4') and (`proposal`.`id_cabang` = '$cabang')  ORDER BY `proposal`.`tanggal` DESC")->row_array();

    // where tambah join
    $tanggal_proposal = 'a.tanggal';
    if ($id_proposal) {
      $tanggal_proposal = "a.tanggal_administrasi as tanggal";
    }

    $result = $this->db->select("a.harga_ringgit, $tanggal_proposal, a.nama as keterangan, c.kode")
      ->from('realisasis a')
      ->join('rabs b', 'a.id_rab = b.id', 'left')
      ->join('aktifitas c', 'b.id_aktifitas = c.id', 'left')
      ->where('a.id_cabang', $cabang)
      ->where("(a.tanggal BETWEEN '$start' and '$end')")
      ->get()
      ->result_array();
    return $result;
  }

  // private function getTotalPengeluaran($cabang)
  // {
  //   $result = $this->db->select_sum('harga_ringgit')
  //     ->from('realisasis')
  //     ->where('id_cabang', $cabang)
  //     ->get()
  //     ->row_array();
  //   return isset($result['harga_ringgit']) ? $result['harga_ringgit'] : 0;
  // }

  private function getPengeluaranAfter($start, $cabang)
  {
    $result = $this->db->select_sum('harga_ringgit')
      ->from('realisasis')
      ->where('id_cabang', $cabang)
      ->where('tanggal >=', $start)
      ->get()
      ->row_array();
    return isset($result['harga_ringgit']) ? $result['harga_ringgit'] : 0;
  }
}

/* End of file LevelModel.php */
/* Location: ./application/models/pengaturan/LevelModel.php */