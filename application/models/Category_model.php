<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends STEVEN_Model
{
    public $_list_category_child;
    public $_list_category_parent;
    public $_list_category_child_id;
    public $category_tree;
    private $table_post_cat;
    public function __construct()
    {
        parent::__construct();
        $this->table            = "category";
        $this->table_post_cat   = "post_category";
        $this->column_order     = array("$this->table.id", "$this->table.id", "title", "$this->table.is_status", "$this->table.created_time", "$this->table.updated_time");
        $this->column_search    = array("title", "id");
        $this->order_default    = array("$this->table.id" => "ASC");
    }
    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);
        if (!empty($type)) $this->db->where("$this->table.type", $type);
        if (!empty($parent_id)) $this->db->where("$this->table.parent_id", $parent_id);

        if (isset($is_robot)) $this->db->where("$this->table.is_robot", $is_robot);
    }

    public function _all_category($type = '', $updateCache = false)
    {
        $key = 'all_category_' . $type;
        $data = $this->getCache($key);
        if (empty($data) || $updateCache == true) {
            $this->db->select("id,title,parent_id,type,is_status,is_featured,slug,crawler_href,description,banner,link_banner");
            $this->db->from($this->table);
            $this->db->where("$this->table.is_status", 1);
            if (!empty($type)) $this->db->where("$this->table.type", $type);
            $data = $this->db->get()->result();
            $this->setCache($key, $data, 60 * 60 * 2);
        }
        return $data;
    }


    public function getListRecursive($type, $parent_id = 0)
    {
        $all = $this->_all_category($type);
        $data = [];
        if (!empty($all)) foreach ($all as $key => $item) {
            if ($item->parent_id == $parent_id) {
                $tmp = $item;
                $tmp->list_child = $this->getListChild($all, $item->id);
                $data[] = $tmp;
            }
        }
        return $data;
    }

    /*Đệ quy lấy record parent id*/
    public function _recursive_one_parent($all, $id)
    {
        if (!empty($all)) foreach ($all as $item) {
            if ($item->id == $id) {
                if ($item->parent_id == 0) return $item;
                else return $this->_recursive_one_parent($all, $item->parent_id);
            }
        }
    }
    /*Đệ quy lấy record parent id*/

    /*Đệ quy lấy array list category con*/
    public function _recursive_child($all, $parentId = 0)
    {
        if (!empty($all)) foreach ($all as $key => $item) {
            if ($item->parent_id == $parentId) {
                $this->_list_category_child[] = $item;
                unset($all[$key]);
                $this->_recursive_child($all, $item->id);
            }
        }
    }

    /*Đệ quy lấy maps các ID cha*/
    public function _recursive_parent($all, $cateId = 0)
    {
        if (!empty($all)) foreach ($all as $key => $item) {
            if ($item->id == $cateId) {
                $this->_list_category_parent[] = $item;
                unset($all[$key]);
                $this->_recursive_parent($all, $item->parent_id);
            }
        }
    }

    /*Đệ quy lấy array list category con*/
    public function getListChild($type, $parentId = 0)
    {
        $all = $this->_all_category($type);
        $data = array();
        if (!empty($all)) foreach ($all as $key => $item) {
            if ($item->parent_id == $parentId) {
                $data[] = $item;
            }
        }
        return $data;
    }
    /*Đệ quy lấy array list category  con*/

    /*Đệ quy lấy list các ID*/
    public function _recursive_child_id($all, $parentId = 0)
    {
        $this->_list_category_child_id[] = (int)$parentId;
        if (!empty($all)) foreach ($all as $key => $item) {
            if ($item->parent_id == $parentId) {
                $this->_list_category_child_id[] = (int) $item->id;
                unset($all[$key]);
                $this->_recursive_child_id($all, (int) $item->id);
            }
            $this->_list_category_child_id = array_unique($this->_list_category_child_id);
        }
    }
    /*Đệ quy lấy list các ID*/



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

    /*Đệ quy lấy maps các ID cha*/

    public function getByIdCached($id)
    {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $data = $this->db->get()->row();
        return $data;
    }


    public function getBySlugCached($slug, $type = '')
    {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where('slug', $slug);
        if (!empty($type)) $this->db->where('type', $type);
        $data = $this->db->get()->row();
        return $data;
    }

    public function getDataByCategoryType($allCategories, $type)
    {
        $dataType = [];
        if (!empty($allCategories)) foreach ($allCategories as $key => $item) {
            if ($item->type === $type) $dataType[] = $item;
        }
        return $dataType;
    }


    public function getAllCategoryByType($type, $parent_id = 0)
    {
        $this->db->from($this->table);
        $this->db->where([
            'type' => $type,
            'parent_id' => $parent_id
        ]);
        $query = $this->db->get()->result();
        return $query;
    }

    /*Lấy category cha*/
    public function getOneParent($id)
    {
        $params = [
            'lang_code' => $this->session->public_lang_code,
            'parent_id' => $id,
            'limit' => 1
        ];
        $data = $this->getData($params);
        return !empty($data) ? $data[0] : null;
    }

    public function getCategoryChild($id)
    {
        $key = "getCategoryChild_{$id}";
        $data = $this->getCache($key);
        if (empty($data)) {
            $this->db->from($this->table);
            $this->db->where([
                'parent_id' => $id,
                'is_status' => 1
            ]);
            $this->db->order_by('order', 'asc');
            $data = $this->db->get()->result();
            $this->setCache($key, $data, 60 * 60);
        }
        return $data;
    }

    public function checkHref($href)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('crawler_href', $href);
        $query = $this->db->get()->row();
        return $query;
    }

    public function getDataGroupBy()
    {
        $this->db->select('type');
        $this->db->from($this->table);
        $this->db->group_by('type');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function getDataCategoryProduct()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where_in('parent_id', [1, 2]);
        $data = $this->db->get()->result();
        return $data;
    }
    public function get_data_by_type($type) {
        // Truy vấn lấy dữ liệu từ bảng 'st_category' theo loại và sắp xếp theo ID DESC
        $this->db->where('type', $type);  // Điều kiện lọc theo loại
        $this->db->order_by('id', 'DESC');  // Sắp xếp theo ID giảm dần
        $query = $this->db->get('st_category');  // Thực hiện truy vấn
        
        // Kiểm tra nếu có dữ liệu
        if ($query->num_rows() > 0) {
            return $query->result();  // Trả về kết quả dưới dạng mảng đối tượng
        } else {
            return array();  // Trả về mảng rỗng nếu không có dữ liệu
        }
    }
    public function get_data_by_parent($type) {
        // Truy vấn lấy dữ liệu từ bảng 'st_category' theo loại và sắp xếp theo ID DESC
        $this->db->where(['parent_id' => $type, 'type' => 'events']);  // Điều kiện lọc theo loại
        $this->db->order_by('id', 'DESC');  // Sắp xếp theo ID giảm dần
        $query = $this->db->get('st_category');  // Thực hiện truy vấn
        
        // Kiểm tra nếu có dữ liệu
        if ($query->num_rows() > 0) {
            return $query->result();  // Trả về kết quả dưới dạng mảng đối tượng
        } else {
            return array();  // Trả về mảng rỗng nếu không có dữ liệu
        }
    }
    public function count_by_type($type)
    {
        $this->db->where('type', 'events');
        $this->db->where('parent_id', $type);
        return $this->db->count_all_results('st_category'); // Adjust table name as needed
    }

    public function get_by_type_paginated($type, $limit, $offset)
    { $this->db->where(['parent_id' => $type, 'type' => 'events']);
        $this->db->limit($limit, $offset);
        return $this->db->get('st_category')->result(); // Adjust table name as needed
    }
}
