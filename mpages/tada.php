<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function addTada() {

    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;
    //echo "at tada";
    if (isset($_SESSION['addTadaSuccess'])) {
//            unset($_SESSION['addTadaSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
        //$str.="Data Entered Successfully !!";
    }


    if (isset($_POST['add'])) {

        $args = array('visited_date' => $_POST['visited_date'], 'visit_place' => $_POST['visit_place'], 'distance' => $_POST['distance'], 'da' => $_POST['da'], 'other' => $_POST['other'], 'remark' => $_POST['remark']);
        //print_r($args);
        //die();
        $retval = $ctrl->addTada($args);

        if ($retval) {
            $_SESSION['addTadaSuccess'] = true;
            header("Location:" . $ctrl->referrer);
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {
        $str .="<div class='main-title'><div id='title'>Add TA/DA</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
        $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='row'><b>Visit Date : (YYYY-MM-DD)</b><div> <input class='addDcrForm' type='date' size='25'  name='visited_date' id='datepicker' value=\"{$form->value('visited_date')}\" /></div><div class='err_msg'>{$form->error('visited_date')}</div></div>
                <div class='row'><b>Visit Place :</b><div> <input type='text' name='visit_place' size='25' value=\"{$form->value('visit_place')}\" /></div><div class='err_msg'>{$form->error('visit_place')}</div></div>
                <div class='row'><b>Distance Travel : (Km)</b><div> <input type='text' size='25' name='distance' value=\"{$form->value('distance')}\" /></div><div class='err_msg'>{$form->error('distance')}</div></div>
                <div class='row'><b>Daily allowance : (Rs.)</b><div> <input type='text' size='25' name='da' value=\"{$form->value('da')}\" /></div><div class='err_msg'>{$form->error('da')}</div></div>
                <div class='row'><b>Other : (Rs.)</b><div> <input type='text' size='25' name='other' value=\"{$form->value('other')}\" /></div><div class='err_msg'>{$form->error('other')}</div></div>
                    <div class='row'><b>Remarks :</b><div> <textarea rows='6' cols='40' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                    <div><input type='hidden' name='add'></div>
                <div id='sub'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' style='float:left;' name='submit' value='Add'></div>
                </form></div></div></div>";
        return $str;
    }
}

function viewTada() {
    global $user;
    Mpage::$jslink = array('js/fortNightLimit.js','js/tada_mob.js');
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL) {
        Mpage::$content = UN_AUTH;
        return;
    }
    $str .="<div class='main-title'><div id='title'>View TA/DA</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
    $str .="<div id='content-wrapper'>";
    $str .="<div class='navigation'><div id='nav-prev'><a href='#' id='prev'>Previous</a></div><div id='nav-next'><a href='#' id='next'>Next</a></div></div><br>";
    $str .= "<div id='list'></div>";
    $str.="</div>";
    return $str;
}

function editTada(){

        global $form,$ctrl,$database;
        $str;

        /*echo "at tada";
        if(isset($_SESSION['edittadaSuccess'])){
            unset($_SESSION['edittadaSuccess']);
            $str.= "<div class='notice'>Data Entered Successfully !!</div>";
            $str.="Data Updated Successfully !!";
        }*/


        if(isset($_POST['edit'])){

//            $args = array('visited_date'=>$_POST['visited_date'],'visit_place'=>$_POST['visit_place'],'distance'=>$_POST['distance'],'da'=>$_POST['da'],'other'=>$_POST['other'],'remark'=>$_POST['remark'],'id'=>$_POST['id']);
            //print_r($args);
            //die();
            $retval = $ctrl->editTada($_POST);

            if($retval){
//                header("Location:agricare.php?mpage=viewtada");
                 echo "<script>document.location.href='?mpage=viewtada'</script>";
            }
            else{
                $_SESSION['value_array'] = $_POST;
                $_SESSION['error_array'] = $form->getErrorArray();
//                header("Location:".$ctrl->referrer);
                 echo "<script>document.location.href='".$ctrl->referrer."'</script>";
            }
        } else {
        $title = $database->getTitle();
            $data = $database->getTadaById($_GET['id']);

            //print_r($data);
            //die();

//            if(time()-strtotime($data['created_date']) > 43200)
//                return "<div class='notice'>You can not edit this data because your time limit exceed 12 hr ask admin to edit it.</div>";

            $form->setValue('visited_date',$data['visited_date']);
            $form->setValue('visit_place',$data['visit_place']);
            $form->setValue('distance',$data['distance']);
            $form->setValue('da',$data['da']);
            $form->setValue('other',$data['other']);
            $form->setValue('remark',$data['remark']);

            $str .="<div class='main-title'><div id='title'>Edit TA/DA</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
            $str .="<div id='content-wrapper'>";
            $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                    <div class='row'><b>Visit Date : (YYYY-MM-DD)</b><div> <input type='date' size='10'  name='visited_date' id='datepicker' value=\"{$form->value('visited_date')}\" /></div><div class='err_msg'>{$form->error('visited_date')}</div></div>
                    <div class='row'><b>Visit Place :</b><div> <input type='text' name='visit_place' value=\"{$form->value('visit_place')}\" /></div><div class='err_msg'>{$form->error('visit_place')}</div></div>
                    <div class='row'><b>Distance Travel : (Km)</b><div> <input type='text' size='5' name='distance' value=\"{$form->value('distance')}\" /></div><div class='err_msg'>{$form->error('distance')}</div></div>
                    <div class='row'><b>Daily allowance : (Rs.)</b><div> <input type='text' size='5' name='da' value=\"{$form->value('da')}\" /></div><div class='err_msg'>{$form->error('da')}</div></div>
                    <div class='row'><b>Other : (Rs.)</b><div> <input type='text' size='10' name='other' value=\"{$form->value('other')}\" /></div><div class='err_msg'>{$form->error('other')}</div></div>
                    <div class='row'><b>Remarks :</b><div> <textarea rows='4' cols='40' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                    <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                    <div><input type='hidden' name='edit'></div>
                    <div id='sub'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='Edit' style='float: left;'></div>
                    </form></div></div></div>";
            return $str;
        }
}
?>
