<?php
defined('BASEPATH') OR die('No direct script access allowed!');

class Cuti extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        is_login();
        redirect_if_level_not('Manager');
        $this->load->model('Karyawan_model', 'karyawan');
        $this->load->model('Divisi_model', 'divisi');
        $this->load->model('Cuti_model', 'cuti');
    }

    public function index()
    {
        
        $data['divisi'] = $this->divisi->get_all();
        return $this->template->load('template', 'cuti/index', $data);
    }
    public function getKaryawan()
    {
       
        $karyawan_id = $this->input->post('id',TRUE);
        $data = $this->karyawan->get_sub_category($karyawan_id)->result();
        echo json_encode($data);
    }

    public function create()
    {
        
        $data['divisi'] = $this->divisi->get_all();
        return $this->template->load('template', 'karyawan/create', $data);
    }

    public function store(){
        
       
        $this->form_validation->set_rules('divisi', 'Divisi', 'required');
        $this->form_validation->set_rules('karyawan', 'Karyawan', 'required');
        $this->form_validation->set_rules('jenis_cuti', 'Jenis Cuti', 'required');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'required');
        
        $this->form_validation->set_error_delimiters("<span class='text-warning' style='color:red;'>", "</span>");

        if($this->form_validation->run() != false) {
            $post = $this->input->post();
            $data = [
                
                'id_user' => $post['karyawan'], 
                'jenis_cuti' => $post['jenis_cuti'],
                'tanggal'   => $post['tanggal'],
                'keterangan' => $this->template->removeSpecialChapr(filter_var($post['keterangan'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)),
            ];
            $result = $this->cuti->insert_data($data);
            if ($result) {
                $response = [
                    'status' => 'success',
                    'message' => 'Data Cuti telah ditambahkan!'
                ];
               
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Data Cuti gagal ditambahkan'
                ];
                
            }
            $this->session->set_flashdata('response', $response);
            $output['error'] = true;
            echo json_encode($output);

            
        }
        else{
             $output['error'] = false;
             $output['divisi'] = form_error('divisi');
             $output['karyawan'] = form_error('karyawan');
             $output['jenis_cuti'] = form_error('jenis_cuti');
             $output['keterangan'] = form_error('keterangan');
             echo json_encode($output);
        }
        
    }
    public function store2()
    {
        $post = $this->input->post();
        $data = [
            'divisi' => $post['divisi'],
            'karyawan' => $post['karyawan'],
            'jenis_cuti' => $post['jenis_cuti'],
            'karyawan' => $post['karyawan'],
        ];

        $result = $this->karyawan->insert_data($data);
        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Data karyawan telah ditambahkan!'
            ];
            $redirect = 'karyawan/';
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data karyawan gagal ditambahkan'
            ];
            $redirect = 'karyawan/create';
        }
        
        $this->session->set_flashdata('response', $response);
        redirect($redirect);
    }

    public function edit()
    {
        $id_user = $this->uri->segment(3);
        $data['karyawan'] = $this->karyawan->find($id_user);
        $data['divisi'] = $this->divisi->get_all();
        return $this->template->load('template', 'karyawan/edit', $data);
    }

    public function update()
    {
        $post = $this->input->post();
        $data = [
            'nik' => $post['nik'],
            'nama' => $post['nama'],
            'telp' => $post['telp'],
            'divisi' => $post['divisi'],
            'email' => $post['email'],
            'username' => $post['username'],
        ];

        if ($post['password'] !== '') {
            $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }

        $result = $this->karyawan->update_data($post['id_user'], $data);
        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Data Karyawan berhasil diubah!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Karyawan gagal diubah!'
            ];
        }
        
        $this->session->set_flashdata('response', $response);
        redirect('karyawan');
    }

    public function destroy()
    {
        $id_user = $this->uri->segment(3);
        $result = $this->karyawan->delete_data($id_user);
        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Data karyawan berhasil dihapus!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data karyawan gagal dihapus!'
            ];
        }
        
        header('Content-Type: application/json');
        echo $response;
    }
}



/* End of File: d:\Ampps\www\project\absen-pegawai\application\controllers\Karyawan.php */