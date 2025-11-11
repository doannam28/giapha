<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fund extends Admin_Controller
{
    protected $_data;
    protected $category_tree;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model(['Fund_model', 'users_model', 'Family_model']);
        $this->_data = new Fund_model();
        $this->_Family_model = new Family_model();
        $this->_user         = new Users_model();

    }

    public function get_list($data){
        $this->session->set_userdata('type',$this->_method);
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function index(){
        $data['heading_title'] = "Quản lý quỹ";
        $data['heading_description'] = "Danh sách quỹ";
        $data['users'] = $this->get_user();
        $this->get_list($data);
    }

    public function _queue($categories, $parent_id = 0, $char = ''){
        if(!empty($categories)) foreach ($categories as $key => $item)
        {
            if ($item->parent_id == $parent_id)
            {
                $tmp['title'] = $char.$item->title;
                $tmp['value'] = $item;
                $this->category_tree[] = $tmp;
                unset($categories[$key]);
                $this->_queue($categories,$item->id,$char.'  '.$item->title.' <i class="fa fa-fw fa-caret-right"></i> ');
            }
        }
    }

    public function _queue_select($categories, $parent_id = 0, $char = ''){
        if(!empty($categories)) foreach ($categories as $key => $item)
        {
            if ($item->parent_id == $parent_id)
            {
                $tmp['title'] = $parent_id ? '  |--'.$char.$item->title : $char.$item->title;
                $tmp['id'] = $item->id;
                $tmp['thumbnail'] = $item->thumbnail;
                $this->category_tree[] = $tmp;
                unset($categories[$key]);
                $this->_queue_select($categories,$item->id,$char.'--');
            }
        }
    }



    public function ajax_list() {
        $this->checkRequestPostAjax(); // Kiểm tra yêu cầu POST AJAX hợp lệ
        $data = array();
    
        // Lấy thông tin phân trang
        $pagination = $this->input->post('pagination');
        $page = $pagination['page'];
        $total_page = isset($pagination['pages']) ? $pagination['pages'] : 1;
        $limit = !empty($pagination['perpage']) && $pagination['perpage'] > 0 ? $pagination['perpage'] : 10;
    
        // Lấy bộ lọc từ query
        $queryFilter = $this->input->post('query');
    
        // Thiết lập tham số truy vấn
        $params = [
            'type'      => isset($queryFilter['type']) ? $queryFilter['type'] : '',
            'limit'     => 2000, // Giới hạn bản ghi
            'order'     => ['id' => 'desc']
        ];
    
        if (isset($queryFilter['user_id']) && $queryFilter['user_id'] !== '')
            $params['user_id'] = $queryFilter['user_id'];
    
        if (isset($queryFilter['is_status']) && $queryFilter['is_status'] !== '')
            $params['is_status'] = $queryFilter['is_status'];
    
        // Lấy toàn bộ dữ liệu
        $listAll = $this->Fund_model->getData($params);
    
        // Xử lý phân trang
        $offset = ($page - 1) * $limit;
        $listData = !empty($listAll) ? array_slice($listAll, $offset, $limit) : [];
        // Duyệt qua danh sách và chuẩn hóa dữ liệu
        foreach ($listData as $key => $item) {
            $row = array();
            $dataUser = $this->_Family_model->getByField('id',$item->user_id);
            $row['checkID']    = $item->id;
            $row['id'] = $offset + $key + 1;
            $row['title'] = $item->title;
            $row['fullname']   = !empty($dataUser->full_name) ? $dataUser->full_name : '';
            $row['description'] = $item->description;
            if ($item->type == "QKH") {
                $row['type'] = 'Quỹ Khuyến học';
            } elseif ($item->type == 'QDH') {
                $row['type'] = 'Quỹ Dòng họ';
            } else {
                $row['type'] = 'Chi tiêu';
            }
            
            $row['money'] = number_format($item->total_money, 0, '.', '.').' VNĐ';
            $row['updated_time'] = $item->updated_at;
            $row['created_time'] = $item->created_at;
            $data[] = $row;
        }
    
        // Định dạng đầu ra
        $output = [
            "meta" => [
                "page"      => $page,
                "pages"     => $total_page,
                "perpage"   => $limit,
                "total"     => count($listAll),
                "sort"      => "desc",
                "field"     => "id"
            ],
            "data" =>  $data
        ];
    
        // Trả về JSON
        $this->returnJson($output);
    }
    public function get_user () {
        $data = array();
        $listData = $this->Family_model->getAll();
        if (!empty($listData)) foreach ($listData as $item) {

            $row = array();
            $row['id'] = $item->id;
            $row['fullname'] = $item->full_name;
            $data[] = $row;
        }


        return $data;
    }
    public function ajax_load_year_and_country($parent_id)
    {
        $data_category = $this->_data->getAllCategoryByType('phim',$parent_id);
        $output = [];
        if(!empty($data_category)) foreach ($data_category as $item) {
            $output[] = ['id'=>$item->id, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }
    public function ajax_load($type = ''){
        $term = $this->input->get("q");
        $id = $this->input->get('id')?$this->input->get('id'):0;
        if(empty($type)) $this->session->userdata('type');
        $params = [
            'type' => !(empty($type)) ? $type : 'product',
            'is_status'=> 1,
            'limit'=> 2000
        ];
        $list = $this->_data->getData($params);
        $this->_queue_select($list);
        $listTree = $this->category_tree;
        if(!empty($term)){
            $searchword = $term;
            $matches = array();
            foreach($listTree as $k=>$v) {
                if(preg_match("/\b$searchword\b/i", $v['title'])) {
                    $matches[$k] = $v;
                }
            }
            $listTree = $matches;
        }
        $output = [];
        if(!empty($listTree)) foreach ($listTree as $item) {
            $item = (object) $item;
            $output[] = ['id'=>$item->id, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }
    
    public function ajax_add() {
        $this->checkRequestPostAjax(); // Kiểm tra yêu cầu POST AJAX hợp lệ
    
        // Lấy dữ liệu từ yêu cầu
        $data = $this->_convertData();
    
        // Thêm mới dữ liệu vào bảng
        if ($id = $this->Fund_model->save($data)) {
            // Ghi nhật ký hành động
            $note = 'Thêm fund có ID là: ' . $id;
            $this->addLogaction('fund', $data, $id, $note, 'Add');
    
            // Thông báo thành công
            $message = [
                'type' => 'success',
                'message' => 'Thêm mới thành công!'
            ];
    
            // Xóa cache nếu cần thiết
            $this->delete_cache_all();
        } else {
            // Thông báo lỗi nếu thêm thất bại
            $message = [
                'type' => 'error',
                'message' => 'Thêm mới thất bại!'
            ];
        }
    
        // Trả về JSON
        $this->returnJson($message);
    }
    
    
    public function ajax_edit(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        if(!empty($id)){
            $output['data_info'] = $this->_data->single(['id' => $id],$this->_data->table);
            // $output['data_category'] = $this->_data->getSelect2Category($id);
            
            $this->returnJson($output);
        }
    }

    public function ajax_update(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        $id = $data['id'];
        $data_old = $this->_data->single(['id' => $id],$this->_data->table);
        if($this->_data->update(['id' => $id],$data, $this->_data->table)){
            $note   = 'Update category có id là : '.$id;
            $this->addLogaction('category',$data_old,$id,$note,'Update');
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
            $this->delete_cache_all();
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_update_field(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        
        $response = $this->_data->update(['id' => $id], [$field => $value]);
        if($response != false){
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
            $this->delete_cache_all();
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_delete(){
        $this->checkRequestPostAjax();
        $ids = (int)$this->input->post('id');
        $response = $this->_data->deleteArray('id',$ids);
        if($response != false){
            $message['type'] = 'success';
            $message['message'] = "Xóa thành công !";
            $this->delete_cache_all();
        }else{
            $message['type'] = 'error';
            $message['message'] = "Xóa thất bại !";
            log_message('error',$response);
        }
        $this->returnJson($message);
    }

    private function _validation(){
        $this->checkRequestPostAjax();
        $rules = [
            [
                'field' => "user_id",
                'label' => "Người đóng quỹ",
                'rules' => "trim|required"
            ],
            [
                'field' => "type",
                'label' => "Loại Thu/Chi",
                'rules' => "trim|required"
            ],
            [
                'field' => "total_money",
                'label' => "Số tiền",
                'rules' => "trim|required"
            ]
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $message['type'] = "warning";
            $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
            $valid = array();
            if(!empty($rules)) foreach ($rules as $item){
                if(!empty(form_error($item['field']))) $valid[$item['field']] = form_error($item['field']);
            }
            $message['validation'] = $valid;
            $this->returnJson($message);
        };
        if (strlen($this->input->post('total_money')) > 12) {
            $message['type'] = "error";
            $message['message'] = "Số tiền không được nhập quá 12 số.";
            $this->returnJson($message);
        };
        if ($this->input->post('total_money') <= 0) {
            $message['type'] = "error";
            $message['message'] = "Số tiền không được nhỏ hơn hoặc bằng 0.";
            $this->returnJson($message);
        }
    }

    private function _convertData(){
        $this->_validation();
        $data = $this->input->post();

        return $data;
    }
}