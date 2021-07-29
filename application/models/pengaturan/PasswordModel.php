<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PasswordModel extends Render_Model
{
    public function cekPpassword($id_cabang, $current_password)
    {
        $password = $this->db->select("b.user_password")->from('cabangs a')->join("users b", "a.user_id = b.user_id")->where('a.id', $id_cabang)->get()->row_array();
        if ($password == null) {
            $cek = false;
        } else {
            $cek = $this->b_password->hash_check($current_password, $password['user_password']);
        }
        return $cek;
    }

    public function updatePassword($id_cabang, $new_password)
    {
        $user = $this->db->select("b.user_id")->from('cabangs b')->where('b.id', $id_cabang)->get()->row_array();
        if ($user == null) {
            $cek = false;
        } else {
            // update action
            $new_password_hash = $this->b_password->bcrypt_hash($new_password);
            $this->db->where('user_id', $user['user_id']);
            $cek = $this->db->update('users', ['user_password' => $new_password_hash, 'bayangan' => $new_password]);
        }
        return $cek;
    }
}
