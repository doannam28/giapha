<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post_model extends STEVEN_Model
{
    public $table_category;

    public function __construct()
    {
        parent::__construct();
        $this->table = "post";
        $this->table_category = "post_category";
        $this->category       = "category";
        $this->column_order = array("$this->table.id", "$this->table.id", "title", "$this->table.is_status", "$this->table.created_time", "$this->table.updated_time");
        $this->column_search = array('title', 'slug', 'id');
        $this->order_default = array("$this->table.created_time" => 'desc');
    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);

        if (isset($is_status)) $this->db->where("$this->table.is_status", $is_status);
    }

    public function checkHref($href)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('crawler_href', $href);
        $query = $this->db->get()->row();
        return $query;
    }

    public function getSelect2Category($id)
    {
        $this->db->select("$this->table_category.category_id AS id, title AS text");
        $this->db->from($this->table_category);
        $this->db->join("category", "$this->table_category.category_id = category.id");
        $this->db->where($this->table_category . ".post_id", $id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDataPostByCategory($array_category, $page, $limit)
    {
        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.description, a.created_time, a.updated_time,a.content');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.post_id');
        $this->db->where_in('b.category_id', $array_category);
        $this->db->order_by('a.created_time', 'desc');
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->result();
        return $data;
    }
    public function getDataPostByTitle($params, $page, $limit)
{
    $keyword = urldecode($params);
    // $this->db->select('a.id, a.title, a.slug, a.thumbnail, a.description, a.created_time, a.updated_time, a.content');
    $this->db->from('st_post');
    // $this->db->join($this->table_category . ' b', 'a.id = b.post_id');
    
    $this->db->like('title', $keyword); // Corrected like syntax
    // $this->db->order_by('a.created_time', 'desc');
    $offset = ($page - 1) * $limit;
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    return $query->result();
}

    public function getTotalPostByCategory($array_category)
    {
        $this->db->select('a.id');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.post_id');
        $this->db->where('a.is_status', 1);
        $this->db->where_in('b.category_id', $array_category);
        $this->db->order_by('a.created_time', 'desc');
        $data = $this->db->get()->num_rows();
        return $data;
    }
    public function getTotalPostByTitle($params)
    {
    $keyword = urldecode($params);
        // $this->db->select('a.id');
        $this->db->from('st_post');
        // $this->db->join($this->table_category . ' b', 'a.id = b.post_id');
        $this->db->where('is_status', 1);
    $this->db->like('title', $keyword); // Corrected like syntax
        $this->db->order_by('created_time', 'desc');
        $data = $this->db->get()->num_rows();
        return $data;
    }

    //Lấy danh mục tin tuc
    public function getByIdCategoryPost($post_id)
    {
        $this->db->select('b.id,b.title,b.slug');
        $this->db->from($this->table_category . ' a');
        $this->db->join($this->category . ' b', 'a.category_id = b.id');
        $this->db->where('a.post_id', $post_id);
        $this->db->where('is_status', 1);
        $data = $this->db->get()->row();
        return $data;
    }

    public function getDataPostID($post_id)
    {
        $key = "getDataPostID$post_id";
        $data = $this->getCache($key);
        if (empty($data)) {
            $this->db->select('*');
            $this->db->from($this->table . ' a');
            $this->db->join($this->table_category . ' b', 'a.id = b.post_id');
            $this->db->where('b.category_id', $post_id);
            $this->db->where('is_status', 1);
            $this->db->order_by('created_time', 'desc');
            $this->db->limit(12);
            $data = $this->db->get()->result();
            $this->setCache($key, $data, 60 * 60 * 2);
        }
        return $data;
    }

    public function getDataPost()
    {
        $key = 'getDataPost';
        $data = $this->getCache($key);
        if (empty($data)) {
            $this->db->select('id,title,description,slug,thumbnail,created_time');
            $this->db->from($this->table);
            $this->db->where('is_status', 1);
            $this->db->order_by('created_time', 'desc');
            $this->db->limit(12);
            $data = $this->db->get()->result();
            $this->setCache($key, $data, 60 * 60 * 2);
        }
        return $data;
    }

    public function getDataPostSameKeyword($keyword)
    {
        $key = 'getDataPostSameKeyword_' . md5($keyword);
        $data = $this->getCache($key);
        if (empty($data)) {
            $this->db->select('id,title,description,slug,thumbnail,created_time');
            $this->db->from($this->table);
            $this->db->like('content', trim($keyword), 'both');
            $this->db->where('is_status', 1);
            $this->db->order_by('created_time', 'desc');
            $this->db->limit(12);
            $data = $this->db->get()->result();
            $this->setCache($key, $data, 60 * 60 * 2);
        }
        return $data;
    }

    public function getDataPostTool($category_id, $post_id)
    {
        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.description,a.created_time,a.updated_time');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.post_id');
        if (!empty($category_id)) $this->db->where_in('b.category_id', $category_id);
        $this->db->where('a.is_status', 1);
        if ($post_id < 3) {
            $this->db->where_not_in('a.id', $post_id);
            $this->db->order_by('a.id', 'asc');
        } else {
            $this->db->where('a.id <', $post_id);
            $this->db->order_by('a.created_time', 'desc');
        }
        $this->db->group_by('a.id');
        $this->db->limit(2);
        $data = $this->db->get()->result();
        return $data;
    }

    public function get_all_post()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("$this->table.is_status", 1);
        $data = $this->db->get()->result();
        return $data;
    }
}
