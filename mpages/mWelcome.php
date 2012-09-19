<?php

function mLoginForm() {
    global $form, $user;
    if ($form->num_errors > 0) {
        $ret.= "<font size=\"2\" color=\"#ff0000\">" . $form->num_errors . " error(s) found </font>";
    }
    define("REQ_LEVEL4", 4);
    define("REQ_LEVEL6", 6);
    define("REQ_LEVEL8", 8);
    define("REQ_LEVEL9", 9);
    if ($user->level == REQ_LEVEL4 || $user->level == REQ_LEVEL6 || $user->level == REQ_LEVEL8 || $user->level == REQ_LEVEL9) {
        $str = '<meta http-equiv="Refresh" content="2; URL=process.php">';
        $str .= UN_AUTH;
        echo $str;
        return ;
    } else {


        $ret.='<div class=\'main-title\'><div id=\'title\'>Agricare Nepal</div></div>
            <div id=\'content-wrapper\'>
                <div id=\'list\'>
                  <form action="process.php" method="POST">
                    <div class=\'row\'><div>Username :</div>
                    <div><input style="width=100%;" class="addDcrForm" type="text" name="user" id="username"/></div></div>
                    <div class=\'row\'><div>Password :</div>
                    <div><input type="password" name="pass" id="password"/></div></div>
                    <input type="hidden" name="synlogin" value="1">
                    <div><input type="submit" name="submit" value="Login"/></div>
                <div id="forgetPassword"><a href="?mpage=forgetpass" style="font-size: 10px;">Forget Password ?</a></div>
                </div>
                 </div>
            </div>';
        return $ret;
    }
}

function getMUserMenu() {
    global $user;
    $ret = '';
    if ($user->logged_in && $user->level == 2) {
        $ret.='<div id="loggedInWrap">
          <div class=\'main-title\'><div id=\'title\'>Agricare Nepal</div><div id=\'menu\'><a href=\'process.php\'>Logout</a></div></div>
<div id=\'content-wrapper\'>
<div id=\'list\'>
<ul style="min-height:322px;">
              <div class="bottomLine"><div id="add"><a href="?mpage=adddcr"><div id="image"></div></a><li><a href="?mpage=adddcr">Add DCR</a></li></div></div>
              <div class="bottomLine"><div id="add"><a href="?mpage=addtada"><div id="image"></div></a><li><a href="?mpage=addtada">Add TA /DA</a></li></div></div>
              <div class="bottomLine"><div id="add"><a href="?mpage=addpartystock"><div id="image"></div></a><li><a href="?mpage=addpartystock">Add Party Stock</a></li></div></div>
              <div class="bottomLine"><div id="add"><a href="?mpage=addvisitplan"><div id="image"></div></a><li><a href="?mpage=addvisitplan">Add Visit Plan</a></li></div></div>
              <div class="bottomLine"><div id="add"><a href="?mpage=addsalesplan"><div id="image"></div></a><li><a href="?mpage=addsalesplan">Add Sales Plan</a></li></div></div>
              <div class="bottomLine"><div id="add"><a href="?mpage=addcollectionplan"><div id="image"></div></a><li><a href="?mpage=addcollectionplan">Add Collection Plan</a></li></div></div>
              <div class="bottomLine"><li><a href="?mpage=viewdcr">View DCR</a></li></div>
              <div class="bottomLine"> <li><a href="?mpage=viewtada">View TA /DA</a></li></div>
              <div class="bottomLine"><li><a href="?mpage=viewpartystock">View Party Stock</a></li></div>
             <div class="bottomLine"> <li><a href="?mpage=viewvisitplan">View Visit Plan</a></li></div>
             <div class="bottomLine"> <li><a href="?mpage=viewsalesplan">View Sales Plan</a></li></div>
             <div class="bottomLine"> <li><a href="?mpage=viewcollectionplan">View Collection Plan</a></li></div>
          </ul>
          </div>
      </div>';
    }
     $ret.="</div>";
    return $ret;
}
?>
