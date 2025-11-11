<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fund_model extends STEVEN_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert_fund($data)
    {
        $this->db->insert('st_fund', $data);
        return $this->db->insert_id(); // Trả về ID vừa được thêm
    }


    // Lấy danh sách tất cả các bản ghi
    public function get_all_funds()
    {
        $query = $this->db->get('st_fund');
        return $query->result_array();
    }

    // Lấy thông tin chi tiết của một fund dựa trên ID
    public function get_fund_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('st_fund');
        return $query->row_array();
    }
    public function get_all_by_type($type)
    {
        $this->db->where('type', $type);
        $query = $this->db->get('st_fund');
        return $query->result_array();
    }
    // Cập nhật fund theo ID
    public function update_fund($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('st_fund', $data);
    }

    // Xóa fund theo ID
    public function delete_fund($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('st_fund');
    }
    public function count_by_type($short)
    {
        $this->db->where('type', $short);
        return $this->db->count_all_results('st_fund'); // Adjust table name as needed
    }

    public function get_by_type_paginated($short, $limit, $offset)
    {
        $this->db->where('type', $short);
        $this->db->limit($limit, $offset);
        return $this->db->get('st_fund')->result_array(); // Adjust table name as needed
    }

}
