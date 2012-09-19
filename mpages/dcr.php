<?php
function addDcr(){
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;

    if (isset($_SESSION['addDcrSuccess'])) {
        unset($_SESSION['addDcrSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
        //$str.="Data Entered Successfully !!";
    }
    if (isset($_POST['add'])) {
        //print_r($_POST);
        //die();
        $retval = $ctrl->addDcr($_POST);

        if ($retval) {
            $_SESSION['addDcrSuccess'] = true;
            header("Location:" . $ctrl->referrer);
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {
        $title = $database->getTitle();

        $str .="<div class='main-title'><div id='title'>Add DCR</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
        $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='row'><b>Date : (YYYY-MM-DD)</b><div><input class='addDcrForm' size='20' type='date' name='collected_date' value=\"{$form->value('collected_date')}\" /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='row'><b>Customer Name :</b><div> <input placeholder='enter customer name' class='addDcrForm' size='20' type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
                <div class='row'><b>Profession :{$form->error('customer_title_id')} </b> <div>";
        foreach ($title as $key) {
            $checked = "";
            if ($key[id] == $form->value('customer_title_id'))
                $checked = "checked";
            $str .= "<div><input type='radio' value='{$key['id']}' name='customer_title_id' {$checked}>&nbsp;&nbsp;{$key['title']} </div>";
        }

        $str .="</div></div><div class='row'><b>Remarks :</b><div> <textarea rows='6' cols='35' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                <div><input type='hidden' name='add'></div>
                <div id='sub'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style='float: left;' type='submit' value='Add' name='submit'></div>
                </form></div></div></div>";
        return $str;
    }
}

function viewDcr() {
   global $user, $database;

   Mpage::$jslink = array('js/fortNightLimit.js','js/dcr_mob.js');

    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL) {
        Mpage::$content = UN_AUTH;
        return;
    }
    
    $str .="<div class='main-title'><div id='title'>View DCR</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
    $str .="<div id='content-wrapper'>";
    $str .="<div class='navigation'><div id='nav-prev'><a href='#' id='prev'>Previous</a></div><div id='nav-next'><a href='#' id='next'>Next</a></div></div><br>";
    $str .= "<div id='list'></div></div>";
    $str.="</div>";
    return $str;

}

function editDcr() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;
    if (isset($_POST['edit'])) {
        //print_r($_POST);
        $retval = $ctrl->editDcr($_POST);
//        print_r($retval);
        if ($retval) {
            $_SESSION['editDcrSuccess'] = true;
//            header("Location:agricare.php?mpage=viewdcr");
             echo "<script>document.location.href='?mpage=viewdcr'</script>";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
//            header("Location:" . $ctrl->referrer);
             echo "<script>document.location.href='".$ctrl->referrer."'</script>";
        }
    } else {
          $title = $database->getTitle();

        $data = $database->getDcrById($_GET['id']);
//        print_r($_GET);
        //die();

        $form->setValue('collected_date', $data['collected_date']);
        $form->setValue('name', $data['name']);
        $form->setValue('customer_title_id', $data['customer_title_id']);
        $form->setValue('remark', $data['remark']);
//        print_r($form);
        $str .="<div class='main-title'><div id='title'>Edit DCR</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
        $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='row'><b>Date : (YYYY-MM-DD)</b><div><input type='date' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" /></div><div class='err_msg'>'{$form->error('collected_date')}</div></div>
                <div class='row'><b>Name :</b><div> <input type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
                <div class='row'><b>Profession :{$form->error('customer_title_id')} </b><div>";
        foreach ($title as $key) {
            $checked = "";
            if ($key[id] == $form->value('customer_title_id'))
                $checked = "checked";
            $str .= "<div><input type='radio' value='{$key['id']}' name='customer_title_id' {$checked}>&nbsp;&nbsp;{$key['title']}</div>";
        }

        $str .="</div></div><div class='row'><b>Remarks :</b><div> <textarea rows='4' cols='40' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='hidden' name='edit'></div>
                <div id='sub'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Edit' name='submit' style='float: left;'></div>
                </form></div></div></div>";

        return $str;
    }
}
?>
