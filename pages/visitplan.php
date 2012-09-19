<?php

function viewVisitplan() {

    global $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL) {
        Page::$content = UN_AUTH;
        return;
    }
    global $database;
    $_SESSION['userid'] = $user->userid;
    //echo $_SESSION['userid'];
    //$data = $database->viewDcr();
    //print_r($data);
    //die();

    $url = "./ajax/visitplan.php";
    $baseLinkUrl = BASE_LINK_URL;
    $addParamE = "&page=editvisitplan";
    $addParamD = "&page=delvisitplan";
    $idName = "id";

    $str = "<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascriptk'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
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
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/visitplan.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1}); 
                jQuery('#list').jqGrid('setCaption','visitplan List').trigger('reloadGrid'); 
            });

			$('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/visitplan.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1}); 
                jQuery('#list').jqGrid('setCaption','visitplan List:').trigger('reloadGrid');

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
                          
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/visitplan.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1}); 
                jQuery('#list').jqGrid('setCaption','visitplan List').trigger('reloadGrid'); 
            });

			var limit = new Array();
			limit = getLimit(interval);
			jQuery('#datepicker').val(limit[0]);
			jQuery('#datepicker_to').val(limit[1]);

            jQuery('#list').jqGrid({
                url:'./ajax/visitplan.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Date','Created At', 'Place','Remark','Approved','-','-'],
                colModel :[ 
                {name:'id', index:'id', width:15,sortable:false}, 
                {name:'collected_date', index:'collected_date', width:60, align:'left',sorttype:'text'},
                {name:'created_at', index:'created_at', width:70, align:'left',sorttype:'text'},
                {name:'place', index:'place', width:120, align:'left',sorttype:'text'}, 
                {name:'remark', index:'remark', width:200, align:'left',sortable:false}, 
                {name:'approve', index:'approved', width:70, align:'center', sortable:false},
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
                caption: 'visitplan List',
                editurl:'./ajax/visitplan.php?msg=del',
                onCellSelect: function(ids,colid) {
                    if(colid == 6){
                        var gr=jQuery(this).jqGrid('getGridParam','selrow');
                        if(gr !=null ){ 
//                            jQuery(this).jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
                        }
                    }
                }
            }); 
            }); 
            </script>
			<div id='heading'><h3 style='float:left'>View Visit Plan</h3><a href='?page=addvisitplan'><div id='linking'>Add Visit Plan</div></a><br/><br/><br/></div>
            <div id='date_alignment'><input type='submit'  class='buttonn' value='<< Previous' name='prev' id='prev'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' class='buttonn' id='go'>&nbsp;&nbsp;<input type='submit' class='buttonn' value='Next>>' name='next' id='next'></div>
            <table id='list'></table> 
            <div id='pager'></div> 
            ";
    $str.="<script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
            $('#datepicker_to').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";

    Page::$content = $str;
}

function addVisitplan() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;

    if (isset($_SESSION['addVisitPlanSuccess'])) {
        unset($_SESSION['addVisitPlanSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
    }

    if (isset($_POST['add'])) {
//            var_dump($_post);
        $retval = $ctrl->addVisitplan($_POST);

        if ($retval) {
            $_SESSION['addVisitPlanSuccess'] = true;
            header("Location:" . $ctrl->referrer);
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {
        $initial = ( $form->value('formlength')) ? $form->value('formlength') : 7;
        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');

        $str.=<<<EOT
          <div id='heading'><h3 style='float:left'>Add Visit Plan</h3><a href='?page=viewvisitplan'><div id='linking'>Manage Visit Plan</div></a><br/><br/><br/></div>
                <div id="sub-content"><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                        <table  id="formTable">
                            <tr align="center">
                                <td>
                                    S.No
                                </td>
                                <td>
                                    Date
                                </td>
                                <td>
                                    Place
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
                                            <input type="text" class="datepicker" name="collected_date$i" id="collected_date$i" size="12" value="{$form->value("collected_date$i")}" />{$form->error("collected_date$i")}
                                        </td>
                                        <td >
                                             <input type="text" name="place$i" id="place$i" size="20" value="{$form->value("place$i")}" />{$form->error("place$i")}</td>
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
                elDate.name = 'collected_date' + iteration;
                elDate.id = 'collected_date' + iteration;
                elDate.class="datepicker";              
                elDate.size = 12;
                cellDate.appendChild(elDate);
                appDatePick();

                var cellPlace = row.insertCell(2);
                var elPlace = document.createElement('input');
                elPlace.type = 'text';
                elPlace.name = 'place' + iteration;
                elPlace.id = 'place' + iteration;
                elPlace.size = 20;
                cellPlace.appendChild(elPlace);
                var cellRightSel = row.insertCell(3);
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
    }
    return $str;
}

function editVisitplan() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;
    if (isset($_POST['edit'])) {
        $retval = $ctrl->editVisitplan($_POST);
        if ($retval) {
            header("Location:" . BASE_LINK_URL . "?page=viewvisitplan");
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {
        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $data = $database->getVisitplanById($_GET['id']);
        $form->setValue('collected_date', $data['collected_date']);
        $form->setValue('place', $data['place']);
        $form->setValue('remark', $data['remark']);

        $str .="<div id ='heading'><h3>Edit Visit Plan</h3></div>
                <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Date :</div><div class='act_obj'> <input type='text' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
                <div class='form_row'><div class='label'>Place :</div><div class='act_obj'> <input type='text' name='place' value=\"{$form->value('place')}\" /></div><div class='err_msg'>{$form->error('place')}</div></div>
                <div class='form_row'><div class='label'>Remarks :</div><div class='act_obj'> <textarea rows='4' cols='45' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
                <div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='hidden' name='edit'></div>
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Edit' name='submit'></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";

        return $str;
    }
}

function mViewVisitPlan() {

    global $user, $database;
    define("REQ_LEVEL", 4);
    define("REQ_LEVEL9", 9);

    if ($user->level < REQ_LEVEL) {
        Page::$content = UN_AUTH;
        return;
    }
    $url = "./ajax/mdcr.php";
    $baseLinkUrl = BASE_LINK_URL;
    $addParamE = "&page=editdcr";
    $addParamD = "&page=deldcr";
    $idName = "id";

    if ($user->level == REQ_LEVEL9) {
        $userlist = $database->getMRList();
    } else {
        $userlist = $database->getUserList();
    }
    $str = "<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/jquery.chainedSelects.js'></script>            
            <script src='./js/mviewvisitplan.js'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <div id ='heading'> <h3> Visit Plan Reports</h3></div>
            <div id='partyStock'>Select M.R : <select name='user' id='user'><option value='0' selected>----select-----</option>";
    foreach ($userlist as $key) {
        $str .= "<option value='{$key['id']}'>{$key['username']}</option>";
    }

    $str .="</select><br /> <br />
            </div>    
            <div id='date_alignment'><input class='buttonn'type='submit' value='<< Previous' name='prev' id='prev'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' class='buttonn' value='Go' name='go' id='go'>&nbsp;&nbsp;<input class='buttonn' type='submit' value='Next>>' name='next' id='next'></div>
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
