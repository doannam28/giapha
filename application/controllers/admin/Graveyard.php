<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Graveyard extends Admin_Controller
{


    protected $_setting;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['setting_model']);
        $this->_setting  = new Setting_model();
    }


    public function index()
    {
        $data['heading_title'] = "Quản lý khu mộ ";
        $data['heading_description'] = "Khu mộ dòng họ";

        $data_graveyard = $this->_setting->get_setting_by_key('data_graveyard');
        $data['data_graveyard'] = !empty($data_graveyard) ? json_decode($data_graveyard->value_setting) : '';


        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
