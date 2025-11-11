<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Graduate_model extends STEVEN_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function count_by_type()
    {
        return $this->db->count_all_results('st_graduate'); // Adjust table name as needed
    }

    public function get_by_type_paginated($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('st_graduate')->result_array(); // Adjust table name as needed
    }

    public function getDataGraduate($limit, $offset)
    {
        $this->db->select('st_graduate.id as gid, st_graduate.university, st_graduate.year, 
                           family.full_name as person_name, 
                           father.full_name as father_name');
        $this->db->from('st_graduate');
        $this->db->join('st_family as family', 'family.id = st_graduate.person_id', 'left');
        $this->db->join('st_family as father', 'father.id = family.father_id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by('st_graduate.id','DESC');
        return $this->db->get()->result_array();
    }
}
