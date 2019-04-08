<?php

class Tools extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('catelog_model');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    }
    public function index()
    {
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        // product
        $sql ="SELECT `alias` FROM  mn_product ORDER BY Id DESC";
        $product=$this->product_model->get_query($sql,null,null);

        foreach ($product as $value) {
            $alias = $value['alias'];
            $pri = rand(0, 10) / 10;
            echo '
            <url>
              <loc>'.BASE_URL.$alias.'.html</loc>
              <changefreq>always</changefreq>
              <priority>'.$pri.'5</priority>
            </url>';
        }

        // product cata
        $sql ="SELECT `alias` FROM  mn_catelog ORDER BY Id DESC";
        $catelog = $this->product_model->get_query($sql,null,null);

        foreach ($catelog as $value) {
            $alias = $value['alias'];
            $pri = rand(0, 10) / 10;
            echo '
            <url>
              <loc>'.BASE_URL.$alias.'/</loc>
              <changefreq>always</changefreq>
              <priority>'.$pri.'5</priority>
            </url>';
        }

        // news
        $sql ="SELECT `alias` FROM  `mn_news` ORDER BY Id DESC";
        $news = $this->product_model->get_query($sql,null,null);

        foreach ($news as $value) {
            $alias = $value['alias'];
            $pri = rand(0, 10) / 10;
            echo '
            <url>
              <loc>'.BASE_URL.'bai-viet/'.$alias.'</loc>
              <changefreq>always</changefreq>
              <priority>'.$pri.'5</priority>
            </url>';
        }

//        // news cata
//        $sql ="SELECT `alias` FROM  `mn_catnews` ORDER BY Id DESC";
//        $news_cata = $this->product_model->get_query($sql,null,null);
//
//        foreach ($news_cata as $value) {
//            $alias = $value['alias'];
//            $pri = rand(0, 10) / 10;
//            echo '
//            <url>
//              <loc>'.BASE_URL.'chu-de/'.$alias.'</loc>
//              <changefreq>always</changefreq>
//              <priority>'.$pri.'5</priority>
//            </url>';
//        }

        echo '</urlset>';
        exit;
    }

}
