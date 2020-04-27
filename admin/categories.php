<?php 
    include("includes/admin_header.php");  
 ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php 
            include("includes/admin_navigation.php");
        ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Blank Page
                            <small>Subheading</small>
                        </h1>


                            <div class="col-xs-6">

                                <!-- INSERT CATEGORIES -->

                                <?php 
                                    insert_categories();
                                 ?>

                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="cat_title"> Add Category</label>
                                        <input name="cat_title" type="text" class="form-control"></input>
                                    </div>
                                    <div class="form-group">
                                        <input name="submit" class="btn btn-primary" type="submit" value="Add Category"></input>
                                    </div>
                                </form>

                                <!-- INCLUDE update_categories.php -->

                                <?php 

                                    if(isset($_GET['edit']))
                                    {
                                        $cat_id = $_GET['edit'];

                                        include("includes/update_categories.php");
                                    }

                                 ?>

                            </div>


                            <div class="col-xs-6">

                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Category Title</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        

                                        <?php 
                                            //FIND ALL CATEGORIES QUERIES

                                            find_all_categories();
                                            
                                        ?>

                                        <?php 
                                            //DELETE QUERY

                                            delete_categories();
                                         ?>

                                    </tbody>
                                </table>
                            </div>


                        <!-- <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol> -->
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php 
    include("includes/admin_footer.php");
 ?>