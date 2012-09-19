<?php
function addPartyStock() {

    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    define("REQ_LEVEL2", 4);
    if (!($user->level == REQ_LEVEL2 || $user->level == REQ_LEVEL)) {
        var_dump($user->level);

        return UN_AUTH;
    }
    $str;

    if (isset($_SESSION['addPartyStockSuccess'])) {
        unset($_SESSION['addPartyStockSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
    }

    if (isset($_POST['add'])) {

        $retval = $ctrl->addPartyStock($_POST);

        if ($retval) {
            $_SESSION['addPartyStockSuccess'] = true;
            header("Location:" . $ctrl->referrer);
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {

        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $party = $database->getMyParty();

        $product = $database->getProduct();

        $str .="<div id='heading'><h3 style='float:left'>Add Party Stock</h3><a href='?page=viewpartystock'><div id='linking'>Manage Party Stock</div></a><br/><br/><br/></div>
                <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Collected date :</div><div class='act_obj'> <input size='16' type='text' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" size='10' /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='form_row'><div class='label'>Party :</div><div class='act_obj'> <select name='party_id'><option value='0' selected>----select-----</option>";
        foreach ($party as $key) {

            $selected = "";
            if ($key['id'] == $form->value('party_id'))
                $selected = "selected";
            $str .="<option value='{$key['id']}' {$selected}>{$key['name']}</option>";
        }


        $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>
                <div class='form_row'>&nbsp;</div>
                <div class='tableContainer' id='tableContainer'>
                    <table width='100%' cellspacing='0' cellpadding='0' border='0' id='addTable'>
                  <thead class='fixedHeader'> <tr> <th style='width:59px;'>sn.</th><th>Product</th><th width='1px'>No. of case</th><th width='1px'>Indivisual</th></tr></thead>
        <tbody class='scrollContent' style='height: 426px;'>";
        $count = 0;
        $no_of_case_error = "";
        $indv_error = "";

        foreach ($product as $key) {
            $count++;
            $no_of_case_err = "";
            $indv_err = "";

            if ($form->error('no_of_case' . $count) != null)
                $no_of_case_err = "<font color='#FF0000'>*</font>";
            if ($form->error('indv' . $count) != null)
                $indv_err = "<font color='#FF0000'>*</font>";
            $str .= "<tr  style='width:300px;'>
                                    <td style='width:51px;'>{$count}<input type='hidden' name='pid{$count}' value='{$key['id']}' /></td>
                                    <td style='width:191px;'>{$key['name']} ({$key['quantity']} {$key['unit_name']})</td>
                                    <td style='width:197px;'><input type='text' name='no_of_case{$count}' size='' value='{$form->value('no_of_case' . $count)}' />{$no_of_case_err}</td>
                                    <td style='width:188px;'><input type='text' name='indv{$count}' size='' value='{$form->value('indv' . $count)}' />{$indv_err}</td>
                                </tr>";
        }
        $str .="<tbody></table>
                </div>
                <div><input type='hidden' name='add'><input type='hidden' name='count' value='{$count}' /></div>
                <div>&nbsp;</div>
                <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type='submit' value='Add' name='submit'></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                                            $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                                            });
                </script>";
        return $str;
    }

    //return $str;
}
function mrViewPartyStock() {
    global $database, $user;
    define("REQ_LEVEL", 2);
    define("REQ_LEVEL2", 4);
    if ($user->level != REQ_LEVEL && $user->level != REQ_LEVEL2) {
        Page::$content = UN_AUTH;
        return;
    }
    $usr = $database->getMyParty();
//    $url = "./ajax/mrpartystock.php";
//    $baseLinkUrl = "agricare.php";
    $str = "<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/jquery.chainedSelects.js'></script>
            <script src='./js/mrviewpartystock.js'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <div id='heading'><h3 style='float:left'>View Party Stock</h3><a href='?page=addpartystock'><div id='linking'>Add Party Stock</div></a><br/><br/><br/></div>
            <div id='partyStock'>Party : <select name='party' id='party'><option value='0' selected>----select-----</option>";
    foreach ($usr as $key) {
        $str .= "<option value='{$key['id']}'>{$key['name']}</option>";
    }
    $str .="</select>
            <br /> <br />
            </div>
            <div id='date_alignment'><input type='submit' value='<< Previous' name='prev' id='prev' class='buttonn'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go' class='buttonn'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next' class='buttonn'></div><div id='display'><table id='list'></table><div id='pager'></div></div>";
    $str.="
            <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
            $('#datepicker_to').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";
    Page::$content = $str;
}



function editPartyStock() {

    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    define("REQ_LEVEL2", 4);
    if ($user->level != REQ_LEVEL && $user->level != REQ_LEVEL2)
        return UN_AUTH;
    $str;
    /*
      if(isset($_SESSION['editPartyStockSuccess'])){
      unset($_SESSON['editPartyStockSuccess']);
      $str.= "<div class='notice'>Data Update Successfully !!</div>";
      } */

    if (isset($_POST['edit'])) {

        //print_r($_POST);
        //die();
        $retval = $ctrl->editPartyStock($_POST);

        if ($retval) {
            //$_SESSION['editPartyStockSuccess'] = true;
            header("Location:agricare.php?page=viewpartystock");
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {

        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $party = $database->getParty();

        $product = $database->getProduct();
        $data = $database->getPartyStockById($_GET['id']);

        if (time() - strtotime($data['created_date']) > 43200)
            return "<div class='notice'>You can not edit this data because your time limit exceed 12 hr ask admin to edit it.</div>";
        $form->setValue('collected_date', $data['collected_date']);
        $form->setValue('party_id', $data['party_id']);
        $form->setValue('product_id', $data['product_id']);
        $form->setValue('no_of_case', $data['no_of_case']);
        $form->setValue('indivisual', $data['indivisual']);
        //print_r($data);
        //die();

        $str .="<div id ='heading'><h3> Edit Party Stock</h3> </div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Collected date :</div><div class='act_obj'> <input type='text' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" size='10' /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='form_row'><div class='label'>Party :</div><div class='act_obj'> <select name='party_id'>";
        foreach ($party as $key) {

            $selected = "";
            if ($key['id'] == $form->value('party_id'))
                $selected = "selected";
            $str .="<option value='{$key['id']}' {$selected}>{$key['name']}</option>";
        }


        $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>
                <div class='form_row'><div class='label'>Product :</div><div class='act_obj'> <select name='product_id'>";
        foreach ($product as $key) {
            $selected = "";
            if ($key['id'] == $form->value('product_id'))
                $selected = "selected";
            $str .= "<option value='{$key['id']}' {$selected}>{$key['name']} ({$key['quantity']} {$key['unit_name']})</option>";
        }
        $str .="</select></div><div class='err_msg'>{$form->error('product_id')}</div></div>
                <div class='form_row'><div class='label'>No. of case :</div><div class='act_obj'> <input type='text' name='no_of_case' size='5' value=\"{$form->value('no_of_case')}\" /></div><div class='err_msg'>{$form->error('no_of_case')}</div></div>
                <div class='form_row'><div class='label'>Indivisual :</div><div class='act_obj'> <input type='text' name='indivisual' size='5' value=\"{$form->value('indivisual')}\" /></div><div class='err_msg'>{$form->error('indivisual')}</div></div>
                <div><input type='hidden' name='edit'></div>
                <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type='submit' value='Edit' name='submit'></div>      
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                                            $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                                            });
                </script>";
        return $str;
    }

    //return $str;
}

function mViewPartyStock() {
    global $database, $user;
    define("REQ_LEVEL", MMR_LEVEL);
    define("REQ_LEVEL2", ADMIN_LEVEL);
    if ($user->level != REQ_LEVEL && $user->level != REQ_LEVEL2) {
        Page::$content = UN_AUTH;
        return;
    }
//    $usr = $database->getInvolvedParty();
   if($user->level == REQ_LEVEL2){
            $usr = $database->getInvolvedParty();
        }else{
        $usr = $database->getParty();
        }
    $url = "./ajax/mpartystock.php";
    $baseLinkUrl = "agricare.php";
    $str = "<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/jquery.chainedSelects.js'></script>            
            <script src='./js/mviewpartystock.js'></script>     
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>       
            <div id ='heading'> <h3> View Party Stock</h3></div><div id='partyStock'>Party : <select name='party' id='party'><option value='0' selected>----select-----</option>";
    foreach ($usr as $key) {
        $str .= "<option value='{$key['party_id']}'>{$key['name']}</option>";
    }

    $str .="</select>
            <br /> <br />
            </div>
            <div id='date_alignment'><input type='submit' value='<< Previous' name='prev' id='prev' class='buttonn'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go' class='buttonn'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next' class='buttonn'></div><div id='display'><table id='list'></table><div id='pager'></div></div>";
    $str.="
            <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
            $('#datepicker_to').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";

    Page::$content = $str;
}
?>
