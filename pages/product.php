<?php

function viewProduct() {
    global $user;
    define("REQ_LEVEL", 9);
    if ($user->level < REQ_LEVEL) {
        Page::$content = UN_AUTH;
        return;
    }
    //global $database;
    //$str;
    //$data = $database->viewProduct();
    //print_r($data);
    $url = "./ajax/product.php";
    $baseLinkUrl = BASE_LINK_URL;
    $addParamE = "&page=editproduct";
    $addParamD = "&page=delproduct";
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
                colNames:['SN','Name', 'Qty.','No. in Case','Price (Rs.)','Active','-','-'],
                colModel :[ 
                {name:'id', index:'id', width:25,sortable:false}, 
                {name:'name', index:'name', width:120, align:'left',sorttype:'text'}, 
                {name:'quantity', index:'quantity', width:50, align:'left',sortable:false}, 
                {name:'no_in_case', index:'no_in_case', width:60, align:'left',sortable:false}, 
                {name:'price', index:'price', width:50, align:'left',sortable:false}, 
                {name:'active', index:'active', width:40, align:'center',sortable:false}, 
                {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}}, 
                {name:'b', index:'b', width:20, align:'center', sortable:false} 
                ],
                pager: '#pager',
                rowNum:15,
                    width:650,
                    height:310,
                    hidegrid:false,
                rowList:[15,30,45],
                sortname: 'name',
                sortorder: '',
                viewrecords: true,
                imgpath: '',
                caption: 'Products List',
                editurl:'./ajax/product.php?msg=del',
                onCellSelect: function(ids,colid) {

                $('#list_d').show();
                jQuery('#list_d').jqGrid('setGridParam',{url:'./ajax/product_effective.php?id='+ids,page:1});
                jQuery('#list_d').jqGrid('setCaption','Products Detail :').trigger('reloadGrid');
//                      alert(ids);

//
//                    //alert(ids+colid+content+jQuery(this).getCell(ids,colid));
                    if(colid == 7){
                        var gr=jQuery(this).jqGrid('getGridParam','selrow');
                        if(gr !=null ){
                            jQuery(this).jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
                        }
                    }
                }
            });
                 jQuery('#list_d').jqGrid({

                url:'./ajax/product_effective.php?id={$_GET[id]}',
                datatype: 'xml',
                mtype: 'GET',
                colNames:['SN','Effective Date','Price'],
                colModel :[
                {name:'id', index:'id', width:25,sortable:false},
                {name:'effective_date', index:'effective_date', width:150, align:'left',sortable:false},
                {name:'price', index:'price', width:70, align:'left',sorttype:'text'},
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
                caption: 'Product Detail',
            });
            }); 
            </script>
			<div id='heading'><h3 style='float:left'>View Product</h3><a href='?page=addproduct'><div id='linking'>Add Product</div></a><br/><br/></div>
            <table id='list'></table> 
            <div id='pager'></div> 
            ";
    $str.="<table id='list_d'></table>";

    //echo $str."dfjsdjfksdfjs";
    //die();
    Page::$content = $str;
}

function addProduct() {
    global $form, $ctrl, $database, $page, $user;
    define("REQ_LEVEL", 9);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $str;
    if (isset($_POST['add'])) {
        $args = array("name" => $_POST['name'], "quantity" => $_POST['quantity'], "unit_id" => $_POST['unit_id'], "no_in_case" => $_POST['no_in_case'], "active" => $_POST['active'], "price" => $_POST['price'], "effective_date" => $_POST['effective_date']);
        $retval = $ctrl->addProduct($args);

        if ($retval) {
            $str.= "<div class='notice'>Data Entered Successfully !!</div>";
            $form->setValueArray(array());
        } else {
            $form->setValueArray($_POST);
            //$_SESSION['value_array'] = $_POST;
            //$_SESSION['error_array'] = $form->getErrorArray();
            //header("Location:".$ctrl->referrer);
        }
    }

    Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
    Page::$csslink = array('css/ui.all.css');
    $unit = $database->getUnit();

    $action;
    if (!$form->value('active')) {
        $action = array('no' => "checked", 'yes' => "");
    } else {
        if ($form->value('active') == 'n')
            $action = array('no' => "checked", 'yes' => "");
        else
            $action = array('no' => "", 'yes' => "checked");
    }
    $str .="<div id='heading'>
            <h3 style='float:left'>Add Product</h3><a href='?page=viewproduct'><div id='linking'>Manage Product</div></a><br/><br/></div>
                <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Name :</div><div class='act_obj'> <input type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
                <div class='form_row'><div class='label'>Qty. :</div><div class='act_obj'> <input type='text' name='quantity' size='10' value=\"{$form->value('quantity')}\" /> &nbsp;&nbsp;
                <select name='unit_id'>";
    foreach ($unit as $key) {
        $str .= "<option value='{$key['id']}'>{$key['unit_name']}</option>";
    }

    $str .="</select></div><div class='err_msg'>{$form->error('quantity')}</div></div>
                <div class='form_row'><div class='label'>No. in case :</div><div class='act_obj'> <input type='text' name='no_in_case' size='10' value=\"{$form->value('no_in_case')}\" /></div><div class='err_msg'>{$form->error('no_in_case')}</div></div>
                <div class='form_row'><div class='label'>Active :</div><div class='act_obj'> <input type='radio' value='y' name='active' {$action['yes']}>Yes &nbsp;&nbsp;
                <input type='radio' value='n' name='active' {$action['no']}>No</div></div>

                <div class='form_row'><div class='label'>ND Price :</div><div class='act_obj'> <input type='text' name='price' value=\"{$form->value('price')}\" /></div><div class='err_msg'>{$form->error('price')}</div></div>
                <div class='form_row'><div class='label'>Eff. Date :</div><div class='act_obj'> <input type='text' name='effective_date' id='datepicker' size='20' value=\"{$form->value('effective_date')}\" /></div><div class='err_msg'>{$form->error('effective_date')}</div></div>
                <div><input type='hidden' value='1' name='add'/></div>
                <div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;<input type='submit' value='Add' name='submit'/></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";
    return $str;
}

function editProduct() {
    global $database, $form, $ctrl, $page, $user;
    define("REQ_LEVEL", 9);
    if ($user->level < REQ_LEVEL)
        return UN_AUTH;
    $action;
    $unit = $database->getUnit();
    $data = $database->getProductById($_GET['id']);
    $str = "<div id ='heading' ><h3>Edit Product</h3></div>";
    if (isset($_POST['edit'])) {
        $args = array("name" => $_POST['name'], "quantity" => $_POST['quantity'], "unit_id" => $_POST['unit_id'], "no_in_case" => $_POST['no_in_case'], "active" => $_POST['active'], "price" => $_POST['price'], "effective_date" => $_POST['effective_date'], "product_id" => $_POST['product_id'], "id" => $_POST['id']);
        $retval = $ctrl->editProduct($args);

        if ($retval) {
            $str.= "<div class='notice'>Data Update Successfully !!</div>";
            $form->setValueArray(array());
            header('Location:' . BASE_LINK_URL . '?page=viewproduct');
        } else {
            $form->setValueArray($_POST);
            if ($form->num_errors > 0) {
                $str.= "<div class='notice_err'>Input Error- {$form->num_errors} errors!!</div>";
            } else {
                $str.= "<div class='notice_err'>Data Edit failed !!</div>";
            }
        }
    } else {

        $form->setValue('name', $data['name']);
        $form->setValue('quantity', $data['quantity']);
        $form->setValue('no_in_case', $data['no_in_case']);
        $form->setValue('price', $data['price']);
        $form->setValue('effective_date', $data['effective_date']);
    }
    Page::$jslink = array('js/ui.core.js', 'js/ui.datepicker.js');
    Page::$csslink = array('css/ui.all.css');
    if ($form->value('active') == 'n' || $data['active'] == '0')
        $action = array('no' => "checked", 'yes' => "");
    else
        $action = array('no' => "", 'yes' => "checked");
    $str .="
                <div id='sub-content'><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Name :</div><div class='act_obj'> <input type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
                <div class='form_row'><div class='label'>Qty. :</div><div class='act_obj'> <input type='text' name='quantity' size='10' value=\"{$form->value('quantity')}\" /> &nbsp;&nbsp;
                <select name='unit_id'>";
    foreach ($unit as $key) {
        $checked = "";

        if ($key['id'] == $data['unit_id'])
            $checked = "selected";

        $str .= "<option value='{$key['id']}' {$checked}>{$key['unit_name']}</option>";
    }

    $str .="</select></div><div class='err_msg'></div>{$form->error('quantity')}</div>
                <div class='form_row'><div class='label'>No. in case :</div><div class='act_obj'> <input type='text' name='no_in_case' size='10' value=\"{$form->value('no_in_case')}\" /></div><div class='err_msg'>{$form->error('no_in_case')}</div></div>
                <div class='form_row'><div class='label'>Active :</div><div class='act_obj'> <input type='radio' value='y' name='active' {$action['yes']}>Yes &nbsp;&nbsp;
                <input type='radio' value='n' name='active' {$action['no']}>No &nbsp;</div><div class='err_msg'>{$form->error('active')}</div></div>

                <div class='form_row'><div class='label'>ND Price :</div><div class='act_obj'> <input type='text' name='price' value=\"{$form->value('price')}\" /></div><div class='err_msg'>{$form->error('price')}</div></div>
                <div class='form_row'><div class='label'>Eff. date :</div><div class='act_obj'> <input type='text' name='effective_date' id='datepicker' size='10' value=\"{$form->value('effective_date')}\" /></div><div class='err_msg'>{$form->error('effective_date')}</div></div>
                <div><input type='hidden' value='{$data['product_id']}' name='product_id'/></div>
                <div><input type='hidden' value='{$data['id']}' name='id'/></div>
                <div><input type='hidden' value='1' name='edit'/></div>
                <div><input type='submit' value='edit' name='submit'/></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                                            $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                                            });
                </script>";

    return $str;
}
?>
