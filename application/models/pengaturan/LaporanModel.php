<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanModel extends Render_Model
{
    public function getData()
    {

        $data =  $this->db->get("pengaturan_laporan")->row_array();

        if (!$data) {

            // default pengaturan laporan
            $data = [
                "id" => "1",
                "kepala_nama" => "Dadang Hermawan, M.Ed.",
                "kepala_nip" => "19700731 199803 1 005",
                "kas_nama" => "Dede Kurniawan, S.Pd.",
                "kas_nip" => "-",
                "kota" => "Kinabalu"
            ];
            $this->db->insert('pengaturan_laporan', $data);
        }
        return $data;
    }

    public function setData($kepala_sekolah, $nip_kepala_sekolah, $pemegang_kas, $nip_pemegang_kas, $kota)
    {
        $data = [
            "kepala_nama" => $kepala_sekolah,
            "kepala_nip" => $nip_kepala_sekolah,
            "kas_nama" => $pemegang_kas,
            "kas_nip" => $nip_pemegang_kas,
            "kota" => $kota
        ];

        return $this->db->update("pengaturan_laporan", $data);
    }
}
