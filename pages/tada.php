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
        $baseLinkUrl = BASE_LINK_URL;
        $addParamE = "&page=edittada";
        $addParamD = "&page=deltada";
        $idName = "id";
		
        $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
             <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
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
                colNames:['SN','Date','Created Date' , 'Place','TA (km)','DA (Rs.)','Others (Rs.)','Remark','Approved','-','-',''],
                colModel :[ 
                {name:'id', index:'id', width:25,sortable:false}, 
                {name:'visited_date', index:'visited_date', width:60, align:'left',sorttype:'text'},
                {name:'created_date', index:'created_date', width:60, align:'left',sorttype:'text'},
                {name:'visit_place', index:'visit_place', width:80, align:'left',sortable:false}, 
                {name:'distance', index:'distance', width:35, align:'left',sortable:false}, 
                {name:'da', index:'da', width:40, align:'left',sortable:false}, 
                {name:'other', index:'other', width:50, align:'center',sortable:false}, 
                {name:'remark', index:'remark', width:120, align:'left',sortable:false}, 
                {name:'approve', index:'approve', width:70, align:'center',sortable:false},
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
                    if(colid == 9 && jQuery(this).getCell(ids,colid+1)==1){
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
			<div id='heading'><h3 style='float:left'>View TADA</h3><a href='?page=addtada'><div id='linking'>Add TADA</div></a><br/><br/><br/></div>
            <div id='date_alignment'><input type='submit' value='<< Previous' name='prev' id='prev' class='buttonn'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go' class='buttonn'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next' class='buttonn'></div>
          
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
//            var_dump($_POST);
//            $args = array('visited_date'=>$_POST['visited_date'],'visit_place'=>$_POST['visit_place'],'distance'=>$_POST['distance'],'da'=>$_POST['da'],'other'=>$_POST['other'],'remark'=>$_POST['remark']);
            $retval = $ctrl->addTada($_POST);

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

            $initial = ( $form->value('formlength'))?$form->value('formlength'):7 ;
            Page::$jslink=array('js/ui.core.js','js/ui.datepicker.js');
            Page::$csslink=array('css/ui.all.css');

             $str.=<<<EOT
              <div id='heading'><h3 style='float:left'>Add TADA</h3><a href='?page=viewtada'><div id='linking'>Manage TADA</div></a><br/><br/><br/></div>
                <div id="sub-content"><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                        <table  id="formTable">
                            <tr align="center">
                                <td>
                                    S.N.
                                </td>
                                <td>
                                    Visited Date
                                </td>
                                <td>
                                    Visited Place
                                </td>
                                 <td>
                                    Distance Travel
                                </td>
                                <td>
                                    Daily Allowance
                                </td>
                                <td>
                                    Other
                                </td>
                                <td>
                                    Remarks
                                </td>
                            </tr>
EOT;


for ($i = 1; $i <= $initial; $i++) {
    $str.= <<<EOT
                                <tr>
                                       <td>
                                            $i
                                        </td>
                                        <td >
                                            <input type="text" class="datepicker" name="visited_date$i" id="visited_date$i" size="10" value="{$form->value("visited_date$i")}" />{$form->error("visited_date$i")}
                                        </td>
                                        <td>
                                             <input type="text" name="visit_place$i" id="visit_place$i" size="12" value="{$form->value("visit_place$i")}" />{$form->error("visit_place$i")}
                                        </td>
                                        <td >
                                             <input type="text" name="distance$i" id="distance$i" size="12" value="{$form->value("distance$i")}" />{$form->error("distance$i")}
                                             </td>
                                        <td >
                                             <input type="text" name="da$i" id="da$i" size="12" value="{$form->value("da$i")}" />{$form->error("da$i")}
                                       </td>
                                       <td >
                                             <input type="text" name="other$i" id="other$i" size="6" value="{$form->value("other$i")}" />{$form->error("other$i")}
                                       </td>
                                        <td >
                                             <textarea rows='2' cols='24' name='remark$i' id="remark$i" >{$form->value("remark$i")}</textarea>{$form->error("remark$i")}
                                        </td>
                                   </tr>
EOT;
}

$str.=<<<EOT
 </table>
                       <div id="submitdiv" style="float:right">
                        <input type="hidden" value="$initial"  id="formlength" name="formlength"/>
                         <input type="hidden" value="1"  id="add" name="add"/>
                        <input type="button" value="Add" onclick="addRow();" />
                        <input type="button" value="Remove" onclick="removeRow();" />
                        <input type="submit" value="Submit" name="submit" />
                        </div>

        </form>
        </div>
        <script language="Javascript" type="text/javascript">
            function addRow()
            {

                var tbl = document.getElementById('formTable');
                var lastRow = tbl.rows.length;
                var iteration = lastRow;
                var row = tbl.insertRow(lastRow);

                var cellSno = row.insertCell(0);
                var textNode = document.createTextNode(iteration);
                cellSno.appendChild(textNode);

                var cellDate = row.insertCell(1);
                var elDate = document.createElement('input');
                elDate.type = 'text';
                elDate.name = 'visited_date' + iteration;
                elDate.id = 'visited_date' + iteration;
                elDate.class="datepicker";
                elDate.size = 10;
                cellDate.appendChild(elDate);
                appDatePick();

                var cellPlace = row.insertCell(2);
                var elPlace = document.createElement('input');
                elPlace.type = 'text';
                elPlace.name = 'visit_place' + iteration;
                elPlace.id = 'visit_place' + iteration;
                elPlace.size = 12;
                cellPlace.appendChild(elPlace);

                var cellPlace = row.insertCell(3);
                var elPlace = document.createElement('input');
                elPlace.type = 'text';
                elPlace.name = 'distance' + iteration;
                elPlace.id = 'distance' + iteration;
                elPlace.size = 12;
                cellPlace.appendChild(elPlace);

                var cellPlace = row.insertCell(4);
                var elPlace = document.createElement('input');
                elPlace.type = 'text';
                elPlace.name = 'da' + iteration;
                elPlace.id = 'da' + iteration;
                elPlace.size = 12;
                cellPlace.appendChild(elPlace);

                var cellPlace = row.insertCell(5);
                var elPlace = document.createElement('input');
                elPlace.type = 'text';
                elPlace.name = 'other' + iteration;
                elPlace.id = 'other' + iteration;
                elPlace.size = 6;
                cellPlace.appendChild(elPlace);

                var cellRightSel = row.insertCell(6);
                var txtarea = document.createElement('textarea');
                txtarea.name = 'remark' + iteration;
                txtarea.id = 'remark'+iteration;
                txtarea.rows =2;
                txtarea.cols = 24
                cellRightSel.appendChild(txtarea);
                
                var formlength = document.getElementById("formlength");
                formlength.value = iteration;
            }

            function removeRow()
            {

                var tbl = document.getElementById('formTable');
                var lastRow = tbl.rows.length;
                if (lastRow > 2){
                    tbl.deleteRow(lastRow - 1);
                    var formlength = document.getElementById("formlength");
                    formlength.value = lastRow - 2;
                }
            }
            $(document).ready(function(){
                            appDatePick();
                        });

            function appDatePick(){
                  $('.datepicker').datepicker({dateFormat:'yy-mm-dd'});
            }

        </script>
EOT;


//            $str .="<div id='heading'><h3>Add TA/DA<h3></div>
//                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
//                <div class='form_row'><div class='label'>Visit Date :</div><div class='act_obj'> <input type='text' size='25'  name='visited_date' id='datepicker' value=\"{$form->value('visited_date')}\" /></div><div class='err_msg'>{$form->error('visited_date')}</div></div>
//                <div class='form_row'><div class='label'>Visit Place :</div><div class='act_obj'> <input type='text' name='visit_place' size='25' value=\"{$form->value('visit_place')}\" /></div><div class='err_msg'>{$form->error('visit_place')}</div></div>
//                <div class='form_row'><div class='label'>Distance Travel :</div><div class='act_obj'> <input type='text' size='25' name='distance' value=\"{$form->value('distance')}\" /></div><div class='err_msg'>{$form->error('distance')}</div></div>
//                <div class='form_row'><div class='label'>Daily allowance :</div><div class='act_obj'> <input type='text' size='25' name='da' value=\"{$form->value('da')}\" /></div><div class='err_msg'>{$form->error('da')}</div></div>
//                <div class='form_row'><div class='label'>Other :</div><div class='act_obj'> <input type='text' size='25' name='other' value=\"{$form->value('other')}\" /></div><div class='err_msg'>{$form->error('other')}</div></div>
//                    <div class='form_row'><div class='label'>Remarks :</div><div class='act_obj'> <textarea rows='6' cols='40' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
//                    <div><input type='hidden' name='add'></div>
//                <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='Add'></div>
//                </form></div>
//                <script type='text/javascript'>
//                $(document).ready(function(){
//                                            $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
//                                            });
//                </script>";

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
                header("Location:".BASE_LINK_URL."?page=viewtada");
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
                <div class='form_row'><div class='label'>Remarks :</div><div class='act_obj'> <textarea rows='4' cols='40' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='hidden' name='edit'></div>
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='Edit'></div>
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

        global $database,$user;
        //$database->managerViewTada();
        define("REQ_LEVEL",4);
        define("REQ_LEVEL9", 9);
        if($user->level < REQ_LEVEL){
            Page::$content=UN_AUTH;
         return;
        }
        $url = "./ajax/mtada.php";
        $baseLinkUrl = BASE_LINK_URL;
        
        if($user->level == REQ_LEVEL9){
            $userlist = $database->getMRList();
        }else{
        $userlist = $database->getUserList();
        }

        $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/jquery.chainedSelects.js'></script>            
            <script src='./js/mviewtada.js'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <div id ='heading'> <h3>View TA/DA </h3></div>
           <div id='partyStock'> Select M.R. <select name='user' id='user'><option value='0' selected>----select-----</option>";
            foreach($userlist as $key){
                $str .= "<option value='{$key['id']}'>{$key['username']}</option>";
            }
            
        $str .="</select>
            <br />
            <br />
            </div>
        <div id='date_alignment'><input type='submit' value='<< Previous' name='prev' id='prev' class='buttonn'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to'   size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go' class='buttonn'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next' class='buttonn'></div>

            <table id='list'></table> 
            <div id='pager'></div>";
            
        $str.="
            <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
            $('#datepicker_to').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";
            Page::$content = $str;

    }
?>
