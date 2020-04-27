
<form action="" method="post">
        <div class="form-group">

            <label for="cat_title"> Edit Category</label>

            <?php 
              // show category title in bar

                if(isset($_GET['edit']))
                {
                    $cat_id = $_GET['edit'];

                    $sql = "SELECT * FROM categories WHERE cat_id = '$cat_id'";
                    $result = mysqli_query($connection,$sql);

                    while($row = mysqli_fetch_assoc($result))
                    {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];


            ?>
                    <input name="cat_title" value="<?php if(isset($cat_title)) { echo $cat_title; }?>" type="text" class="form-control"></input>

            <?php

                    }
                }

            ?>

                  <?php 
                      //UPDATE GATEGORY

                      if(isset($_POST['update']))
                      {
                          $cat_title = $_POST['cat_title'];

                          $statement = mysqli_prepare($connection,"UPDATE categories SET cat_title = ? WHERE cat_id = ?");
                    
                          mysqli_stmt_bind_param($statement,"si",$cat_title,$cat_id);
                          mysqli_stmt_execute($statement);

                          confirm_query($statement);

                          redirect("categories.php");

                          mysqli_stmt_close($statement);
                        }

                  ?>
                                        
        </div>

        <div class="form-group">
              <input name="update" class="btn btn-primary" type="submit" value="Update Category"></input>
        </div>
        
</form>