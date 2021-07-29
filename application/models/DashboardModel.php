<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends Render_Model
{
    public function getDataPusat()
    {
        $data['jml'] = $this->db->get('cabangs')->num_rows();
        $data['profile'] = $this->db->select('kode, no_telpon, alamat, nama')
            ->from('cabangs')
            ->where(['user_id' => $this->session->userdata('data')['id']])
            ->get()
            ->row_array();
        return ($data);
    }

    public function getDataCabang()
    {
        $data['jml'] = $this->db->get('cabangs')->num_rows();
        $data['profile'] =  $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
        return ($data);
    }

    public function updateDataCabang($id, $data)
    {
        return $this->db
            ->set($data)
            ->where('id', $id)
            ->update('cabangs');
    }
}
