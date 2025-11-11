<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'family/index';
$route['default'] = 'home';
$route['translate_uri_dashes'] = FALSE;
$route['404.html'] = 'page/notfound';
$route['404_override'] = 'home/notfound';
$route['admin'] = 'admin/dashboard';

$route['(:any).html'] = 'family/index';
$route['gia-pha'] = 'family/index';
$route['gioi-thieu'] = 'intro/index';
$route['lich-su'] = 'intro/history';
$route['tu-duong'] = 'intro/home';
$route['tin-tuc/(:any)'] = 'intro/news/$1';
$route['tin-tuc/(:any)/(:num)'] = 'intro/news/$1/$2';
$route['nganh-nghe'] = 'home/jobs';
$route['nganh-nghe/(:num)'] = 'home/jobs/$1';
$route['bang-vang'] = 'home/rank';
$route['bang-vang/(:num)'] = 'home/rank/$1';
$route['lien-he'] = 'home/contact';
$route['khu-mo'] = 'home/khumo';
$route['gia-pha/pha-do'] = 'family/phado';
$route['gia-pha/toc-uoc'] = 'family/toc_uoc';
$route['gia-pha/huong-hoa'] = 'family/huong_hoa';
$route['gia-pha/huong-hoa/(:num)'] = 'family/huong_hoa/$1';
$route['gia-pha/ngay-gio'] = 'family/ngay_gio';
$route['gia-pha/ngay-gio/(:num)'] = 'family/ngay_gio/$1';
$route['chi-tiet/(:any)'] = 'intro/detail/$1';
$route['pha-do-chi-tiet/(:any)'] = 'family/phado_chi_tiet/$1';
$route['quan-ly-quy'] = 'home/fund/quy-dong-ho';
$route['quan-ly-quy/(:any)'] = 'home/fund/$1';
$route['quan-ly-quy/(:any)/(:num)'] = 'home/fund/$1/$2';
$route['tai-lieu'] = 'home/files/hinh-anh';
$route['tai-lieu/(:any)'] = 'home/files/$1';
$route['tai-lieu/(:any)/(:any)'] = 'home/detail_files/$1/$2';
$route['tim-kiem'] = 'intro/search';

$route['pdf/gia_pha'] = 'family/pdf_gia_pha';
$route['pdf/huong_hoa'] = 'family/pdf_huong_hoa';
$route['uploads/(.*)'] = function ($file) {
    // Trả về file trực tiếp từ thư mục uploads
    $path = FCPATH . 'uploads/' . $file;
    if (file_exists($path)) {
        // Gửi header và file
        header('Content-Type: ' . mime_content_type($path));
        readfile($path);
        exit;
    } else {
        show_404();
    }
};
