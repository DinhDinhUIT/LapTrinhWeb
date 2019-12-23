<?php include "../data/database.php"; ?>
<?php include "../include/lib/simple_html_dom.php"; ?>
<?php
    $from="2019-08-01";
    $to="2019-12-24";
    $test = new ProductAnalysisB();
    // $test->GetView(3, $from, $to);
    $test->GetRelevantLinks("iphone x 64gb");

    class ProductAnalysisB{
        private $google_link = "https://www.google.com/search?q=";

        public function GetRelevantLinks($product_name){
            //1. Build search string
            $search = $this->BuildSearchString($product_name);
            $url = $this->google_link . $search;

            //2. Send search string and get result
            $html = file_get_html($url);

            //3. Analyze search result and get links
            $return_list = array();
            foreach($html->find('a') as $element){      
                $pos = stripos($element->plaintext, $product_name);
                if ($pos !== false){
                    $link = $this->StandarizeLink($element->href);
                    if($link!=-1){
                        $return_list["{$element->plaintext}"] = "{$link}";
                    }
                }      
            }

            foreach($return_list as $x =>$x_value){
                echo $x . "<br>";
                echo $x_value . "<br>";
            }

            $this->FindPrice("https://didongviet.vn/iphone-x-64gb-like-new");
        }

        public function FindPrice($link){
            $html = file_get_html($link);
            //$ret = $html->find('.area_price');
            //$test = '.area_price';
            // $test = '.fs-dtprice';
            //$test = '#_price_new436';
            $test = '.price';
            // $test = '.area_price';
            echo $test;
            foreach($html->find($test) as $element)
                echo $element . '<br>';
        }

        public function StandarizeLink($raw_link){
            $start = stripos($raw_link,"http");
            if($start!==false){
                $end = stripos($raw_link,"&");
                $link = substr($raw_link,$start,$end-$start);
                return $link;
            }
            return -1;   
        }

        //standardize search string
        public function BuildSearchString($search){
            $list = explode(" ",$search);
            $result = "";
            for ($i = 0; $i < count($list)-1; $i ++)
                $result = $result . $list[$i] . "+";
            $result = $result . $list[$i];
            return $result;
        }

        public function GetView($product_id, $from, $to){
            $FROM="'" . $from . "'";
            $TO="'" . $to . "'";
            $sql="SELECT COUNT(*) as NUM FROM `product_analysis` WHERE `product_id`={$product_id} AND 
            `visited_date`>{$FROM} AND `visited_date`<{$TO}";
            $db=new Database();
            $result=$db->select($sql);
            $row = mysqli_fetch_array($result);
            echo $row['NUM'];
        }

        public function UpdateViewOfProduct($product_id){
            $now = date("Y-m-d H:i:s");
            $NOW = "'" . $now . "'";
            $sql = "INSERT INTO `product_analysis`(`product_id`, `visited_date`) VALUES ({$product_id},{$NOW})";
            $db = new Database();
            $db -> insert($sql);
        }
    }
?>