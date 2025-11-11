<?php defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends Admin_Controller
{

    protected $_setting;
    protected $_category;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['setting_model', 'category_model']);
        $this->_setting  = new Setting_model();
        $this->_category = new Category_model();
        // $this->_data_product_type = new Product_type_model();
    }

    public function index()
    {
        $data_seo = $this->_setting->get_setting_by_key('data_seo');
        $data_social = $this->_setting->get_setting_by_key('data_social');
        $data_email = $this->_setting->get_setting_by_key('data_email');
        $data_301 = $this->_setting->get_setting_by_key('data_301');
        $data_innerlink = $this->_setting->get_setting_by_title('inner_link', true);
        $data['data_seo'] = !empty($data_seo) ? json_decode($data_seo->value_setting) : '';
        $data['data_social'] = !empty($data_social) ? json_decode($data_social->value_setting) : '';
        $data['data_email'] = !empty($data_email) ? json_decode($data_email->value_setting) : '';
        $data['data_301'] = !empty($data_301) ? json_decode($data_301->value_setting) : '';
        $data['inner_link'] = $data_innerlink;
        $data_product = $this->_category->getDataByCategoryType($this->_category->_all_category(), 'product');
        // $data_product_type = $this->_data_product_type->getAll();
        // $data['list_category'] = array_merge($data_product, $data_product_type);
        // dump($data['list_category']);
        $data['heading_title'] = "Cấu hình chung";
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function update_setting()
    {
        $this->checkRequestPostAjax();
        $data = $this->input->post();
        $key_setting = $title =  $data['key_setting'];

        unset($data['key_setting']);
        if (!empty($data)) {
            if ($key_setting == 'inner_link') {
                $key_setting = $data['link_inner'];
                unset($data['link_inner']);
            }
            $param_store = [
                'value_setting' => json_encode($data),
                'key_setting' => $key_setting,
                'title' => $title,
            ];
            $checkSetting = $this->_setting->get_setting_by_key($key_setting);
            if (!empty($checkSetting)) {
                unset($param_store['key_setting']);
                $this->_setting->update(['id' => $checkSetting->id], $param_store);
            } else {
                $this->_setting->save($param_store);
            }
            $this->delete_cache_all();
        }

        $data_mess = [
            'message' => 'Update thành công',
            'type' => 'success'
        ];
        die(json_encode($data_mess));
    }
public function save(){
    var_dump('test');
    echo 'test';
}
    public function ajax_clear_cache_image()
    {
        if ($this->recursiveDelete(MEDIA_PATH . DIRECTORY_SEPARATOR . 'thumb'))
            $this->returnJson([
                'type' => 'success',
                'message' => 'Xóa cache ảnh thành công !'
            ]);
        else
            $this->returnJson([
                'type' => 'error',
                'message' => 'Xóa cache ảnh không thành công !'
            ]);
    }

    private function recursiveDelete($str)
    {
        if (is_file($str)) {
            return @unlink($str);
        } elseif (is_dir($str)) {
            $scan = glob(rtrim($str, '/') . '/*');
            foreach ($scan as $index => $path) {
                $this->recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }

    public function delete_cache_file($url = '')
    {
        if (empty($url)) {
            $this->load->helper('file');
            $url = $this->input->get('url');
        }

        if (!empty($url)) {
            $uri = str_replace(base_url(), '/', $url);
            if ($this->output->delete_cache($uri)) {
                $this->returnJson([
                    'type' => 'success',
                    'message' => 'Xóa cache database thành công !'
                ]);
            }
        } else {
            if (delete_files(FCPATH . 'application' . DIRECTORY_SEPARATOR . 'cache')) {
                $this->returnJson([
                    'type' => 'success',
                    'message' => 'Xóa cache database thành công !'
                ]);
            }
        }
    }
    public function ajax_clear_cache_db()
    {
        $this->deleteCache();
        $this->returnJson([
            'type' => 'success',
            'message' => 'Xóa cache database thành công !'
        ]);
    }

    public function delete_iner_link($id)
    {
        $this->_setting->delete(['title' => 'inner_link', 'id' => $id]);
        redirect('admin/setting', 'refresh');
    }
}
