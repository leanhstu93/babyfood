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
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';


        $sql ="SELECT * FROM  mn_product ORDER BY id DESC";
        $product=$this->product_model->get_query($sql,null,null);

        foreach ($product as $value) {
            $alias = $value['alias'];
            $pri = rand(0, 10) / 10;
            echo '
            <url>
              <loc>'.BASE_URL.$alias.'</loc>
              <changefreq>always</changefreq>
              <priority>'.$pri.'5</priority>
            </url>';
        }
        echo '</urlset>';
        exit;
    }

}
