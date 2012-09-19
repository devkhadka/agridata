<?php

function addVisitplan() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;

    if (isset($_SESSION['addDcrSuccess'])) {
        unset($_SESSION['addDcrSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
    }

    if (isset($_POST['add'])) {

        $retval = $ctrl->addVisitplan($_POST);

        if ($retval) {
            $_SESSION['addDcrSuccess'] = true;
            header("Location:" . $ctrl->referrer);
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {
        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $str .="<div class='main-title'><div id='title'>Add Visit Plan</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
        $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='row'><b>Date :</b><div><input size='20' type='date' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" size='10' /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='row'><b>Place :</b><div> <input size='20' type='text' name='place' value=\"{$form->value('place')}\" /></div><div class='err_msg'>{$form->error('place')}</div></div>
                <div class='row'><b>Remarks :</b><div> <textarea rows='6' cols='35' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                <div class='row'><input type='hidden' name='add'></div>
                <div id='sub'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input style='float:left;' type='submit' value='Add' name='submit'></div>
                </form></div></div></div>";

        return $str;
    }
}

function viewVisitplan() {

    global $user;
    Mpage::$jslink = array('js/fortNightLimit.js', 'js/visitPlan_mob.js');
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL) {
        Mpage::$content = UN_AUTH;
        return;
    }

    $str .="<div class='main-title'><div id='title'>View Visit Plan</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
    $str .="<div id='content-wrapper'>";
    $str .="<div class='navigation'><div id='nav-prev'><a href='#' id='prev'>Previous</a></div><div id='nav-next'><a href='#' id='next'>Next</a></div></div><br>";
    $str .= "<div id='list'></div></div>";
    $str.="</div>";
    return $str;
//    global $user, $database;
//    define("REQ_LEVEL", 2);
//    if ($user->level < REQ_LEVEL) {
//        Mpage::$content = UN_AUTH;
//        return;
//    }
//    $_SESSION['userid'] = $user->userid;
//    $sidx = 2;
//    $sord = "DESC";
//    $start = 0;
//    $limit = 10;
//    $llimit = "2011-06-01";
//    $ulimit = "2011-08-15";
//    $data = $database->viewVisitplan($sidx, $sord, $start, $limit, $llimit, $ulimit);
//    $i = 1;
//    $approved;
//    $s = '<div id="headDcr"><h4>View Visit Plan</h4></div>';
//    foreach ($data as $row) {
//        if ($row['approved'] > 0) {
//            $approved = "Yes";
//        } else {
//            $approved = "No";
//        }
//        $s.="<div>";
//        $s .= "<row id='" . $row['id'] . "'>";
//        $s.= "<div id='party'><div id='partyLabel'>Date :</div><div id='partyName'>" . $row['collected_date'] . "</div></div><br>";
//        $s.= "<div id='party'><div id='partyLabel'>Place :</div><div id='partyName'>" . $row['place'] . "</div></div><br>";
//        $s.= "<div id='party'><div id='partyLabel'>Remarks :</div><div id='partyName'>" . $row['remark'] . "</div></div><br>";
//        $s.= "<div id='party'><div id='partyLabel'>Approved :</div><div id='partyName'>" . $approved . "</div></div><br>";
//        $s .="<div id='party'><a href='?id=" . $row['id'] . "&mpage=editvisitplan'>Edit</a></div>";
//        $s .= "</row><hr>";
//        $i++;
//    }
//        $s .="</div>";
//
//    echo $s;
}

function editVisitplan() {

    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;
    if (isset($_POST['edit'])) {
        $retval = $ctrl->editVisitplan($_POST);
        if ($retval) {
//            header("Location:agricare.php?mpage=viewvisitplan");
            echo "<script>document.location.href='?mpage=viewvisitplan'</script>";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='".$ctrl->referrer."'</script>";
        }
    } else {
        $data = $database->getVisitplanById($_GET['id']);
        $form->setValue('collected_date', $data['collected_date']);
        $form->setValue('place', $data['place']);
        $form->setValue('remark', $data['remark']);
        
        $str .="<div class='main-title'><div id='title'>Edit Visit Plan</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
        $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='row'><b>Date :</b><div> <input type='date' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" /></div><div class='err_msg'>'{$form->error('collected_date')}</div></div>
                <div class='row'><b>Place :</b><div> <input type='text' name='place' value=\"{$form->value('place')}\" /></div><div class='err_msg'>{$form->error('place')}</div></div>
                <div class='row'><b>Remarks :</b><div> <textarea rows='4' cols='45' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='hidden' name='edit'></div>
                <div id='sub'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Edit' name='submit' style='float: left;'></div>
                </form></div></div></div>";

        return $str;
    }
}
?>
