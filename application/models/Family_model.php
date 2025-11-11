<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Family_model extends STEVEN_Model
{
    public $table;
    public $column_order;
    public $column_search;
    public $order_default;

    public function __construct()
    {
        parent::__construct();
        $this->table            = "family";
        $this->column_order     = array("full_name");
        $this->column_search    = array("full_name", "id");
        $this->order_default    = array("$this->table.id" => "ASC");
    }

    public function insert_fund($data)
    {
        $this->db->insert('st_fund', $data);
        return $this->db->insert_id(); // Trả về ID vừa được thêm
    }

    public function count_all()
    {
        return $this->db->count_all_results('st_family'); // Adjust table name as needed
    }

    public function get_by_paginated($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('st_family')->result_array(); // Adjust table name as needed
    }
    // Lấy danh sách tất cả các bản ghi
    public function get_all_by_params($params)
    {
        $this->db->like(['full_name' => $params]);
        // $this->db->where('gender !=', 'Nữ');
        $this->db->order_by('id', 'ASC'); // Sắp xếp theo parent_id giảm dần
        $query = $this->db->get('st_family');
        return $query->result_array();
    }
    
    public function getDataFE($params)
    {
        if (!empty($params['like'])) $this->db->like(['full_name' => $params['like']], true);
        if (!empty($params['gender'])) $this->db->where('gender', $params['gender']);
        if (!empty($params['parent_id'])) $this->db->where('parent_id', $params['parent_id']);
        $this->db->order_by('id', 'ASC'); // Sắp xếp theo parent_id giảm dần
        $query = $this->db->get('st_family');
        return $query->result_array();
    }

    // Lấy thông tin chi tiết của một fund dựa trên ID
    public function get_all_wife($id)
    {
        $this->db->where([
            'husband_id' => $id,
            'role' => 'Vợ'
        ]);
        $query = $this->db->get('st_family');
        return $query->result_array();
    }
    public function get_all_child($id)
    {
        $this->db->where('father_id', $id);
        $query = $this->db->get('st_family');
        return $query->result_array();
    }
    public function get_all_parent($id)
    {
        $this->db->where('parent_id', $id);
        $this->db->where('gender', 'Nam');
        $query = $this->db->get('st_family');
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
    public function get_data()
    {
        $this->db->select('*'); // Chọn tất cả các cột hoặc thay bằng cột cụ thể
        $this->db->from('st_family'); // Thay 'your_table_name' bằng tên bảng thực tế
        //        $this->db->where('father_id !=', 0); // Điều kiện father_id != 0
        $this->db->order_by('parent_id', 'DESC'); // Sắp xếp theo parent_id giảm dần

        $query = $this->db->get(); // Thực thi truy vấn
        return $query->result(); // Trả về kết quả dạng mảng đối tượng
    }
    public function countAllRank()
    {
        $this->db->select('st_graduate.university, st_graduate.year, st_family.*');
        $this->db->from('st_graduate');
        $this->db->join('st_family', 'st_family.id = st_graduate.person_id', 'left');
        return $this->db->count_all_results();
    }

    public function getRank($limit, $offset)
    {
        $this->db->select('st_graduate.university, st_graduate.year, st_family.*');
        $this->db->from('st_graduate');
        $this->db->join('st_family', 'st_family.id = st_graduate.person_id', 'left');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    public function get_user_first($level = 1)
    {
        $this->db->where([
            'parent_id' => 1,
            'gender' => 'Nam',
        ]);
        $query = $this->db->get('st_family');
        return $query->result();
    }
    public function count_by_type()
    {
        $this->db->where('job_title !=', '');
        $this->db->where('father_id !=', 0);

        return $this->db->count_all_results('st_family'); // Adjust table name as needed
    }
    public function count_user_die()
    {
        $this->db->where('status', 'Mất');
        $this->db->where('father_id !=', 0);

        return $this->db->count_all_results('st_family'); // Adjust table name as needed
    }
    public function get_by_type_paginated($limit, $offset, $type = null)
    {
        $this->db->where('job_title !=', '');
        if ($type == 'jobs') {
            // $this->db->where('gender', 'Nam');
        } else {
            $this->db->where('father_id !=', 0);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('parent_id', 'DESC'); // Sắp xếp theo parent_id giảm dần
        return $this->db->get('st_family')->result_array(); // Adjust table name as needed
    }
    public function get_user_die_paginated($limit, $offset)
    {
        $this->db->where('status', 'Mất');
        $this->db->limit($limit, $offset);
        $this->db->order_by('date_die', 'DESC'); // Sắp xếp theo parent_id giảm dần
        return $this->db->get('st_family')->result_array(); // Adjust table name as needed
    }
    public function filter_user($query)
    {
        $this->db->like('full_name', $query);
        return $this->db->get('st_family')->result_array();
    }
    public function getSelect2Fullname($ids)
    {
        $this->db->select("$this->table.id, full_name AS text");
        $this->db->from($this->table);
        if (is_array($ids)) $this->db->where_in("$this->table.id", $ids);
        else $this->db->where("$this->table.id", $ids);

        $query = $this->db->get();
        return $query->result();
    }
    public function getSelect2HusbandFullname($ids)
    {
        $this->db->select("$this->table.id, full_name AS text");
        $this->db->from($this->table);
        if (is_array($ids)) $this->db->where_in("$this->table.husband_id", $ids);
        else $this->db->where("$this->table.husband_id", $ids);

        $query = $this->db->get();
        return $query->result();
    }
    public function getSelect2FatherFullname($ids)
    {
        $this->db->select("$this->table.id, full_name AS text");
        $this->db->from($this->table);
        if (is_array($ids)) $this->db->where_in("$this->table.id", $ids);
        else $this->db->where("$this->table.id", $ids);

        $query = $this->db->get();
        return $query->result();
    }
    public function getAllRankByUserId($limit, $offset)
    {
        $this->db->select('st_family.full_name ,st_graduate.university,st_graduate.year, father.full_name as father_name,mother.full_name AS mother_name');
        $this->db->from('st_family');
        $this->db->join('st_graduate', 'st_family.id = st_graduate.person_id', 'inner');
        $this->db->join('st_family as father', 'st_family.father_id = father.id', 'left');
        $this->db->join('st_family as mother', 'st_family.mother_id = mother.id', 'left');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result_array();
    }

    public function get_unique_parent_ids()
    {
        $this->db->distinct();
        $this->db->select('parent_id');
        $query = $this->db->get('st_family'); // Thay 'your_table_name' bằng tên bảng của bạn

        return $query->result();
    }
}
