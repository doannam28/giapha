<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newspaper_model extends STEVEN_Model {
    public $table;

    public function __construct() {
        parent::__construct();
        $this->table = "newspaper";
        $this->column_order = array("$this->table.id",);
        $this->column_search = array('title');
        $this->order_default = array("$this->table.id" => "order");
    }


    public function _where_custom($args = array()){
        parent::_where_custom();
        extract($args);
        if(!empty($phone)) $this->db->where("$this->table.phone", $phone);

    }


    public function getDataNewspaper()
    {
        $key = 'getDataNewspaper';
        $data = $this->getCache($key);
        if(empty($data)){
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->order_by('order','asc');
            $this->db->where('is_status',1);
            $query = $this->db->get()->result();
            $this->setCache($key,$data,60*60*2);
        }
        return $query;
    }

}
