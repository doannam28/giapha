<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

if (!function_exists('getImageThumb')) {
    function getImageThumb($image = '', $width = '', $height = '', $crop = true)
    {
        $_this = &get_instance();
        if (empty($image)) {
            return base_url() . "public/default-thumbnail.webp";
        }
        if (strpos($image, 'http') !== false) return $image;
        if ($crop == false || empty($width)) {
            return MEDIA_URL . $image;
        }
        $image = trim($image);
        $imageOrigin = MEDIA_PATH . "/" . $image;
        $sizeText = sprintf('-%dx%d', $width, $height);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $newImage = str_replace(".$ext", "$sizeText.webp", $image); // Đổi sang .webp
        $pathThumb = MEDIA_PATH . '/thumb/' . $newImage;
        $pathThumb = str_replace('//', '/', $pathThumb);

        if (!file_exists($pathThumb)) {
            try {
                if (!is_dir(dirname($pathThumb))) {
                    mkdir(dirname($pathThumb), 0755, TRUE);
                }
                Image::configure(array('driver' => 'gd'));

                if (intval($width) > 0 && intval($height) > 0) {
                    $image = Image::make($imageOrigin)->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $image = Image::make($imageOrigin);
                }
                // Lưu ảnh dưới định dạng WebP
                $image->encode('webp', 90); // Chất lượng 90%
                $image->save($pathThumb);
            } catch (Exception $e) {
                // Xử lý lỗi (có thể thêm logging ở đây)
            }
        }

        $thumbnail_new = MEDIA_URL . str_replace('//', '/', 'thumb/' . $newImage);
        return $thumbnail_new . '?v=1';
    }
}

if (!function_exists('getWatermark')) {
    function getWatermark($oneItem = '', $width = '', $height = '', $crop = true)
    {
        $_this = &get_instance();
        $image = $oneItem->thumbnail;
        if (empty($image)) {
            return base_url() . "public/default-thumbnail.webp";
        }
        if ($crop == false || empty($width)) {
            return base_url('public/media') . $image;
        }
        $image = trim($image);
        $imageOrigin = MEDIA_PATH . "/" . $image;
        $sizeText = sprintf('-%dx%d', $width, $height);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $newImage = str_replace(".$ext", "$sizeText.webp", $image); // Đổi sang .webp
        $pathThumb = MEDIA_PATH . '/thumb/' . $newImage;
        $pathThumb = str_replace('//', '/', $pathThumb);
        if (!file_exists($pathThumb)) {
            try {
                if (!is_dir(dirname($pathThumb))) {
                    mkdir(dirname($pathThumb), 0755, TRUE);
                }
                Image::configure(array('driver' => 'gd'));

                if (intval($width) > 0 && intval($height) > 0) {
                    if (!empty($oneItem->watermark)) {
                        $settings  = getSetting('data_seo');
                        $watermark = MEDIA_PATH . $settings->watermark;
                        $image = Image::make($imageOrigin)->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        })->insert($watermark, 'center', 10, 10);
                    } else {
                        $image = Image::make($imageOrigin)->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                } else {
                    $image = Image::make($imageOrigin);
                }
                // Lưu ảnh dưới định dạng WebP
                $image->encode('webp', 90); // Chất lượng 90%
                $image->save($pathThumb);
            } catch (Exception $e) {
                // Xử lý lỗi (có thể thêm logging ở đây)
            }
        }

        $thumbnail_new = MEDIA_URL . str_replace('//', '/', 'thumb/' . $newImage);
        return $thumbnail_new . '?v=' . time();
    }
}

if (!function_exists('getThumbnail')) {
    function getThumbnail($data, $width = '100%', $height = '100%', $class = '', $crop = true)
    {
        $_this = &get_instance();
        $data = '<img width="' . $width . '" height="' . $height . '" loading="lazy" class="lazy ' . $class . '" src="' . $_this->templates_assets . 'dot.webp" data-src="' . getWatermark($data, $width, $height, $crop) . '" alt="' . $data->title . '"/>';
        echo $data;
    }
}

if (!function_exists('getThumbnailStatic')) {
    function getThumbnailStatic($thumbnail, $alt = '', $class = '')
    {
        $_this = &get_instance();
        $data = '<img class="lazy ' . $class . '" src="' . $_this->templates_assets . 'dot.webp" data-src="' . $thumbnail . '" alt="' . $alt . '"/>';
        echo $data;
    }
}

if (!function_exists('getImage')) {
    function getImage($thumbnail, $alt = '', $width = '', $height = '', $class = '', $crop = false)
    {
        $_this = &get_instance();
        $data = '<img loading="lazy" class="' . $class . '" src="' . getImageThumb($thumbnail, $width, $height, $crop) . '" alt="' . $alt . '"/>';
        echo $data;
    }
}
