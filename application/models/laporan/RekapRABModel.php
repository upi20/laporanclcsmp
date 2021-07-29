<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RekapRABModel extends Render_Model
{

    public function rekapRabCabangs($tahun = null, $month_start = null, $month_end = null)
    {

        $tahun = $tahun ? $tahun : date("Y");
        $month_start = $month_start ? $month_start : 1;
        $month_end = $month_end ? $month_end : 12;
        $results = [];
        // get all cabangs
        $cabangs = $this->db->select("a.id, a.kode, a.nama")
            ->from("cabangs a")
            ->get()
            ->result_array();

        // jika cabang belum dibuat
        $cabangs = $cabangs ? $cabangs : [
            [
                'id' => 0,
                'kode' => 0,
                'nama' => 0
            ]
        ];

        foreach ($cabangs as $cabang) {
            $id_cabang = $cabang['id'];
            // set detail cabang
            $result = [
                'id_cabang' => $id_cabang,
                'kode' => $cabang['kode'],
                'nama' => $cabang['nama']
            ];

            // get jumlah anggaran
            $anggaran = $this->getJumlahAnggaranByCabang($id_cabang, $tahun, $month_start, $month_end);
            $result['anggaran'] = $anggaran;

            // get data perbulan
            $realisasi = [];
            $jml_pengeluaran = 0;
            for ($bulan = $month_start; $bulan <= $month_end; $bulan++) {
                $realisasi_bulan = $this->getRealisasiPerBulanByCabang($id_cabang, $tahun, $bulan);
                $realisasi[$bulan] = $realisasi_bulan;
                $jml_pengeluaran += $realisasi_bulan;
            }
            $result['realisasi'] = $realisasi;

            // get jumlah pengeluaran
            $result['pengeluaran'] = $jml_pengeluaran;

            // get saldo
            $result['saldo']  = $anggaran - $jml_pengeluaran;

            // finish
            $results[] = $result;
        }

        return $results;
    }

    private function getJumlahAnggaranByCabang($id_cabang, $tahun, $month_start, $month_end)
    {
        $tahun_next = $tahun;

        if (($month_start == 1 && $month_end == 12) || ($month_start == 7 && $month_end == 12)) {
            $tahun_next = (int)$tahun + 1;
            $month_end = 1;
        }
        if ($month_start == 1 && $month_end == 6) {
            $month_end += 1;
        }

        $month_start = $this->addZero($month_start);
        $month_end = $this->addZero($month_end);

        // debuging query tanggal
        // var_dump("a.created_date >= '$tahun-$month_start-01'");
        // var_dump("a.created_date < '$tahun_next-$month_end-01'");

        // die;
        $result = $this->db->select_sum("a.total_harga_ringgit")
            ->from("rabs a")
            ->where("a.id_cabang = '$id_cabang'")
            ->where("a.created_date >= '$tahun-$month_start-01'")
            ->where("a.created_date < '$tahun_next-$month_end-01'")
            ->get()
            ->row_array();
        $this->db->reset_query();
        return isset($result['total_harga_ringgit']) ? (int)$result['total_harga_ringgit'] : 0;
    }

    private function addZero($value)
    {
        return ((int)$value < 10) ? 0 . $value : $value;
    }

    private function getRealisasiPerBulanByCabang($id_cabang, $tahun, $bulan)
    {
        // ubah bulan jadi ada 0 nya
        $bulan_next = $bulan + 1;
        $bulan_next = $bulan_next < 10 ? "0" . $bulan_next : $bulan_next;
        $bulan = $bulan < 10 ? "0" . $bulan : $bulan;

        // eksekusi query
        $result = $this->db->select_sum("a.harga_ringgit")
            ->from("realisasis a")
            ->where("a.id_cabang = '$id_cabang'")
            ->where("(a.tanggal >= '$tahun-$bulan-01' and a.tanggal < '$tahun-$bulan_next-01')")
            ->get()
            ->row_array();
        $this->db->reset_query();

        return isset($result['harga_ringgit']) ? (int)$result['harga_ringgit'] : 0;
    }
}

/* End of file LevelModel.php */
/* Location: ./application/models/pengaturan/LevelModel.php */