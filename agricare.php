<?php
//ini_set("display_error" , 0);
$mtest = 0;
error_reporting(E_ALL & ~E_NOTICE);
include './include/class.controller.php';
include './include/class.page.php';
include './include/class.mpage.php';
include './include/mobile_device_detect.php';
include 'staticpage.php';
$getValue = (isset($_GET['page'])) ? $_GET['page'] : '';
$getType = (isset($_GET['type'])) ? $_GET['type'] : '';
if (!mobile_device_detect() && !$mtest) {

    $page = new Page($getValue);
    /* these are different sections in the template file */
    $pagetitle = Page::$title;
    $keywords = Page::$keywords;
    $description = Page::$description;
    $jslink = Page::$jslink;
    $csslink = Page::$csslink;
    $header = getHeaderContent();

    if ($user->logged_in) {     
        $userMenu = $ctrl->getUserMenu();
        $greetings = $ctrl->getGreetings();
        $mainContent = Page::$content;
    } else {
        $mainContent = $ctrl->getLoginForm();       
    }

    $footer = getFooterContent();
    
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php echo $pagetitle; ?></title>
            <meta name="keywords" content="<?php echo $keywords; ?>" />
            <meta name="description" content="<?php echo $description; ?>" />
            <link href="css/default.css" rel="stylesheet" type="text/css" />
            <link href="css/slideshow.css" rel="stylesheet" type="text/css" />
            <link href="css/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" />
            <link href="css/dropdown/dropdown.vertical.css" media="all" rel="stylesheet" type="text/css" />
            <link href="css/dropdown/themes/default/default.css" media="all" rel="stylesheet" type="text/css" />
            <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

            <link href="facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
            <script src="facefiles/facebox.js" type="text/javascript"></script>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('a[rel*=facebox]').facebox()

                    /*
                      var loginCheck=<?php echo $user->logged_in ?>;
                            if(loginCheck){
                            //login

                            }else{
                            //not login

                            }
                     */
                    if (document.getElementById("column_w200") && document.getElementById("column_w600")){
                        var leftColumnHeight=$('#column_w200').height();
                        var rightColumnHeight=$('#column_w600').height();
                        if(leftColumnHeight != rightColumnHeight){
                            //alert(leftColumnHeight+"   "+rightColumnHeight)
                            $('#column_w200').css('min-height',750);
                            $('#column_w600').css('min-height',750);

                        }
                    }




                })
            </script>

        <?php
        //extra js files to be included is included here
        if (!empty($jslink)) {
            if (is_array($jslink)) {
                foreach ($jslink as $js) {
                    echo "<script language='JavaScript' type='text/javascript' src='$js'></script>";
                }
            } else {
                echo "<script language='JavaScript' type='text/javascript' src='$jslink'></script>";
            }
        }
        //extra css files to be included are included here
        if (!empty($csslink)) {
            if (is_array($csslink)) {
                foreach ($csslink as $css) {
                    echo "<link href='$css' rel='stylesheet' type='text/css' />";
                }
            } else {
                echo "<link href='$csslink' rel='stylesheet' type='text/css' />";
            }
        }
        ?>


        <style>
            html, body {
                margin: 0;
                padding: 0;
                font-size: 85%;
            }
        </style>
    </head>
    <body>
        <div id="templatemo_header_wrapper">
            <div id="templatemo_header">
                <?php echo $header; ?>
                <?php echo $greetings; ?>
            </div>
        </div> <!-- end of header wrapper -->

        <div id="tempatemo_content_wrapper">
            <div id="templatemo_content">
                <?php if ($user->logged_in): ?>
                    <div id="column_w200">
                        <div id="submenu">
                            <?php echo $userMenu; ?>
                        </div>
                    </div>
                
                <div id="column_w600">             
                    <div id="main_content"><?php echo $mainContent; ?>
                    </div>
                </div><!-- end of column_w600 -->               
                <div class="cleaner"></div>
                      <?php else: ?>
                        <div id="content_panel">
                            <?php echo $mainContent; ?>
                        </div>
                        <div class="cleaner"></div>
                         <?php endif; ?>
                    </div> <!-- end of templato  content -->
                </div> <!-- end of content panel wrapper -->

                <div id="templatemo_footer_wrapper">
                    <?php echo $footer; ?>
                </div> <!-- end of footer  wrapper-->
                    
    </body>
</html>

<?php
                    }else {
//                    echo "mob device";
                        $getMvalue = (isset($_GET['mpage'])) ? $_GET['mpage'] : '';
                        $mpage = new Mpage($getMvalue);
                        $pagetitle = Mpage::$title;

                        //echo "jslink".
                        $jslink = Mpage::$jslink;
                        $csslink = Mpage::$csslink;

                        if ($user->logged_in) {

                            if ($getMvalue == "") {
                                $mainContent = $ctrl->getMUserMenu();
//                                 var_dump($mainContent);
                            } else {
                                $mainContent = Mpage::$content;
                            }
                        } else {
                            $mainContent = $ctrl->getMLoginForm();
                        }
?>
                        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                                <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
        <?php
                        //extra js files to be included is included here
                        if (!empty($jslink)) {
                            if (is_array($jslink)) {
                                foreach ($jslink as $js) {
                                    echo "<script language='JavaScript' type='text/javascript' src='$js'></script>";
                                }
                            } else {
                                echo "<script language='JavaScript' type='text/javascript' src='$jslink'></script>";
                            }
                        }
                        //extra css files to be included are included here
                        if (!empty($csslink)) {
                            if (is_array($csslink)) {
                                foreach ($csslink as $css) {
                                    echo "<link href='$css' rel='stylesheet' type='text/css' />";
                                }
                            } else {
                                echo "<link href='$csslink' rel='stylesheet' type='text/css' />";
                            }
                        }
        ?>

                        <link rel="stylesheet" type="text/css" href="css/viewCss/login.css"/>
                        <title><?php echo $pagetitle; ?></title>
                    </head>
                    <body>
        <?php if (!is_null($mainContent)) {
        ?>
                            <div id="mainContent">
            <?php echo $mainContent; ?>

                        </div>
        <?php } ?>
                        <div id='footer'><font color='#828C96'>Copyright©2011</font><font color='#fff'> Agricare Nepal</font></div>
                    </body>
                </html>
<?php
                    }
?>
