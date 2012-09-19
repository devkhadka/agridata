<?php
function addUser(){
    global $ctrl,$form;
    $ret; $addsuccess=-1;
    if(isset($_POST['adduser'])){
        $retval=$ctrl->addUser($_POST);
//        echo $retval. 'return value';
        if($retval==0 || $retval==1){ 
            $addsuccess=$retval;
            $form->setValueArray(array());
            $ret.= "<div class='notice'>Data Entered Successfully !!</div>";
        }
        else 
        {
            //$_SESSION['value_array']=$_POST;
            //$_SESSION['error_array']=$form->getErrorArray();
            $form->setValueArray($_POST);
        }
    }
    $ret="<div id ='heading'>
            <h3 style='float:left'>Add User</h3><a href='?page=userlist'><div id='linking'>Manage User</div></a><br><br></div>
        <div id='sub-content' >";

    if($form->num_errors > 0){
        $ret.= "<div id= 'notice_start'>  </div> <div class='notice'><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></div> <div id='notice_end'> </div>";
    }
    else if($addsuccess==0){
        $ret.="<div class='notice'><font size=\"2\" color=\"#00ff00\">{$_POST['username']}  was addded successfully </font></div>";
    }
    else if($addsuccess==1){
        $ret.="<div class='notice'>{$_POST['username']}  was addded successfully but mail was not sent because of error</div>";
    }
    $ret.=<<<EOT
<form action="{$_SERVER['REQUEST_URI']}" method="POST">
<table align="left" border="0" cellspacing="0" cellpadding="3">
        <tr>
                <td>Name:</td>
                <td><input type="text" name="name" maxlength="30" value="{$form->value("name")}" class="inputt"></td>
                <td>{$form->error("name")}</td>
        </tr>
        <tr>
                <td>Username:</td>
                <td><input type="text" name="username" maxlength="30" value="{$form->value("username")}" class="inputt"></td>
                <td>{$form->error("username")}</td>
        </tr>
        <tr>
                <td>Email:</td>
                <td><input type="text" name="email" maxlength="50" value="{$form->value("email")}" class="inputt">
                </td>
                <td>{$form->error("email")}</td>
        </tr>
        <tr>
                <td>Phone No:</td>
                <td><input type="text" name="phone" maxlength="30" value="{$form->value("phone")}" class="inputt"></td>
                <td>{$form->error("phone")}</td>
        </tr>
        <tr>
                <td>Address Line 1:</td>
                <td><input type="text" name="addl1" maxlength="30" value="{$form->value("addl1")}" class="inputt"></td>
                <td>{$form->error("addl1")}</td>
        </tr>
        <tr>
                <td>Address Line 2:</td>
                <td><input type="text" name="addl2" maxlength="30" value="{$form->value("addl2")}" class="inputt"></td>
                <td>{$form->error("addl2")}</td>
        </tr>
        <tr>
                <td colspan="2" align="right"><input type="hidden" name="adduser" value="1" class="inputt"><input type="submit" value="Add " ></td>
        </tr>
</table>
</form>
</div>
EOT;

    Page::$content= $ret;
}
function changePassword(){
    global $ctrl,$form,$user;
    $ret; 
    $ret.="<h1>User Account Edit : {$user->username}</h1>";
    if(isset($_POST['changepass'])){
        $retval= $user->changePassword($_POST);
        if($retval){
            $form->setValueArray(array());
        $ret.="<div class='notice'><font size=\"2\" color=\"#00ff00\">{$_POST['username']}  password changed successfully </font></div>";
        }else{
            $form->setValueArray(array());
        $ret.= "<div class='notice'><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></div>";
        }
    }

    $ret.=<<<EOT
        <form action="{$_SERVER['REQUEST_URI']}" method="POST">
        <table align="left" border="0" cellspacing="0" cellpadding="3">
        <tr>
        <td>Current Password:</td>
        <td><input type="password" name="curpass" maxlength="30" value="{$form->value("curpass")}" class="inputt"></td>
        <td>{$form->error("curpass")}</td>
        </tr>
        <tr>
        <td>New Password:</td>
        <td><input type="password" name="newpass" maxlength="30" value="{$form->value("newpass")}" class="inputt"></td>
        <td>{$form->error("newpass")}</td>
        </tr>
        <tr>
        <td>Conform Password:</td>
        <td><input type="password" name="newpass2" maxlength="30" value="{$form->value("newpass2")}" class="inputt"></td>
        <td></td>
        </tr>
        <tr><td colspan="2" align="right">
        <input type="hidden" name="changepass" value="1">
        <input type="submit" value="Change" ></td></tr>
        <tr><td colspan="2" align="left"></td></tr>
        </table>
        </form>
EOT;
    Page::$content=$ret;
}
function  readEmail() {
    include("./include/constants.php");
$url =EMAIL_URL3;
    $ret=<<<EOT
        <iframe src='{$url}' width='670px' height='700px'> </iframe>
EOT;
Page::$content=$ret;
}
?>
