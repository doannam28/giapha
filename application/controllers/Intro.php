<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Intro extends Public_Controller
{
    protected $_menu;
    protected $_category;
    protected $_page;
    protected $_post;
    protected $_customer;
    protected $_banner;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Menus_model', 'Category_model', 'Post_model', 'Page_model', 'Customer_model', 'Banner_model']);
        $this->_menu     = new Menus_model();
        $this->_post     = new Post_model();
        $this->_page     = new Page_model();
        $this->_category = new Category_model();
        $this->_customer = new Customer_model();
        $this->_banner   = new Banner_model();
    }

    public function index()
    {
        $this->setCacheFile(60);

        $data = [];
        $data['class_css'] = 'about';
        $oneItem = $this->_category->getByField('slug', 'gioi-thieu');
        $data['title'] = $oneItem->title;
        $data['content_page'] = $oneItem->content;

        $data['content_intro'] =  $this->load->view($this->template_path . 'intro/intro', $data, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'intro/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function history()
    {
        $this->setCacheFile(60);
        $oneItem = $this->_category->getByField('slug', 'lich-su');
        $data = [];
        $data['title'] = $oneItem->title;
        $data['content_page'] = $oneItem->content;
        $data['class_css'] = 'about';
        $data['content_intro'] =  $this->load->view($this->template_path . 'intro/history', $data, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'intro/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function home()
    {
        $this->setCacheFile(60);

        $data = [];
        $data['class_css'] = 'about';

        $oneItem = $this->_category->getByField('slug', 'tu-duong');
        $data['title'] = $oneItem->title;
        $data['content_page'] = $oneItem->content;
        $data['content_intro'] =  $this->load->view($this->template_path . 'intro/home', $data, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'intro/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function news($slug, $page = 1)
    {
        $this->setCacheFile(60);
        $data = [];
        $oneItem = $this->_category->getByField('slug', $slug);
        $data['cate_id'] = $oneItem->id ?? 0;
        $data['class_css'] = 'about';
        $data['title'] = $oneItem->title;
        $data['list_category'] = $this->_category->getAllCategoryByType('news', 0);
        if ($this->agent->is_mobile()) {
            $limit = 10;
        } else {
            $limit = 9;
        }
        // phân Trang
        $total = $this->_post->getTotalPostByCategory([$oneItem->id]);
        $data['post'] = $this->_post->getDataPostByCategory([$oneItem->id], $page, $limit);
        $this->load->library('pagination');
        $paging['base_url'] = base_url('tin-tuc/' . $slug);
        $paging['first_url'] = base_url('tin-tuc/' . $slug);
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $paging['this_page'] = $page;
        $paging['all_page'] = ceil($total / $limit);
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();
        // end phân Trang
        $data['content_intro'] =  $this->load->view($this->template_path . 'intro/news', $data, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'intro/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function search()
    {
        // Lấy query string
        $query = $this->input->get('tu-khoa');

        // Kiểm tra và xử lý
        if ($query) {
            $data = [];
            $data['list_category'] = [];
            $data['class_css'] = 'about';
            $data['query'] = $query;
            $data['title'] = 'Kết quả tìm kiếm theo từ khoá: ' . $query;
            $data['content_intro'] =  $this->load->view($this->template_path . 'intro/news', $data, TRUE);
            $data['main_content']  = $this->load->view($this->template_path . 'intro/index', $data, TRUE);
            $this->load->view($this->template_main, $data);
        }
    }
    public function detail($slug)
    {
        $data = [];
        $data['class_css'] = 'about';
        $oneItem = $this->_post->getByField('slug', $slug);
        if (empty($oneItem)) show_404();
        else
            $data['item_content'] = $oneItem;
        $post_id = $oneItem->id;
        $cate_id = $this->_post->getByIdCategoryPost($post_id);
        $data_post = $this->_post->getDataPostByCategory([$cate_id->id], 1, 10);
        $data['cate'] = $cate_id;
        $data['posts'] = $data_post;
        $data['title'] = $oneItem->title;
        $data['main_content']  = $this->load->view($this->template_path . 'intro/detail', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
    public function get_post($id, $page = 1, $search = '')
    {
        // Đảm bảo page là một số hợp lệ
        $page = (int)$page;
        if ($page <= 0) {
            $page = 1;
        }

        // Số bài viết trên mỗi trang
        $per_page = 9;

        // Lấy dữ liệu bài viết
        $data = array();
        if ($search == '') $data = $this->_post->getDataPostByCategory([$id], $page, $per_page);
        else $data = $this->_post->getDataPostByTitle($search, $page, $per_page);


        // Lấy tổng số bài viết để tính số trang
        $total = 0;
        if ($search == '') $total = $this->_post->getTotalPostByCategory([$id]);
        $total = $this->_post->getTotalPostByTitle($search);

        // Tính toán số trang
        $total_pages = ceil($total / $per_page);

        // Trả về dữ liệu dưới dạng JSON
        $this->returnJson([
            'data' => $data,
            'total' => $total,
            'total_pages' => $total_pages,
            'current_page' => $page
        ]);
    }
    public function search_post($search = '', $page = 1)
    {
        // Đảm bảo page là một số hợp lệ
        $page = (int)$page;
        if ($page <= 0) {
            $page = 1;
        }

        // Số bài viết trên mỗi trang
        $per_page = 9;

        // Lấy dữ liệu bài viết
        $data = $this->_post->getDataPostByTitle($search, $page, $per_page);


        // Lấy tổng số bài viết để tính số trang
        $total = $this->_post->getTotalPostByTitle($search);

        // Tính toán số trang
        $total_pages = ceil($total / $per_page);

        // Trả về dữ liệu dưới dạng JSON
        $this->returnJson([
            'data' => $data,
            'total' => $total,
            'total_pages' => $total_pages,
            'current_page' => $page
        ]);
    }
}
