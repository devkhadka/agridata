<?php

    function viewPartyStock(){

        global $user;
        define("REQ_LEVEL",2);
        define("REQ_LEVEL2",4);
        if($user->level!= REQ_LEVEL && $user->level!=REQ_LEVEL2) {
            Page::$content=UN_AUTH;
         return; 
        }
        $_SESSION['userid']= $user->userid;
        $url = "./ajax/partystock.php";
        $baseLinkUrl = "agricare.php";
        $addParamE = "&page=editpartystock";
        $addParamD = "&page=delpartystock";
        $idName = "id";
 $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <script type='text/javascript'>
            jQuery(document).ready(function(){

        var interval = 0;
        var ids;

            $('#prev').click(function(){
                interval++;
                var limit = new Array();
				limit = getMonthLimit(interval);
				jQuery('#datepicker').val(limit[0]);
				jQuery('#datepicker_to').val(limit[1]);
				
                //alert(interval);            
                jQuery('#next').attr('disabled',false); 
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/partystock.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],page:1}); 
                jQuery('#list').jqGrid('setCaption','Party Stock List:').trigger('reloadGrid'); 
            });
            
            $('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/partystock.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1}); 
                jQuery('#list').jqGrid('setCaption','Party Stock List:').trigger('reloadGrid');

            });

            $('#next').click(function(){
                if(interval > -1){
                    interval--;
                    var limit = new Array();
					limit = getMonthLimit(interval);
					jQuery('#datepicker').val(limit[0]);
					jQuery('#datepicker_to').val(limit[1]);
					
                    if(interval == 1)
                        jQuery('#next').attr('disabled',true); 
                }
                          
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/partystock.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],page:1}); 
                jQuery('#list').jqGrid('setCaption','Party Stock List:').trigger('reloadGrid'); 
            });
            
            var limit = new Array();
			limit = getMonthLimit(interval);
			jQuery('#datepicker').val(limit[0]);
			jQuery('#datepicker_to').val(limit[1]);
            
            jQuery('#list').jqGrid({
                url:'./ajax/partystock.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Date', 'Party Name','Product','No. of Case','Indivisual','-','-',''],
                colModel :[ 
                {name:'id', index:'id', width:25,sortable:false}, 
                {name:'collected_date', index:'collected_date', width:60, align:'left',sorttype:'text'}, 
                {name:'party_name', index:'party_name', width:150, align:'left',sortable:false}, 
                {name:'name', index:'name', width:100, align:'left',sortable:false}, 
                {name:'no_of_case', index:'no_of_case', width:50, align:'left',sortable:false}, 
                {name:'indivisual', index:'indivisual', width:50, align:'left',sortable:false}, 
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
                caption: 'Party Stock List',
                editurl:'./ajax/partystock.php?msg=del',
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
            <div><input type='submit' value='<< Previous' name='prev' id='prev'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next'></div>
            <table id='list'></table> 
            <div id='pager'></div>";

            Page::$content = $str;

    }


    function addPartyStock(){
        
        global $form,$ctrl,$database,$user;
        define("REQ_LEVEL",2);
        define("REQ_LEVEL2",4);
        if($user->level!= REQ_LEVEL && $user->level!=REQ_LEVEL2) return UN_AUTH;
        
        $str;

        if(isset($_SESSION['addPartyStockSuccess'])){
            unset($_SESSION['addPartyStockSuccess']);
            $str.= "<div class='notice'>Data Entered Successfully !!</div>";
        }

        if(isset($_POST['add'])){

            $retval = $ctrl->addPartyStock($_POST);

            if($retval){
                $_SESSION['addPartyStockSuccess'] = true;
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
            $party = $database->getMyParty();

            $product = $database->getProduct();

            $str .="<div id='heading'><h3> Add Party Stock </h3> </div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Collected date :</div><div class='act_obj'> <input type='text' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" size='10' /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='form_row'><div class='label'>Party :</div><div class='act_obj'> <select name='party_id'>";
            foreach($party as $key){

                $selected = "";
                if($key['id'] == $form->value('party_id'))
                    $selected = "selected";
                $str .="<option value='{$key['id']}' {$selected}>{$key['name']}</option>"; 
            }

                
            $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>
                <div class='form_row'>&nbsp;</div>
                <div class='form_row'>
                    <table border='1' width='80%'>
                    <th>sn.</th><th>Product</th><th>No. of case</th><th>Indivisual</th>";
                    $count =0;
                    $no_of_case_error = "";
                    $indv_error = "";

                    foreach($product as $key){
                        $count++;
                        $no_of_case_err = "";
                        $indv_err = "";

                        if($form->error('no_of_case'.$count)!=null)
                            $no_of_case_err = "<font color='#FF0000'>*</font>";
                        if($form->error('indv'.$count) != null)
                            $indv_err = "<font color='#FF0000'>*</font>";

                        $str .= "<tr>
                                    <td>{$count}<input type='hidden' name='pid{$count}' value='{$key['id']}' /></td>
                                    <td>{$key['name']} ({$key['quantity']} {$key['unit_name']})</td>
                                    <td><input type='text' name='no_of_case{$count}' size='5' value='{$form->value('no_of_case'.$count)}' />{$no_of_case_err}</td>
                                    <td><input type='text' name='indv{$count}' size='5' value='{$form->value('indv'.$count)}' />{$indv_err}</td>
                                </tr>";
                    }
            $str .="</table> 
                </div>
                <div><input type='hidden' name='add'><input type='hidden' name='count' value='{$count}' /></div>
                <div>&nbsp;</div>
                <div><input type='submit' value='Add' name='submit'></div>      
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

    function editPartyStock(){
        
        global $form,$ctrl,$database,$user;
        define("REQ_LEVEL",2);
        define("REQ_LEVEL2",4);
        if($user->level!= REQ_LEVEL && $user->level!=REQ_LEVEL2) return UN_AUTH;
        $str;
        /*
        if(isset($_SESSION['editPartyStockSuccess'])){
            unset($_SESSON['editPartyStockSuccess']);
            $str.= "<div class='notice'>Data Update Successfully !!</div>";
        }*/

        if(isset($_POST['edit'])){

            //print_r($_POST);
            //die();
            $retval = $ctrl->editPartyStock($_POST);

            if($retval){
                //$_SESSION['editPartyStockSuccess'] = true;
                header("Location:agricare.php?page=viewpartystock");				
            }
            else{
                $_SESSION['value_array'] = $_POST;
                $_SESSION['error_array'] = $form->getErrorArray();
                header("Location:".$ctrl->referrer);				
            }
        } else {

            Page::$jslink=array('js/ui.core.js','js/ui.datepicker.js');
            Page::$csslink=array('css/ui.all.css');
            $party = $database->getParty();

            $product = $database->getProduct();
            $data = $database->getPartyStockById($_GET['id']);

            if(time()-strtotime($data['created_date']) > 43200)
                return "<div class='notice'>You can not edit this data because your time limit exceed 12 hr ask admin to edit it.</div>";
            $form->setValue('collected_date',$data['collected_date']);            
            $form->setValue('party_id',$data['party_id']);          
            $form->setValue('product_id',$data['product_id']);
            $form->setValue('no_of_case',$data['no_of_case']);          
			$form->setValue('indivisual',$data['indivisual']);
            //print_r($data);
            //die();

            $str .="<div id ='heading'><h3> Edit Party Stock</h3> </div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Collected date :</div><div class='act_obj'> <input type='text' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" size='10' /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='form_row'><div class='label'>Party :</div><div class='act_obj'> <select name='party_id'>";
            foreach($party as $key){

                $selected = "";
                if($key['id'] == $form->value('party_id'))
                    $selected = "selected";
                $str .="<option value='{$key['id']}' {$selected}>{$key['name']}</option>"; 
            }

                
            $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>
                <div class='form_row'><div class='label'>Product :</div><div class='act_obj'> <select name='product_id'>";
            foreach($product as $key){
                $selected = "";
                if($key['id'] == $form->value('product_id'))
                    $selected = "selected";
                $str .= "<option value='{$key['id']}' {$selected}>{$key['name']} ({$key['quantity']} {$key['unit_name']})</option>";
            }            
            $str .="</select></div><div class='err_msg'>{$form->error('product_id')}</div></div>
                <div class='form_row'><div class='label'>No. of case :</div><div class='act_obj'> <input type='text' name='no_of_case' size='5' value=\"{$form->value('no_of_case')}\" /></div><div class='err_msg'>{$form->error('no_of_case')}</div></div>
                <div class='form_row'><div class='label'>Indivisual :</div><div class='act_obj'> <input type='text' name='indivisual' size='5' value=\"{$form->value('indivisual')}\" /></div><div class='err_msg'>{$form->error('indivisual')}</div></div>
                <div><input type='hidden' name='edit'></div>
                <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='submit' value='Edit' name='submit'></div>      
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


    function mViewPartyStock(){
        global $database,$user;
        define("REQ_LEVEL",MMR_LEVEL);
        define("REQ_LEVEL2",ADMIN_LEVEL);
        if($user->level!= REQ_LEVEL && $user->level!=REQ_LEVEL2){ 
            Page::$content=UN_AUTH;
         return; 
        }
        $usr = $database->getParty();

        $url = "./ajax/mpartystock.php";
        $baseLinkUrl = "agricare.php";
/*
        $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/jquery.chainedSelects.js'></script>            
            <script src='./js/mviewpartystock.js'></script>            
            <div><select name='headquater' id='headquater'><option value='0' selected>----select-----</option>";
            foreach($headquater as $key){
                $str .= "<option value='{$key['id']}'>{$key['name']}</option>";
            }
            
        $str .="</select></div><div><select name='party' id='party'></select></div>    
            <table id='list'></table> 
            <div id='pager'></div>";

            //echo $str."dfjsdjfksdfjs";
            //die();
            Page::$content = $str;
*/


        $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/jquery.chainedSelects.js'></script>            
            <script src='./js/mviewpartystock.js'></script>     
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>       
            <div id ='heading'> <h3> View Party Stock</h3></div><div>Party : <select name='party' id='party'><option value='0' selected>----select-----</option>";
            foreach($usr as $key){
                $str .= "<option value='{$key['id']}'>{$key['name']}</option>";
            }
            
        $str .="</select></div><div><input type='submit' value='<< Previous' name='prev' id='prev'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next'></div><div id='display'><table id='list'></table><div id='pager'></div></div>";

        Page::$content = $str;
    }

?>
