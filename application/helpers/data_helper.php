<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('getSetting')) {
    function getSetting($key_setting)
    {
        $instance = &get_instance();
        $instance->load->model('setting_model');
        $setting_model = new Setting_model();
        $data = $setting_model->get_setting_by_key($key_setting);
        return !empty($data) ? json_decode($data->value_setting) : '';
    }
}

if (!function_exists('getByIdPost')) {
    function getByIdPost($post_id)
    {
        $_this = &get_instance();
        $_this->load->model(array('post_model'));
        $post_model = new Post_model();
        $dataPost = $post_model->getById($post_id);
        return $dataPost;
    }
}

if (!function_exists('getByIdProduct')) {
    function getByIdProduct($product_id)
    {
        $_this = &get_instance();
        $_this->load->model('product_model');
        $product_model = new Product_model();
        $data = $product_model->getById($product_id, 'id,title,price,price_sale,size,mass,thumbnail,slug,guarantee');
        return $data;
    }
}

if (!function_exists('getDataProductID')) {
    function getDataProductID($post_id)
    {
        $_this = &get_instance();
        $_this->load->model('product_model');
        $product_model = new Product_model();
        $dataPost = $product_model->getDataProduct(1, 12, [], $post_id);
        return $dataPost;
    }
}

if (!function_exists('getDataPostID')) {
    function getDataPostID($post_id)
    {
        $_this = &get_instance();
        $_this->load->model(array('post_model'));
        $post_model = new Post_model();
        $dataPost = $post_model->getDataPostID($post_id);
        return $dataPost;
    }
}

if (!function_exists('getStore')) {
    function getStore()
    {
        $_this = &get_instance();
        $_this->load->model('store_model');
        $store_model = new Store_model();
        $data = $store_model->getDataStore();
        return $data;
    }
}

if (!function_exists('getDataProductType')) {
    function getDataProductType()
    {
        $_this = &get_instance();
        $_this->load->model('product_type_model');
        $product_type_model = new Product_type_model();
        $data = $product_type_model->getDataProductType();
        return $data;
    }
}

function toSlug($doc)
{
    $str = addslashes(html_entity_decode($doc));
    $str = toNormal($str);
    $str = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
    $str = preg_replace("/( )/", '-', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace("\/", '', $str);
    $str = str_replace("+", "", $str);
    $str = strtolower($str);
    $str = stripslashes($str);
    return trim($str, '-');
}
function toNormal($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str;
}

if (!function_exists('isMobileDevice')) {
    function isMobileDevice()
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}



if (!function_exists('getMenuParent')) {
    function getMenuParent($parent_id, $location = 0)
    {
        $_this = &get_instance();
        $_this->load->model('menus_model');
        $data = $_this->menus_model->getMenuParent($parent_id, $location);
        return $data;
    }
}
if (!function_exists('getListMenu')) {
    function getListMenu($parent_id)
    {
        $_this = &get_instance();
        $_this->load->model('menus_model');
        $data = $_this->menus_model->get_list_by_type($parent_id);
        return $data;
    }
}
if (!function_exists('getInfo')) {
    function getInfo($type = 'data_seo')
    {
        $_this = &get_instance();
        $_this->load->model('setting_model');
        $data = $_this->setting_model->getByField('key_setting', $type);
        return json_decode($data->value_setting);
    }
}
if (!function_exists('getMenu')) {
    function getMenu($location = 0)
    {
        $_this = &get_instance();
        $_this->load->model('menus_model');
        $data = $_this->menus_model->getMenu($location);
        return $data;
    }
}

if (!function_exists('recursive_child')) {
    function getListChild($parent_id)
    {
        $_this = &get_instance();
        $_this->load->model('category_model');
        $data = $_this->category_model->getListChild('product', $parent_id);
        return $data;
    }
}

if (!function_exists('getByIdCategory')) {
    function getByIdCategory($category_id)
    {
        $_this = &get_instance();
        $_this->load->model('category_model');
        $data = $_this->category_model->getByIdCached($category_id);
        return $data;
    }
}

if (!function_exists('show_price')) {
    function show_price($oneItem)
    {
        if (!empty($oneItem->price) && !empty($oneItem->price_sale)) {
            $html = '<p><b>Giá hãng:</b> 
            <span class="prbt">' . number_format($oneItem->price, 0, '', '.') . '₫</span></p><p><b>Giá KM:</b> 
            <span class="prsale">' . number_format($oneItem->price_sale, 0, '', '.') . '₫</span>
            </p>';
        } elseif (empty($oneItem->price_sale) && !empty($oneItem->price)) {
            $html = '<p><b>Giá:</b><span class="prsale">' . number_format($oneItem->price, 0, '', '.') . '₫</span></p>';
        } else {
            $html = '<p><b>L.hệ 0933 48 1979</b></p><p><span class="prsale">Để giảm giá 5-10%</span></p>';
        }
        return $html;
    }
}

if (!function_exists('show_price_detail')) {
    function show_price_detail($oneItem)
    {
        if (!empty($oneItem->price) && !empty($oneItem->price_sale)) {
            $price_remaining = $oneItem->price - $oneItem->price_sale;
            $sale = round((int)$price_remaining / (int)$oneItem->price * 100);
            $html = '<div class="gia-tct g2">
                            <span class="label">Giảm:</span>
                            <span class="devvn_price sale_amount"><span class="phantram" style="color: #ee3238;">-' . $sale . '%</span> (Tiết kiệm <span class="Price-amount">' . number_format($price_remaining, 0, '', '.') . '₫</span>)</span>
                        </div>
                        <div class="gia-tct g3">
                            <span class="label">Giá hãng:</span>
                            <span class="devvn_price"><del><span class="Price-amount " style="font-size: 16px !important;">' . number_format($oneItem->price, 0, '', '.') . '₫</span></del></span>
                        </div>
            <div class="gia-tct g1">
                            <span class="label">Giá giảm: </span>
                            <span class="devvn_price"> <span class="Price-amount" style="font-size: 18px !important;">' . number_format($oneItem->price_sale, 0, '', '.') . '₫</span></span>
                        </div>
                        
                        ';
        } elseif (empty($oneItem->price_sale) && !empty($oneItem->price)) {
            $html = '<div class="gia-tct g1">
                            <span class="label">Giá : </span>
                            <span class="devvn_price"> <span class="Price-amount" style="font-size: 16px !important;">' . number_format($oneItem->price, 0, '', '.') . '₫</span></span>
                        </div>';
        } else {
            $html = '<div class="gia-tct g1">
            <span class="label">Giá: </span>
            <span class="devvn_price" style="font-size: 16px !important;">Liên hệ</span>
            </div>';
        }
        return $html;
    }
}


if (!function_exists('show_sale')) {
    function show_sale($oneItem)
    {
        $html = '';
        if (!empty($oneItem->price) && !empty($oneItem->price_sale)) {
            $html = '<div class="ribbon1"><span></span></div>';
        }
        echo $html;
    }
}

if (!function_exists('show_price_cart')) {
    function show_price_cart($oneItem, $quality)
    {
        $html = '';
        if (!empty($oneItem->price) && !empty($oneItem->price_sale)) {
            $html = '<td class="text-center">' . number_format($oneItem->price_sale, 0, '', '.') . '<sup>₫</sup></td>
            <td class="text-center subtotal">' . number_format($oneItem->price_sale * $quality, 0, '', '.') . '<sup>₫</sup></td>';
        } elseif (!empty($oneItem->price) && empty($oneItem->price_sale)) {
            $html = '<td class="text-center">' . number_format($oneItem->price, 0, '', '.') . '<sup>₫</sup></td>
            <td class="text-center subtotal">' . number_format($oneItem->price * $quality, 0, '', '.') . '<sup>₫</sup></td>';
        } else {
            $html = '<td class="text-center">Liên hệ</td>
            <td class="text-center">Liên hệ</td>';
        }
        echo $html;
    }
}

if (!function_exists('show_price_cart_mobile')) {
    function show_price_cart_mobile($oneItem, $quality)
    {
        $html = '';
        if (!empty($oneItem->price) && !empty($oneItem->price_sale)) {
            $html = '<div class="content" style="padding-top: 6px;">
            <strong>Đơn giá:</strong> 
            <span style="text-transform: lowercase; color: red">' . number_format($oneItem->price_sale, 0, '', '.') . '
            <sup>₫</sup>
            </span>
            </div>
            <div class="content" style="padding-top: 6px;">
            <strong>Thành tiền:</strong> 
            <span style="text-transform: lowercase; color: red" class="subtotal">' . number_format($oneItem->price_sale * $quality, 0, '', '.') . '
            <sup>₫</sup>
            </span>
            </div>';
        } elseif (!empty($oneItem->price) && empty($oneItem->price_sale)) {
            $html = '<td class="text-center">' . number_format($oneItem->price, 0, '', '.') . '<sup>₫</sup></td>
            <td class="text-center subtotal">' . number_format($oneItem->price * $quality, 0, '', '.') . '<sup>₫</sup></td>';
        } else {
            $html = '<td class="text-center">Liên hệ</td>
            <td class="text-center">Liên hệ</td>';
        }
        echo $html;
    }
}

if (!function_exists('replace_content')) {
    function replace_content($content, $title = '')
    {
        require_once "simple_html_dom.php";
        if (!empty($content)) {
            $content = htmlentities($content, null, 'utf-8');
            $content = str_replace('/data/upload', 'public/media/upload', $content);
            $content = str_replace('/data/images/product', 'public/media/upload/product', $content);
            $content = str_replace('/data/images/product_images', 'public/media/upload/product_images', $content);
            $content = str_replace("/admin/https://ketsatgiadinh.vn", '', $content);
            $content = str_replace("https://ketsatgiadinh.vn", '', $content);
            $content = str_replace("https:/ketsatgiadinh.vn", '', $content);
            $content = str_replace('//', '/', $content);
            $content = str_replace("/admin/", '', $content);
            //            $content = preg_replace('/(style=".*?")/m','',$content);
            $content = preg_replace('/font-family.+?;/', '', $content);
            $content = html_entity_decode($content);
            $content = str_replace('%20', ' ', $content);
            if (preg_match_all('#<img[^>]*src[^>]*>#Usmi', $content, $matches)) {
                foreach ($matches[0] as $key => $tag) {
                    //                    if($key < 3 )continue;
                    $doc = $tag;
                    $html = str_get_html($doc);
                    $width = !empty($html->find('img', 0)) ? $html->find('img', 0)->getAttribute('width') : '';
                    $height = !empty($html->find('img', 0)) ? $html->find('img', 0)->getAttribute('height') : '';
                    $altAtr = !empty($html->find('img', 0)) ? $html->find('img', 0)->getAttribute('alt') : '';
                    if (preg_match_all('#src=(?:"|\')(?!data)(.*)(?:"|\')#Usmi', $tag, $urls, PREG_SET_ORDER)) {
                        $width = !empty($width) ? "width='$width'" : "width='500'";
                        $height = !empty($height) ? "height='$height'" : "height='500'";
                        $alt = !empty($altAtr) ? "alt='$altAtr'" : "alt='$title'";
                        $altText = !empty($altAtr) ? $altAtr : $title;
                        $caption = "caption='false'";
                        foreach ($urls as $url) {
                            $full_src_orig = $url[0];
                            $url           = $url[1];
                            $new_img = "<figure><img class='lazy img-fluid' $width $height $caption $alt data-src='$url' /><figcaption>$altText</figcaption></figure>";
                            $content = str_replace($tag, $new_img, $content);
                        }
                    };
                }
            }
        } else {
            $content = 'Đang cập nhật';
        }
        return $content;
    }
}


if (!function_exists('convertDetailTime')) {
    function convertDetailTime($time)
    {
        $dow = getDay($time, 0);
        $date = date("d/m/Y", strtotime($time));
        $time = date("H:i", strtotime($time));
        return "{$dow}, ngày {$date} - {$time}";
    }
}
function getDay($time, $type = 0)
{
    $getday = date('D', strtotime($time));
    $arrayDay = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $arrayDayVn = ['Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy', 'Chủ Nhật'];
    $arrayDayNumber = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];
    $arrayDayLinkLite = ['thu-2', 'thu-3', 'thu-4', 'thu-5', 'thu-6', 'thu-7', 'chu-nhat'];
    $arrayDayLink = ['t2', 't3', 't4', 't5', 't6', 't7', 'cn'];
    if ($type == 0) {
        for ($i = 0; $i < count($arrayDay); $i++) {
            if ($getday == $arrayDay[$i]) {
                return $arrayDayVn[$i];
            };
        };
    };
    if ($type == 1) {
        for ($i = 0; $i < count($arrayDay); $i++) {
            if ($getday == $arrayDay[$i]) {
                return $arrayDayLink[$i];
            };
        };
    };
    if ($type == 2) {
        for ($i = 0; $i < count($arrayDay); $i++) {
            if ($getday == $arrayDay[$i]) {
                return $arrayDayLinkLite[$i];
            };
        };
    };
    if ($type == 3) {
        for ($i = 0; $i < count($arrayDay); $i++) {
            if ($getday == $arrayDay[$i]) {
                return $arrayDayNumber[$i];
            };
        };
    };
    if ($type == 4) {
        $current_type_6 = 'ngày ' . date('j', strtotime($time)) . ' tháng ' . date('n', strtotime($time)) . ' năm ' . date('Y', strtotime($time));
        return $current_type_6;
    }
}

function optimize_image($content)
{
    if (preg_match_all('#<img[^>]*src[^>]*>#Usmi', $content, $matches)) {
        foreach ($matches[0] as $tag) {
            if (preg_match_all('#src=(?:"|\')(?!data)(.*)(?:"|\')#Usmi', $tag, $urls, PREG_SET_ORDER)) {
                foreach ($urls as $url) {
                    $full_src_orig = $url[0];
                    $url           = $url[1];
                    $new_img = "<img class='lazy img-fluid' data-src-orign='$full_src_orig' data-src='$url' />";
                    $content = str_replace($tag, $new_img, $content);
                }
            };
        }
    }
    return $content;
}

if (!function_exists('toNormalTitle')) {
    function toNormalTitle($str)
    {
        $str = str_replace("'", '', $str);
        $str = str_replace('"', '', $str);
        return $str;
    }
}
