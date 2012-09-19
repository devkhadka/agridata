<?php
function addPartyStock() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level != REQ_LEVEL)
        return UN_AUTH;
    $str = '';
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
//        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
//        Page::$csslink = array('css/ui.all.css');
        $party = $database->getMyParty();
        $product = $database->getProduct();
//        $str .="<div>";
        $str .="<div class='main-title'><div id='title'>Add Party Stock</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
        $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='row'><b>Collected date : (YYYY-MM-DD)</b><div> <input size='16' type='date' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" size='10' /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='row'><b>Party :</b><div><select name='party_id'>";

        foreach ($party as $key) {
            $selected = "";
            if ($key['id'] == $form->value('party_id'))
                $selected = "selected";
            $str .="<option value='{$key['id']}' {$selected}>{$key['name']}</option>";
        }
        $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>";
//                <div class='row'>&nbsp;</div>";
//                <div class='row'>
//                    <table border='0' width='100%'>
//                    <!--<th>sn.</th><th>Product</th><th>No. of case</th><th>Indivisual</th> -->";
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
            $str .= "<div class='row'>{$count}. <b>{$key['name']} ({$key['quantity']} {$key['unit_name']})</b><input type='hidden' name='pid{$count}' value='{$key['id']}' /></div>
                     <div class='row'><input type='number' name='no_of_case{$count}' size='5' value='{$form->value('no_of_case' . $count)}' /> case / <input type='text' name='indv{$count}' size='5' value='{$form->value('indv' . $count)}' />  Pcs </div>
                     <div class='row'>{$no_of_case_err} {$indv_err}</div>";

            if($count < count($product)){
                $str .= "<div class='line-separator'></div>";
            }

        }
        $str .="<div><input type='hidden' name='add'><input type='hidden' name='count' value='{$count}' /></div>
                <div>&nbsp;</div>
                <div id='sub'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type='submit' value='Add' name='submit' style='float: left;'></div>
                </form></div>";
        $str .= "</div><!-- end of list -->";
        $str .="</div><!-- end of content wrapper -->";
//        $str .="<div id='footer'><font color='#828C96'>Copyright©2011</font><font color='#fff'> Agricare Nepal</font></div>";
//        $str .="</div>";


        return $str;
    }
}
function viewPartyStock() {

    global $user,$database;

    Mpage::$jslink = array('js/fortNightLimit.js','js/partyStock_mob.js');
    Mpage::$heading = "View Party Stock";

    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL) {
        Mpage::$content = UN_AUTH;
        return;
    }
    $usr = $database->getMyParty();
    //$url = "./ajax_mobile/partyStockList.php";
    
//    $str.="<div>";
    $str .="<div class='main-title'><div id='title'>View Party Stock</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
    $str .="<div id='content-wrapper'>";
    $str.=" <b>Party : <select name='party' id='mob_party'><option value='0' selected>----select-----</option>";
    foreach ($usr as $key) {
        $str .= "<option value='{$key['id']}'>{$key['name']}</option>";
    }
    $str .="</select></b>";
    $str .="<div class='navigation'><div id='nav-prev'><a href='#' id='prev'>Previous</a></div><div id='nav-next'><a href='#' id='next'>Next</a></div></div><br>";
    $str .= "<div id='list'></div>";
    $str .="</div><!-- end of content wrapper -->";
//    $str .="<div id='footer'><font color='#828C96'>Copyright©2011</font><font color='#fff'> Agricare Nepal</font></div>";
//    $str .="</div>";

    return $str;

}
function editPartyStock(){

   global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level != REQ_LEVEL)
        return UN_AUTH;
    $str;
         if (isset($_SESSION['editPartyStockSuccess'])) {
        unset($_SESSION['editPartyStockSuccess']);
        $str.= "<div class='notice'>Data Update Successfully !!</div>";
         }
   
    if (isset($_POST['edit'])) {

        //print_r($_POST);
        //die();
        $retval = $ctrl->editPartyStock($_POST);

        if ($retval) {
            $_SESSION['editPartyStockSuccess'] = true;
//            header("Location:agricare.php?mpage=viewpartystock");
            echo "<script>document.location.href='?mpage=viewpartystock'</script>";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='".$ctrl->referrer."'</script>";
        }
    } else {
        $party = $database->getParty();

        $product = $database->getProduct();
        $data = $database->getPartyStockById($_GET['id']);
//        var_dump($product);
        $form->setValue('collected_date', $data['collected_date']);
        $form->setValue('party_id', $data['party_id']);
        $form->setValue('product_id', $data['product_id']);
        $form->setValue('no_of_case', $data['no_of_case']);
        $form->setValue('indivisual', $data['indivisual']);
        //print_r($data);
        //die();


        $str .="<div class='main-title'><div id='title'>Edit Party Stock</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
        $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='row'><b>Collected date :</b><div><input disabled type='date' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" size='10' /><input type='hidden' name='collected_date' value='{$data[collected_date]}'/></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='row'><b>Party :</b><div>{$data[party_name]}</div><input type='hidden' name='party_id' value='{$data[party_id]}'/><div class='err_msg'>{$form->error('party_id')}</div></div>
                <div class='row'><b>Product :</b><div>{$data[product_name]} ({$data[quantity]} {$data[unit_name]})</div><input type='hidden' name='product_id' value='{$data[product_id]}'/><div class='err_msg'>{$form->error('product_name')}</div></div>
                <div class='row'><b>No. of case :</b><div> <input type='text' name='no_of_case' size='5' value=\"{$form->value('no_of_case')}\" /></div><div class='err_msg'>{$form->error('no_of_case')}</div></div>
                <div class='row'><b>Indivisual :</b><div> <input type='text' name='indivisual' size='5' value=\"{$form->value('indivisual')}\" /></div><div class='err_msg'>{$form->error('indivisual')}</div></div>

                <div><input type='hidden' name='edit'></div>
                <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div id='sub'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type='submit' value='Edit' name='submit' style='float: left;'></div>
                </form></div></div></div>";
        return $str;
    }

}
?>
