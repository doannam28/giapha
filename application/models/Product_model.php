<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends STEVEN_Model
{
    public $table;
    public $table_category;
    public $category;
    public $product_type_category;

    public function __construct()
    {
        parent::__construct();
        $this->table          = "product";
        //        $this->table2         = "product2";
        $this->table_category = "product_category";
        $this->product_type_category = "product_type_category";
        $this->category       = "category";
        $this->column_order = array("$this->table.id", "$this->table.id", "title", "$this->table.is_status", "$this->table.created_time", "$this->table.updated_time");
        $this->column_search = array('title', 'code', 'price', 'slug');
        $this->order_default = array("$this->table.created_time" => 'desc');
    }

    public function _where_custom($args = array())
    {
        parent::_where_custom();
        extract($args);

        if (!empty($category_id)) {
            $this->db->join($this->table_category, "$this->table.id = $this->table_category.product_id");
            $this->db->where_in("$this->table_category.category_id", $category_id);
        }

        if (!empty($product_type_id)) {
            $this->db->join($this->product_type_category, "$this->table.id = $this->product_type_category.product_id");
            $this->db->where_in("$this->product_type_category.product_type_id", $product_type_id);
        }

        if (isset($is_sale)) $this->db->where("is_sale", $is_sale);
        if (isset($is_type)) $this->db->where("is_type", $is_type);
        if (isset($product_id)) $this->db->where("id", $product_id);
        if (isset($is_best_sale)) $this->db->where("is_best_sale", $is_best_sale);
    }

    //    public function getProduct2()
    //    {
    //        $this->db->select('id,title,region');
    //        $this->db->from($this->table2);
    //        $query = $this->db->get()->result();
    //        return $query;
    //    }

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
        $this->db->where($this->table_category . ".product_id", $id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getSelect2ProductTypeCategory($id)
    {
        $this->db->select("$this->product_type_category.product_type_id AS id, title AS text");
        $this->db->from($this->product_type_category);
        $this->db->join("product_type", "$this->product_type_category.product_type_id = product_type.id");
        $this->db->where($this->product_type_category . ".product_id", $id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function dataProductCategoryType($id)
    {
        $this->db->select('*');
        $this->db->from($this->product_type_category);
        $this->db->join("product_type", "$this->product_type_category.product_type_id = product_type.id");
        $this->db->where($this->product_type_category . ".product_id", $id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDataProductSale()
    {
        $key = 'getDataProductSale';
        $data = $this->getCache($key);
        if (empty($data)) {
            $this->db->select('id,title,slug,is_new,thumbnail,price,price_sale,size,mass,watermark');
            $this->db->from($this->table);
            $this->db->where('is_status', 1);
            $this->db->where('is_sale', 1);
            $this->db->order_by('order_home', 'asc');
            $this->db->limit(10);
            $data = $this->db->get()->result();
            $this->setCache($key, $data, 60 * 60 * 2);
        }
        return $data;
    }

    public function getDataProductBestSale()
    {
        $key = 'getDataProductBestSale';
        $data = $this->getCache($key);
        if (empty($data)) {
            $this->db->select('id,title,is_new,slug,thumbnail,price,price_sale,size,mass,watermark');
            $this->db->from($this->table);
            $this->db->where('is_status', 1);
            $this->db->where('is_best_sale', 1);
            $this->db->order_by('order_home', 'asc');
            $this->db->limit(10);
            $data = $this->db->get()->result();
            $this->setCache($key, $data, 60 * 60 * 2);
        }
        return $data;
    }

    public function getDataProductTypeHome()
    {
        $key = 'getDataProductTypeHome';
        $data = $this->getCache($key);
        if (empty($data)) {
            $this->db->select('id,title,slug,thumbnail,is_new,price,price_sale,size,mass,watermark');
            $this->db->from($this->table);
            $this->db->where('is_status', 1);
            $this->db->where('is_type', 1);
            $this->db->order_by('order_home', 'asc');
            $this->db->limit(20);
            $data = $this->db->get()->result();
            $this->setCache($key, $data, 60 * 60 * 2);
        }
        return $data;
    }

    public function getDataProductHot()
    {
        $key = 'getDataProductHot';
        $data = $this->getCache($key);
        if (empty($data)) {
            $this->db->select('id,title,slug,thumbnail,is_new,price,price_sale,size,mass,watermark');
            $this->db->from($this->table);
            $this->db->where('is_status', 1);
            $this->db->where('is_featured', 1);
            $this->db->order_by('created_time', 'desc');
            $this->db->limit(4);
            $data = $this->db->get()->result();
            $this->setCache($key, $data, 60 * 60 * 2);
        }
        return $data;
    }

    public function getDataProductByCategory($array_category)
    {
        $data = [];
        if (!empty($array_category)) {
            $this->db->select('a.id,a.title,a.description,a.slug,a.is_new,a.thumbnail,a.price,a.price_sale,a.size,a.mass,a.watermark,a.order_home,a.is_home,a.content,a.created_time,a.updated_time');
            $this->db->from($this->table . ' a');
            $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
            $this->db->where('a.is_status', 1);
            $this->db->where('a.is_home', 1);
            $this->db->where_in('b.category_id', $array_category);
            $this->db->order_by('a.order_home', 'asc');
            $this->db->order_by("FIELD(b.category_id," . join(',', $array_category) . ")");
            $data = $this->db->get()->result();
        }
        return $data;
    }

    public function getDataProductByCategoryType($array_category)
    {
        $data = [];
        if (!empty($array_category)) {
            $this->db->select('a.id,a.title,a.slug,a.is_new,a.thumbnail,a.price,a.price_sale,a.size,a.mass,a.watermark,a.order_home,a.is_home');
            $this->db->from($this->table . ' a');
            $this->db->join($this->product_type_category . ' b', 'a.id = b.product_id');
            $this->db->where('a.is_status', 1);
            $this->db->where('a.is_type', 1);
            $this->db->where_in('b.product_type_id', $array_category);
            $this->db->order_by('a.order_home', 'asc');
            $data = $this->db->get()->result();
        }
        return $data;
    }


    //Lấy danh mục sản phẩm
    public function getByIdCategoryProduct($product_id)
    {
        $this->db->select('b.id,b.title,b.slug');
        $this->db->from($this->table_category . ' a');
        $this->db->join($this->category . ' b', 'a.category_id = b.id');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('is_status', 1);
        $data = $this->db->get()->row();
        return $data;
    }

    public function getDataProductRelated($array_category, $not_id, $limit = 8, $start_price = 0, $end_price = 0, $page = 1)
    {
        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.size,a.mass,a.watermark,a.order');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
        if (!empty($array_category)) {
            $this->db->where_in('b.category_id', $array_category);
            $this->db->order_by("FIELD(b.category_id," . join(',', $array_category) . ")");
        }
        $this->db->order_by('order', 'ASC');
        if (!empty($not_id)) $this->db->where_not_in('b.product_id', $not_id);
        if (!empty($start_price)) {
            $this->db->where('a.price_sale >=', $start_price * 1000000);
            $this->db->where('a.price_sale <=', $end_price * 1000000);
            $this->db->where('is_filter', 1);
        }
        $this->db->where('is_status', 1);
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDataProductFE($args)
    {
        $array_category = [];
        $not_id = [];
        $limit = 8;
        $start_price = 0;
        $end_price = 0;
        $page = 1;
        extract($args);

        $this->db->select('a.id, a.title, a.slug, a.thumbnail, a.price, a.price_sale, a.size, a.mass, a.watermark, a.order, GROUP_CONCAT(c.product_type_id) as product_type_id');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
        $this->db->join($this->product_type_category . ' c', 'a.id = c.product_id', 'left');
        $this->db->group_by('a.id');
        if (!empty($array_category)) {
            $this->db->where_in('b.category_id', $array_category);
            $this->db->order_by("FIELD(b.category_id," . join(',', $array_category) . ")");
        };
        if (!empty($ProductTypeChecked)) {
            foreach ($ProductTypeChecked as $id) {
                $this->db->having("SUM(FIND_IN_SET('$id', c.product_type_id)) > 0");
            }
        }
        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        } else $this->db->order_by('order', 'ASC');
        if (!empty($not_id)) $this->db->where_not_in('b.product_id', $not_id);
        if (!empty($start_price)) {
            $this->db->where('a.price_sale >=', $start_price * 1000000);
            $this->db->where('a.price_sale <=', $end_price * 1000000);
            $this->db->where('is_filter', 1);
        };
        if (!empty($is_best_sale)) $this->db->where('is_best_sale', 1);
        $this->db->where('is_status', 1);
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getTotalDataProductFE($args)
    {
        $array_category = [];
        $not_id = [];
        $limit = 500000;
        $start_price = 0;
        $end_price = 0;
        $page = 1;
        extract($args);

        $this->db->select('a.id, a.title, a.slug, a.thumbnail, a.price, a.price_sale, a.size, a.mass, a.watermark, a.order, GROUP_CONCAT(c.product_type_id) as product_type_id');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
        $this->db->join($this->product_type_category . ' c', 'a.id = c.product_id', 'left');
        $this->db->group_by('a.id');
        if (!empty($array_category)) {
            $this->db->where_in('b.category_id', $array_category);
            $this->db->order_by("FIELD(b.category_id," . join(',', $array_category) . ")");
        };
        if (!empty($ProductTypeChecked)) {
            foreach ($ProductTypeChecked as $id) {
                $this->db->having("SUM(FIND_IN_SET('$id', c.product_type_id)) > 0");
            }
        }
        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        } else $this->db->order_by('order', 'ASC');
        if (!empty($not_id)) $this->db->where_not_in('b.product_id', $not_id);
        if (!empty($start_price)) {
            $this->db->where('a.price_sale >=', $start_price * 1000000);
            $this->db->where('a.price_sale <=', $end_price * 1000000);
            $this->db->where('is_filter', 1);
        };
        if (!empty($is_best_sale)) $this->db->where('is_best_sale', 1);
        $this->db->where('is_status', 1);
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function getDataProductCategoryTypeFE($args)
    {
        $product_type = [];
        $not_id = [];
        $limit = 8;
        $start_price = 0;
        $end_price = 0;
        $page = 1;
        extract($args);

        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.size,a.mass,a.watermark, b.category_id');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
        $this->db->join($this->product_type_category . ' c', 'a.id = c.product_id');
        if (!empty($brand)) {
            $this->db->where_in("b.category_id", $brand);
        };
        if (!empty($product_type)) $this->db->where_in('c.product_type_id', $product_type);
        if (!empty($start_price)) {
            $this->db->where('a.price_sale >=', $start_price * 1000000);
            $this->db->where('a.price_sale <=', $end_price * 1000000);
            $this->db->where('is_filter', 1);
        };
        $this->db->where('is_status', 1);
        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        } else $this->db->order_by('order', 'asc');
        if (!empty($is_best_sale)) $this->db->where('is_best_sale', 1);
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getTotalDataProductCategoryTypeFE($args)
    {
        $product_type = [];
        $not_id = [];
        $limit = 500000;
        $start_price = 0;
        $end_price = 0;
        $page = 1;
        extract($args);

        $this->db->select('a.id');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
        $this->db->join($this->product_type_category . ' c', 'a.id = c.product_id');
        if (!empty($brand)) {
            $this->db->where_in("b.category_id", $brand);
        };
        if (!empty($product_type)) $this->db->where_in('c.product_type_id', $product_type);
        if (!empty($start_price)) {
            $this->db->where('a.price_sale >=', $start_price * 1000000);
            $this->db->where('a.price_sale <=', $end_price * 1000000);
            $this->db->where('is_filter', 1);
        };
        $this->db->where('is_status', 1);
        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        } else $this->db->order_by('order', 'asc');
        if (!empty($is_best_sale)) $this->db->where('is_best_sale', 1);
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function getDataProductCategoryType($product_type_id = [], $page = 1, $limit = 28, $start_price = 0, $end_price = 0, $order)
    {
        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.size,a.mass,a.watermark');
        $this->db->from($this->table . ' a');
        $this->db->join($this->product_type_category . ' b', 'a.id = b.product_id');
        if (!empty($product_type_id)) $this->db->where_in('b.product_type_id', $product_type_id);
        if (!empty($start_price)) {
            $this->db->where('a.price_sale >=', $start_price * 1000000);
            $this->db->where('a.price_sale <=', $end_price * 1000000);
            $this->db->where('is_filter', 1);
        }
        $this->db->where('is_status', 1);
        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        } else $this->db->order_by('order', 'asc');
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDataProductCategoryTypeTotal($product_type_id = [], $start_price = 0, $end_price = 0)
    {
        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.size,a.mass,a.watermark');
        $this->db->from($this->table . ' a');
        $this->db->join($this->product_type_category . ' b', 'a.id = b.product_id');
        if (!empty($product_type_id)) $this->db->where_in('b.product_type_id', $product_type_id);
        if (!empty($start_price)) {
            $this->db->where('a.price_sale >=', $start_price * 1000000);
            $this->db->where('a.price_sale <=', $end_price * 1000000);
            $this->db->where('is_filter', 1);
        }
        $this->db->where('is_status', 1);
        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function getTotalProductRelated($array_category, $not_id = '', $start_price = 0, $end_price = 0)
    {
        $this->db->select('a.id');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
        $this->db->where_in('b.category_id', $array_category);
        if (!empty($not_id)) $this->db->where_not_in('b.product_id', $not_id);
        if (!empty($start_price)) {
            $this->db->where('a.price_sale >=', $start_price * 1000000);
            $this->db->where('a.price_sale <=', $end_price * 1000000);
            $this->db->where('is_filter', 1);
        }
        $this->db->where('is_status', 1);
        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function getDataProductType($product_type_id, $not_id, $limit = 5)
    {
        $this->db->select('id,title,slug,thumbnail,price,price_sale,size,mass,watermark');
        $this->db->from($this->table);
        $this->db->where('product_type_id', $product_type_id);
        if (!empty($not_id)) $this->db->where_not_in('id', $not_id);
        $this->db->where('is_status', 1);
        $this->db->order_by('created_time', 'desc');
        $this->db->limit($limit);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDataProductTypeIn($product_type_id, $not_id, $limit = 5)
    {
        $this->db->select('id,title,slug,thumbnail,price,price_sale,size,mass,watermark');
        $this->db->from($this->table);
        $this->db->where_in('product_type_id', $product_type_id);
        if (!empty($not_id)) $this->db->where_not_in('id', $not_id);
        $this->db->where('is_status', 1);
        $this->db->order_by("FIELD(product_type_id," . join(',', $product_type_id) . ")");
        $this->db->limit($limit);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDataProductHistory($product_arr_id, $not_id = [])
    {
        $product_arr_id = array_reverse($product_arr_id);
        $this->db->select('id,title,slug,thumbnail,price,price_sale,size,mass,watermark');
        $this->db->from($this->table);
        $this->db->where_in('id', $product_arr_id);
        if (!empty($not_id)) $this->db->where_not_in('id', $not_id);
        $this->db->where('is_status', 1);
        $this->db->order_by("FIELD(id," . join(',', $product_arr_id) . ")");
        $this->db->limit(10);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDataSearchProduct($keyword)
    {
        $this->db->select('id,title,slug,thumbnail,price,price_sale,size,mass,watermark');
        $this->db->from($this->table);
        $this->db->like('title', $keyword);
        $this->db->where('is_status', 1);
        $this->db->order_by('created_time', 'desc');
        $this->db->limit(28);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDataProduct($page, $limit, $not_id_arr, $category_id)
    {
        $this->db->select('a.id,a.title,a.slug,a.thumbnail,a.price,a.price_sale,a.size,a.mass,a.watermark');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
        if (!empty($not_id_arr)) $this->db->where_not_in('a.id', $not_id_arr);
        if (!empty($category_id)) $this->db->where_in('b.category_id', $category_id);
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        $this->db->where('a.is_status', 1);
        $this->db->order_by('a.created_time', 'desc');
        $data = $this->db->get()->result();
        return $data;
    }

    public function getTotalProduct($not_id_arr, $category_id)
    {
        $this->db->select('a.id');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
        if (!empty($not_id_arr)) $this->db->where_not_in('a.id', $not_id_arr);
        if (!empty($category_id)) $this->db->where_in('b.category_id', $category_id);
        $this->db->where('a.is_status', 1);
        $data = $this->db->get()->num_rows();
        return $data;
    }

    public function getDataProductInBaoGia($arr_product_id)
    {
        $this->db->select('id,title,slug,thumbnail,price,price_sale,size,mass,guarantee,watermark');
        $this->db->from($this->table);
        $this->db->where_in('id', $arr_product_id);
        $this->db->where('is_status', 1);
        $this->db->order_by('created_time', 'desc');
        $data = $this->db->get()->result();
        return $data;
    }

    public function getDataAllP($id, $ProductTypeChecked, $order)
    {
        $this->db->select('GROUP_CONCAT(c.product_type_id) as product_type');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
        $this->db->join($this->product_type_category . ' c', 'a.id = c.product_id');
        $this->db->group_by('a.id');
        $this->db->where('b.category_id', $id);
        if (!empty($ProductTypeChecked)) {
            foreach ($ProductTypeChecked as $id) {
                $this->db->having("SUM(FIND_IN_SET('$id', c.product_type_id)) > 0");
            }
        };
        if (!empty($order) && !empty($order['order'])) {
            foreach ($order['order'] as $key => $value) {
                $this->db->order_by($key, $value);
            }
        };
        if (!empty($order) && !empty($order['is_best_sale'])) {
            $this->db->where('is_best_sale', 1);
        };
        $this->db->where('is_status', 1);
        $this->db->order_by("FIELD(b.category_id, $id)");
        $data = $this->db->get()->result_array();
        $data = $this->_group_by($data);
        return $data;
    }

    public function getDataAllB($id, $order)
    {
        $this->db->select('b.category_id as product_type');
        $this->db->from($this->table . ' a');
        $this->db->join($this->table_category . ' b', 'a.id = b.product_id');
        $this->db->join($this->product_type_category . ' c', 'a.id = c.product_id');
        $this->db->where('c.product_type_id', $id);
        if (!empty($order) && !empty($order['order'])) {
            foreach ($order['order'] as $key => $value) {
                $this->db->order_by($key, $value);
            }
        };
        if (!empty($order) && !empty($order['is_best_sale'])) {
            $this->db->where('is_best_sale', 1);
        };
        $this->db->where('is_status', 1);
        $this->db->order_by("FIELD(b.category_id, $id)");
        $data = $this->db->get()->result_array();
        $data = $this->_group_by($data);
        return $data;
    }

    function _group_by($array)
    {
        $return = array();
        foreach ($array as $val) {
            foreach (explode(',', $val['product_type']) as $key => $value) {
                $return[] = $value;
            }
        }
        return $return;
    }
}
