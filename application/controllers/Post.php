<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post extends Public_Controller
{
    protected $_product;
    protected $_post;
    protected $_all_category;
    protected $_category;
    protected $_customer;
    protected $_data_setting;
    protected $_reviews;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['post_model', 'product_model', 'reviews_model', 'category_model', 'customer_model', 'setting_model']);
        $this->_post = new Post_model();
        $this->_product  = new Product_model();
        $this->_category = new Category_model();
        $this->_reviews = new Reviews_model();
        $this->_customer = new Customer_model();
        $this->_data_setting = new Setting_model();

        $this->_all_category = $this->_category->_all_category('post');
    }

    public function demo()
    {
        for ($i = 0; $i < 30; $i++) {
            // $id = $this->_post->insert([
            //     'title' => 'Test ' . md5($i),
            //     'slug' => $this->toSlug('Test ' . md5($i)),
            //     'thumbnail' => 'https://siglaw.com.vn/wp-content/uploads/2023/06/thanh-lap-chi-nhanh-cong-ty-nuoc-ngoai-tai-viet-nam-768x432.webp',
            //     'meta_title' => 'Test ' . md5($i),
            //     'meta_description' => 'Test ' . md5($i),
            // ], '');
            // $this->_post->insert(['post_id' => $id, 'category_id' => 2], 'st_post_category');

            $id = $this->_post->insert([
                'person_id' => 3,
                'university' => $this->toSlug('Test ' . md5($i)),
                'year' => '2024'
            ], 'st_graduate');

            // $id = $this->_post->insert([
            //     'user_id' => 2,
            //     'title' => $this->toSlug('Test ' . md5($i)),
            //     'description' => '2024',
            //     'type' => 'Chi',
            //     'total_money' => array_rand(["100000", "500000", "2000000", "5000000"])
            // ], 'st_fund');

            // $id = $this->_post->insert([
            //     'full_name' => $this->toSlug('Test ' . md5($i)),
            //     'job_title' => 'Chi',
            //     'father_id' => 37,
            //     'status' => 'Mất',
            //     'date_die' => '2025-01-09'
            // ], 'st_family');
        }
    }

    public function category($id, $page = 1)
    {
        $data['oneItem'] = $oneItem = $this->_category->getByField('id', $id);
        if (empty($oneItem) || $oneItem->type === 'product') show_404();
        $this->_category->_recursive_child_id($this->_all_category, $id);
        $listCateId = $this->_category->_list_category_child_id;
        $limit = 10;
        $data['list_post'] = $this->_post->getDataPostByCategory($listCateId, $page, $limit);
        // phân Trang
        $total = $this->_post->getTotalPostByCategory($listCateId);
        $this->load->library('pagination');
        $paging['base_url'] = get_url_category_post($oneItem, $page);
        $paging['first_url'] = get_url_category_post($oneItem);
        $paging['total_rows'] = $total;
        $paging['per_page'] = $limit;
        $this->pagination->initialize($paging);
        $data['pagination'] = $this->pagination->create_links();
        // end phân Trang

        $this->breadcrumbs->push('Trang chủ', base_url());
        $this->_category->_recursive_parent($this->_all_category, $oneItem->id);
        if (!empty($this->_category->_list_category_parent)) foreach (array_reverse($this->_category->_list_category_parent) as $item) {
            $this->breadcrumbs->push($item->title, get_url_category_post($item));
        }
        $this->breadcrumbs->push($oneItem->title, get_url_category_post($oneItem));
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_category_post($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => TEMPLATES_ASSETS . 'media/Logo-share-ketsatgiadinh.png',
        ];
        $layoutView = '';
        if (!empty($oneItem->layout)) $layoutView = '-' . $oneItem->layout;
        $data['main_content'] = $this->load->view($this->template_path . 'post/category', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }

    public function detail($id)
    {
        $data['oneItem'] = $oneItem = $this->_post->getByField('id', $id);
        if (empty($oneItem)) show_404();

        $data['category'] = $oneCategory = $this->_post->getByIdCategoryPost($id);
        $this->_category->_recursive_child_id($this->_all_category, !empty($oneCategory->id) ? $oneCategory->id : '');
        $listCateId = $this->_category->_list_category_child_id;
        $data['list_post'] = $this->_post->getDataPostByCategory($listCateId, 1, 10);

        $oneItem->content = $this->handleContent($oneItem->content, $oneItem->id, $oneCategory->id);
        $oneItem->content = $this->handleInternalLink($oneItem->content, $oneItem->title);

        $data['hot_product']       = $this->_product->getDataProductBestSale();
        $data['reviews'] = $this->_reviews->getRate([
            'slug' => $oneItem->slug
        ]);
        $this->breadcrumbs->push('Trang chủ', base_url());
        $this->_category->_recursive_parent($this->_all_category, $oneCategory->id);
        if (!empty($this->_category->_list_category_parent)) foreach (array_reverse($this->_category->_list_category_parent) as $item) {
            $this->breadcrumbs->push($item->title, get_url_category_post($item));
        }
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_post($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];

        $data['main_content'] = $this->load->view($this->template_path . 'post/detail', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }

    private function handleInternalLink($content, $title)
    {
        $content = html_entity_decode($content);
        $internal_link = $this->_data_setting->get_setting_by_title('inner_link');

        // dòng này remove các interlink cũ để chèn cái mới
        $content = preg_replace('/<a class=["|\']interlink["|\'].*?>(.*?)<\/a>/m', '$1', $content);
        $content = preg_replace('/(<(?P<tag_name>(h[1-6]|a|td))[\s\S]*?>[\s\S]*?<\/(?P=tag_name)>)/m', '<[.,:$1:,.]>', $content);

        if (!empty($internal_link)) {
            foreach ($internal_link as $value) {
                $url = $value->key_setting;
                $keywords = json_decode($value->value_setting);
                $keywords = explode('|', $keywords->keyword);
                foreach ($keywords as $keyword) {
                    $tmp = explode('-', $keyword);
                    $internal_key = trim($tmp[0]);
                    $slug_internal_key = $this->toSlug($internal_key);
                    $limit = trim($tmp[1]);
                    $link_remove_domain = str_replace(rtrim(BASE_URL, '/'), '', $url);
                    preg_match('/<a class=["|\']interlink["|\'].*?>(.*?)<\/a>/m', $content, $matches_interlink);
                    $count_keyword = $this->input->cookie($slug_internal_key, TRUE);
                    if ((int) $count_keyword <= (int) $limit && count($matches_interlink) <= 5) {
                        preg_match('/<a [\s\S]*?>' . $internal_key . '<\/a>/ui', $content, $matches);
                        preg_match('/<a [\s\S]*? href=[\'|\"](' . str_replace('/', '\/', $url) . '|' . str_replace('/', '\/', $link_remove_domain) . ')[\'|\"][\s\S]*?>[\s\S]*?<\/a>/ui', $content, $link_matches);
                        if (empty($matches) && empty($link_matches)) {
                            if (preg_match('/' . $internal_key . '/iu', $content)) {
                                $name = preg_quote($internal_key, '/');
                                $replace = "<[.,:<a class='interlink' target='_blank' title=\"$1\" href=\"$url\">$1</a>:,.]>";
                                // không chèn vào giữa 2 ký từ <> và []
                                $reg = '/(?!(?:[^\[]+[\]]|[^<]+[>]))\b($name)\b/ui';
                                $regexp = str_replace('$name', $name, $reg);
                                $content = preg_replace($regexp, $replace, $content, 1);

                                $count_keyword++;
                                $cookie = array(
                                    'name'   => $slug_internal_key,
                                    'value'  => $count_keyword,
                                    'expire' => '300',
                                );
                                $this->input->set_cookie($cookie);
                            }
                        }
                    }
                }
            }
        }

        $content = str_replace('<[.,:', '', $content);
        $content = str_replace(':,.]>', '', $content);

        $alt = 'alt="' . $title . '"';
        $content = preg_replace('/[\s]alt=""/', $alt, $content);
        $content = preg_replace('/[\s]alt[^=]/', $alt, $content);

        return $content;
    }


    public function handleContent($content, $post_id, $category_id)
    {
        $content = str_replace('<p></p>', '', $content);
        preg_match_all("/<p>.*?<\/p>/", $content, $patt);

        // lấy những bài không được lớn hơn post_id
        $data_post = $this->_post->getDataPostTool($category_id, $post_id);

        if (!empty($patt[0])) foreach ($patt[0] as $key => $item) {

            if ($key == 4 && !empty($data_post[0])) {
                $new_1 = '<p>Xem thêm : <em><strong><a href="' . get_url_post($data_post[0]) . '" title="' . $data_post[0]->title . '">' . $data_post[0]->title . '</a></strong></em></p>';
                $content = str_replace($item, $item . $new_1, $content);
            }

            if ($key == 8 && !empty($data_post[1])) {
                $new_2 = '<p>Tham khảo thêm : <em><strong><a href="' . get_url_post($data_post[1]) . '" title="' . $data_post[1]->title . '">' . $data_post[1]->title . '</a></strong></em></p>';
                $content = str_replace($item, $item . $new_2, $content);
            }
        }
        return $content;
    }

    public function detail_customer($id)
    {
        $data['oneItem'] = $oneItem = $this->_customer->getByField('id', $id);
        if (empty($oneItem)) show_404();


        $this->breadcrumbs->push('Trang chủ', base_url());
        $this->breadcrumbs->push($oneItem->title, get_url_customer($oneItem));
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $data['SEO'] = [
            'meta_title' => !empty($oneItem->meta_title) ? $oneItem->meta_title : '',
            'meta_description' => !empty($oneItem->meta_description) ? $oneItem->meta_description : '',
            'meta_keyword' => !empty($oneItem->meta_keyword) ? $oneItem->meta_keyword : '',
            'url' => get_url_post($oneItem),
            'is_robot' => !empty($oneItem->is_robot) ? $oneItem->is_robot : '',
            'image' => getImageThumb($oneItem->thumbnail, 600, 314),
        ];

        $data['main_content'] = $this->load->view($this->template_path . 'post/detail_customer', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }

    public function getDataPostById($id)
    {
        $data = $this->_post->getDataPostByCategory([$id], 1, 10000);
        foreach ($data as $item) {
            echo get_url_post($item) . '<br>';
        }
    }
}
