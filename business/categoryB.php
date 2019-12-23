<?php include "data/database.php"?>
<?php
    // $test = new CategoryB();
    // $test->GettAllCategories();
    class CategoryB{
        private $cat_list=null;

        public function GetAllCategories(){
            if($this->cat_list==null){
                $sql="SELECT * FROM category";
                $db=new Database();
                $this->cat_list=$db->select($sql);
            }

            return $this->cat_list;
            
            // while($row=mysqli_fetch_array($result)){
            //     echo $row['cat_name'];
            // }

        }
    }
?>