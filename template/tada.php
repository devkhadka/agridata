<?php

    function viewTada(){
        //global $database;

        //$data = $database->viewTada();
        //print_r($data);
        //die();
        global $user;
        define("REQ_LEVEL",2);
        if($user->level < REQ_LEVEL){
            Page::$content=UN_AUTH;
         return; 
        }

       $_SESSION['uid']= $user->userid; 
        $url = "./ajax/tada.php";
        $baseLinkUrl = "agricare.php";
        $addParamE = "&page=edittada";
        $addParamD = "&page=deltada";
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

            jQuery('#next').attr('disabled',true); 
            $('#prev').click(function(){
                interval++;
                var limit = new Array();
				limit = getLimit(interval);
				jQuery('#datepicker').val(limit[0]);
				jQuery('#datepicker_to').val(limit[1]);
                
                jQuery('#next').attr('disabled',false);
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/tada.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1});                 
                jQuery('#list').jqGrid('setCaption','TA / DA List:').trigger('reloadGrid'); 
            });

			$('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/tada.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1}); 
                jQuery('#list').jqGrid('setCaption','TA / DA List:').trigger('reloadGrid');

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
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/tada.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1}); 
                jQuery('#list').jqGrid('setCaption','TA / DA List:').trigger('reloadGrid'); 
            });

			var limit = new Array();
			limit = getLimit(interval);
			jQuery('#datepicker').val(limit[0]);
			jQuery('#datepicker_to').val(limit[1]);
			
            jQuery('#list').jqGrid({
                url:'./ajax/tada.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Date', 'Place','TA (km)','DA (Rs.)','Others (Rs.)','Remark','-','-',''],
                colModel :[ 
                {name:'id', index:'id', width:25,sortable:false}, 
                {name:'visited_date', index:'visited_date', width:60, align:'left',sorttype:'text'}, 
                {name:'visit_place', index:'visit_place', width:80, align:'left',sortable:false}, 
                {name:'distance', index:'distance', width:35, align:'left',sortable:false}, 
                {name:'da', index:'da', width:40, align:'left',sortable:false}, 
                {name:'other', index:'other', width:50, align:'center',sortable:false}, 
                {name:'remark', index:'remark', width:120, align:'left',sortable:false}, 
                {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}}, 
                {name:'b', index:'b', width:20, align:'center', sortable:false}, 
                {name:'dummy', index:'dummy',hidden:true}
                ],
                pager: '#pager',
                rowNum:10,
                    width:650,
                    height:220,
                    hidegrid:false,
                rowList:[10,20,30],
                sortname: 'visited_date',
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'TA / DA List',
                editurl:'./ajax/tada.php?msg=del',
                onCellSelect: function(ids,colid) {
                    if(colid == 8 && jQuery(this).getCell(ids,colid+1)==1){
                        //alert(ids+'--->'+colid+'--->'+jQuery(this).getCell(ids,colid+1));
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
            <div id='pager'></div>";

            //echo $str."dfjsdjfksdfjs";
            //die();
            Page::$content = $str;

    }


    function addTada(){

        global $form,$ctrl,$database,$user;
        define("REQ_LEVEL",2);
        if($user->level < REQ_LEVEL) return UN_AUTH;
        $str;
        //echo "at tada";
        if(isset($_SESSION['addTadaSuccess'])){
            unset($_SESSION['addTadaSuccess']);
            $str.= "<div class='notice'>Data Entered Successfully !!</div>";
            //$str.="Data Entered Successfully !!";
        }
        
        
        if(isset($_POST['add'])){

            $args = array('visited_date'=>$_POST['visited_date'],'visit_place'=>$_POST['visit_place'],'distance'=>$_POST['distance'],'da'=>$_POST['da'],'other'=>$_POST['other'],'remark'=>$_POST['remark']);
            //print_r($args);
            //die();
            $retval = $ctrl->addTada($args);

            if($retval){
                $_SESSION['addTadaSuccess'] = true;
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
            $str .="<div id='heading'><h3>Add TA/DA<h3></div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Visit Date :</div><div class='act_obj'> <input type='text' size='10'  name='visited_date' id='datepicker' value=\"{$form->value('visited_date')}\" /></div><div class='err_msg'>{$form->error('visited_date')}</div></div>
                <div class='form_row'><div class='label'>Visit Place :</div><div class='act_obj'> <input type='text' name='visit_place' value=\"{$form->value('visit_place')}\" /></div><div class='err_msg'>{$form->error('visit_place')}</div></div>
                <div class='form_row'><div class='label'>Distance Travel :</div><div class='act_obj'> <input type='text' size='5' name='distance' value=\"{$form->value('distance')}\" /></div><div class='err_msg'>{$form->error('distance')}</div></div>
                <div class='form_row'><div class='label'>Daily allowance :</div><div class='act_obj'> <input type='text' size='5' name='da' value=\"{$form->value('da')}\" /></div><div class='err_msg'>{$form->error('da')}</div></div>
                <div class='form_row'><div class='label'>Other :</div><div class='act_obj'> <input type='text' size='10' name='other' value=\"{$form->value('other')}\" /></div><div class='err_msg'>{$form->error('other')}</div></div>
                <div class='form_row'><div class='label'>Remarks :</div><div class='act_obj'> <textarea rows='4' cols='20' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                <div><input type='hidden' name='add'></div>
                <div><input type='submit' name='submit' value='Add'></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                                            $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                                            });
                </script>";

        //}
        
            return $str;
        }
    }

    function editTada(){

        global $form,$ctrl,$database;
        $str;
        
        /*echo "at tada";
        if(isset($_SESSION['edittadaSuccess'])){
            unset($_SESSION['edittadaSuccess']);
            $str.= "<div class='notice'>Data Entered Successfully !!</div>";
            $str.="Data Updated Successfully !!";
        }*/
        
        
        if(isset($_POST['edit'])){

            $args = array('visited_date'=>$_POST['visited_date'],'visit_place'=>$_POST['visit_place'],'distance'=>$_POST['distance'],'da'=>$_POST['da'],'other'=>$_POST['other'],'remark'=>$_POST['remark'],'id'=>$_POST['id']);
            //print_r($args);
            //die();
            $retval = $ctrl->editTada($args);

            if($retval){
                header("Location:agricare.php?page=viewtada");				
            }
            else{
                $_SESSION['value_array'] = $_POST;
                $_SESSION['error_array'] = $form->getErrorArray();
                header("Location:".$ctrl->referrer);				
            }
        } else {

            Page::$jslink=array('js/ui.core.js','js/ui.datepicker.js');
            Page::$csslink=array('css/ui.all.css');
            $data = $database->getTadaById($_GET['id']);

            //print_r($data);
            //die();
            
            if(time()-strtotime($data['created_date']) > 43200)
                return "<div class='notice'>You can not edit this data because your time limit exceed 12 hr ask admin to edit it.</div>";

            $form->setValue('visited_date',$data['visited_date']);            
            $form->setValue('visit_place',$data['visit_place']);          
            $form->setValue('distance',$data['distance']);
            $form->setValue('da',$data['da']);          
            $form->setValue('other',$data['other']);
            $form->setValue('remark',$data['remark']);

            $str .="<div id ='heading'> <h3>Edit TA/DA </h3></div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Visit Date :</div><div class='act_obj'> <input type='text' size='10'  name='visited_date' id='datepicker' value=\"{$form->value('visited_date')}\" /></div><div class='err_msg'>{$form->error('visited_date')}</div></div>
                <div class='form_row'><div class='label'>Visit Place :</div><div class='act_obj'> <input type='text' name='visit_place' value=\"{$form->value('visit_place')}\" /></div><div class='err_msg'>{$form->error('visit_place')}</div></div>
                <div class='form_row'><div class='label'>Distance Travel :</div><div class='act_obj'> <input type='text' size='5' name='distance' value=\"{$form->value('distance')}\" /></div><div class='err_msg'>{$form->error('distance')}</div></div>
                <div class='form_row'><div class='label'>Daily allowance :</div><div class='act_obj'> <input type='text' size='5' name='da' value=\"{$form->value('da')}\" /></div><div class='err_msg'>{$form->error('da')}</div></div>
                <div class='form_row'><div class='label'>Other :</div><div class='act_obj'> <input type='text' size='10' name='other' value=\"{$form->value('other')}\" /></div><div class='err_msg'>{$form->error('other')}</div></div>
                <div class='form_row'><div class='label'>Remarks :</div><div class='act_obj'> <textarea rows='4' cols='20' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='hidden' name='edit'></div>
                <div><input type='submit' name='submit' value='Edit'></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                        $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                        });

                </script>";

        //}
        
            return $str;
        }
    }
    function mviewTada(){

        global $database;
        //$database->managerViewTada();  
      
        $url = "./ajax/mtada.php";
        $baseLinkUrl = "agricare.php";
        //$addParamE = "&page=edittada";
        //$addParamD = "&page=deltada";
        //$idName = "id";

        $userlist = $database->getUserList();
        $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/jquery.chainedSelects.js'></script>            
            <script src='./js/mviewtada.js'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <div><select name='user' id='user'><option value='0' selected>----select-----</option>";
            foreach($userlist as $key){
                $str .= "<option value='{$key['id']}'>{$key['username']}</option>";
            }
            
        $str .="</select></div>
        <div><input type='submit' value='<< Previous' name='prev' id='prev'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next'></div>

            <table id='list'></table> 
            <div id='pager'></div>";
            
            Page::$content = $str;

    }
?>
