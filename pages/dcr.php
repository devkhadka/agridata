<?php

function viewDcr() {
    global $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL) {
        Page::$content = UN_AUTH;
        return;
    }
    global $database;
    $_SESSION['userid'] = $user->userid;
    $url = "./ajax/dcr.php";
    $baseLinkUrl = BASE_LINK_URL;
    $addParamE = "&page=editdcr";
    $addParamD = "&page=deldcr";
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
                colNames:['SN','Date','Created Date' ,'Name of Customer','Title','Remark','Approved','-','-'],
                colModel :[ 
                {name:'id', index:'id', width:15,sortable:false}, 
                {name:'collected_date', index:'collected_date', width:60, align:'left',sorttype:'text'},
                {name:'created_date', index:'created_date', width:60, align:'left',sorttype:'text'},
                {name:'name', index:'name', width:120, align:'left',sorttype:'text'}, 
                {name:'title', index:'title', width:50, align:'left',sortable:false}, 
                {name:'remark', index:'remark', width:200, align:'left',sortable:false}, 
                {name:'approve', index:'approve', width:70, align:'center',sortable:false},
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
                //editurl:'./ajax/dcr.php?msg=del',
                onCellSelect: function(ids,colid) {
                    if(colid == 7){
                        var gr=jQuery(this).jqGrid('getGridParam','selrow');
//                        if(gr !=null ){
//                            //jQuery(this).jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
//                        }
                    }
                }
            }); 
            }); 
            </script>
                <div id='heading'><h3 style='float:left'>View DCR</h3><a href='?page=adddcr'><div id='linking'>Add DCR</div></a><br><br><br></div>
            <div id='date_alignment'><input type='submit' class='buttonn' value='<< Previous' name='prev' id='prev'>&nbsp;From :&nbsp;<input type='text' class='inputt' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' class='inputt' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' class='buttonn' value='Go' name='go' id='go'>&nbsp;&nbsp;<input type='submit' class='buttonn' value='Next>>' name='next' id='next'></div>
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

function addDcr() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;

    if (isset($_SESSION['addDcrSuccess'])) {
        unset($_SESSION['addDcrSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
        //$str.="Data Entered Successfully !!";
    }

    if (isset($_POST['add'])) {

//        print_r($_POST);
        //die();
        $retval = $ctrl->addDcr($_POST);

        if ($retval) {
            $_SESSION['addDcrSuccess'] = true;
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
        $title = $database->getTitle();

        $str.=<<<EOT
              <div id='heading'><h3 style='float:left'>Add DCR</h3><a href='?
        page=viewdcr'><div id='linking'>Manage DCR</div></a><br/><br/><br/></div>
                <div id="sub-content"><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                        <table  id="formTable" border="1">
                            <tr align="center">
                                <td>
                                    S.N.
                                </td>
                                <td>
                                    Date
                                </td>
                                <td>
                                    Name
                                </td>
                                 <td>
                                    Profession
                                </td>
                                 <td>
                                    Remarks
                                </td>
                            </tr>
EOT;


        for ($i = 1; $i <= $initial; $i++) {
            $collectedDate = $form->value("collected_date");
            $name = $form->value('name');
            $name = $name[$i];

            $str.= <<<EOT
                                <tr>
                                       <td>
                                            $i
                                        </td>
                                        <td>
                                            <input type="text" class="datepicker" name="collected_date$i" id="collected_date$i" size="10" value="{$form->value("collected_date$i")}" />{$form->error("collected_date$i")}
                                        </td>
                                        <td>
                                 <input type="text" name="name$i" id="name$i" size="12" value="{$form->value("name$i")}" />{$form->error("name$i")}
                                                                                    </td>
                          <td> <select name="customer_title_id$i">
EOT;
            foreach ($title as $key) {
                $str .= "<option value='{$key['id']}' > {$key['title']}</option>";
            }
            $str.=<<<EOT
                                    </select>
                                        </td>


                                        <td>
                                             <textarea rows='2' cols='24' name='remark$i'
                                            id="remark$i" >{$form->value("remark$i")}</textarea>{$form->error("remark$i")}
                                        </td>
                                   </tr>
EOT;
        }

        $str.=<<<EOT
 </table>
                       <div id="submitdiv" style="float:right">
                        <input type="hidden" value="$initial"  id="formlength"
name="formlength"/>
                         <input type="hidden" value="1"  id="add" name="add"/>
                        <input type="button" value="Add" onclick="addRow();" />
                        <input type="button" value="Remove" onclick="removeRow();"
/>
                        <input type="submit" value="Submit" name="submit" />
                        </div>

        </form>
        </div>
        <script language="Javascript" type="text/javascript">
            function addRow()
            {

               var table = document.getElementById('formTable');

            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            var colCount = table.rows[1].cells.length;
           
            for(var i=0; i<colCount; i++) {
            
                var newcell = row.insertCell(i);

                if(i>0){                   
                    var child = table.rows[1].cells[i].lastElementChild.cloneNode(true);
                  
                    child.id = child.id.replace("1",rowCount);
                    child.name = child.name.replace("1", rowCount);
                    newcell.appendChild(child);
                    }
                else{
                     newcell.innerHTML = rowCount;
                     }
                    
                }
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


//            $str .="<div id='heading'><h3 style='float:left'>Add DCR</h3><a href='?page=viewdcr'><div id='linking'>Manage DCR</div></a><br/><br/><br/></div>
//                <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
//                <div class='form_row'><div class='label'>Date :</div><div class='act_obj'><input size='20' type='text' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" /></div><div class='err_msg'>{$form->error('collected_date')}</div></div>
//                <div class='form_row'><div class='label'>Customer Name :</div><div class='act_obj'> <input size='20' type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
//                <div class='form_row'><div class ='label'>Profession :{$form->error('customer_title_id')} </div> <div class='act_obj'>";
//            foreach($title as $key){
//                $str .= "<div><input type='radio' value='{$key['id']}' name='customer_title_id' {$checked}>&nbsp;&nbsp;{$key['title']} </div>";
//            }
//
//            $str .="</div></div><div class='form_row'><div class='label'>Remarks :</div><div class='act_obj'> <textarea rows='6' cols='35' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
//                <div><input type='hidden' name='add'></div>
//                <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Add' name='submit'></div>
//                </form></div>
//                <script type='text/javascript'>
//                $(document).ready(function(){
//                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
//                        });
//                </script>";

        return $str;
    }
}

function editDcr() {
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
        $retval = $ctrl->editDcr($_POST);

        if ($retval) {
            //$_SESSION['editDcrSuccess'] = true;
            header("Location:" . BASE_LINK_URL . "?page=viewdcr");
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
            header("Location:" . $ctrl->referrer);
        }
    } else {
        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $title = $database->getTitle();

        $data = $database->getDcrById($_GET['id']);
//            print_r($data);
        //die();

        $form->setValue('collected_date', $data['collected_date']);
        $form->setValue('name', $data['name']);
        $form->setValue('customer_title_id', $data['customer_title_id']);
        $form->setValue('remark', $data['remark']);

        $str .="<div id ='heading'><h3>Edit DCR</h3></div>
                <div  id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Date :</div><div class='act_obj'> <input type='text' name='collected_date' id='datepicker' value=\"{$form->value('collected_date')}\" /></div><div class='err_msg'>'{$form->error('collected_date')}</div></div>
                <div class='form_row'><div class='label'>Name :</div><div class='act_obj'> <input type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
                <div class='form_row'><div class='label'>Profession :{$form->error('customer_title_id')} </div><div class='act_obj'>";
        foreach ($title as $key) {
            $checked = "";
            if ($key[id] == $form->value('customer_title_id'))
                $checked = "checked";
            $str .= "<div><input type='radio' value='{$key['id']}' name='customer_title_id' {$checked}>&nbsp;&nbsp;{$key['title']}</div>";
        }

        $str .="</div></div><div class='form_row'><div class='label'>Remarks :</div><div class='act_obj'> <textarea rows='4' cols='40' name='remark'>{$form->value('remark')}</textarea></div><div class='err_msg'>{$form->error('remark')}</div></div>
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

function mViewDcr() {

    global $user;
    define("REQ_LEVEL", 4);
    define("REQ_LEVEL9", 9);
    if ($user->level < REQ_LEVEL) {
        Page::$content = UN_AUTH;
        return;
    }
    global $database;
    $url = "./ajax/mdcr.php";
    $baseLinkUrl = BASE_LINK_URL;
    $addParamE = "&page=editdcr";
    $addParamD = "&page=deldcr";
    $idName = "id";

    //$headquater = $database->getHeadquaterList();
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
            <script src='./js/mviewdcr.js'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <div id ='heading'> <h3> View DCR</h3></div>
            <div id='partyStock'>Select M.R : <select name='user' id='user'><option value='0' selected>----select-----</option>";
    foreach ($userlist as $key) {
        $str .= "<option value='{$key['id']}'>{$key['username']}</option>";
    }

    $str .="</select><br /> <br />
            </div>    
            <div id='date_alignment'><input type='submit' value='<< Previous' class='buttonn' name='prev' id='prev'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' class='buttonn' name='go' id='go'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next' class='buttonn'></div>
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
