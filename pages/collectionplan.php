<?php

function addCollectionPlan() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    define("REQ_LEVEL4", 4);
    if (!($user->level == REQ_LEVEL || $user->level == REQ_LEVEL4))
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
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='" . $ctrl->referrer . "'</script>";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='" . $ctrl->referrer . "'</script>";
        }
    } else {

        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $party = $database->getMyParty();
//        $product = $database->getProduct();

        $str .="<div id='heading'><h3 style='float:left'>Add Collection Plan</h3><a href='?page=viewcollectionplan'><div id='linking'>Manage Collection Plan</div></a><br/><br/><br/></div>
                <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>From date :</div><div class='act_obj'> <input size='28' type='text' name='from_date' class='datepicker' value=\"{$form->value('from_date')}\" size='10' /></div><div class='err_msg'>{$form->error('from_date')}</div></div>
                <div class='form_row'><div class='label'>To date :</div><div class='act_obj'> <input size='28' type='text' name='to_date' class='datepicker' value=\"{$form->value('to_date')}\" size='10' /></div><div class='err_msg'>{$form->error('to_date')}</div></div>
                <div class='form_row'><div class='label'>Party :</div><div class='act_obj'> <select name='party_id' onchange='partyId(this.value);'><option value='0' selected>----select-----</option>";

        foreach ($party as $key) {
            $selected = "";
            if ($key['id'] == $form->value('party_id'))
                $selected = "selected";
            $str .="<option value='{$key['id']}' {$selected}>{$key['name']}</option>";
        }


        $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>
                   <div class='form_row'><div class='label'>Due Amount :</div><div id='dueAmount'><input style='background:#eee;border:none;' type='text' size='28' disabled></div></div>
                 <div class='form_row'><div class='label'>Amount :</div><div class='act_obj'> <input size='28' type='text' name='amount'     value=\"{$form->value('amount')}\" size='10' /></div><div class='err_msg'>{$form->error('amount')}</div></div>
                <div class='form_row'>&nbsp;</div>";
        $str .="<div><input type='hidden' name='add'><input type='hidden' name='count'/></div>
                <div>&nbsp;</div>
                <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type='submit' value='Add' name='submit'></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                                            $('.datepicker').datepicker({dateFormat:'yy-mm-dd'});
                                            });
                </script>";
        return $str;
    }
}

function viewCollectionPlan() {

    global $user;
    define("REQ_LEVEL", 2);
    define("REQ_LEVEL2", 4);
    define("REQ_LEVEL9", 9);
    if ($user->level != REQ_LEVEL && $user->level != REQ_LEVEL2 && $user->level != REQ_LEVEL9) {
        Page::$content = UN_AUTH;
        return;
    }
    $_SESSION['userid'] = $user->userid;
    $url = "./ajax/collectionPlan.php";
    $baseLinkUrl = BASE_LINK_URL;
    $addParamE = "&page=editcollectionplan";
    $addParamD = "&page=delcollectionplan";

    $idName = "id";
    $str = "<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <script type='text/javascript'>
            jQuery(document).ready(function(){

        var interval = 0;
        var ids;
			jQuery('#next').attr('disabled',true);
            $('#prev').click(function(){
                interval++;
                var limit = new Array();
				limit = getMonthLimit(interval);
				jQuery('#datepicker').val(limit[0]);
				jQuery('#datepicker_to').val(limit[1]);

                //alert(interval);
                jQuery('#next').attr('disabled',false);
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/collectionPlan.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+limit[1],page:1});
                jQuery('#list').jqGrid('setCaption','Collection Plan List:').trigger('reloadGrid');
            });

            $('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/collectionPlan.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1});
                jQuery('#list').jqGrid('setCaption','Collection Plan List:').trigger('reloadGrid');

            });

            $('#next').click(function(){
                if(interval > 0){
                    interval--;
                    var limit = new Array();
					limit = getMonthLimit(interval);
					jQuery('#datepicker').val(limit[0]);
					jQuery('#datepicker_to').val(limit[1]);

                    if(interval == 0)
                        jQuery('#next').attr('disabled',true);
                }

                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/collectionPlan.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                jQuery('#list').jqGrid('setCaption','Collection Plan List:').trigger('reloadGrid');
            });

            var limit = new Array();
			limit = getMonthLimit(interval);
			jQuery('#datepicker').val(limit[0]);
			jQuery('#datepicker_to').val(limit[1]);

            jQuery('#list').jqGrid({
                url:'./ajax/collectionPlan.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Party Name','Created At','From','To','Amount','-','-',''],
                colModel :[
                {name:'id', index:'id', width:25,sortable:false},
                {name:'party_name', index:'party_name', width:150, align:'left',sortable:false},
                {name:'created_at', index:'created_at', width:70, align:'left',sorttype:'text'},
                {name:'From_date', index:'From_date', width:60, align:'left',sorttype:'text'},
                {name:'To_date', index:'To_date', width:60, align:'left',sorttype:'text'},
                {name:'amount', index:'amount', width:60, align:'left',sorttype:'false'},
                {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}},
                {name:'b', index:'b', width:20, align:'center', sortable:false},
                {name:'dummy', index:'dummy', hidden:true}
                ],
                pager: '#pager',
                rowNum:15,
                    width:650,
                    height:330,
                    hidegrid:false,
                rowList:[10,20,30],
                sortname: 'From_date',
                sortname: 'To_date',
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'Collection Plan List',
                editurl:'./ajax/collectionPlan.php?msg=del',
                onCellSelect: function(ids,colid) {
                    //alert(ids+colid+content+jQuery(this).getCell(ids,colid));
                    if(colid == 7 && jQuery(this).getCell(ids,colid+1) == 1){
                        var gr=jQuery(this).jqGrid('getGridParam','selrow');
                        if(gr !=null ){
                            jQuery(this).jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
                        }
                    }


                       //alert(ids);
                }
            });
            });
            </script>
			<div id='heading'><h3 style='float:left'>View Collection Plan</h3><a href='?page=addcollectionplan'><div id='linking'>Add Collection Plan</div></a><br/><br/><br/></div>
		   <div  id='date_alignment'>
			<input type='submit' value='<< Previous' name='prev' id='prev' class='buttonn'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go' class='buttonn'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next' class='buttonn'></div>
            <table id='list'></table>
            <div id='pager'></div>";
    $str.="<script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
            $('#datepicker_to').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";
    Page::$content = $str;
}

function editCollectionPlan() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;

    /*  if(isset($_SESSION['editDcrSuccess'])){
      unset($_SESSON['editDcrSuccess']);
      $str.= "<div class='notice'>Data Update Successfully !!</div>";
      //$str.="Data Update Successfully !!";
      } */
    if (isset($_POST['edit'])) {

        //print_r($_POST);
        //echo "sala";
        //die();
        $retval = $ctrl->editCollectionPlan($_POST);

        if ($retval) {
            $_SESSION['editDcrSuccess'] = true;
//                header("Location:agricare.php?page=viewcollectionplan");
            echo "<script>document.location.href='?page=viewcollectionplan'</script>";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
//                header("Location:".$ctrl->referrer);
            echo "<script>document.location.href='" . $ctrl->referrer . "'</script>";
        }
    } else {
        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $title = $database->getTitle();

        $data = $database->getCollectionPlanById($_GET['id']);

        $form->setValue('from_date', $data['from_date']);
        $form->setValue('to_date', $data['to_date']);
        $form->setValue('party_id', $data['party_id']);
        $form->setValue('amount', $data['amount']);
        $party = $database->getMyParty();
//        $product = $database->getProduct();

        $str .="<div id='heading'><h3> Add Collection Plan </h3> </div>
                <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>From date :</div><div class='act_obj'> <input size='16' type='text' name='from_date' class='datepicker' value=\"{$form->value('from_date')}\" size='10' /></div><div class='err_msg'>{$form->error('from_date')}</div></div>
                <div class='form_row'><div class='label'>To date :</div><div class='act_obj'> <input size='16' type='text' name='to_date' class='datepicker' value=\"{$form->value('to_date')}\" size='10' /></div><div class='err_msg'>{$form->error('to_date')}</div></div>
                <div class='form_row'><div class='label'>Party :</div><div class='act_obj'> <select name='party_id' onchange='partyId(this.value);'><option value='0' selected>----select-----</option>";

        foreach ($party as $key) {
            $selected = "";
            if ($key['id'] == $form->value('party_id'))
                $selected = "selected";
            $str .="<option value='{$key['id']}' {$selected}>{$key['name']}</option>";
        }


        $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>
                 <div class='form_row'><div class='label'>Due Amount :</div><div id='dueAmount'> </div></div>
                 <div class='form_row'><div class='label'>Amount :</div><div class='act_obj'> <input size='16' type='text' name='amount'     value=\"{$form->value('amount')}\" size='10' /></div><div class='err_msg'>{$form->error('amount')}</div></div>";
        $str .="</div></div>
                <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='hidden' name='edit'></div>
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Edit' name='submit'></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";

        return $str;
    }
}
function mViewCollectionPlan(){
    global $user;
        define("REQ_LEVEL",4);
        if($user->level < REQ_LEVEL){
            Page::$content=UN_AUTH;
         return;
        }
        global $database;
        $url = "./ajax/mCollectionPlan.php";
        $baseLinkUrl = "agricare.php";
        $idName = "id";

        //$headquater = $database->getHeadquaterList();

        $userlist = $database->getMRList();

        $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />

            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/jquery.chainedSelects.js'></script>
            <script src='./js/mviewcollectionplan.js'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <div id ='heading'> <h3> View Collection Plan</h3></div>
            <div id='partyStock'>Select M.R : <select name='user' id='user'><option value='0' selected>----select-----</option>";
            foreach($userlist as $key){
                $str .= "<option value='{$key['id']}'>{$key['username']}</option>";
            }

        $str .="</select><br /> <br />
            </div>
            <div  id='date_alignment'><input type='submit' value='<< Previous' class='buttonn' name='prev' id='prev'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' class='buttonn' name='go' id='go'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next' class='buttonn'></div>
            <table id='list'></table>
            <div id='pager'></div>
            <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
            $('#datepicker_to').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";
            Page::$content = $str;
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