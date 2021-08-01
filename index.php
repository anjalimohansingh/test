<?php
include("common/includes/constants.php");
include("common/includes/functions.php");
include("common/includes/common.php");
include("common/includes/admin_session.php");
include("common/includes/allstripslashes.php");
include("common/includes/english_admin.php");
include_once("common/includes/Charts.php");
include 'common/conf/init.php';
include_once("common/includes/license_functions.php");

date_default_timezone_set("Asia/Kolkata");


$msg = $_GET['msg'];
$sesver = $_SESSION['SESS_STU_ADMINID']; //echo $sesver; 
$lictype = $_SESSION['LIC_TYPE'];
$sql = "select * from `usermaster` where `user_id`='$sesver'"; //echo $sql;
$ret = mysql_query($sql);
$row = mysql_fetch_object($ret);
$scode = $row->Site_Code; //echo $scode."<br>"; 
$usertype = $row->user_type; //echo $rcode."<br>";  
$dcode = $row->Dep_Code; //echo $dcode."<br>";   
$lcode = $row->Loc_Id; //echo $lcode."<br>";    
$ecode = $row->Emp_Code; //echo $ecode."<br>";    
$admin_username = $row->username; //echo $ecode."<br>";
//if session expired
if (empty($_SESSION['SESS_STU_ADMINID'])) {
    //show login page     
    header("Location:login.php?act=$act");
    exit;
}

if (empty($_SESSION['SESS_STU_ADMINID'])) {
    //show login page     
    header("Location:login.php?act=$act");
    exit;
} else {
    session_start();

    $inactive = 1200 * 3;
    if (isset($_SESSION['timeout'])) {
        $session_life = time() - $_SESSION['timeout'];
        if ($session_life > $inactive) {
            session_destroy();
            header("Location: login.php?msg=Your session expired!!&act=$act");
        } else {
            $_SESSION['timeout'] = time();
            $sql = "select * from `permission` where `user_id`='$sesver'";
            $ret = mysql_query($sql);
            $row = mysql_fetch_object($ret);

            ?>



            <!DOCTYPE html>
            <html>
                <head>
                    <?php include('index_head.php'); ?>
                    <!--for date picker-->
                    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                    <link rel="stylesheet" href="/resources/demos/style.css">
                    <!--for date picker-->
                    <style>

                        body {
                            /* default is 1rem or 16px */
                            font-size: 15px;
                        }

                        .navbar-custom {
                            background-color: #475466;
                        }

                    </style>
                    <link rel='icon' href='dist/img/<?php echo $data->favicon; ?>' type='image/x-icon' sizes="16x16" />
                </head>

                <body class="hold-transition sidebar-mini layout-navbar-fixed layout-navbar-fixed text-sm">
                    <div class="wrapper">

                        <!-- Navbar -->


                        <nav class="main-header navbar navbar-expand navbar-white navbar-light navbar-custom">
                            <!-- Left navbar links -->
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars" style="color:white;"></i></a>
                                </li>

                            </ul>

                            <ul class="navbar-nav ml-auto">
                              
                                <li class="nav-item dropdown user-menu ">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                        <img src="dist/img/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image">
                                        <span class="d-none d-md-inline text-white"><?php echo $admin_username ?></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right ">
                                        <!-- User image -->
                                        <li class="user-header bg-white">
                                            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

                                            <p>
                                                <?php echo $admin_username ?> - <?php echo ($usertype == 1) ? 'Administrator' : 'Standard User' ?>
                                          <!--   <small>Member since Nov. 2012</small> -->
                                            </p>
                                        </li>
                                        <!-- Menu Footer-->
                                        <li class="user-footer text-center">
                                           <!-- <a href="#" class="btn btn-default btn-flat">Profile</a>-->
                                            <a href="logout.php" class="btn btn-default btn-flat float-none">Sign out</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                        <!-- /.navbar -->

                        <!-- Main Sidebar Container -->
                        <aside class="main-sidebar sidebar-dark-primary elevation-4">
                                         
                            
                             <a href="index.php" class="brand-link logo-switch">
                                 </a>


                            <!-- Sidebar -->
                            <div class="sidebar">
                              

                                <nav class="mt-2">
                                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                      

                                        <?php
                                        if ($act == "vendor" ) {
                                            $cls = 1;
                                        }
                                        if ($row->m1 == 1 ) {
                                            ?>


                                            <li class="nav-item has-treeview <?php if ($cls == 1) { ?>menu-open<?php } ?>">
                                                <a href="#" class="nav-link <?php if ($cls == 1) { ?>active<?php } ?>">
                                                    <i class="nav-icon fa fa-book"></i>
                                                    <p>
                                                        Master
                                                        <i class="fas fa-angle-left right"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview p-1 " >

                                                    <?php if ($row->m1 == 1) { ?>


                                                        <li class="nav-item " ><a href="vendor"  class="nav-link <?php if ($act == "vendor" or $act == "addvendor") { ?>active<?php } ?>"> <i class="fa fa-chevron-circle-right"></i> <p style="font-size:14px">&nbsp;Company Stock Master</p>  </a></li><?php } ?>


                                                    

                                                </ul>
                                            </li>

                                            <?php
                                        }

                                       
?>
                                </nav>
                                <!-- /.sidebar-menu -->
                            </div>
                            <!-- /.sidebar -->
                        </aside>



                        <div class="content-wrapper">
                            <?php
                            switch ($act) {

                                
                                //vendor master
                                case "vendor":
                                    if ($row->m1 == 1) {
                                        include("vendor.php");
                                    }
                                    break;

                               
                            }
                            ?>
                        </div>



                        <footer class="main-footer">
                           



                        </footer>

                        <!-- Control Sidebar -->
                        <aside class="control-sidebar control-sidebar-dark">
                            <!-- Control sidebar content goes here -->
                        </aside>
                        <!-- /.control-sidebar -->
                    </div>

                </body>
                <script>
                    $("form#quickfilter #search-btn").click(function (event) {
                        $("form#quickfilter input[name='q']").triggerHandler('keyup');
                    });
                    $("form#quickfilter input[name='q']").keyup(function (event) {

                        if (event.keyCode == 27) {
                            $(this).val("");
                        }

                        var userneeds = $(this).val().toLowerCase();
                        var sidebarLi = $('.sidebar-menu').find('li');

                        // hide all first..
                        $(".treeview.menu-open").removeClass('menu-open').find('.treeview-menu').hide();
                        $(".sidebar-menu>li,.treeview-menu>li").hide();

                        // search
                        var anythingFound = false;
                        for (var i = 0; i < sidebarLi.length; i++) {
                            var $li = $(sidebarLi[i]);
                            var aText = $li.find('a:first').text().toLowerCase();
                            if (aText.indexOf(userneeds) !== -1) {
                                $li.parents('.treeview').addClass('menu-open').show();
                                $li.parents('.treeview-menu').show();
                                $li.show();
                                anythingFound = true;
                            }
                        }
                        if (userneeds === '') {
                            $(".sidebar-menu>li").show();
                        }
                    });
                    $(document).ready(function () {
                        $('[data-href="<?php echo $act ?>"]').css('color', '#e8e8e8');
                    });

                </script>

            </html>
            <?php
        }
    }
}
?>

<!--<script src="plugins/jquery/jquery.min.js"></script>-->
<script src="plugins/select2/js/select2.full.min.js"></script>