
<?php
function addSalesPlan() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level != REQ_LEVEL)
        return UN_AUTH;
    $str;
//    if (isset($_SESSION['addSalesSuccess'])) {
//        unset($_SESSION['addSalesSuccess']);
//        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
//    }
    if (isset($_POST['add'])) {
//        var_dump($_POST);
//        die();
        $retval = $ctrl->addSalesPlan($_POST);
        if ($retval) {
            $_SESSION['addSalesSuccess'] = true;
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='" . $ctrl->referrer . "'</script>";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='" . $ctrl->referrer . "'</script>";
        }
    } else {
//        Mpage::$csslink = array('css/jquery.keypad.css');
//        Mpage::$jslink = array('js/jquery.keypad.js');

        $party = $database->getMyParty();
        $str .="<div class='main-title'><div id='title'>Add Sales Plan</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
        $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='row'><b>Party :</b><div><select name='party_id' onchange='partyId(this.value)'><option value='0' selected>----Select Party-----</option>";
        foreach ($party as $key) {
            $selected = "";
            if ($key['id'] == $form->value('party_id'))
                $selected = "selected";
            $str .="<option value='{$key['id']}' {$selected}>{$key['name']}</option>";
        }
        $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>";
        $str.=" <div class='row'><b>Date :</b></div>
                <div class='row'><b>From :(YYYY-MM-DD)</b></div>
                <div class='row'><div><input type='date' name='from_date' value='{$form->value('from_date')}'/></div><div class='err_msg'>{$form->error('from_date')}</div></div>
                <div class='row'><b>To :(YYYY-MM-DD)</b></div>
                <div class='row'><div><input type='date' name='to_date' value='{$form->value('to_date')}'/></div><div class='err_msg'>{$form->error('to_date')}</div></div>";
        $str.="<div id='salesPlanDetail'>&nbsp;</div>
                <div id='sub'><input style='float:left' type='submit' value='Add' name='submit'></div>
                </form></div></div></div>";

        return $str;
    }
}

function viewSalesPlan() {
    global $user, $database;
    Mpage::$jslink = array('js/fortNightLimit.js','js/salesPlan_mob.js');
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL) {
        Mpage::$content = UN_AUTH;
        return;
    }
    $str .="<div class='main-title'><div id='title'>View Sales Plan</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
    $str .="<div id='content-wrapper'>";
    $str .="<div class='navigation'><div id='nav-prev'><a href='#' id='prev'>Previous</a></div><div id='nav-next'><a href='#' id='next'>Next</a></div></div><br>";
    $str .= "<div id='list'></div></div>";
    $str.="</div>";
    return $str;
}

function viewSalesPlanDetail(){
    global $user, $database;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL) {
        Mpage::$content = UN_AUTH;
        return;
    }
    $str = '';
    $data = $database->viewSalesPlanDetail($_GET['id']);
//    var_dump($data);
    foreach($data as $detail){
        $str .= "<div><b>{$detail['product_name']} {$detail['qty']} {$detail['unit']}</b></div>";
        $str .= "<div>Plan : {$detail['plan_case']} case / {$detail['plan_individual']} pcs </div>";
        $str .= "<div>Discount : {$detail['discount_case']} case / {$detail['discount_individual']} pcs </div>";
        $str .= "<hr>";
    }
    echo $str;
}
function editsalesplan(){
     global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level != REQ_LEVEL)
        return UN_AUTH;
    $str = '';
//     if (isset($_SESSION['editSalesSuccess'])) {
//        unset($_SESSION['editSalesSuccess']);
//        $str.= "<div class='notice'>Data Update Successfully !!</div>";
//    }
    if (isset($_POST['edit'])) {

        $retval = $ctrl->editSalesPlan($_POST);
        if ($retval) {
            $_SESSION['editSalesSuccess'] = true;
//            header("Location:agricare.php?mpage=viewsalesplan");
             echo "<script>document.location.href='?mpage=viewsalesplan'</script>";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
//            header("Location:" . $ctrl->referrer);
             echo "<script>document.location.href='".$ctrl->referrer."'</script>";
        }
    } else {
        $salesPlan = $database->getSalesPlanById($_GET['id']);
        $salesPlanDetail = $database->getSalesPlanDetail($_GET['id']);
        $form->setValue('from_date', $salesPlan['from_date']);
        $form->setValue('to_date', $salesPlan['to_date']);
        $form->setValue('party_id', $salesPlan['party_id']);
        $party = $database->getMyParty();
        $str .="<div class='main-title'><div id='title'>Edit Sales Plan</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
         $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='row'><b>Party :</b><div>{$salesPlan[party_name]}</div><input type='hidden' name='party_id' value='{$salesPlan[party_id]}'/><div class='err_msg'>{$form->error('party_id')}</div></div>";
        $str.="<div class='row'><b>Date :</b></div>
               <div class='row'> <b>From :</b></div>
                <div class='row'><div><input class='addDcrForm' type='date' name='from_date' value='{$form->value('from_date')}'/></div><div class='err_msg'>{$form->error('from_date')}</div></div>
               <div class='row'> <div>To :</div>
               <div><input class='addDcrForm' type='date' name='to_date' value='{$form->value('to_date')}'/></div><div class='err_msg'>{$form->error('to_date')}</div></div>";

        $products = $database->getProduct();
        $count;
        $i=0;
        $str.= "<table>";
        foreach ($products as $count => $product) {
            $i++;
            $str .= "<tr>";
            $str .= "<td>$i. <b>" . $product['name'] . " " . $product['quantity'] . " " . $product['unit_name'] . "</b><input type='hidden' name='product_id{$count}' value='{$product['id']}'/></td>";
            $str .= "</tr>";
            $stock = $database->getPartyStock($form->value('party_id'), $product['id']);
            if (is_array($stock) && count($stock)) {
                $str .= "<tr><td>Stock : </td>";
                $str.= "<td>" . $stock[0]['no_of_case'] . " case / " . $stock[0]['indivisual'] . " pcs. </td>
            </tr>";
            } else {
                $str .= "<tr><td>Stock : </td><td>0 case / 0 pcs. </td></tr>";
            }

            $data = hasRecord($product['id'], $salesPlanDetail);
            if(is_array($data)){
                $str .= "<tr><td>Plan : </td><td><input type='text' name='plan_case{$count}' value=\"{$data[plan_case]}\" size='5' /> case / <input type='text' name='plan_individual{$count}' value=\"{$data[plan_individual]}\" size='5'/> pcs.</td></tr>";
                $str .= "<tr><td>Discount : </td><td><input type='text' name='discount_case{$count}' value=\"{$data[discount_case]}\" size='5' /> case / <input type='text' name='discount_individual{$count}' value=\"{$data[discount_individual]}\" size='5'/> pcs.<input type='hidden' name='id{$count}' value=\"{$data[id]}\"/></td></tr>";
            }else {
                $str .= "<tr><td>Plan : </td><td><input type='text' name='plan_case{$count}' value=\"\" size='5' /> case / <input type='text' name='plan_individual{$count}' value=\"\" size='5'/> pcs.</td></tr>";
                $str .= "<tr><td>Discount : </td><td><input type='text' name='discount_case{$count}' value=\"\" size='5' /> case / <input type='text' name='discount_individual{$count}' value=\"\" size='5'/> pcs.</td></tr>";
            }
            
        }
        $str .= "</table><div><input type='hidden' name='count' value='{$count}' /></div>";
                $str.="<div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='hidden' name='edit'></div>
                <div id='sub'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input style='float:left' type='submit' value='Edit' name='submit'></div>
                </form></div></div></div>";
        return $str;
    }
}
function hasRecord($id,$list){

    foreach($list as $item){

        if($item['product_id'] == $id){
            return $item;
            break;
        }
    }

    return false;

}
?>
<script language="javascript" type="text/javascript">
    function partyId(val) {
//            alert(val);
        $.ajax({
            type:"GET",
            url:"./ajax_mobile/add_salesPlan.php?party_id="+val,
            cache: false,
               success: function(msg){
//                location.reload();
                $("#salesPlanDetail").html(msg);
                //$("#dueAmount").show();
                //alert(msg);
            }
        });
    }
//    jQuery(document).ready(function(){
//        $('#defaultKeypad').keypad();
//    });
</script>
