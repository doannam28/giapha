<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (! function_exists('site_admin_url')) {
    function site_admin_url($uri = '')
    {
        return BASE_ADMIN_URL . $uri;
    }
}
if (!function_exists('get_url_page')) {
    function get_url_page($optional)
    {
        $linkReturn = BASE_URL . $optional->slug . '.html';
        return $linkReturn;
    }
}
if (!function_exists('cutString')) {
    function cutString($chuoi, $max)
    {
        $length_chuoi = strlen($chuoi);
        if ($length_chuoi <= $max) {
            return $chuoi;
        } else {
            return mb_substr($chuoi, 0, $max, 'UTF-8') . '...';
        }
    }
}

if (!function_exists('get_url_product_type')) {
    function get_url_product_type($optional, $page = '')
    {
        $optional = (object)$optional;
        $linkReturn = BASE_URL . 'pb' . $optional->id . '_' . $optional->slug . '.html';
        if (!empty($page)) $linkReturn .= "/page";
        return $linkReturn;
    }
}

if (!function_exists('get_url_category_product')) {
    function get_url_category_product($optional, $page = '')
    {
        $linkReturn = BASE_URL . 'pd' . $optional->id . '_' . $optional->slug . '.html';
        if (!empty($page)) $linkReturn .= "/page";
        return $linkReturn;
    }
}

if (!function_exists('get_url_category_post')) {
    function get_url_category_post($optional, $page = '')
    {
        $linkReturn = BASE_URL . $optional->slug . '.html';
        if (!empty($page)) $linkReturn .= "/page";
        return $linkReturn;
    }
}

if (!function_exists('get_url_category_product_menu')) {
    function get_url_category_product_menu($optional)
    {
        if (empty($optional->link)) {
            return base_url();
        }
        $linkReturn = BASE_URL . 'pd' . $optional->data_id . '_' . $optional->link . '.html';
        return $linkReturn;
    }
}

if (!function_exists('get_url_post')) {
    function get_url_post($optional)
    {
        $linkReturn = BASE_URL . $optional->slug . '.html';
        return $linkReturn;
    }
}

if (!function_exists('get_url_product')) {
    // function get_url_product($optional)
    // {
    //     $linkReturn = BASE_URL . 'pc' . $optional->id . '_' . $optional->slug . '.html';
    //     return $linkReturn;
    // }

    function get_url_product($optional)
    {
        $linkReturn = BASE_URL . 'san-pham/' . $optional->slug . '.html';
        return $linkReturn;
    }

}

if (!function_exists('get_url_bao_gia')) {
    function get_url_bao_gia($optional, $page = '')
    {
        $linkReturn = BASE_URL . 'am_' . $optional->slug . '.html';
        if (!empty($page)) $linkReturn .= "/page";
        return $linkReturn;
    }
}



if (!function_exists('get_url_customer')) {
    function get_url_customer($optional)
    {
        $linkReturn = BASE_URL . 'as' . $optional->id . '_' . $optional->slug . '.html';
        return $linkReturn;
    }
}

if (!function_exists('getDayOfWeek')) {
    function getDayOfWeek($date, $style = false)
    {
        switch (date('N', strtotime($date))) {
            case 1:
                $titleDay = "Thứ hai";
                break;

            case 2:
                $titleDay = "Thứ ba";
                break;

            case 3:
                $titleDay = "Thứ tư";
                break;

            case 4:
                $titleDay = "Thứ năm";
                break;

            case 5:
                $titleDay = "Thứ sáu";
                break;

            case 6:
                $titleDay = "Thứ bảy";
                break;
            case 7:
                $titleDay = "Chủ nhật";
                break;
            default:
                $titleDay = "";
        }
        if ($style) {
            $temp = explode(' ', $titleDay);
            $titleDay = "<i>$temp[0]&nbsp;</i>$temp[1]";
        }
        return $titleDay;
    }
}
