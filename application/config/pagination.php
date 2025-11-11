<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$config['num_links'] = 9;
$config['last_link'] = '››';
$config['first_link'] ='‹‹';
$config['enable_query_strings'] = TRUE;
$config['use_page_numbers'] = TRUE;
/*SET PARAM PAGE*/
$config['page_query_string'] = FALSE;
$config['query_string_segment'] = 'page';
/*SET PARAM PAGE*/
$config['reuse_query_string'] = TRUE;
$config['full_tag_open'] = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';
$config['first_tag_open'] = '<li id="page-links" class="pagination__page">';
$config['first_tag_close'] = '</li>';
$config['next_tag_open'] = '<li id="page-links" class="pagination__page">';
$config['next_tag_close'] = '</li>';
$config['prev_tag_open'] = '<li id="page-links" class="pagination__page">';
$config['prev_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="pagination__page active">';
$config['cur_tag_close'] = '</li>';
$config['num_tag_open'] = '<li id="page-links" class="pagination__page">';
$config['num_tag_close'] = '</li>';
$config['last_tag_open'] = '<li id="page-links" class="pagination__page">';
$config['last_tag_close'] = '</li>';

$config['prev_link'] = '<span aria-hidden="true">‹</span>';
$config['next_link'] = '<span aria-hidden="true">›</span>';
$config['display_pages'] = true;
