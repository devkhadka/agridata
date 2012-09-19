<?php
function viewParty(){
    global $user;
    define("REQ_LEVEL",9);
    if($user->level < REQ_LEVEL){
        Page::$content=UN_AUTH;
        return; 
    }
    $url = "./ajax/party.php";
    $baseLinkUrl = "agricare.php";
    $addParamE = "&page=editparty";
    $addParamD = "&page=delparty";
    $idName = "id";

    $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
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
colNames:['SN','Name', 'M.R.','Address','Phone', '-','-'],
colModel :[ 
{name:'id_profile', index:'id_profile', width:25,sortable:false}, 
{name:'name', index:'name', width:80, sorttype:'text'}, 
{name:'user', index:'user', width:50, align:'left',sorttype:'float'}, 
{name:'address', index:'address', width:80, sorttype:'text'}, 
{name:'phone', index:'phone', width:50, align:'right',sorttype:'float'}, 
{name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}}, 
{name:'b', index:'b', width:20, align:'center', sortable:false} 
],
pager: '#pager',
rowNum:8,
width:650,
height:250,
hidegrid:false,
rowList:[10,20,30],
sortname: 'name',
sortorder: '',
    viewrecords: true,
    imgpath: '',
    caption: 'Party List',
    editurl:'./ajax/party.php?msg=del',
    onCellSelect: function(ids,colid) {
        if(colid == 6){
            var gr=jQuery(this).jqGrid('getGridParam','selrow');
            if(gr !=null ){ 
                jQuery(this).jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
            }
        }
    }
}); 
}); 
</script>
<table id='list'></table> 
<div id='pager'></div> 
";

//echo $str."dfjsdjfksdfjs";
//die();
Page::$content = $str;
}

function addParty(){    

    global $form,$ctrl,$database,$user;
    $str;
    define("REQ_LEVEL",9);
    if($user->level < REQ_LEVEL) return UN_AUTH;
    if(isset($_POST['add'])){
        $args = array("name"=>$_POST['name'],"address"=>$_POST['address'],"phone"=>$_POST['phone'] , "MR_id"=>$_POST["MR_id"]);
        $retval = $ctrl->addParty($args);

        if($retval){
            $str.= "<div class='notice'><font size=\"2\" color=\"#00ff00\">{$_POST['username']}  Data Entered Sucessfully !! </font></div>";
        }
        else{
            if($_SESSION['inp_err']){
                $form->setValueArray($_POST);
                $str.="<div class='notice'><font size=\"2\" color=\"#ff0000\">Input error - ".$form->num_errors." error(s) found</font></div>";
                unset($_SESSION['inp_err']);
            }else{
                $str.= "<div class='notice'> <font size='2' color='#ff0000'>Data couldnot be Entered in Database !!</font> </div>";
            }
        }
    }  
    $MRList = $database->getMRList();
    $str .="<div id='heading'><h3>Add Party</h3></div>
        <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
        <div class='form_row'><div class='label'>Name :</div><div class='act_obj'> <input type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
        <div class='form_row'><div class='label'>Address :</div><div class='act_obj'> <input type='text' name='address' value=\"{$form->value('address')}\" /></div><div class='err_msg'>{$form->error('address')}</div></div>
        <div class='form_row'><div class='label'>Phone :</div><div class='act_obj'> <input type='text' name='phone' value=\"{$form->value('phone')}\" /></div><div class='err_msg'>{$form->error('address')}</div></div>";
    $str.=" <div class='form_row'><div class='label'>Marketing Representative:</div><div class='act_obj'> <select name='MR_id'> ";

    foreach($MRList as $MR){
        $str.= "<option value='{$MR['id']}'>{$MR['username']}</option>";
    }

    $str.="</select></div></div>";
    $str.="<div><input type='hidden' name='add'></div>
        <div><input type='submit' name='submit' value='Add'></div>
        </form></div>";
    
    return $str;


}   

function editParty(){
    global $form,$database,$user,$ctrl;
    define("REQ_LEVEL",9);
    if($user->level < REQ_LEVEL) return UN_AUTH;

    $str;

    if(isset($_SESSION['editpartySuccess'])){
        unset($_SESSION['editpartySuccess']);
        $str.= "<div class='notice'>Data Updated Successfully !!</div>";
    }
    if(isset($_SESSION['editpartyFailed'])){
        unset($_SESSION['editpartyFailed']);
        $str.= "<div class='notice'><font size='2' color='#ff0000'>Input are incorrect, Please check it !!</font></div>";
    }

    if(isset($_POST['edit'])){

        $retval = $ctrl->editParty($_REQUEST);

        if($retval){
            $_SESSION['editpartySuccess'] = true;
            header("Location:".$ctrl->referrer);
        }
        else{
            $_SESSION['value_array'] = $_REQUEST;
            $_SESSION['error_array'] = $form->getErrorArray();
            $_SESSION['editpartyFailed'] = true;
            header("Location:".$ctrl->referrer);
        }


    } else {
        $data = $database->getPartyById($_GET['id']);
        $form->setValue('name',$data['name']);
        $form->setValue('address',$data['address']);
        $form->setValue('phone',$data['phone']);
        $form->setValue('MR_id',$data['user_id']);
        $form->setValue('party_id',$data['party_id']);
        $form->setValue('profile_id',$data['profile_id']);
        $form->setValue('party_user_relation_id',$data['party_user_relation_id']);
        $form->setValue('address_id',$data['address_id']);
        $form->setValue('phone_id',$data['phone_id']);
        $MRList = $database->getMRList();
        $str .="<div id='heading'><h3>Edit Party</h3></div>
            <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
            <div class='form_row'><div class='label'>Name :</div><div class='act_obj'> <input type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
            <div class='form_row'><div class='label'>Address :</div><div class='act_obj'> <input type='text' name='address' value=\"{$form->value('address')}\" /></div><div class='err_msg'>{$form->error('address')}</div></div>
            <div class='form_row'><div class='label'>Phone :</div><div class='act_obj'> <input type='text' name='phone' value=\"{$form->value('phone')}\" /></div><div class='err_msg'>{$form->error('address')}</div></div>";
        $str.=" <div class='form_row'><div class='label'>Marketing Representative:</div><div class='act_obj'> <select name='MR_id'> ";
        $selected = "";
        foreach($MRList as $MR){
            if($MR['id']==$form->value('MR_id'))
                $selected="selected";
            else
                $selected="";
            $str.= "<option value='{$MR['id']}' {$selected}>{$MR['username']}</option>";
        }
           $str.= "</select></div></div>";
        $str.="
            <div><input type='hidden' name='edit'>
            <input type='hidden' name='party_id' value='{$form->value('party_id')}'>
            <input type='hidden' name='profile_id' value='{$form->value('profile_id')}'>
            <input type='hidden' name='party_user_relation_id' value='{$form->value('party_user_relation_id')}'>
            <input type='hidden' name='address_id' value='{$form->value('address_id')}'>
            <input type='hidden' name='phone_id' value='{$form->value('phone_id')}'>
            </div>
            <div><input type='submit' name='submit' value='Edit'></div>
            </form></div>";
            return $str;
    }
}    
?>
