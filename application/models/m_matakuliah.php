<?php

class M_matakuliah extends CI_Model {
    public function tampil_data() {
        return $this->db->get('mata_kuliah');
    }
    
    public function input_data($data) {
        $this->db->insert('mata_kuliah', $data);
    }

    public function hapus_data($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function update_matkul($where, $data, $table){
        $this->db->where($where);
        $this->db->update($table, $data);
    }
}