<?php
function addSalesPlan() {
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    define("REQ_LEVEL2", 4);
    if ($user->level != REQ_LEVEL && $user->level != REQ_LEVEL2)
        return UN_AUTH;

    $str;

    if (isset($_SESSION['addSalesSuccess'])) {
        unset($_SESSION['addSalesSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
    }

    if (isset($_POST['add'])) {

//        var_dump($_POST);
//        die();

        $retval = $ctrl->addSalesPlan($_POST);

        if ($retval) {
            $_SESSION['addSalesSuccess'] = true;
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='" . $ctrl->referrer . "'</script>";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='" . $ctrl->referrer . "'</script>";
        }
    } else {
        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');
        $party = $database->getMyParty();
        $str .="<div id='heading'><h3 style='float:left'>Add Sales Plan</h3><a href='?page=viewsalesplan'><div id='linking'>Manage Sales Plan</div></a><br/><br/><br/></div>
                <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Party :</div><div class='act_obj'> <select name='party_id' onchange='partyId(this.value)'><option value='0' selected>----select-----</option>";

        foreach ($party as $key) {
            $selected = "";
            if ($key['id'] == $form->value('party_id'))
                $selected = "selected";
            $str .="<option value='{$key['id']}' {$selected}>{$key['name']}</option>";
        }
        $str .="</select></div><div class='err_msg'>{$form->error('party_id')}</div></div>";
        $str.=" <div class='form_row'><div class='label'>From date :</div><div class='act_obj'> <input size='16' type='text' name='from_date' class='datepicker' value=\"{$form->value('from_date')}\" size='10' /></div><div class='err_msg'>{$form->error('from_date')}</div></div>
                 <div class='form_row'><div class='label'>To date :</div><div class='act_obj'> <input size='16' type='text' name='to_date' class='datepicker' value=\"{$form->value('to_date')}\" size='10' /></div><div class='err_msg'>{$form->error('to_date')}</div></div>
                ";
        $str.="<div id='salesPlanDetail' style='float:left;'>&nbsp;</div>
                <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input style='float:left' type='submit' value='Add' name='submit'></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                $('.datepicker').datepicker({dateFormat:'yy-mm-dd'});
                });
                </script>";

        return $str;
    }
}
/*For MR */
function viewSalesPlan() {
    global $user;
    define("REQ_LEVEL", 2);
    define("REQ_LEVEL2", 4);
    define("REQ_LEVEL3", 9);
    if ($user->level != REQ_LEVEL && $user->level != REQ_LEVEL2 && $user->level != REQ_LEVEL3) {
        Page::$content = UN_AUTH;
        return;
    }
    //$_SESSION['userid'] = $user->userid;
    $url = "./ajax/salesPlan.php";
    $baseLinkUrl = BASE_LINK_URL;
    $addParamE = "&page=editsalesPlan";
    $addParamD = "&page=delsalesPlan";
    $addParamG = "&page=viewsalesplandetail";
    $idName = "id";
    $str = "<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />
            
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <script type='text/javascript'>
            jQuery(document).ready(function(){
    $('#list_d').hide();
        var interval = 0;
        var ids;
			jQuery('#next').attr('disabled',true);
            $('#prev').click(function(){
                interval++;
                var limit = new Array();
				limit = getMonthLimit(interval);
				jQuery('#datepicker').val(limit[0]);
				jQuery('#datepicker_to').val(limit[1]);
                jQuery('#next').attr('disabled',false);
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/salesPlan.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                jQuery('#list').jqGrid('setCaption','Sales Plan List:').trigger('reloadGrid');
            });

            $('#go').click(function(){
                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/salesPlan.php?q=1&llimit='+jQuery('#datepicker').val()+'&ulimit='+jQuery('#datepicker_to').val(),page:1});
                jQuery('#list').jqGrid('setCaption','Sales Plan List:').trigger('reloadGrid');

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

                jQuery('#list').jqGrid('setGridParam',{url:'./ajax/salesPlan.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1],page:1});
                jQuery('#list').jqGrid('setCaption','Sales Plan List:').trigger('reloadGrid');
            });

            var limit = new Array();
			limit = getMonthLimit(interval);
			jQuery('#datepicker').val(limit[0]);
			jQuery('#datepicker_to').val(limit[1]);

    jQuery('#list').jqGrid({
                url:'./ajax/salesPlan.php?q=2&llimit='+limit[0]+'&ulimit='+limit[1],
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN', 'Party Name','Created At','From Date','To Date','-','-',''],
                colModel :[
                {name:'id', index:'id', width:25,sortable:false},
                {name:'party_name', index:'party_name', width:150, align:'left',sortable:false},
                {name:'created_date', index:'created_date', width:70, align:'left',sorttype:'text'},
                {name:'from_date', index:'from_date', width:70, align:'left',sorttype:'text'},
                {name:'to_date', index:'to_date', width:60, align:'left',sorttype:'text'},
                {name:'a', index:'a', width:40, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}},
                {name:'b', index:'b', width:40, align:'center', sortable:false},
                {name:'dummy', index:'dummy', hidden:true}
                ],
                pager: '#pager',
                rowNum:15,
                    width:650,
                    height:330,
                    hidegrid:false,
                rowList:[10,20,30],
                sortname: 'from_date',
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'Sales Plan List',
                editurl:'./ajax/salesPlan.php?msg=del',
                onSelectRow: function(ids) {

                    //alert(ids);
                      $('#list_d').show();
                    jQuery('#list_d').jqGrid('setGridParam',{url:'./ajax/salesPlanDetail.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1]+'&id='+ids,page:1});
                    jQuery('#list_d').jqGrid('setCaption','Sales Plan Detail :').trigger('reloadGrid');
                }
            });

                    
            jQuery('#list_d').jqGrid({

                url:'./ajax/salesPlanDetail.php?q=1&llimit='+limit[0]+'&ulimit='+limit[1]+'&id={$_GET[id]}',
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN', 'Product Name','Plan','Discount'],
                colModel :[
                {name:'id', index:'id', width:25,sortable:false},
                {name:'product_name', index:'product_name', width:150, align:'left',sortable:false},
                {name:'plan', index:'plan', width:70, align:'left',sorttype:'text'},
                {name:'Discount', index:'Discount', width:60, align:'left',sorttype:'text'},
                ],
                pager: '#pager',
                rowNum:15,
                    width:650,
                    height:330,
                    hidegrid:false,
                rowList:[10,20,30],
                sortname: 'plan_case',
                sortorder: 'DESC',
                viewrecords: true,
                imgpath: '',
                caption: 'Sales Plan Detail',
            });
        });
        </script>
			<div id='heading'><h3 style='float:left'>View Sales Plan</h3><a href='?page=addsalesplan'><div id='linking'>Add Sales Plan</div></a><br/><br/><br/></div>
		   <div id='date_alignment'>
			<input type='submit' value='<< Previous' name='prev' id='prev' class='buttonn'>&nbsp;From :&nbsp;<input type='text' name='from_date' id='datepicker' size='10' />&nbsp;&nbsp;&nbsp;To :&nbsp<input type='text' name='to_date' id='datepicker_to' size='10' />&nbsp;&nbsp;<input type='submit' value='Go' name='go' id='go' class='buttonn'>&nbsp;&nbsp;<input type='submit' value='Next>>' name='next' id='next' class='buttonn'></div>
            <table id='list'></table>
            <div id='pager'></div>
            <br />
            <div id='pager_d'></div>";
    $str.="<script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
            $('#datepicker_to').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";
   $str.="<table id='list_d'></table>";
    Page::$content = $str;
}

function hasRecord($id,$list){

    foreach($list as $item){

        if($item['product_id'] == $id){
            return $item;
            break;
        }
    }

    return false;

}
/*for Admin */
function mViewSalesPlan(){
    global $user;
        define("REQ_LEVEL",4);
        if($user->level < REQ_LEVEL){
            Page::$content=UN_AUTH;
         return;
        }
        global $database;
        $url = "./ajax/msalesplan.php";
        $baseLinkUrl = "agricare.php";
        $addParamE = "&page=editdcr";
        $addParamD = "&page=deldcr";
        $idName = "id";

        //$headquater = $database->getHeadquaterList();

        $userlist = $database->getMRList();

        $str="<link rel='stylesheet' type='text/css' media='screen' href='./css/redmond/jquery-ui-1.7.1.custom.css' />
            <link rel='stylesheet' type='text/css' media='screen' href='./css/ui.jqgrid.css' />

            <script src='./js/jquery.js' type='text/javascript'></script>
            <script src='./js/i18n/grid.locale-en.js' type='text/javascript'></script>
            <script src='./js/jquery.jqGrid.min.js' type='text/javascript'></script>
            <script src='./js/jquery.chainedSelects.js'></script>
            <script src='./js/mviewsalesplan.js'></script>
            <script src='./js/ui.core.js' type='text/javascript'></script>
            <script src='./js/ui.datepicker.js' type='text/javascript'></script>
            <script src='./js/fortNightLimit.js' type='text/javascript'></script>
            <div id ='heading'> <h3> View Sales Plan</h3></div>
            <div id='partyStock'>Select M.R : <select name='user' id='user'><option value='0' selected>----select-----</option>";
            foreach($userlist as $key){
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
        $str.="<table id='list_d'></table>";
            Page::$content = $str;
}

function editSalesPlan() {
    session_start();
    global $form, $ctrl, $database, $user;
    define("REQ_LEVEL", 2);
    define("REQ_LEVEL2", 4);
    define("REQ_LEVEL9", 9);
    if ($user->level != REQ_LEVEL && $user->level != REQ_LEVEL2 && $user->level != REQ_LEVEL9)
        return UN_AUTH;
    $str = '';
    if (isset($_SESSION['editSalesSuccess'])) {
        unset($_SESSION['editSalesSuccess']);
        $str.= "<div class='notice'>Data Entered Successfully !!</div>";
    }
    if (isset($_POST['edit'])) {
//        var_dump($_POST);die();
        $retval = $ctrl->editSalesPlan($_POST);
        if ($retval) {
            $_SESSION['editSalesSuccess'] = true;
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='?page=viewsalesplan'</script>";
        } else {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $form->getErrorArray();
//            header("Location:" . $ctrl->referrer);
            echo "<script>document.location.href='" . $ctrl->referrer . "'</script>";
        }
    } else {
        Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
        Page::$csslink = array('css/ui.all.css');

        $salesPlan = $database->getSalesPlanById($_GET['id']);
        $salesPlanDetail = $database->getSalesPlanDetail($_GET['id']);
//        var_dump($salesPlan);
        //fill data in form
        $form->setValue('from_date', $salesPlan['from_date']);
        $form->setValue('to_date', $salesPlan['to_date']);
        $form->setValue('party_id', $salesPlan['party_id']);



        $party = $database->getMyParty();
        $str .="<div id='heading'><h3> Edit Sales Plan </h3> </div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Party :</div><div class='act_obj'>{$salesPlan[party_name]}</div><input type='hidden' name='party_id' value='{$salesPlan[party_id]}'/><div class='err_msg'>{$form->error('party_name')}</div></div>";
        $str.="<div class='form_row'><div class='label'>From date :</div><div class='act_obj'> <input size='16' type='text' name='from_date' class='datepicker' value=\"{$form->value('from_date')}\" size='10' /></div><div class='err_msg'>{$form->error('from_date')}</div></div>
                <div class='form_row'><div class='label'>To date :</div><div class='act_obj'> <input size='16' type='text' name='to_date' class='datepicker' value=\"{$form->value('to_date')}\" size='10' /></div><div class='err_msg'>{$form->error('to_date')}</div></div>";
        $products = $database->getProduct();
        $str.= "<table width='90%' style='float:left';>";
        foreach ($products as $count => $product) {
            $str .= "<tr>";
            $str .= "<td><b>" . $product['name'] . " " . $product['quantity'] . " " . $product['unit_name'] . "</b><input type='hidden' name='product_id{$count}' value='{$product['id']}'/></td>";
            $str .= "</tr>";
            $stock = $database->getPartyStock($form->value('party_id'), $product['id']);
            if (is_array($stock) && count($stock)) {
                $str .= "<tr><td>Stock : </td>";
                $str.= "<td>" . $stock[0]['no_of_case'] . " case / " . $stock[0]['indivisual'] . " pcs. </td>
            </tr>";
            } else {
                $str .= "<tr><td>Stock : </td><td>0 case / 0 pcs. </td></tr>";
            }

            $data = hasRecord($product['id'], $salesPlanDetail);
            if(is_array($data)){
                $str .= "<tr><td style='width:8%'>Plan : </td><td><input type='text' name='plan_case{$count}' value=\"{$data[plan_case]}\" size='5' /> case / <input type='text' name='plan_individual{$count}' value=\"{$data[plan_individual]}\" size='5'/> pcs.</td></tr>";
                $str .= "<tr><td>Discount : </td><td><input type='text' name='discount_case{$count}' value=\"{$data[discount_case]}\" size='5' /> case / <input type='text' name='discount_individual{$count}' value=\"{$data[discount_individual]}\" size='5'/> pcs.<input type='hidden' name='id{$count}' value=\"{$data[id]}\"/></td></tr>";
            }else {
                $str .= "<tr><td style='width:8%'>Plan : </td><td><input type='text' name='plan_case{$count}' value=\"\" size='5' /> case / <input type='text' name='plan_individual{$count}' value=\"\" size='5'/> pcs.</td></tr>";
                $str .= "<tr><td>Discount : </td><td><input type='text' name='discount_case{$count}' value=\"\" size='5' /> case / <input type='text' name='discount_individual{$count}' value=\"\" size='5'/> pcs.</td></tr>";
            }
        }
        $str .= "</table><div><input type='hidden' name='add'><input type='hidden' name='count' value='{$count}' /></div>";
        $str.="<div><input type='hidden' name='id' value='{$_GET['id']}'></div>
                <div><input type='hidden' name='edit'></div>
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Edit' name='submit'></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                $('.datepicker').datepicker({dateFormat:'yy-mm-dd'});
                });
                </script>";

        return $str;
    }
}
?>
<script language="javascript" type="text/javascript">
    function partyId(val) {
        //                    alert(val);

        $.ajax({
            type:"GET",
            url:"./ajax/add_salesPlan.php?party_id="+val,
            cache: false,
            success: function(msg){
                //                location.reload();

                $("#salesPlanDetail").html(msg);
                //$("#dueAmount").show();
                //alert(msg);
            }
        });
    }
</script>
