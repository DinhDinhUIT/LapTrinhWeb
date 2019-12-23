<?php include "business/categoryB.php"; ?>
<?php
    // $test=new CategoryP();
    // $test->ShowAllCategories();
    class CategoryP{
        public function ShowAllCategories(){
            $cb=new CategoryB();
            $result=$cb->GetAllCategories();
            $count=1;

            while($row=mysqli_fetch_array($result)){
                $category=<<<DELIMITER
                 <a href="index.php?category={$count}" class="list-group-item list-group-item-action" {$this->SetStyleForCurrentCategory($count)} >{$row['cat_name']}</a>
                DELIMITER;

                echo $category;
                $count ++;
            }
        }

        public function GetCategory(){
            $cat_id;
            if(!isset($_GET['category']))
                $cat_id=0;
            else
                $cat_id=$_GET['category'];
            return $cat_id;
        }

        public function SetStyleForCurrentCategory($count){
            $cat_id=$this->GetCategory();
            $style="";
            if($count==$cat_id)
                $style="style='color: #feca57'";
            return $style;
        }
    }
?>