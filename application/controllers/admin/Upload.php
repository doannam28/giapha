<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function do_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048; // Giới hạn 2MB
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')) {
            echo json_encode([
                'success' => false,
                'error' => $this->upload->display_errors()
            ]);
        } else {
            $data = $this->upload->data();
            echo json_encode([
                'success' => true,
                'file_path' => base_url('uploads/' . $data['file_name'])
            ]);
        }
    }
}
