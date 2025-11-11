<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends Admin_Controller
{
    protected $_data;
    protected $category_tree;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model(['category_model']);
        $this->_data = new Category_model();
        $this->load->helper(['url', 'form']);
        $this->load->library('upload');
    }

    public function get_list($data)
    {
        $this->session->set_userdata('type', $this->_method);
        $data['upload_image'] = $this->load->view($this->template_path . 'uploadImage' . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function product()
    {
        $data['heading_title'] = "Danh mục sản phẩm";
        $data['heading_description'] = "Danh sách sản phẩm";
        $this->get_list($data);
    }

    public function post()
    {
        $data['heading_title'] = "Danh mục tin tức";
        $data['heading_description'] = "Danh sách tin tức";
        $this->get_list($data);
    }
    public function news()
    {
        $data['heading_title'] = "Danh mục tin tức";
        $data['heading_description'] = "Danh sách";
        $this->get_list($data);
    }
    public function page()
    {
        $this->session->set_userdata('type', $this->_method);
        $data['heading_title'] = "Quản lý Trang";
        $data['heading_description'] = "Danh sách";
        $this->get_list($data);
    }
    public function events()
    {
        $this->session->set_userdata('type', $this->_method);
        $data['heading_title'] = "Quản lý Sự kiện";
        $data['heading_description'] = "Danh sách";
        $data['upload_image'] = $this->load->view($this->template_path . 'uploadImage' . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . 'events', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function _queue($categories, $parent_id = 0, $char = '')
    {
        if (!empty($categories)) foreach ($categories as $key => $item) {
            if ($item->parent_id == $parent_id) {
                $tmp['title'] = $char . $item->title;
                $tmp['value'] = $item;
                $this->category_tree[] = $tmp;
                unset($categories[$key]);
                $this->_queue($categories, $item->id, $char . '  ' . $item->title . ' <i class="fa fa-fw fa-caret-right"></i> ');
            }
        }
    }

    public function _queue_select($categories, $parent_id = 0, $char = '')
    {
        if (!empty($categories)) foreach ($categories as $key => $item) {
            if ($item->parent_id == $parent_id) {
                $tmp['title'] = $parent_id ? '  |--' . $char . $item->title : $char . $item->title;
                $tmp['id'] = $item->id;
                $tmp['thumbnail'] = $item->thumbnail;
                $this->category_tree[] = $tmp;
                unset($categories[$key]);
                $this->_queue_select($categories, $item->id, $char . '--');
            }
        }
    }



    public function ajax_list()
    {
        $this->checkRequestPostAjax();
        $data = array();
        $pagination = $this->input->post('pagination');
        $page = $pagination['page'];
        $total_page = isset($pagination['pages']) ? $pagination['pages'] : 1;
        $limit = !empty($pagination['perpage']) && $pagination['perpage'] > 0 ? $pagination['perpage'] : 1;
        $type = $this->session->userdata('type');
        $queryFilter = $this->input->post('query');

        $params = [
            'parent_id' => !empty($queryFilter['category_id']) ? $queryFilter['category_id'] : '',
            'type'      => $type,
            'limit'     => $limit,
            'order'     => ['id' => 'desc']
        ];

        if (!empty($queryFilter['is_status']) && $queryFilter['is_status'] !== '')
            $params = array_merge($params, ['is_status' => $queryFilter['is_status']]);

        $listData = $this->_data->getData($params);
        $offset = ($page - 1) * $limit;
        if (!empty($listData)) foreach ($listData as $key => $category) {
            $item = $category;
            $title = $category->title;
            $row = array();
            $row['checkID'] = $item->id;
            $row['id'] = $offset + $key + 1;
            $row['title'] = $title;
            $row['is_featured']  = $item->is_featured;
            $row['parent_id']  = $item->parent_id;
            if ($item->parent_id == 1) {
                $row['type'] = 'Hình ảnh';
            };
            if ($item->parent_id == 2) {
                $row['type'] = 'Video';
            };
            $row['order']  = $item->order;
            $row['is_status']    = $item->is_status;
            $row['updated_time'] = $item->updated_time;
            $row['created_time'] = $item->created_time;

            $data[] = $row;
        }



        $output = [
            "meta" => [
                "page"      => $page,
                "pages"     => $total_page,
                "perpage"   => $limit,
                "total"     => $this->_data->getTotal($params),
                "sort"      => "asc",
                "field"     => "id"
            ],
            "data" =>  $data
        ];

        $this->returnJson($output);
    }
    public function ajax_load_year_and_country($parent_id)
    {
        $data_category = $this->_data->getAllCategoryByType('phim', $parent_id);
        $output = [];
        if (!empty($data_category)) foreach ($data_category as $item) {
            $output[] = ['id' => $item->id, 'text' => $item->title];
        }
        $this->returnJson($output);
    }
    public function ajax_load($type = '')
    {
        $term = $this->input->get("q");
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        if (empty($type)) $this->session->userdata('type');
        $params = [
            'type' => !(empty($type)) ? $type : 'product',
            'is_status' => 1,
            'limit' => 2000
        ];
        $list = $this->_data->getData($params);
        $this->_queue_select($list);
        $listTree = $this->category_tree;
        if (!empty($term)) {
            $searchword = $term;
            $matches = array();
            foreach ($listTree as $k => $v) {
                if (preg_match("/\b$searchword\b/i", $v['title'])) {
                    $matches[$k] = $v;
                }
            }
            $listTree = $matches;
        }
        $output = [];
        if (!empty($listTree)) foreach ($listTree as $item) {
            $item = (object) $item;
            $output[] = ['id' => $item->id, 'text' => $item->title];
        }
        $this->returnJson($output);
    }

    public function ajax_add()
    {
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        if ($id = $this->_data->save($data)) {
            $note   = 'Thêm category có id là : ' . $id;
            $this->addLogaction('category', $data, $id, $note, 'Add');
            $message['type'] = 'success';
            $message['message'] = "Thêm mới thành công !";
            $this->delete_cache_all();
        } else {
            $message['type'] = 'error';
            $message['message'] = "Thêm mới thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_edit()
    {
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        if (!empty($id)) {
            $output['data_info'] = $this->_data->single(['id' => $id], $this->_data->table);
            $output['data_category'] = $this->_data->getSelect2($output['data_info']->parent_id);
            $this->returnJson($output);
        }
    }

    public function ajax_update()
    {
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        $id = $data['id'];
        $data_old = $this->_data->single(['id' => $id], $this->_data->table);
        if ($this->_data->update(['id' => $id], $data, $this->_data->table)) {
            $note   = 'Update category có id là : ' . $id;
            $this->addLogaction('category', $data_old, $id, $note, 'Update');
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
            $this->delete_cache_all();
        } else {
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_update_field()
    {
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        $response = $this->_data->update(['id' => $id], [$field => $value]);
        if ($response != false) {
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
            $this->delete_cache_all();
        } else {
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_delete()
    {
        $this->checkRequestPostAjax();
        $ids = (int)$this->input->post('id');
        $response = $this->_data->deleteArray('id', $ids);
        if ($response != false) {
            $message['type'] = 'success';
            $message['message'] = "Xóa thành công !";
            $this->delete_cache_all();
        } else {
            $message['type'] = 'error';
            $message['message'] = "Xóa thất bại !";
            log_message('error', $response);
        }
        $this->returnJson($message);
    }

    private function _validation()
    {
        $this->checkRequestPostAjax();
        $rules = [
            [
                'field' => "title",
                'label' => "Tiêu đề",
                'rules' => "trim|required"
            ]
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $message['type'] = "warning";
            $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
            $valid = array();
            if (!empty($rules)) foreach ($rules as $item) {
                if (!empty(form_error($item['field']))) $valid[$item['field']] = form_error($item['field']);
            }
            $message['validation'] = $valid;
            $this->returnJson($message);
        }
    }

    private function _convertData()
    {
        $this->_validation();
        $data = $this->input->post();
        $data['type'] = $this->session->userdata('type');
        if (!empty($data['is_status'])) $data['is_status'] = 1;
        else $data['is_status'] = 0;
        if (empty($data['parent_id'])) $data['parent_id'] = 0;
        if (empty($data['slug'])) $data['slug'] = $this->toSlug($data['title']);
        if (!empty($data['album'])) $data['album'] = json_encode($data['album']);
        return $data;
    }
    public function multifile()
    {
        $response = ['status' => 'error', 'message' => 'No files uploaded.'];

        if (!empty($_FILES['files']['name'][0])) {
            $uploadPath = './uploads/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $uploadedFiles = [];
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                // Lấy phần mở rộng của file
                $fileExt = pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION);

                // Tạo tên file ngắn gọn (ví dụ: file_abc123.jpg)
                $newFileName = 'file_' . uniqid() . '.' . $fileExt;

                $_FILES['file']['name'] = $newFileName;
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048; // 2MB
                $config['file_name'] = $newFileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    // Thêm đường dẫn đầy đủ của file đã upload thành công
                    $uploadedFiles[] = base_url("uploads/") . $newFileName;
                } else {
                    // Trả về lỗi và dừng
                    $response['message'] = $this->upload->display_errors();
                    echo json_encode($response);
                    return;
                }
            }

            if (!empty($uploadedFiles)) {
                $response = [
                    'status' => 'success',
                    'files' => $uploadedFiles
                ];
            }
        }

        $this->returnJson($response);
    }
}
