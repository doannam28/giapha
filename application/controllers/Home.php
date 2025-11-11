<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Public_Controller
{
    protected $_menu;
    protected $_category;
    protected $_page;
    protected $_post;
    protected $_customer;
    protected $_banner;
    protected $_family;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Menus_model', 'Category_model', 'Post_model', 'Page_model', 'Customer_model', 'Banner_model', 'Family_model', 'Graduate_model', 'Fund_model']);
        $this->_menu = new Menus_model();
        $this->_post = new Post_model();
        $this->_page = new Page_model();
        $this->_category = new Category_model();
        $this->_customer = new Customer_model();
        $this->_banner = new Banner_model();
        $this->_family = new Family_model();
        $this->_graduate = new Graduate_model();
        $this->_fund = new Fund_model();
    }

    public function index()
    {
        $this->setCacheFile(60);

        $data = [];
        $data['class_css'] = 'about';
        $data['title'] = 'Giới thiệu về Họ Hoàng';
        $data['content_page'] = $this->_category->getByField('slug', 'gioi-thieu')->content;
        $data['content_intro'] =  $this->load->view($this->template_path . 'intro/intro', $data, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'intro/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function jobs($current_page = 1)
    {
        $data = [];
        $data['class_css'] = 'about';
        $data['title'] = 'Ngành nghề Họ Hoàng';
        $array_data = array();
        $per_page = 8; // Number of records per page
        $data['offset'] = $offset = ($current_page - 1) * $per_page; // Calculate offset

        // Fetch total records and paginated records
        $total_records = $this->_family->count_by_type(); // Implement count_by_type in your model
        $list = $this->_family->get_by_type_paginated($per_page, $offset, 'jobs'); // Implement get_by_type_paginated in your model
        foreach ($list as $user) {
            $row = array();
            $father = $this->_family->getByField('id', $user['father_id']);
            $mother = $this->_family->getByField('id', $user['mother_id']);
            $row['fullname'] = $user['full_name'];
            $row['parent_id'] = $user['parent_id'];
            $row['job_title'] = $user['job_title'];
            $row['phone'] = $user['phone'];
            $row['father_name'] = $father->full_name ?? '';
            $row['mother_name'] = $mother->full_name ?? '';
            $array_data[] = $row;
        }
        $data['list_person'] = $array_data;
        $data['pagination'] = $this->generate_pagination(base_url('nganh-nghe'), $total_records, $per_page, $current_page);
        $data['main_content'] = $this->load->view($this->template_path . 'jobs/index', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
    public function rank($current_page = 1)
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['title'] = 'Bảng vàng Họ Hoàng';
        $per_page = 8;
        $data['offset'] = $offset = ($current_page - 1) * $per_page; // Calculate offset

        // Fetch total records and paginated records
        $listAllRank = $this->_family->getAllRankByUserId($per_page, $offset);
        $total_records = $this->_family->countAllRank();
        $data['list_rank'] = $listAllRank;

        $data_post = $this->_post->getDataPostByCategory([4], 1, 10);
        $data['posts'] = $data_post;
        $data['pagination'] = $this->generate_pagination(base_url('bang-vang'), $total_records, $per_page, $current_page);
        $data['main_content'] = $this->load->view($this->template_path . 'rank/index', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
    public function contact()
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['title'] = 'Thông tin liên hệ';
        $data['main_content'] = $this->load->view($this->template_path . 'contact/index', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
    public function files($type = '', $current_page = 1)
    {
        if ($type == '') {
            $data = [];
            $data['class_css'] = 'top';
            $data['title'] = "Trang không tồn tại";
            $data['main_content'] = $this->load->view($this->template_path . 'home/notfound', $data, TRUE);
            $this->setCacheFile(60);
            $this->load->view($this->template_main, $data);
        }
        $data = [];
        $data['class_css'] = 'top';
        $data['type'] = $type;
        $data['title'] = 'Tài liệu Họ Hoàng';
        $per_page = 9; // Number of records per page
        $data['offset'] = $offset = ($current_page - 1) * $per_page; // Calculate offset

        // Fetch total records and paginated records
        $total_records = $this->_category->count_by_type($type == 'video' ? 2 : 1); // Implement count_by_type in your model
        $data['list_file'] = $this->_category->get_by_type_paginated($type == 'hinh-anh' ? 1 : 2, $per_page, $offset);
        $data['pagination'] = $this->generate_pagination(base_url('tai-lieu/' . $type), $total_records, $per_page, $current_page);
        $data['main_content'] = $this->load->view($this->template_path . 'files/index', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
    public function detail_files($type, $slug)
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['type'] = $type;
        $data['detail'] = $detail = $this->_category->getByField('slug', $slug);
        if (!empty($_GET['debug'])) dd($slug);
        $data['title'] = $data['detail']->title;
        
        $data['main_content'] = $this->load->view($this->template_path . 'files/detail', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
    public function fund($type, $current_page = 1)
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['title'] = "Danh sách Quỹ";
        $data['type'] = $type;
        $short = '';
        $list_fund = [];

        if ($type == 'quy-khuyen-hoc') {
            $short = 'QKH';
        } elseif ($type == 'quy-dong-ho') {
            $short = 'QDH';
        } else {
            $short = 'Chi';
        }

        // Pagination setup
        $per_page = 10; // Number of records per page
        $data['offset'] = $offset = ($current_page - 1) * $per_page; // Calculate offset

        // Fetch total records and paginated records
        $total_records = $this->_fund->count_by_type($short); // Implement count_by_type in your model
        $list_data = $this->_fund->get_by_type_paginated($short, $per_page, $offset); // Implement get_by_type_paginated in your model

        foreach ($list_data as $fund) {
            $row = [];
            $person = $this->_family->getByField('id', $fund['user_id']);
            $row['person_name'] = !empty($person) ? $person->full_name : '';
            $row['description'] = $fund['description'];
            $row['title'] = $fund['title'];
            $row['money'] = number_format($fund['total_money'], 0, '.', '.') . ' VNĐ';
            $row['created_at'] = $fund['created_at'];
            $list_fund[] = $row;
        }

        // Prepare data for view
        $data['list_fund'] = $list_fund;
        $data['pagination'] = $this->generate_pagination(base_url('quan-ly-quy/' . $type), $total_records, $per_page, $current_page);
        $data['main_content'] = $this->load->view($this->template_path . 'fund/index', $data, TRUE);

        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }

    // Generate pagination links
    private function generate_pagination($link = '', $total_records, $per_page, $current_page = 1)
    {
        // phân Trang
        $this->load->library('pagination');
        $paging['base_url'] = $link;
        $paging['first_url'] = $link;
        $paging['total_rows'] = $total_records;
        $paging['per_page'] = $per_page;
        $paging['this_page'] = $current_page;
        $paging['all_page'] = ceil($total_records / $per_page);
        $this->pagination->initialize($paging);
        return $this->pagination->create_links();
        // end phân Trang
    }

    public function khumo()
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['title'] = "Khu mộ";
        $data['main_content'] = $this->load->view($this->template_path . 'khumo/index', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
}
