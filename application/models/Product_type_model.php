<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_type_model extends STEVEN_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "product_type";
        $this->column_order = array("$this->table.id", "$this->table.id", "title", "$this->table.is_status", "$this->table.created_time", "$this->table.updated_time");
        $this->column_search = array("title");
        $this->order_default = array("$this->table.created_time" => "DESC");

    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);

        if (isset($is_status)) $this->db->where("$this->table.is_status", $is_status);

        if (isset($keyword_search)) $this->db->like("$this->table.title", $keyword_search);

        if (isset($not_in)) $this->db->where_not_in("$this->table.id", $not_in);
    }

    public function checkHref($href)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('crawler_href', $href);
        $query = $this->db->get()->row();
        return $query;
    }

    public function getDataProductType()
    {
        $this->db->select('id,title,slug');
        $this->db->from($this->table);
        $this->db->where('is_Status', 1);
        $this->db->order_by('order', 'asc');
        $query = $this->db->get()->result();
        return $query;
    }

    public function getDataproductChildType($parent_id)
    {
        $this->db->select('id,title,slug');
        $this->db->from($this->table);
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('order', 'asc');
        $query = $this->db->get()->result();
        return $query;
    }

}
