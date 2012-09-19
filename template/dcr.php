<?php
    
    function viewDcr(){

        global $user;
        define("REQ_LEVEL",2);
        if($user->level < REQ_LEVEL){
            Page::$content=UN_AUTH;
         return; 
        }
        global $database;
        $_SESSION['userid']= $user->userid;
        //echo $_SESSION['userid'];
		
        //$data = $database->viewDcr();
        //print_r($data);
        //die();

        $url = "./ajax/dcr.php";
        $baseLinkUrl = "agricare.php";
        $addParamE = "&page=editdcr";
        $addParamD = "&page=deldcr";
        $idName = "id";

        $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascriptk'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <script type='text/javascript'>
            jQuery(document).ready(function(){

            var interval = 0;

            jQuery('#next').attr('disabled',true); 
            $('#prev').click(function(){
                interval++;
                 
				var limit = new Array();
				limit = getLimit(interval);
				jQuery('#datepicker').val(limit[0]);
				jQuery('#datepicker_to').val(limit[1]);
                jQuery('#next').attr('disabled',false); 
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/dcr.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1}); 
                jQuery('#list').jqGrid('setCaption','DCR List').trigger('reloadGrid'); 
            });

			$('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/dcr.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1}); 
                jQuery('#list').jqGrid('setCaption','DCR List:').trigger('reloadGrid');

            });

            $('#next').click(function(){
                if(interval > -1){
                    interval--;
                    var limit = new Array();
					limit = getLimit(interval);
					jQuery('#datepicker').val(limit[0]);
					jQuery('#datepicker_to').val(limit[1]);
                    if(interval == 0)
                        jQuery('#next').attr('disabled',true); 
                }
                          
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/dcr.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1}); 
                jQuery('#list').jqGrid('setCaption','DCR List').trigger('reloadGrid'); 
            });

			var limit = new Array();
			limit = getLimit(interval);
			jQuery('#datepicker').val(limit[0]);
			jQuery('#datepicker_to').val(limit[1]);

            jQuery('#list').jqGrid({
                url:'./ajax/dcr.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Date', 'Name of Customer','Title','Remark','-','-'],
                colModel :[ 
                {name:'id', index:'id', width:15,sortable:false}, 
                {name:'collected_date', index:'collected_date', width:60, align:'left',sorttype:'text'}, 
                {name:'name', index:'name', width:120, align:'left',sorttype:'text'}, 
                {name:'title', index:'title', width:50, align:'left',sortable:false}, 
                {name:'remark', index:'remark', width:270, align:'left',sortable:false}, 
                {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}}, 
                {name:'b', index:'b', width:20, align:'center', sortable:false} 
                ],
                pager: '#pager',
                rowNum:10,
                    width:650,
                    height:220,
                    hidegrid:false,
                rowList:[10,20,30],
                sortname: 'collected_date',
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'DCR List',
                editurl:'./ajax/dcr.php?msg=del',
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
            <div><input type='submit' value='<< Previous' name='prev' id='prev'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next'></div>           
            <table id='list'></table> 
            <div id='pager'></div> 
            ";

            Page::$content = $str;

    }


    function addDcr(){
        global $form,$ctrl,$database,$user;
        define("REQ_LEVEL",2);
        if($user->level < REQ_LEVEL) return UN_AUTH;
        $str;

        if(isset($_SESSION['addDcrSuccess'])){
            unset($_SESSION['addDcrSuccess']);
            $str.= "<div class='notice'>Data Entered Successfully !!</div>";
            //$str.="Data Entered Successfully !!";
        }

        if(isset($_POST['add'])){

            //print_r($_POST);
            //die();
            $retval = $ctrl->addDcr($_POST);

            if($retval){
                $_SESSION['addDcrSuccess'] = true;
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
            $title = $database->getTitle();

            $str .="<div id ='heading'><h3>Add DCR</h3></div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Date :</div><div class='act_obj'><input type='text' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" size='10' /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='form_row'><div class='label'>Name of customer :</div><div class='act_obj'> <input type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
                <div class='form_row'><div class ='label'>Profession :{$form->error('customer_title_id')} </div> <div class='act_obj'>";
            foreach($title as $key){
                $checked = "";                
                if($key[id] == $form->value('customer_title_id'))
                    $checked = "checked";
                $str .= "<div><input type='radio' value='{$key['id']}' name='customer_title_id' {$checked}>&nbsp;&nbsp;{$key['title']} </div>";
            }
            
            $str .="</div></div><div class='form_row'><div class='label'>Remarks :</div><div class='act_obj'> <textarea rows='4' cols='59' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                <div><input type='hidden' name='add'></div>
                <div><input type='submit' value='Add' name='submit'></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";

            return $str;
        }

    }

    function editDcr(){
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

            //print_r($_POST);
            //echo "sala";
            //die();
            $retval = $ctrl->editDcr($_POST);

            if($retval){
                //$_SESSION['editDcrSuccess'] = true;
                header("Location:agricare.php?page=viewdcr");				
            }
            else{
                $_SESSION['value_array'] = $_POST;
                $_SESSION['error_array'] = $form->getErrorArray();
                header("Location:".$ctrl->referrer);				
            }
        } else {
            Page::$jslink=array('js/ui.core.js','js/ui.datepicker.js');
            Page::$csslink=array('css/ui.all.css');
            $title = $database->getTitle();

            $data = $database->getDcrById($_GET['id']);
            //print_r($data);
            //die();

            $form->setValue('collected_date',$data['collected_date']);            
            $form->setValue('name',$data['name']);          
            $form->setValue('customer_title_id',$data['customer_title_id']);
            $form->setValue('remark',$data['remark']);          

            $str .="<div id ='heading'><h3>Edit DCR</h3></div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Date :</div><div class='act_obj'> <input type='text' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" /></div><div class='err_msg'>'{$form->error('collected_date')}</div></div>
                <div class='form_row'><div class='label'>Name of customer :</div><div class='act_obj'> <input type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
                <div class='form_row'>Profession :{$form->error('customer_title_id')} </div>";
            foreach($title as $key){
                $checked = "";                
                if($key[id] == $form->value('customer_title_id'))
                    $checked = "checked";
                $str .= "<div><input type='radio' value='{$key['id']}' name='customer_title_id' {$checked}>&nbsp;&nbsp;{$key['title']}</div>";
            }
            
            $str .="<div class='form_row'><div class='label'>Remarks :</div><div class='act_obj'> <textarea rows='4' cols='20' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='hidden' name='edit'></div>
                <div><input type='submit' value='Edit' name='submit'></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";

            return $str;
        }
    }

    function mViewDcr(){

        global $user;
        define("REQ_LEVEL",4);
        if($user->level < REQ_LEVEL){
            Page::$content=UN_AUTH;
         return; 
        }
        global $database;

        //$data = $database->viewDcr();
        //print_r($data);
        //die();

        $url = "./ajax/mdcr.php";
        $baseLinkUrl = "agricare.php";
        $addParamE = "&page=editdcr";
        $addParamD = "&page=deldcr";
        $idName = "id";

        //$headquater = $database->getHeadquaterList();
        
        $userlist = $database->getUserList();
        
        $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.all.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/jquery.chainedSelects.js'></script>            
            <script src='./js/mviewdcr.js'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <div id ='heading'> <h3> View DCR</h3></div>     
            <div>Select M.R : <select name='user' id='user'><option value='0' selected>----select-----</option>";
            foreach($userlist as $key){
                $str .= "<option value='{$key['id']}'>{$key['username']}</option>";
            }
            
        $str .="</select></div>    
            <div><input type='submit' value='<< Previous' name='prev' id='prev'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next'></div>          
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
