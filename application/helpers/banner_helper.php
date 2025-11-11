<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function get_banner($location){
    $ci =& get_instance();
    $ci->load->model('banner_model');
    $bannerModel = new Banner_model();
    $q = $bannerModel->getBanner($location);
    return $q;
}
?>
