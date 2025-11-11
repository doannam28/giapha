<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seo extends Public_Controller
{
    protected $urls;
    protected $changefreqs;
    protected $_limit_url = 500;
    public function __construct()
    {
        parent::__construct();
        $this->urls = array();
        $this->changefreqs = array(
            'always',
            'hourly',
            'daily',
            'weekly',
            'monthly',
            'yearly',
            'never'
        );
        $this->load->model(['category_model', 'post_model', 'page_model', 'product_model']);

        $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"/>');
    }
    public function sitemap()
    {
        $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');
        
        // $this->sitemap_page();
        // $this->sitemap_category_product();
        // $this->sitemap_category_post();
        // $this->sitemap_post();
        // $this->sitemap_product();

        $child = $this->xml->addChild('sitemap');
        $child->addChild('loc', base_url('category_page.xml'));
        $child->addChild('lastmod', date('c',time()));

        $child = $this->xml->addChild('sitemap');
        $child->addChild('loc', base_url('category_product.xml'));
        $child->addChild('lastmod', date('c',time()));

        $child = $this->xml->addChild('sitemap');
        $child->addChild('loc', base_url('category_post.xml'));
        $child->addChild('lastmod', date('c',time()));

        $child = $this->xml->addChild('sitemap');
        $child->addChild('loc', base_url('sitemap_post.xml'));
        $child->addChild('lastmod', date('c',time()));

        $child = $this->xml->addChild('sitemap');
        $child->addChild('loc', base_url('sitemap_product.xml'));
        $child->addChild('lastmod', date('c',time()));

        $this->output->set_content_type('application/xml')->set_output($this->xml->asXml());
    }

    public function category_page()
    {
        $child = $this->xml->addChild('url');
        $child->addChild('loc', base_url());
        $child->addChild('lastmod', date('c',strtotime('2020-05-17')));
        $child->addChild('priority', '1.0');
        
        $data = $this->page_model->getData([
            'is_status' => 1,
            'limit' => 1000
        ]);
        if (!empty($data)) foreach ($data as $item) {
            $child = $this->xml->addChild('url');
            $child->addChild('loc', get_url_page($item));
            $child->addChild('lastmod', date('c', strtotime($item->updated_time)));
            $child->addChild('priority', '0.8');
        }
        $this->output->set_content_type('application/xml')->set_output($this->xml->asXml());
    }

    public function sitemap_category_product()
    {
        $data = $this->category_model->getData([
            'is_status' => 1,
            'limit' => 1000,
            'type' => 'product'
        ]);
        if (!empty($data)) foreach ($data as $item) {
            $child = $this->xml->addChild('url');
            $child->addChild('loc', get_url_category_product($item));
            $child->addChild('lastmod', date('c', strtotime($item->updated_time)));
            $child->addChild('priority', '0.8');
        }
        $this->output->set_content_type('application/xml')->set_output($this->xml->asXml());
    }

    public function sitemap_category_post()
    {
        $data = $this->category_model->getData([
            'is_status' => 1,
            'limit' => 1000,
            'type' => 'post'
        ]);
        if (!empty($data)) foreach ($data as $item) {
            $child = $this->xml->addChild('url');
            $child->addChild('loc', get_url_category_post($item));
            $child->addChild('lastmod', date('c', strtotime($item->updated_time)));
            $child->addChild('priority', '0.8');
        };
        $this->output->set_content_type('application/xml')->set_output($this->xml->asXml());
    }

    public function sitemap_post()
    {
        $data = $this->post_model->getData([
            'is_status' => 1,
            'limit' => 1000
        ]);
        if (!empty($data)) foreach ($data as $item) {
            $child = $this->xml->addChild('url');
            $child->addChild('loc', get_url_post($item));
            $child->addChild('lastmod', date('c', strtotime($item->updated_time)));
            $child->addChild('priority', '0.8');
        }
        $this->output->set_content_type('application/xml')->set_output($this->xml->asXml());
    }

    public function sitemap_product()
    {
        $data = $this->product_model->getData([
            'is_status' => 1,
            'limit' => 2000
        ]);
        if (!empty($data)) foreach ($data as $item) {
            $child = $this->xml->addChild('url');
            $child->addChild('loc', get_url_product($item));
            $child->addChild('lastmod', date('c', strtotime($item->updated_time)));
            $child->addChild('priority', '0.5');
        }
        $this->output->set_content_type('application/xml')->set_output($this->xml->asXml());
                                    }
                                    
                                    
    public function category_product() {
        $data = $this->category_model->getData([
            'is_status' => 1,
            'limit' => 1000,
            'type' => 'product'
        ]);
        if (!empty($data)) foreach ($data as $item) {
            $child = $this->xml->addChild('url');
            $child->addChild('loc', get_url_category_product($item));
            $child->addChild('lastmod', date('c', strtotime($item->updated_time)));
            $child->addChild('priority', '0.8');
        }
        $this->output->set_content_type('application/xml')->set_output($this->xml->asXml());   
    }
    
    public function category_post() {
        $data = $this->category_model->getData([
            'is_status' => 1,
            'limit' => 1000,
            'type' => 'post'
        ]);
        if (!empty($data)) foreach ($data as $item) {
            $child = $this->xml->addChild('url');
            $child->addChild('loc', get_url_category_post($item));
            $child->addChild('lastmod', date('c', strtotime($item->updated_time)));
            $child->addChild('priority', '0.8');
        }
        $this->output->set_content_type('application/xml')->set_output($this->xml->asXml());
    }

    public function add($loc, $image = NULL, $lastmod = NULL, $changefreq = NULL, $priority = NULL)
    {

        if ($changefreq !== NULL && !in_array($changefreq, $this->changefreqs)) {
            show_error('Unknown value for changefreq: ' . $changefreq);
            return false;
        }

        if ($priority !== NULL && ($priority < 0 || $priority > 1)) {
            show_error('Invalid value for priority: ' . $priority);
            return false;
        }
        $item = new stdClass();
        $item->loc = $loc;
        $item->lastmod = $lastmod;
        $item->image = $image;
        $item->changefreq = $changefreq;
        $item->priority = $priority;
        $this->urls[] = $item;

        return true;
    }

    /**
     * Generate the sitemap file and replace any output with the valid XML of the sitemap
     *
     * @param string $type Type of sitemap to be generated. Use 'urlset' for a normal sitemap. Use 'sitemapindex' for a sitemap index file.
     * @access public
     * @return void
     */
    private function output($type = 'urlset')
    {
        $root = $type . " xmlns='http://www.sitemaps.org/schemas/sitemap/0.9' xmlns:xhtml=\"http://www.w3.org/1999/xhtml\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"";
        if (isset($this->urls[0]->image)) $root .= " xmlns:image='http://www.google.com/schemas/sitemap-image/1.1'";
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><' . $root . '/>');

        if ($type == 'urlset') {
            foreach ($this->urls as $url) {
                $child = $xml->addChild('url');
                $child->addChild('loc', strtolower($url->loc));


                if (isset($url->image)) {
                    $image = $child->addChild('image:image:image');
                    $image->addChild('image:image:loc', $url->image);
                }
                if (isset($url->lastmod)) $child->addChild('lastmod', $url->lastmod);
                if (isset($url->changefreq)) $child->addChild('changefreq', $url->changefreq);
                if (isset($url->priority)) $child->addChild('priority', number_format($url->priority, 1));
            }
        } elseif ($type == 'sitemapindex') {
            foreach ($this->urls as $url) {
                $child = $xml->addChild('sitemap');
                $child->addChild('loc', strtolower($url->loc));
                if (isset($url->lastmod)) $child->addChild('lastmod', $url->lastmod);
            }
        }
        $this->output->set_content_type('application/xml')->set_output($xml->asXml());
    }

    /**
     * Clear all items in the sitemap to be generated
     *
     * @access public
     * @return boolean
     */
    public function clear()
    {
        $this->urls = array();
        return true;
    }

    public function rss($type = '')
    {
        $category = new Category_model();
        if (!empty($type)) {
            if ($type === 'product') {
                $categories = $category->_all_category('product');
            } else {
                $categories = $category->_all_category('post');
            }
        }
        $data['allCate'] = $categories ?? '';

        $data['SEO'] = [
            'meta_title' => 'Rss ' . $this->_settings->meta_title,
            'meta_description' => 'Rss ' . $this->_settings->meta_desc,
            'meta_keyword' => 'Rss ketsatgiadinh',
            'url' => base_url("rss-feed"),
            'meta_robots' => 1
        ];
        $data['main_content'] = $this->load->view($this->template_path . 'seo/rss', $data, true);
        $this->load->view($this->template_main, $data);
    }

    public function rssDetailNews($slug)
    {
        $categoryModel = new Category_model();
        $postModel = new Post_model();
        $productModel = new Product_model();
        $oneItem = $categoryModel->getBySlugCached($slug);
        header('Content-Type: text/xml; charset=utf-8', true);
        $rss = new SimpleXMLElement('<rss></rss>');
        $rss->addAttribute('version', '2.0');
        $rss->addAttribute('xmlns:xmlns:content', 'http://purl.org/rss/1.0/modules/content/');
        $channel = $rss->addChild('channel');
        $title = "$oneItem->meta_title";
        $des = $oneItem->meta_description;
        $channel->addChild('title', $title);
        $channel->addChild('description', $des);
        $channel->addChild('link', $oneItem->type === 'product' ? get_url_category_product($oneItem) : get_url_category_post($oneItem));
        $channel->addChild('copyright', !empty($this->_settings->title) ? $this->_settings->title : "Két Sắt Gia Định"); //feed site
        $channel->addChild('language', 'vi-vn');
        $date_f = date(DATE_RFC2822, time());
        $channel->addChild('pubDate', $date_f);
        $channel->addChild('lastBuildDate', $date_f);
        $channel->addChild('generator', BASE_URL);
        if ($oneItem->type === 'product') {
            $keyCache = "list-products-$oneItem->id";
            $dataCache = $this->getCache($keyCache);
            if (empty($dataCache)) {
                $listResult = $productModel->getDataProductByCategory([$oneItem->id]);
                $dataCache['data'] = $listResult;
                $this->setCache($keyCache, $dataCache, 60 * 2);
            }
        } else {
            $keyCache = "list-news-$oneItem->id";
            $dataCache = $this->getCache($keyCache);
            if (empty($dataCache)) {
                $listResult = $postModel->getDataPostByCategory([$oneItem->id], 1, 20000);
                $dataCache['data'] = $listResult;
                $this->setCache($keyCache, $dataCache, 60 * 2);
            }
        }


        if (!empty($dataCache['data']))  foreach ($dataCache['data'] as $oneNews) {
            $dateDisplay = $oneNews->created_time;
            $item = $channel->addChild('item');
            $item->addChild('title', $oneNews->title);
            $item->addChild('description', !empty($oneNews->description) ? $oneNews->description : 'Két Sắt Gia Định');
            $item->addChild('link', $oneItem->type === 'product' ? get_url_product($oneNews)  : get_url_post($oneNews));
            $date_rfc = date(DATE_RFC2822, strtotime($dateDisplay));
            $item->addChild('pubDate', $date_rfc);
            $item->addChild('lastBuildDate', date('c', strtotime($oneNews->updated_time)));
            $item->addChild('language', 'vi-vn');
            $item->addChild('content:content:encoded', "<![CDATA[" . htmlspecialchars(html_entity_decode($oneNews->content)) . "]]>");
            if ($oneItem->type === 'product') {
                $item->addChild('price', $oneNews->price);
                $item->addChild('price_sale', $oneNews->price_sale);
                $item->addChild('size', $oneNews->size);
                $item->addChild('mass', $oneNews->mass);
            }
        }

        $this->output->set_content_type('application/xml')->set_output($rss->asXml());
    }
}
