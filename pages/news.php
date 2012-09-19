<?php
function addNews(){
    global $form,$ctrl,$database,$user;
    define("REQ_LEVEL",9);
    if($user->level < REQ_LEVEL) return UN_AUTH;
    $str;

    if(isset($_SESSION['addNewsItem'])){
        unset($_SESSION['addNewsItem']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
        //$str.="Data Entered Successfully !!";
    }

    if(isset($_POST['add'])){

        //print_r($_POST);
        //die();
        $retval = $ctrl->addNews($_POST);

        if($retval){
            $_SESSION['addNewsItem'] = true;
            header("Location:".$ctrl->referrer);				
        }
        else{
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:".$ctrl->referrer);				
        }
    } else {
        Page::$jslink=array('js/ui.core.js','js/ui.datepicker.js');
        Page::$csslink=array('css/ui.all.css');

        $str .="<div id ='heading'>
        <h3 style='float:left'>Add News </h3><a href='?page=viewnews'><div id='linking'>Manage News</div></a><br/><br/></div>
            <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
            <div class='form_row'><div class='label'>Date :</div><div class='act_obj'> <input type='text' name='entered_date' id='datepicker'  size ='20' value=\"{$form->value('entered_date')}\" /></div><div class='err_msg'>{$form->error('entered_date')}</div></div>
            <div class='form_row'><div class='label'>Title :</div><div class='act_obj'> <input type='text' size ='40' name='title'   value=\"{$form->value('title')}\" /></div><div class='err_msg'>{$form->error('title')}</div></div>";

        $str .="<div class='form_row'><div class='label'>Body :</div><div class='act_obj'> <textarea rows='8' cols='44' name='body'>{$form->value('body')}</textarea></div><div class='err_msg'>{$form->error('body')}</div></div>
            <div><input type='hidden' name='add'></div>
            <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='submit' value='Add' name='submit'></div>
            </form></div>
            <script type='text/javascript'>
$(document).ready(function(){
    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
    });
                </script>";

            return $str;
}
}
function viewNews(){
        global $user;
        define("REQ_LEVEL",9);
        if($user->level < REQ_LEVEL){
            Page::$content=UN_AUTH;
         return; 
        }
        //global $database;
        //$str;

        //$data = $database->viewProduct();
        //print_r($data);
        $url = "./ajax/news.php";
        $baseLinkUrl = BASE_LINK_URL;
        $addParamE = "&page=editnews";
        $addParamD = "&page=delNews";
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
            colNames:['SN', 'Date','Title','Body','-','-'],
            colModel :[ 
        {name:'id', index:'id', width:15,sortable:false}, 
        {name:'date', index:'date', width:40, align:'left',sortable:true}, 
        {name:'title', index:'title', width:80, align:'left',sorttype:'text'}, 
        {name:'body', index:'body', width:120, align:'left',sortable:false}, 
        {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}}, 
        {name:'b', index:'b', width:20, align:'center', sortable:false} 
        ],
        pager: '#pager',
        rowNum:8,
        width:650,
        height:250,
        hidegrid:false,
        rowList:[10,20,30],
        sortname: 'date',
        sortorder: '',
        viewrecords: true,
        imgpath: '',
        caption: 'News List',
        editurl:'./ajax/news.php?msg=del',
        onCellSelect: function(ids,colid) {
            //alert(ids+colid+content+jQuery(this).getCell(ids,colid));
            if(colid == 5){
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
			<div id='heading'><h3 style='float:left'>View News</h3><a href='?page=addnews'><div id='linking'>Add News</div></a><br/><br/></div>
            <table id='list'></table> 
            <div id='pager'></div> 
            ";
            Page::$content = $str;


}
    function editNews(){
        global $database,$form,$ctrl,$page,$user;
        define("REQ_LEVEL",9);
        if($user->level < REQ_LEVEL) return UN_AUTH;
            $data = $database->getNewsById($_GET['id']);
            $str="<div id ='heading' ><h3>Edit News</h3></div>";
        if(isset($_POST['edit'])){
            $retval = $ctrl->editNews($_POST);

            if($retval){
                $str.= "<div class='notice'>Data Update Successfully !!</div>";
                $form->setValueArray(array());
                header('Location:'.BASE_LINK_URL.'?page=viewnews');
            }
            else{
                $form->setValueArray($_POST);
                if($form->num_errors>0){
                    $str.= "<div class='notice_err'>Input Error- {$form->num_errors} errors!!</div>";
                }else{
                    $str.= "<div class='notice_err'>Data Edit failed !!</div>";
                }
            }

        }else{

            $form->setValue('entered_date',$data['date']);            
            $form->setValue('title',$data['title']);          
            $form->setValue('body',$data['body']);
        }
        Page::$jslink=array('js/ui.core.js','js/ui.datepicker.js');
        Page::$csslink=array('css/ui.all.css');

        $str .="<div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
            <div class='form_row'><div class='label'>Date :</div><div class='act_obj'> <input type='text' name='entered_date' id='datepicker' size ='50' value=\"{$form->value('entered_date')}\" /></div><div class='err_msg'>{$form->error('entered_date')}</div></div>
            <div class='form_row'><div class='label'>Title :</div><div class='act_obj'> <input type='text' name='title' size ='50' value=\"{$form->value('title')}\" /></div><div class='err_msg'>{$form->error('title')}</div></div>";

        $str .="<div class='form_row'><div class='label'>Body :</div><div class='act_obj'> <textarea rows='6' cols='50' name='body'>{$form->value('body')}</textarea></div><div class='err_msg'>{$form->error('body')}</div></div>
            <div><input type='hidden' name='edit'></div>
        <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type='submit' value='Add' name='submit'></div>
            </form></div>
            <script type='text/javascript'>
$(document).ready(function(){
    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
    });
                </script>";

            return $str;
                return $str;
        }
?>
