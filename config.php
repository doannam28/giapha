<?php

date_default_timezone_set("asia/ho_chi_minh");
$root = realpath(dirname(__FILE__));
$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

$url = "https://";

$root = str_replace("\\", '/', $root);
$url .= $domain;

define('ASSET_VERSION', '1.8.'.md5(time()));
define('AMP_ASSET_VERSION', '1.0.0');
define('BASE_URL', $url . '/');
define('DOMAIN_PLAY', $url . '/');
define('BASE_ADMIN_URL', BASE_URL . "admin/");
define('MEDIA_NAME', "media/"); //Tên đường dẫn lưu media
define('MEDIA_PATH', str_replace('\\', '/', $root . DIRECTORY_SEPARATOR . MEDIA_NAME)); //Đường dẫn lưu media
define('MEDIA_URL', BASE_URL . MEDIA_NAME);
define('TEMPLATES_ASSETS', BASE_URL . 'public/');

define('DB_DEFAULT_HOST', '127.0.0.1');
define('DB_DEFAULT_USER', 'giaphah1_db');
define('DB_DEFAULT_PASSWORD', 'bewHaz]4Q.P^jR-*');
define('DB_DEFAULT_NAME', 'giaphah1_db');

define('MAINTAIN_MODE', FALSE); //Bảo trì

define('DEBUG_MODE', FALSE);
define('CACHE_MODE', FALSE);
define('CACHE_FILE_MODE', FALSE);
define('CACHE_PREFIX_NAME', 'KS_');

define('MEDIA_HIDE_FOLDER', 'mcith|thumb|2019');
define('CACHE_ADAPTER', (!empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1') ? 'memcached' : 'file');
define('CACHE_TIMEOUT_LOGIN', 1800);

//Config zalo
define('ZALO_APP_ID_CFG', '1250780810165803242');
define('ZALO_APP_SECRET_KEY_CFG', 'Ui7fBnBF3r45Y3N1Igk9');
define('ZALO_CAL_BACK', BASE_URL . 'auth/loginzalo');
//define('ZALO_OA_SECRET_KEY_CFG','APS_');
//Config zalo
define('API_KEY', 'bsyb9w9vu7njewraemygpam3');

define('FB_API', '2618030124890231');
define('FB_SECRET', '6257cf7cd74343b5527dd43efba55880');
define('FB_VER', 'v2.9');

define('GG_API', '689686302228-ba71dd4fnncfddsf6o30gcbeidb5jngg.apps.googleusercontent.com');
define('GG_SECRET', 'P5BJVSsjeDkyvqm-mvZ-z-Mh');
define('GG_KEY', 'AIzaSyCOBA11YRsaiqqftlxbwZG_4FZbhmO9Mes'); //AIzaSyAhR8OG9cUL1jDfAAc6i35nt5Ki1ZJnykA
define('GG_CAPTCHA_MODE', FALSE);
define('GG_CAPTCHA_SITE_KEY', '6LdnG70UAAAAAGf8iRAzYQt7oFpEGhWLeh1s1UW7');