<?php

function addDueAmount() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 9);
    define("REQ_LEVEL2", 4);
    if ($user->level != REQ_LEVEL && $user->level != REQ_LEVEL2)
        return UN_AUTH;
    $str = '';

    if (isset($_SESSION['addAmountSuccess'])) {
        unset($_SESSION['addAmountSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
    }

    if (isset($_POST['add'])) {

        $retval = $ctrl->addDueAmount($_POST);

        if ($retval) {
            $_SESSION['addAmountSuccess'] = true;
            header("Location:" . $ctrl->referrer);
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {

        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $party = $database->getInvolvedParty();

        $str .="<div id='heading'>
                <h3 style='float:left'>Add Due Amount</h3><a href='?page=viewdueamount'><div id='linking'>Manage Due Amount</div></a><br><br></div>
                <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Collected date :</div><div class='act_obj'> <input size='16' type='text' name='collected_date' class='datepicker' value=\"{$form->value('collected_date')}\" size='10' /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='form_row'><div class='label'>Party :</div><div class='act_obj'> <select name='party_id'>";

        foreach ($party as $key) {
            $selected = "";
            if ($key['id'] == $form->value('party_id'))
                $selected = "selected";
            $str .="<option value='{$key['party_id']}' {$selected}>{$key['name']}</option>";
        }


        $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>
                <div class='form_row'><div class='label'>Amount :</div><div class='act_obj'> <input size='16' type='text' name='amount' value=\"{$form->value('amount')}\" size='10' /></div><div class='err_msg'>{$form->error('amount')}</div></div>
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

function viewDueAmount() {
    global $user;
    define("REQ_LEVEL", 9);
    define("REQ_LEVEL2", 4);
    if ($user->level != REQ_LEVEL && $user->level != REQ_LEVEL2) {
        Page::$content = UN_AUTH;
        return;
    }
    $_SESSION['userid'] = $user->userid;
    $url = "./ajax/dueamount.php";
    $baseLinkUrl = BASE_LINK_URL;
    $addParamE = "&page=editdueamount";
    $addParamD = "&page=delpartystock";

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
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/dueamount.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                jQuery('#list').jqGrid('setCaption','Due Amount List:').trigger('reloadGrid');
            });

            $('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/dueamount.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1});
                jQuery('#list').jqGrid('setCaption','Due Amount List:').trigger('reloadGrid');

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

                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/dueamount.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                jQuery('#list').jqGrid('setCaption','Due Amount List:').trigger('reloadGrid');
            });

            var limit = new Array();
			limit = getMonthLimit(interval);
			jQuery('#datepicker').val(limit[0]);
			jQuery('#datepicker_to').val(limit[1]);

            jQuery('#list').jqGrid({
                url:'./ajax/dueamount.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Party Name','collected_date','Amount','-','-',''],
                colModel :[
                {name:'id', index:'id', width:25,sortable:false},
                {name:'party_name', index:'party_name', width:150, align:'left',sortable:false},
                {name:'collected_date', index:'collected_date', width:60, align:'left',sorttype:'text'},
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
                sortname: 'collected_date',
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'Due Amount List',
                editurl:'./ajax/dueamount.php?msg=del',
                onCellSelect: function(ids,colid) {
                 $('#list_d').show();
                    jQuery('#list_d').jqGrid('setGridParam',{url:'./ajax/due_oldPartyPrice.php?id='+ids,page:1});
                    jQuery('#list_d').jqGrid('setCaption','Due Party Amount Detail :').trigger('reloadGrid');

                
                    //alert(ids+colid+content+jQuery(this).getCell(ids,colid));
                    if(colid == 7 && jQuery(this).getCell(ids,colid+1) == 1){
                        var gr=jQuery(this).jqGrid('getGridParam','selrow');
                        if(gr !=null ){
                            jQuery(this).jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
                        }
                    }


//                       alert(ids);
                }
            });
                jQuery('#list_d').jqGrid({

                url:'./ajax/due_oldPartyPrice.php?id={$_GET[id]}',
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Collected Date','Amount'],
                colModel :[
                {name:'id', index:'id', width:25,sortable:false},
                {name:'collected_date', index:'effective_date', width:50, align:'left',sortable:false},
                {name:'amount', index:'amount', width:70, align:'left',sorttype:'text'},
                ],
                pager: '#pager',
                rowNum:15,
                    width:650,
                    height:330,
                    hidegrid:false,
                rowList:[10,20,30],
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'TA Setting Detail',
            });
            });
            </script>
			<div id='heading'><h3 style='float:left'>View Due Amount</h3><a href='?page=adddueamount'><div id='linking'>Add Due Amount</div></a><br/><br/><br/></div>
		   <!-- <div>
			<input type='submit' value='<< Previous' name='prev' id='prev' class='buttonn'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go' class='buttonn'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next' class='buttonn'></div> -->
            <table id='list'></table>
            <div id='pager'></div>";
    $str.="<script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
            $('#datepicker_to').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";
    $str.="<table id='list_d'></table>";
    Page::$content = $str;
}
function editDueAmount(){
        global $form,$ctrl,$database,$user;
        define("REQ_LEVEL",2);
        if($user->level < REQ_LEVEL) return UN_AUTH;
        $str;

          /*  if(isset($_SESSION['editDcrSuccess'])){
            unset($_SESSON['editDcrSuccess']);
            $str.= "<div class='notice'>Data Update Successfully !!</div>";
            //$str.="Data Update Successfully !!";
          }*/

        if(isset($_POST['edit'])){

//            print_r($_POST);
            //die();
            $retval = $ctrl->editDueAmount($_POST);
            if($retval){
                $_SESSION['editDcrSuccess'] = true;
//                header("Location:agricare.php?page=viewdcr");
                echo "<script>document.location.href='?page=viewdueamount'</script>";
            }
            else{
                $_SESSION['value_array'] = $_POST;
                $_SESSION['error_array'] = $form->getErrorArray();
//                header("Location:".$ctrl->referrer);
                echo "<script>document.location.href='".$ctrl->referrer."'</script>";
            }
        } else {
            Page::$jslink=array('js/ui.core.js','js/ui.datepicker.js');
            Page::$csslink=array('css/ui.all.css');
            $title = $database->getTitle();
            $data = $database->getPartyDueById($_GET['id']);
            
            $form->setValue('collected_date',$data['collected_date']);
            $form->setValue('party_id',$data['party_id']);
            $form->setValue('amount',$data['amount']);

        $party = $database->getInvolvedParty();

//        $product = $database->getProduct();

        $str .="<div id='heading'><h3> Edit Due Amount </h3> </div>
                <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Collected date :</div><div class='act_obj'> <input size='16' type='text' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" size='10' /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='form_row'><div class='label'>Party :</div><div class='act_obj'> <select name='party_id'>";

        foreach ($party as $key) {
            $selected = "";
            if ($key['id'] == $form->value('party_id'))
                $selected = "selected";
            $str .="<option value='{$key['party_id']}' {$selected}>{$key['name']}</option>";
        }


        $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>
                <div class='form_row'><div class='label'>Amount :</div><div class='act_obj'> <input size='16' type='text' name='amount' value=\"{$form->value('amount')}\" size='10' /></div><div class='err_msg'>{$form->error('amount')}</div></div>
                <div class='form_row'>&nbsp;</div>
        
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
?>
