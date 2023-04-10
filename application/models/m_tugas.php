<?php

class M_tugas extends CI_Model {
    public function tampil_data() {
        return $this->db->get('tugas');
    }

    public function input_data($data) {
        $this->db->insert('tugas', $data);
    }

    public function hapus_data($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function hapus_data_matkul($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function update_sudahselesai($where, $data, $table) {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
}