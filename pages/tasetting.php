<?php

function viewTASetting() {
    global $user;
    define("REQ_LEVEL", 9);
    if ($user->level < REQ_LEVEL) {
        Page::$content = UN_AUTH;
        return;
    }
    global $database;

    $url = "./ajax/tasetting.php";
    $baseLinkUrl = BASE_LINK_URL;
    $addParamE = "&page=edittasetting";
    $addParamD = "&page=deltasetting";
    $idName = "id";

    $str = "<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            
            <script type='text/javascript'>
            jQuery(document).ready(function(){

            jQuery('#list').jqGrid({
                url:'{$url}',
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Username', 'Amount / km. (Rs.)','Date','-','-',''],
                colModel :[ 
                {name:'id', index:'id', width:25,sortable:false}, 
                {name:'username', index:'username', width:120, align:'left',sorttype:'text'}, 
                {name:'amount', index:'amount', width:80, align:'left',sortable:false}, 
                {name:'date', index:'date', width:60, align:'left',sortable:false}, 
                {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}}, 
                {name:'b', index:'b', width:20, align:'center',edit:false, sortable:false},
                {name:'dummy',index:'dummy',hidden:true}
                ],
                pager: '#pager',
                rowNum:8,
                    width:500,
                    height:175,
                    hidegrid:false,
                rowList:[10,20,30],
                sortname: 'username',
                sortorder: '',
                viewrecords: true,
                imgpath: '',
                caption: 'TA Setting List',
                editurl:'./ajax/tasetting.php?msg=del',
                onCellSelect: function(ids,colid) {
                $('#list_d').show();
                jQuery('#list_d').jqGrid('setGridParam',{url:'./ajax/tasetting_effective.php?id='+ids,page:1});
                jQuery('#list_d').jqGrid('setCaption','TA Setting Detail :').trigger('reloadGrid');
                    //alert(ids+colid+content+jQuery(this).getCell(ids,colid));
                    if(colid == 5){
                        var gr=jQuery(this).jqGrid('getGridParam','selrow');
                        if(gr !=null ){ 
                            jQuery(this).jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
                        }
                    }


//                       alert(ids);    
                }
            });
                 jQuery('#list_d').jqGrid({

                url:'./ajax/tasetting_effective.php?id={$_GET[id]}',
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Effective Date','Amount'],
                colModel :[
                {name:'id', index:'id', width:25,sortable:false},
                {name:'effective_date', index:'effective_date', width:50, align:'left',sortable:false},
                {name:'amount', index:'amount', width:70, align:'left',sorttype:'text'},
                ],
                pager: '#pager',
                rowNum:8,
                    width:500,
                    height:175,
                    hidegrid:false,
                rowList:[10,20,30],
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'TA Setting Detail',
            });
            }); 
            </script>
			<div id='heading'><h3 style='float:left'>View TA Settings</h3><a href='?page=addtasetting'><div id='linking'>Add TA Settings</div></a><br/><br/></div>
            <table id='list'></table> 
            <div id='pager'></div> 
            ";
$str.="<table id='list_d'></table>";
    //echo $str."dfjsdjfksdfjs";
    //die();
    Page::$content = $str;
}

function addTASetting() {
    global $user;
    define("REQ_LEVEL", 9);
    if ($user->level < REQ_LEVEL) {
        Page::$content = UN_AUTH;
        return;
    }
    global $form, $ctrl, $database, $page;
    $str;

    if ($_SESSION['addtaSuccess']) {
        unset($_SESSION['addtaSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
    }


    if (isset($_POST['add'])) {
        //print_r($_POST);
        //die();
        $retval = $ctrl->addTASetting($_POST);


        if ($retval) {
            $_SESSION['addtaSuccess'] = true;
            header("Location:" . $ctrl->referrer);
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {


        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $userList = $database->getMRList();

        $str.="<div id= 'heading'>
        <h3 style='float:left'>Add TA Settings</h3><a href='?page=viewtasetting'><div id='linking'>Manage TA Settings</div></a><br/><br/></div>
        <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Username :</div><div class='act_obj'><select name='user_id' style='width:162px'> ";

        foreach ($userList as $key) {
            $selected = "";
            if ($key['id'] == $form->value('user_id'))
                $selected = "selected";
            $str.= "<option value='{$key['id']}' {$selected}>{$key['username']}</option>";
        }

        $str.= "</select></div></div>
                    <div class='form_row'><div class='label'>Amount :</div><div class='act_obj'><input size='20' type='text' name='amount' value=\"{$form->value('amount')}\" /></div><div class='err_msg'>{$form->error('amount')}</div></div>
                    <div class='form_row'><div class='label'>Effective Date :</div><div class='act_obj' ><input size='20' type='text' name='effective_date' id='datepicker' size='10' value=\"{$form->value('effective_date')}\" /></div><div class='err_msg'>{$form->error('effective_date')}</div></div>
                    <div><input type='hidden' value='1' name='add'></div>
                    <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type='submit' value='Add' name='submit'></div>
                    </form></div>
                    
            <script type='text/javascript'>
            $(document).ready(function(){
                                        $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                                        });
            </script>";

        Page::$content = $str;

        //return $str;
    }
}

function editTASetting() {

    global $form, $ctrl, $database, $page;
    $str;

    if ($_SESSION['edittaSuccess']) {
        unset($_SESSION['edittaSuccess']);
        $str.= "<div class='notice'>Data Updated Successfully !!</div>";
    }


    if (isset($_POST['edit'])) {
        //print_r($_POST);
        //die();
        $retval = $ctrl->editTASetting($_POST);


        if ($retval) {
            $_SESSION['edittaSuccess'] = true;
            header("Location:" . $ctrl->referrer);
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {


        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $data = $database->getTASettingById($_GET['id']);
        $userList = $database->getUserList();


        $form->setValue('user_id', $data['user_id']);
        $form->setValue('amount', $data['amount']);
        $form->setValue('effective_date', $data['effective_date']);
        $form->setValue('id', $data['id']);
        //echo $form->value('user_id');
        $str.="<div id='heading'><h3>Edit TA Settings</h3></div><div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Username :</div><div class='act_obj'> <select name='user_id' style='width:180px'> ";
        //print_r($userList);
        foreach ($userList as $key) {
            $selected = "";
            if ($key['id'] == $form->value('user_id'))
                $selected = "selected";
            $str.= "<option value='{$key['id']}' {$selected}>{$key['username']}</option>";
        }

        $str.= "</select></div></div>
                    <div class='form_row'><div class='label'>Amount :</div><div class='act_obj'> <input size='31' type='text' name='amount' value=\"{$form->value('amount')}\" /></div><div class='err_msg'>{$form->error('amount')}</div></div>
                    <div class='form_row'><div class='label'>Effective Date :</div><div class='act_obj'> <input size='31' type='text' name='effective_date' id='datepicker'  value=\"{$form->value('effective_date')}\" /></div><div class='err_msg'>{$form->error('effective_date')}</div></div>
                    <div><input type='hidden' value=\"{$form->value('id')}\" name='id'></div>
                    <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type='hidden' value='1' name='edit'></div>
                    <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type='submit' value='Edit' name='submit'></div>
                
                    </form></div>
                    
            <script type='text/javascript'>
            $(document).ready(function(){
                                        $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                                        });
            </script>";

        Page::$content = $str;

        //return $str;
    }
}
?>
