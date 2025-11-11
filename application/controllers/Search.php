<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Public_Controller {

    protected $_product;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->_product = new Product_model();
    }

    public function index(){
        $keyword = $this->input->get('url_text_search');
        $data['keyword'] = xss_clean($keyword);
        $data['data_product'] = $this->_product->getDataSearchProduct($data['keyword']);
        
        $url = base_url('pa_ket-qua-tim-kiem.html?url_text_search=').$keyword;
        
        $this->breadcrumbs->push("Trang chủ", base_url());
        $this->breadcrumbs->push("Bạn vừa tìm kiếm từ khóa \"$keyword \"", "$url" );
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $data['SEO'] = array(
            'meta_title'        => "Kết quả tìm kiếm sản phẩm",
            'meta_description'  => "Kết quả tìm kiếm sản phẩm, Két sắt Gia Định cung cấp các sản phẩm Két sắt - Két bạc chính hãng giá rẻ",
            'meta_keyword'      => "Kết quả tìm kiếm sản phẩm",
            'url'               => $url
        );
        $data['main_content'] = $this->load->view($this->template_path.'search/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }


}
