<?php

function getLoginForm() {
    global $form;
    $ret = "
        <div class='news_section'>";
    if ($form->num_errors > 0) {
        $ret.= "
            <font size=\"2\" color=\"#ff0000\">" . $form->num_errors . " error(s) found </font>";
    }
    $ret.='<div class="signin-box">
                <h2>
                <strong id="image"></strong>
                Sign in
                </h2>
                <form action=\'process.php\' method=\'POST\'>
                    <label for=\'user\'>
                        <strong class="email-label">Username</strong>
                        <input type="text" value="" id="Email" name=\'user\' maxlength=\'50\' >
                    </label>
                    <label>
                        <strong class="passwd-label">Password</strong>
                        <input type="password" id="Passwd" name=\'pass\' maxlength=\'30\' >
                    </label for=\'pass\'>
                    <label class="remember">
                            <a href="?page=forgotpass">Forgot your  Password ?</a>
                        <input type=\'hidden\' name=\'synlogin\' value=\'1\'>
                        <input type=\'submit\' value=\'Login\' id="signIn" class="g-button g-button-submit">
                    </label>

                </form>
            </div>';

//    $ret.="<div id='login_box'>
//        <form action=\"process.php\" method=\"POST\">
//        <p><label for='user'>Username:</label><input type=\"text\" name=\"user\" maxlength=\"50\" value=\"{$form->value('user')}\">{$form->error('user')}
//        <p><label for='pass'>Password:</label><input type=\"password\" name=\"pass\" maxlength=\"30\" value=\"{$form->value('pass')}\"> {$form->error('pass')}
//        <p> <a href='?page=forgotpass'>
//        Forgot your  Password ?</a>
//        &nbsp; &nbsp; &nbsp;
//    <input type=\"hidden\" name=\"synlogin\" value=\"1\">
//        <input id='inputsubmit1' type=\"submit\" value=\"Login\">
//        </form>
//        </div>
//        </div>
//        <div class='cleaner'> </div>
//        ";
    return $ret;
}

function getUserMenu() {
    global $user;
    $ret = '';
    $ret.="<ul id='nav' class='dropdown dropdown-vertical'>";
    $ret.='<li><a href="?">DashBoard</a></li>';
    if ($user->logged_in && $user->level > 0) {
        if ($user->level == MR_LEVEL || $user->level == MMR_LEVEL) {
            $ret.="<li class='dir'>DCR
                          <ul>
                             <li><a href='?page=adddcr'>Add DCR</a></li>
                             <li><a href='?page=viewdcr'>Manage DCR</a></li>
                          </ul>
                      </li>
                      <li class='dir'>Party Stock
                          <ul>
                             <li><a href='?page=addpartystock'>Add Party Stock</a></li>
                             <li><a href='?page=viewpartystock'>Manage Party Stock</a></li>
                          </ul>
                      </li>
                      <li class='dir'>TA/DA
                          <ul>
                             <li><a href='?page=addtada'>Add TA/DA</a></li>
                             <li><a href='?page=viewtada'>Manage TA/DA</a></li>
                          </ul>
                      </li>
                      <li class='dir'>Visit Plan
                          <ul>
                             <li><a href='?page=addvisitplan'>Add Visit Plan</a></li>
                             <li><a href='?page=viewvisitplan'>Manage Visit Plan</a></li>
                          </ul>
                      </li>
                      <li class='dir'>Sales Plan
                          <ul>
                             <li><a href='?page=addsalesplan'>Add Sales Plan</a></li>
                             <li><a href='?page=viewsalesplan'>Manage Sales Plan</a></li>
                          </ul>
                      </li>
                      <li class='dir'>Collection Plan
                          <ul>
                             <li><a href='?page=addcollectionplan'>Add Collection Plan</a></li>
                             <li><a href='?page=viewcollectionplan'>Manage Collection Plan</a></li>
                          </ul>
                      </li>
                    ";
        }
        if ($user->level == MMR_LEVEL || $user->level == ADMIN_LEVEL) {
            $ret.="

                    <li class='dir'>Reports
                            <ul>
                                 <li><a href='?page=mviewdcr'>DCR Reports</a></li>
                                 <li><a href='?page=mviewtada'>TA/DA Reports</a></li>
                                 <li><a href='?page=mviewvisitplan'>Visit Plan Reports</a></li>
                                 <li><a href='?page=mviewpartystock'r>Party Stock Reports</a></li>
                            </ul>
                        </li>
                      </ul>";
        }

        if ($user->level == SK_LEVEL || $user->level == ADMIN_LEVEL) {
            /* $ret.="Stock Management Tasks<br /><li class='newbullet'><a href='?page=addmaterial'>Add Material</a></li>
              <li class='newbullet'><a href='?page=addstock'>Add Stock</a></li>
              <li class='newbullet'><a href='?page=viewmaterial'>View Material</a></li>
              <li class='newbullet'><a href='?page=vstock'>View Stock</a></li><br />";
             */
        }

        if ($user->level == ADMIN_LEVEL) {
//            $ret.="Admin Tasks<br /><li class='newbullet'><a href='?page=addnews'>Add News</a></li>"
//                    . "<li class='newbullet'><a href='?page=addparty'>Add Party</a></li>"
//                    . "<li class='newbullet'><a href='?page=addproduct'>Add Product</a></li>"
//                    /*      ."<li class='newbullet'><a href='?page=addproductdetails'>Add product details</a></li>" */
//                    . "<li class='newbullet'><a href='?page=addtasetting'>Add TA Setting</a></li>"
//                    . "<li class='newbullet'><a href='?page=adduser'>Add User</a></li>"
//                    . "<li class='newbullet'><a href='?page=adddueamount'>Add Due Amount</a></li>"
//                    . "<li class='newbullet'><a href='?page=userlist'>Team</a></li>"
//                    . "<li class='newbullet'><a href='?page=viewnews'>View News</a></li>"
//                    . "<li class='newbullet'><a href='?page=viewparty'>View Party</a></li>"
//                    . "<li class='newbullet'><a href='?page=viewproduct'>View Product</a></li>"
//                    . "<li class='newbullet'><a href='?page=viewtasetting'>View TA Setting</a></li>"
//                    . "<li class='newbullet'><a href='?page=mviewsalesplan'>View Sales Plan</a></li>"
//                    . "<li class='newbullet'><a href='?page=mviewcollectionplan'>View Collection Plan</a></li>"
//                    . "<li class='newbullet'><a href='?page=viewdueamount'>View Due Amount</a></li><br/>";

            $ret.='<ul id="nav" class="dropdown dropdown-vertical">
                          <li class="dir">News
                              <ul>
                                <li><a href="?page=addnews">Add News</a></li>
                                <li><a href="?page=viewnews">Manage News</a></li>
                              </ul>
                          </li>
                        <li class="dir">Party
                              <ul>
                                    <li><a href="?page=addparty">Add Party</a></li>
                                    <li><a href="?page=viewparty">Manage Party</a></li>

                             </ul>
                        </li>
                        <li class="dir">Product
                            <ul>
                                <li><a href="?page=addproduct">Add Product</a></li>
                                <li><a href="?page=viewproduct">Manage Product</a></li>
                            </ul>
                        </li>
                        <li class="dir">TA Settings
                            <ul>
                                <li><a href="?page=addtasetting">Add TA Setting</a></li>
                                <li><a href="?page=viewtasetting">Manage TA Setting</a></li>
                            </ul>
                        </li>
                        <li class="dir">User
                            <ul>
                                <li><a href="?page=adduser">Add User</a></li>
                                <li><a href="?page=userlist">Manage User</a></li>
                            </ul>
                        </li>
                      <li class="dir">Due Amount
                            <ul>
                                <li><a href="?page=adddueamount">Add Due Amount</a></li>
                                <li><a href="?page=viewdueamount">Manage Due Amount</a></li><br/>
                            </ul>
                      </li>
                      <li><a href="?page=mviewsalesplan">Manage Sales Plan</a></li>
                      <li><a href="?page=mviewcollectionplan">Manage Collection Plan</a></li></ul>';
        }
//        $ret.="<li class='newbullet'><a href=\"process.php\">Logout</a></li>
//            </ul>";
//        $ret.="<li><a href=\"process.php\">Logout</a></li>
//            </ul>";
    }
    return $ret;
}

function getGreetings() {
    global $user , $database;
     $users = $database->getAllUsers();

    $ret = "<div id='greeting' >Welcome &nbsp;<b>$user->username </b>
            <ul id='nav' class='dropdown dropdown-horizontal'>
                <li id='settings' class='dir'><div>&nbsp</div>
                    <ul>
			<li><a href='?page=changepass'>Account</a></li>
                        <li><a href='?page=readmail'> Read Email </a> </li>
                    </ul>
                </li>
            </ul>
            <a href=\"process.php\">Logout</a>
            <div id='user_switcher'>
            <p> View as:
            <form action='process.php' method='post'>
            <select id='username' name='username'>";

    
     foreach ($users  as $u){
        $ret .= "<option value='{$u['username']}'> {$u['username']} </option>";

     }

        $ret .= "</select>
            <input type='hidden' name='switch' value='1'>
            <input type='submit' value='Go' />
            </form>
            </div>
            </div>";
    return $ret;
}

function getNews() {
    global $database;
    $newslist = $database->getNews();
    $str = "<div class='header_02'>News and Events</div>";
    foreach ($newslist as $news) {
        $day = explode('_', $news['date']);
        $str.="<div class='news_section'>
                <div class='news_date'>
                        $day[1]<span> $day[0]</span>
                </div>
                <div class='news_content'>
                    <div class='header_05'>
                        <a href='#'>{$news['title']}</a>
                    </div>
                    <p>{$news['body']}</p>
                </div>
                <div class='cleaner'></div>
                </div>";
    }
    $str.="</div>";
    return $str;
}
?>
