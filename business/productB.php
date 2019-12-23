<!-- <?php include "../data/database.php"?> -->
<?php
    class ProductB{
        public function GetProductsByID($product_id){
            $sql="SELECT * FROM product WHERE product_id={$product_id}";
            $db=new Database();
            $result=$db->select($sql);
            
            return $result;
        }

        public function GetAllProductFromCategory($cat_id){
            $sql="SELECT * FROM product WHERE cat_id={$cat_id}";
            $db=new Database();
            $result=$db->select($sql);
            
            return $result;
        }
    }
?>