<?php

function addMCollectionPlan() {

    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);

    if ($user->level != REQ_LEVEL)
        return UN_AUTH;

    $str;

    if (isset($_SESSION['addCollectionPlanSuccess'])) {
        unset($_SESSION['addCollectionPlanSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
    }

    if (isset($_POST['add'])) {
        $retval = $ctrl->addCollectionPlan($_POST);
        if ($retval) {
            $_SESSION['addCollectionPlanSuccess'] = true;
            echo "<script>document.location.href='?mpage=viewcollectionplan'</script>";
//            header("Location:" . $ctrl->referrer);
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {
        $party = $database->getMyParty();
        $str .="<div class='main-title'><div id='title'>Add Collection Plan</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
        $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='row'><div>Party :</div><div> <select name='party_id' id='party_id' onchange='partyId(this.value);' ><option value='0' selected>----Select Party-----</option>";
        $partyId = '';
        foreach ($party as $key) {
            $selected = "";
            if ($key['id'] == $form->value('party_id'))
                $selected = "selected";
            $partyId = $key['id'];
            $str .="<option value='{$key['id']}' {$selected}>{$key['name']}</option>";
        }
        $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>";
//        $datas = $database->getPartyDue($partyId);
        $str .="<div class='row'><b>Date :</b></div>
            <div class='row'><b>From :</b>
            <div><input placeholder='YYYY-MM-DD' class='addDcrForm' type='date' name='from_date'/></div></div>
            <div class='row'><b>To :</b>
            <div><input placeholder='YYYY-MM-DD' class='addDcrForm' type='date' name='to_date'/></div></div>
            <div class='row'><div id='mainDue'><b>Due Amount :</b>
            <div id='dueAmount'></div></div></div><br>
            <div class='row'><b>Amount :</b>
            <div><input type='text' name='amount'/></div></div>
            <div><input type='hidden' name='add'><input type='hidden' name='count'/></div>
            <div id='sub'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input style='float:left' type='submit' value='Add' name='submit'></div>
            </form></div></div></div>";
    }
    return $str;
}

function viewCollectionPlan() {
    global $user, $database;

    Mpage::$jslink = array('js/fortNightLimit.js','js/collectionPlan_mob.js');

    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL) {
        Mpage::$content = UN_AUTH;
        return;
    }
    //$_SESSION['userid'] = $user->userid;
    
    $str .="<div class='main-title'><div id='title'>View Collection Plan</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
    $str .="<div id='content-wrapper'>";
    $str .="<div class='navigation'><div id='nav-prev'><a href='#' id='prev'>Previous</a></div><div id='nav-next'><a href='#' id='next'>Next</a></div></div><br>";
    $str .= "<div id='list'></div></div>";
    $str.="</div>";
    return $str;
}

function editCollectionPlan() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;
    if (isset($_POST['edit'])) {
//        print_r($_POST);
        $retval = $ctrl->editCollectionPlan($_POST);
//        print_r($retval);
        if ($retval) {
            $_SESSION['editDcrSuccess'] = true;
//            header("Location:agricare.php?mpage=viewcollectionplan");
            echo "<script>document.location.href='?mpage=viewcollectionplan'</script>";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='".$ctrl->referrer."'</script>";
        }
    } else {
        $title = $database->getTitle();
        $data = $database->getCollectionPlanById($_GET['id']);
        $form->setValue('party_id', $data['party_id']);
        $form->setValue('from_date', $data['from_date']);
        $form->setValue('to_date', $data['to_date']);
        $form->setValue('amount', $data['amount']);
        $str .="<div class='main-title'><div id='title'>Edit Collection Plan</div><div id='menu'><a href='?mpage='>Home</a></div></div>";
        $str .="<div id='content-wrapper'>";
        $str .="<div id='list'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                 <div class='row'><b>Party :</b><div>{$data[party_name]}</div><input type='hidden' name='party_id' value='{$data[party_id]}'/><div class='err_msg'>{$form->error('party_id')}</div></div>";
        $str .="<div class='row'><b>Date :</b></div>
                <div class='row'><b>From :</b>
                <div><input class='addDcrForm' type='date' name='from_date' value=\"{$form->value('from_date')}\"/></div></div>
                <div class='row'><b>To :</b>
                <div><input class='addDcrForm' type='date' name='to_date' value=\"{$form->value('to_date')}\"/></div></div>
                <div class='row'><b>Due Amount :</b>
                <div id='dueAmount'></div></div>
                <div class='row'><b>Amount :</b>
                <div><input type='text' name='amount' value=\"{$form->value('amount')}\"/></div></div>";

        $str .="<div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='hidden' name='edit'></div>
                <div id='sub'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Edit' name='submit' style='float: left;'></div>
                </form></div>";

        return $str;
    }
}
?>
<script language="javascript" type="text/javascript">
    function partyId(val) {
        //            alert(val);

        $.ajax({
            type:"GET",
            url:"./ajax/add_collectionPlan.php?party_id="+val,
            cache: false,
            success: function(msg){
                //                location.reload();
                $("#dueAmount").html(msg);
                $("#dueAmount").show();
                //                alert(msg);
            }
        });
    }
</script>