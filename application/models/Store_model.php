<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "store";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array('title','phone','address');
        $this->order_default = array("$this->table.id" => "order");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
        if(!empty($phone)) $this->db->where("$this->table.phone", $phone);

    }

    public function getDataStore()
    {
        $this->db->select("$this->table.*, st_menus.title as city_title");
        $this->db->from($this->table);
        $this->db->order_by('order','asc');
        $this->db->where('is_status',1);
        $this->db->join('st_menus',"$this->table.city_id = st_menus.id" ,"LEFT");
        $query = $this->db->get()->result();
        return $query;
    }
    
}
