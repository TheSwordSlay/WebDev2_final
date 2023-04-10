<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function index()
	{
		$data1['matakuliah'] = $this->m_matakuliah->tampil_data()->result();
		$data2['tugas'] = $this->m_tugas->tampil_data()->result();
		$data = array_merge($data1, $data2);
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar', $data);
		$this->load->view('list_tugas', $data);
		$this->load->view('templates/footer', $data);
	}

	public function tambah_matkul() {
		$matakuliah = $this->input->post();
		$warna = rand(1,4);
		
		$data = array(
			'mata_kuliah' => $matakuliah['matakuliah'],
			'warna' => $warna
		);
		
		$this->m_matakuliah->input_data($data, 'mata_kuliah');
		redirect('#');
	}

	public function tambah_tugas() {
		$tugas = $this->input->post();
		$data = array(
			'mata_kuliah' => $tugas['matakuliah'],
			'nama_tugas' => $tugas['namatugas'],
			'deskripsi' => $tugas['deskripsi'],
			'sudah_selesai' => 'Belum'
		);
		
		$this->m_tugas->input_data($data, 'tugas');
		redirect('#');
	}

	public function hapustugas($id) {
		$where = array ('id' => $id);
		$this->m_tugas->hapus_data($where, 'tugas');
		redirect('#');
	}

	public function hapusmatkul($matakuliah) {
		$replaced = str_replace('%20', ' ', $matakuliah);
		$where = array ('mata_kuliah' => $replaced);
		$this->m_matakuliah->hapus_data($where, 'mata_kuliah');
		$this->m_tugas->hapus_data_matkul($where, 'tugas');
		redirect('#');
	}

	public function sudahtugas($id) {
		$where = array ('id' => $id);
		$sudahbelum = "Sudah";
		$data = array(
			'sudah_selesai' => $sudahbelum
		);

		$where = array (
			'id' => $id
		);

		$this->m_tugas->update_sudahselesai($where, $data, 'tugas');
		redirect('#');

	}

	public function belumtugas($id) {
		$where = array ('id' => $id);
		$sudahbelum = "Belum";
		$data = array(
			'sudah_selesai' => $sudahbelum
		);

		$where = array (
			'id' => $id
		);

		$this->m_tugas->update_sudahselesai($where, $data, 'tugas');
		redirect('#');

	}

	public function editmatkul() {
		$editmatkul = $this->input->post();
		$data = array(
			'mata_kuliah' => $editmatkul['matakuliahnew'],
		);

		$where = array ('mata_kuliah' => $editmatkul['matakuliahold']);
		$this->m_tugas->update_matkul($where, $data, 'tugas');
		$this->m_matakuliah->update_matkul($where, $data, 'mata_kuliah');
		redirect('#');
	}

	public function edit_tugas() {
		$edittugas = $this->input->post();
		$data = array(
			'mata_kuliah' => $edittugas['matakuliah'],
			'nama_tugas' => $edittugas['namatugas'],
			'deskripsi' => $edittugas['deskripsi'],
		);
		$where = array('id' => $edittugas['id']);
		$this->m_tugas->update_tugas($where, $data, 'tugas');
		redirect('#');
	}
}
