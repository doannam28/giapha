<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs_model extends STEVEN_Model
{
    public $table;
    public $table_post;

    public function __construct()
    {
        parent::__construct();
        $this->table = "log_action";
        $this->table_post = "post";
        $this->column_order = array("id", "id", "action", "note", "uid", "created_time","updated_time");
        $this->column_search = array("note");
        $this->order_default = array("id" => "DESC");
    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);
    }

    public function getDataLogsToday($type)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where('module',$type);
        $this->db->order_by('created_time','asc');
        $query = $this->db->get()->row();
        return $query;
    }

    public function getDateLogsDrag($type)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where('module',$type);
        $this->db->order_by('created_time','desc');
        $this->db->limit(6);
        $query = $this->db->get()->result();
        return $query;
    }

    public function getDataLogsDragById($id,$type)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where('module',$type);
        $this->db->where('id',$id);
        $query = $this->db->get()->row();
        return $query;
    }

    public function listDataVer($post_id)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where('module','post');
        $this->db->where('module_id',$post_id);
        $this->db->order_by('created_time','asc');
        $query = $this->db->get()->result();
        return $query;
    }

    public function getDataByDate($date,$post_id)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where('module','post');
        $this->db->where('created_time >=',$date);
        $this->db->where('module_id',$post_id);
        $this->db->limit(2);
        $this->db->order_by('created_time','asc');
        $query = $this->db->get()->result();
        return $query;
    }
    public function getDataByDateLast($post_id)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where('module','post');
        $this->db->order_by('created_time','desc');
        $this->db->where('module_id',$post_id);
        $data[] = $this->db->get()->row_array();
        if (!empty($data)) {
            $data_2[] = $this->getPostId($data[0]['module_id']);
        }
        $data_arr = array_merge($data,$data_2);
        return $data_arr;
    }
    public function getPostId($post_id='')
    {
        $this->db->select("id,title,content,slug,description,meta_title,meta_description,meta_keyword,created_time");
        $this->db->from($this->table_post);
        $this->db->where('id',$post_id);
        $data = $this->db->get()->row_array();
        return $data;
    }
}