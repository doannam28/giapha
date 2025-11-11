<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drag extends Admin_Controller
{
    protected $_data;
    protected $_data_product;
    protected $_logs;
    protected $type;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['drag_model','product_model','logs_model']);
        $this->_data          = new Drag_model();
        $this->_data_product          = new Product_model();
        $this->_logs          = new Logs_model();

        $this->type           = $this->uri->segment(3);
    }

    public function index($data){
        $data['list_date_logs_drag'] = $this->_logs->getDateLogsDrag('drag_'.$this->type);
        $data['logs_today'] = $this->_logs->getDataLogsToday('drag_'.$this->type);

        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function home_featured(){
        $data['heading_title'] = "Nổi bật trang chủ";
        $data['heading_type'] = "home_featured";
        $data['heading_description'] = "Nổi bật trang chủ";
        $data['dragInfo'] = $this->_data->getDataPostFeatured($this->type);
        $this->index($data);
    }
    
    public function save_drag(){
        $input = $this->input->post()['s'];
        $type  = $this->input->post('type');
        foreach ($input as $k => $value){
            $input[$k]['order'] = $k;
            $input[$k]['post_id'] = $value['id'];
            if(!empty($value['content'])) $input[$k]['content'] = $value['content'];
            $input[$k]['type'] = $type;
            
            unset($input[$k]['id']);
        }
        $this->_data_product->delete(['type' => $type],'post_setting');
        if ($this->_data_product->insertMultiple($input,'post_setting')){
            $note   = "Update drag $type";
            $this->addLogaction('drag_'.$type,$input,'',$note,'Update');
            echo 1;
        } else {
            echo 0;
        };

        if ($type == 'home_featured' || $type == 'tournament') {
            shell_exec("curl ".BASE_URL."cache/delete/homepage");
        }
        if ($type == 'soikeo_featured' || $type == 'top_facts') {
            shell_exec("curl ".BASE_URL."cache/delete/cache_box_soikeo");
        }

        if ($type == 'video_featured') {
            shell_exec("curl ".BASE_URL."cache/delete/video_box_home");
        }

    }

    public function ajax_load_logs_drag()
    {
        $id           = $this->input->post('id');
        $type         = $this->input->post('type');
        $dataRes      = $this->_logs->getDataLogsDragById($id,'drag_'.$type);
        $data['data'] = json_decode($dataRes->data);
        $data_html    = $this->load->view($this->template_path . 'drag/load_logs_drag', $data, TRUE);
        $user         = getByIdUser($dataRes->uid);
        $data_mess = array(
            'html' => $data_html,
            'user' => $user->username,
        );
        die(json_encode($data_mess));
    }
    /*end drag*/

    public function ajax_load(){
        $term = $this->input->get("q");
        $id = $this->input->get('id')?$this->input->get('id'):0;
        $params = [
            'is_status'=> 1,
            'not_in' => ['id' => $id],
            'search' => $term,
            'limit'=> 20
        ];
        $data = $this->_data_product->getData($params);
        $output = [];
        if(!empty($data)) foreach ($data as $item) {
            $output[] = ['id'=>$item->id, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }

    public function ajax_load_topfacts()
    {
        $term = $this->input->get("q");
        $id = $this->input->get('id')?$this->input->get('id'):0;
        $params = [
            'search' => $term,
            'limit'=> 20,
            'type'=> 'soikeo',
            'is_status'=> 1
        ];
        $data = $this->_data_product->getData($params);
        $output = [];
        if(!empty($data)) foreach ($data as $item) {
            $output[] = ['id'=>$item->id, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }

    public function ajax_load_video()
    {
        $term = $this->input->get("q");
        $params = [
            'search' => $term,
            'limit'=> 20
        ];
        $data = $this->video->getDataVideo($params);
        $output = [];
        if(!empty($data)) foreach ($data as $item) {
            $output[] = ['id'=>$item->id, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }

    public function ajax_load_tournament()
    {
        $term = $this->input->get("q");
        $params = [
            'search' => $term,
            'order' => array("order" => "ASC"),
            'limit'=> 20
        ];
        $data = $this->tournament->getDataFE($params);
        $output = [];
        if(!empty($data)) foreach ($data as $item) {
            $output[] = ['id'=>$item->id, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }

}