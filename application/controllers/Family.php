<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Family extends Public_Controller
{
    protected $_menu;
    protected $_category;
    protected $_page;
    protected $_post;
    protected $_customer;
    protected $_banner;
    protected $_family;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Menus_model', 'Category_model', 'Post_model', 'Page_model', 'Customer_model', 'Banner_model', 'Family_model']);
        $this->_menu = new Menus_model();
        $this->_post = new Post_model();
        $this->_page = new Page_model();
        $this->_category = new Category_model();
        $this->_customer = new Customer_model();
        $this->_banner = new Banner_model();
        $this->_family = new Family_model();
    }

    public function index()
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['title'] = "Gia phả Họ Hoàng";
        $data['main_content'] = $this->load->view($this->template_path . 'home/index', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
    public function phado()
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['title'] = 'Phả đồ Hoàng';
        $data['search'] = 'display';
        $data['processedData'] = $this->get_pha_do_html();
        $data['content_giapha'] = $this->load->view($this->template_path . 'phado/pha_do', $data, TRUE);
        $data['main_content'] = $this->load->view($this->template_path . 'phado/index', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
    public function toc_uoc()
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['title'] = "Tộc ước";
        $data['content_page'] = $this->_category->getByField('slug', 'toc-uoc')->content;
        $data['content_giapha'] = $this->load->view($this->template_path . 'phado/toc_uoc', $data, TRUE);
        $data['main_content'] = $this->load->view($this->template_path . 'phado/index', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
    public function huong_hoa($current_page = 1)
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['title'] = "Hương hoả";
        $per_page = 10; // Number of records per page
        $data['offset'] = $offset = ($current_page - 1) * $per_page; // Calculate offset

        // Fetch total records and paginated records
        $total_records = $this->_family->count_user_die(); // Implement count_by_type in your model
        $data['list_user'] = $this->_family->get_user_die_paginated($per_page, $offset);
        $data['pagination'] = $this->generate_pagination(base_url('gia-pha/huong-hoa'), $total_records, $per_page, $current_page);
        $data['content_giapha'] = $this->load->view($this->template_path . 'phado/huong_hoa', $data, TRUE);
        $data['main_content'] = $this->load->view($this->template_path . 'phado/index', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
    public function ngay_gio($current_page = 1)
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['title'] = 'Ngày giỗ';
        $per_page = 10; // Number of records per page
        $data['offset'] = $offset = ($current_page - 1) * $per_page; // Calculate offset

        // Fetch total records and paginated records
        $total_records = $this->_family->count_user_die(); // Implement count_by_type in your model
        $data['list_user'] = $this->_family->get_user_die_paginated($per_page, $offset);
        $data['pagination'] = $this->generate_pagination(base_url('gia-pha/ngay-gio'), $total_records, $per_page, $current_page);
        $data['content_giapha'] = $this->load->view($this->template_path . 'phado/ngay_gio', $data, TRUE);
        $data['main_content'] = $this->load->view($this->template_path . 'phado/index', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }

    private function generate_pagination($link = '', $total_records, $per_page, $current_page = 1)
    {
        // phân Trang
        $this->load->library('pagination');
        $paging['base_url'] = $link;
        $paging['first_url'] = $link;
        $paging['total_rows'] = $total_records;
        $paging['per_page'] = $per_page;
        $paging['this_page'] = $current_page;
        $paging['all_page'] = ceil($total_records / $per_page);
        $this->pagination->initialize($paging);
        return $this->pagination->create_links();
        // end phân Trang
    }

    public function phado_chi_tiet($id)
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['id'] = $id;
        $data['person_info'] = $person_info = $this->_family->getByField('id', $id);
        $data['father'] = $this->_family->getByField('id', $person_info->father_id);
        $data['mother'] = $this->_family->getByField('id', $person_info->mother_id);
        
        $data['title'] = 'Phả đồ chi tiết của Ông ' . $data['person_info']->full_name;
        $array_data = array();
        $array_data['list_parent'] = array();
        array_push($array_data['list_parent'], $this->_family->getByField('id', $data['person_info']->father_id));
        if ($data['person_info']->mother_id != '')
            array_push($array_data['list_parent'], $this->_family->getByField('id', $data['person_info']->mother_id));
        $array_data['list_wife'] = $this->_family->get_all_wife($data['person_info']->id);
        $array_data['list_sibling'] = $this->_family->get_all_child($data['person_info']->father_id);
        $array_data['list_child'] = $this->_family->get_all_child($data['person_info']->id);
        $data['list_data'] = $array_data;
        $data['processedData'] = $this->get_phado_chitiet_html($id);
        $data['main_content'] = $this->load->view($this->template_path . 'phado/chi_tiet', $data, TRUE);
        $this->setCacheFile(60);
        $this->load->view($this->template_main, $data);
    }
    public function get_phado_chitiet($id)
    {
        $person_info = $this->_family->getByField('id', $id);
        $tree = array();
        if ($person_info->father_id == 0 && $person_info->mother_id == 0) {
            $tree['text'] = [
                'origin' => '',
                'partner' => '',
                'data-gender' => 'male',
                'data-type' => 'horizontal'
            ];
        } else {
            $tree['text'] = [
                'origin' => $this->_family->getByField('id', $person_info->father_id)->full_name ?? '',
                'partner' => $this->_family->getByField('id', $person_info->mother_id)->full_name ?? '',
                'data-gender' => 'male',
                'data-type' => 'horizontal'
            ];
        }
        $list_child = $this->_family->get_all_child($person_info->id);
        $child = array();
        foreach ($list_child as $item) {
            $row = array();
            $row['text'] = [
                'origin' => $item['full_name'],
                'partner' => $this->_family->getByField('husband_id', $item['id'])->full_name ?? '',
                'data-gender' => $item['gender'] == 'Nam' ? 'male' : 'female',
                'data-type' => 'horizontal',
            ];
            $child[] = $row;
        }
        $tree['children'] = [
            [
                'text' => [
                    'origin' => $person_info->full_name ?? '',
                    'partner' => $this->_family->getByField('husband_id', $person_info->id)->full_name ?? '',
                    'data-gender' => 'male',
                    'data-type' => 'horizontal',
                    'data-select' => true
                ],
                'children' => $child
            ]
        ];
        $this->returnJson($tree);
    }
    public function get_phado_chitiet_html($id)
    {
        $person_info = $this->_family->getByField('id', $id);
        if ($person_info->role == 'Tổ tiên') {
            $tree['text'] = [
                'origin' => $person_info->full_name ?? '',
                'partner' => $this->_family->getByField('husband_id', $id)->full_name ?? '',
                'data-gender' => $person_info->gender == 'Nam' ? 'male' : 'female',
                'data-type' => 'horizontal',
                'data-select' => true,
            ];
            $list_child = $this->_family->get_all_child($person_info->id);
            $child = array();
            foreach ($list_child as $item) {
                $list_children = $this->_family->get_all_child($item['id']);
                $row = array();
                $row_child = array();
                if ($item['gender'] == 'Nam' || $item['role'] !== 'Vợ') {
                    $row['text'] = [
                        'origin' => $item['full_name'],
                        'partner' => $this->_family->getByField('husband_id', $item['id'])->full_name ?? '',
                        'data-gender' => $item['gender'] == 'Nam' ? 'male' : 'female',
                        'data-type' => 'horizontal',
                    ];
                    if (!empty($list_children)) {
                        foreach ($list_children as $item) {
                            $row2 = array();
                            if ($item['gender'] == 'Nam' || $item['role'] !== 'Vợ') {
                                $row2['text'] = [
                                    'origin' => $item['full_name'],
                                    'partner' => $this->_family->getByField('husband_id', $item['id'])->full_name ?? '',
                                    'data-gender' => $item['gender'] == 'Nam' ? 'male' : 'female',
                                    'data-type' => 'horizontal',
                                ];
                                $row_child[] = $row2;
                            }
                        }
                        $row['children'] = $row_child;
                    };
                    $child[] = $row;
                }
            };
            $tree['children'] = $child;
        } else {
            $tree = array();
            if ($person_info->father_id == 0 && $person_info->mother_id == 0) {
                $tree['text'] = [
                    'origin' => '',
                    'partner' => '',
                    'data-gender' => 'male',
                    'data-type' => 'horizontal'
                ];
            } else {
                $tree['text'] = [
                    'origin' => $this->_family->getByField('id', $person_info->father_id)->full_name ?? '',
                    'partner' => $this->_family->getByField('id', $person_info->mother_id)->full_name ?? '',
                    'data-gender' => 'male',
                    'data-type' => 'horizontal'
                ];
            }
            $list_child = $this->_family->get_all_child($person_info->id);
            $child = array();
            foreach ($list_child as $item) {
                $row = array();
                if ($item['gender'] == 'Nam' || $item['role'] !== 'Vợ') {
                    $row['text'] = [
                        'origin' => $item['full_name'],
                        'partner' => $this->_family->getByField('husband_id', $item['id'])->full_name ?? '',
                        'data-gender' => $item['gender'] == 'Nam' ? 'male' : 'female',
                        'data-type' => 'horizontal',
                    ];
                    $child[] = $row;
                }
            }
            $tree['children'] = [
                [
                    'text' => [
                        'origin' => $person_info->full_name ?? '',
                        'partner' => $this->_family->getByField('husband_id', $person_info->id)->full_name ?? '',
                        'data-gender' => 'male',
                        'data-type' => 'horizontal',
                        'data-select' => true
                    ],
                    'children' => $child
                ]
            ];
        }

        return json_encode($tree);
    }
    public function get_pha_do_html()
    {
        $first_user = $this->_family->get_user_first()[0];
        $wife_info = $this->_family->getByField('husband_id', $first_user->id);
        $wife_info = !empty($wife_info) ? $wife_info->full_name : '';
        $list_child = $this->_family->get_all_child($first_user->id);

        $array_tree = $this->buildTree($list_child);

        $output = [
            'text' => [
                "origin" => $first_user->full_name,
                "partner" => $wife_info,
                "lever" => $first_user->parent_id,
                "data-gender" => "male",
                "data-type" => "horizontal",
                "link" => [
                    "href" => site_url("pha-do-chi-tiet/" . $first_user->id),
                    "val" => "#" . $first_user->id
                ],
            ],
            "HTMLid" => 'note_'.$first_user->id,
            "collapsable" => true,
            "children" => $array_tree,
        ];
        return json_encode($output);
    }
    public function get_pha_do()
    {
        $first_user = $this->_family->get_user_first()[0];
        $wife_info = $this->_family->getByField('husband_id', $first_user->id);
        $wife_info = !empty($wife_info) ? $wife_info->full_name : '';
        $list_child = $this->_family->get_all_child($first_user->id);

        $array_tree = $this->buildTree($list_child);

        $output = [
            'text' => [
                "origin" => $first_user->full_name,
                "partner" => $wife_info,
                "lever" => $first_user->parent_id,
                "data-gender" => "male",
                "data-type" => "horizontal",
                "link" => [
                    "href" => site_url("pha-do-chi-tiet/" . $first_user->id),
                    "val" => "#" . $first_user->id
                ],
            ],
            "HTMLid" => 'note_'.$first_user->id,
            "collapsable" => true,
            "children" => $array_tree,
        ];
        $this->returnJson($output);
    }

    function buildTree($list_child, $parent = 0)
    {
        $array_tree = array(); // Đưa khai báo ra ngoài vòng lặp
        $i = 1;
        foreach ($list_child as $key) {
            $row = array();
            $row['HTMLid'] = 'note_'.$key['id'];
            if ($key['gender'] == 'Nam' || $key['role'] !== 'Vợ') {
                $row['text'] = [
                    'origin' => $key['full_name'],
                    'data-gender' => $key['gender'] == 'Nam' ? 'male' : 'female',
                ];

                if ($key['parent_id'] < 5) $row['text']['data-type'] = 'horizontal';
                if ($i == 1)
                    $row['text']['lever'] = (int) $key['parent_id'];
                $i++;
                $wife_child_info = $this->_family->getByField('husband_id', $key['id'])->full_name ?? '';
                $row['text']['partner'] = $wife_child_info;

                // Lấy danh sách con
                $list_child_array = $this->_family->get_all_child($key['id']);
                if (empty($_GET['all'])) {
                    if ((int) $key['parent_id'] > 2)
                        if (count($list_child_array) > 0)
                            $row['collapsed'] = true;
                        else
                            $row['collapsable'] =  true;
                    else
                        $row['collapsable'] =  true;
                }

                $row['text']['link'] = [
                    "href" => site_url("pha-do-chi-tiet/" . $key['id']),
                    "val" => "#" . $key['id']
                ];
                // Gọi đệ quy nếu có danh sách con
                if (!empty($list_child_array)) {
                    $row['children'] = $this->buildTree($list_child_array);
                }
                $array_tree[] = $row; // Thêm vào mảng kết quả
            }
        }

        return $array_tree;
    }

    public function pdf_gia_pha()
    {
        $data = [];
        $data['class_css'] = 'top';
        if ($_GET['typee'] == 1) {
            $data['processedData'] = $this->get_pha_do_html();
        } else {
            if (!empty($_GET['thanhvien'])) {
                $data['processedData'] = $this->get_phado_chitiet_html($_GET['thanhvien']);
            } else {
                $data['processedData'] = $this->get_phado_doi_html($_GET['doi']);
            }
        };

        $this->load->view($this->template_path . 'pdf/phado', $data);
    }

    public function get_phado_doi_html($id)
    {
        if ($id == 1) {
            $person_info = $this->_family->getByField('role', 'Tổ tiên');
            $tree['text'] = [
                'origin' => $person_info->full_name,
                'partner' => $this->_family->getByField('husband_id', $person_info->id)->full_name ?? '',
                'data-gender' => 'male',
                'data-type' => 'horizontal',
            ];
            $tree['collapsable'] = true;

            $list_child_array = $this->_family->get_all_child($person_info->id);
            $child = [];

            if (!empty($list_child_array)) {
                foreach ($list_child_array as $item) {
                    if ($item['gender'] == 'Nam' || $item['role'] !== 'Vợ') {
                        $row = [
                            'text' => [
                                'origin' => $item['full_name'],
                                'partner' => $this->_family->getByField('husband_id', $item['id'])->full_name ?? '',
                                'data-gender' => $item['gender'] == 'Nam' ? 'male' : 'female',
                                'data-type' => 'horizontal',
                            ]
                        ];

                        $list_children = $this->_family->get_all_child($item['id']);
                        if (!empty($list_children)) {
                            $child2 = [];
                            foreach ($list_children as $item2) {
                                if ($item2['gender'] == 'Nam' || $item2['role'] !== 'Vợ') {
                                    $row2 = [
                                        'text' => [
                                            'origin' => $item2['full_name'],
                                            'partner' => $this->_family->getByField('husband_id', $item2['id'])->full_name ?? '',
                                            'data-gender' => $item2['gender'] == 'Nam' ? 'male' : 'female',
                                            'data-type' => 'horizontal',
                                        ]
                                    ];
                                    $child2[] = $row2;
                                }
                            }
                            $row['children'] = $child2;
                        }

                        $child[] = $row; // Sửa lỗi ở đây: thêm vào mảng $child
                    }
                }
            }

            $tree['children'] = $child;
            $person_info = $this->_family->getByField('role', 'Tổ tiên');
            $tree['text'] = [
                'origin' => $person_info->full_name,
                'partner' => $this->_family->getByField('husband_id', $person_info->id)->full_name ?? '',
                'data-gender' => 'male',
                'data-type' => 'horizontal',
            ];
            $list_child_array = $this->_family->get_all_child($person_info->id);
            $child = [];

            if (!empty($list_child_array)) {
                foreach ($list_child_array as $item) {
                    if ($item['gender'] == 'Nam' || $item['role'] !== 'Vợ') {
                        $row = [
                            'text' => [
                                'origin' => $item['full_name'],
                                'partner' => $this->_family->getByField('husband_id', $item['id'])->full_name ?? '',
                                'data-gender' => $item['gender'] == 'Nam' ? 'male' : 'female',
                                'data-type' => 'horizontal',
                            ]
                        ];

                        $list_children = $this->_family->get_all_child($item['id']);
                        if (!empty($list_children)) {
                            $child2 = [];
                            foreach ($list_children as $item2) {
                                if ($item2['gender'] == 'Nam' || $item2['role'] !== 'Vợ') {
                                    $row2 = [
                                        'text' => [
                                            'origin' => $item2['full_name'],
                                            'partner' => $this->_family->getByField('husband_id', $item2['id'])->full_name ?? '',
                                            'data-gender' => $item2['gender'] == 'Nam' ? 'male' : 'female',
                                            'data-type' => 'horizontal',
                                        ]
                                    ];
                                    $child2[] = $row2;
                                }
                            }
                            $row['children'] = $child2;
                        }

                        $child[] = $row; // Sửa lỗi ở đây: thêm vào mảng $child
                    }
                }
            }

            $tree['children'] = $child;

            // dd($tree);
        } else {
            $tree = array();
            $tree['text'] = [
                'origin' => '',
                'partner' => '',
                'data-gender' => 'male',
                'data-type' => 'horizontal'
            ];

            $list_child_array = $this->_family->get_all_parent($id - 1);
            $child = array();

            if (!empty($list_child_array)) {
                foreach ($list_child_array as $item) {
                    if ($item['gender'] == 'Nam' || $item['role'] !== 'Vợ') {
                        $row = [
                            'text' => [
                                'origin' => $item['full_name'],
                                'partner' => $this->_family->getByField('husband_id', $item['id'])->full_name ?? '',
                                'data-gender' => $item['gender'] == 'Nam' ? 'male' : 'female',
                                'data-type' => 'horizontal',
                            ]
                        ];

                        // Lấy danh sách con của item
                        $list_children = $this->_family->get_all_child($item['id']);
                        if (!empty($list_children)) {
                            $child2 = [];
                            foreach ($list_children as $item2) {
                                if ($item2['gender'] == 'Nam' || $item2['role'] !== 'Vợ') {
                                    $row2 = [
                                        'text' => [
                                            'origin' => $item2['full_name'],
                                            'partner' => $this->_family->getByField('husband_id', $item2['id'])->full_name ?? '',
                                            'data-gender' => $item2['gender'] == 'Nam' ? 'male' : 'female',
                                            'data-type' => 'horizontal',
                                        ]
                                    ];

                                    // Lấy danh sách con của item2
                                    $list_children2 = $this->_family->get_all_child($item2['id']);
                                    if (!empty($list_children2)) {
                                        $child3 = [];
                                        foreach ($list_children2 as $item3) {
                                            if ($item3['gender'] == 'Nam' || $item3['role'] !== 'Vợ') {
                                                $row3 = [
                                                    'text' => [
                                                        'origin' => $item3['full_name'],
                                                        'partner' => $this->_family->getByField('husband_id', $item3['id'])->full_name ?? '',
                                                        'data-gender' => $item3['gender'] == 'Nam' ? 'male' : 'female',
                                                        'data-type' => 'horizontal',
                                                    ]
                                                ];
                                                $child3[] = $row3; // Thêm vào mảng child3
                                            }
                                        }
                                        $row2['children'] = $child3; // Gán children cho item2
                                    }

                                    $child2[] = $row2; // Thêm vào mảng child2
                                }
                            }
                            $row['children'] = $child2; // Gán children cho item
                        }

                        $child[] = $row; // Thêm vào mảng child
                    }
                }
            }

            $tree['children'] = $child; // Gán children cho cây
        }
        return json_encode($tree);
    }

    public function pdf_huong_hoa()
    {
        $data = [];
        $data['class_css'] = 'top';
        $data['per_page'] = $per_page = $this->input->get('limit') ?: 1000; // Number of records per page
        $data['current_page'] = $current_page = $this->input->get('page') ?: 1; // Get current page from query params
        $data['offset'] = $offset = ($current_page - 1) * $per_page; // Calculate offset

        // Fetch total records and paginated records
        $total_records = $this->_family->count_user_die(); // Implement count_by_type in your model
        $data['list_user'] = $this->_family->get_user_die_paginated($per_page, $offset);
        $this->load->view($this->template_path . 'pdf/huong_hoa', $data);
    }
    public function search()
    {
        $query = $this->input->post('query');
        $data = $this->_family->filter_user($query);
        if (!empty($data)) foreach ($data as $key => $value) {
            $data[$key]['thumbnail'] = getImageThumb($value['thumbnail']);
        };
        $this->returnJson($data);
    }

    public function ajax_load($type)
    {
        switch ($type) {
            case 'doi':
                $listTree = $this->_family->get_unique_parent_ids();
                $output = [];
                $i = 1;
                if (!empty($listTree)) foreach ($listTree as $item) {
                    $output[] = ['id' => $item->parent_id, 'text' => "Đời " . $i];
                    $i++;
                }
                break;
            case 'thanhvien':
                $listTree = $this->_family->getDataAll(['gender' => 'Nam']);
                $output = [];
                $i = 1;
                if (!empty($listTree)) foreach ($listTree as $item) {
                    $item = (object) $item;
                    if ($item->gender == 'Nam' || $item->role == 'Nữ') {
                        $output[] = ['id' => $item->id, 'text' => $item->full_name];
                        $i++;
                    }
                }
                break;
        };
        $this->returnJson($output);
    }
}
