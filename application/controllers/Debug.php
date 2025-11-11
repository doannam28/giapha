<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Debug extends Public_Controller
{
    protected $_data_category;
    protected $_data;
    protected $_data_post;
    protected $_data_reviews;
    protected $_data_setting;


    public function __construct()
    {
        parent::__construct();
        $this->load->model(['category_model', 'post_model','setting_model','reviews_model']);
        $this->_data_post = new Post_model();
        $this->_data = new Post_model();
        $this->_data_reviews = new Reviews_model();
        $this->_data_category = new Category_model();
        $this->_data_setting = new Setting_model();
    }

    public function cache(){
        $allCache = $this->cache->cache_info();
        echo "<ul>";
        if(!empty($allCache)) foreach ($allCache as $key => $item){
            $delete = "<a target='_blank' href='".base_url('debug/delete_cache?key='.$key)."'>Delete cache</a>";
            echo "<li>$key => $delete</li>";
        }
        echo "</ul>";
    }

    public function delete_cache_file($url = ''){
        if (empty($url)){
            $this->load->helper('file');
            $url = $this->input->get('url');
        }

        if(!empty($url)){
            $uri = str_replace(base_url(),'/',$url);
            if($this->output->delete_cache($uri)) echo 'Delete cache'.$uri."<br>";
            else  echo "$uri has been deleted !<br>";
        }else{
            if(delete_files(FCPATH . 'application' . DIRECTORY_SEPARATOR . 'cache')) die("Delete all page statistic success !");
            else  die("Delete all page statistic error !");
        }

    }

    public function delete_cache(){
        $key = $this->input->get('key');
        $key = str_replace(CACHE_PREFIX_NAME,'',$key);
        if(!empty($key)) {
            if($this->deleteCache($key)) die('Delete success !');
            else  die('Delete error !');
        }else{
            die('Not key => error !');
        }
    }

    public function update_cache(){
        $this->delete_cache_file(base_url());
        exit;
    }

    public function update_cache_home(){
        $this->delete_cache_file(base_url());
        exit;
    }

    public function update_cache_cate($slug){
        $this->delete_cache_file(base_url());
        exit;
    }


    public function update_cache_detail($id){
        $oneItem = $this->_data->get_post_by_id($id,true);
        $this->delete_cache_file(get_url_post($oneItem));
        exit;
    }


    public function convertData() {
        $posts = $this->_data_post->get_all_post();

        foreach ($posts as $post) {
            // $data_inter[]= $this->handleInternalLink($post->content);
            $new_content= $this->handleInternalLink($post->content);

            if ($new_content != $post->content) {
                $data['content'] = $new_content;
                $this->_data_post->update(['id' => $post->id], $data, $this->_data_post->table);
            }
        }
        // dd($data_inter);
    }


    private function handleInternalLink($content) {
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
                            if (preg_match('/'.$internal_key.'/iu', $content)) {
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

        return $content;
    }


}

