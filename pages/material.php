<?php

    function viewMaterial(){
        //global $database;
        //$str;

        //$data = $database->viewProduct();
        //print_r($data);
        global $user;
        define("REQ_LEVEL",6);
        if($user->level < REQ_LEVEL){
            Page::$content=UN_AUTH;
            return; 
        }
        $url = "./ajax/material.php";
        $baseLinkUrl = BASE_LINK_URL;
        $addParamE = "&page=editmaterial";
        $addParamD = "&page=delmaterial";
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
                colNames:['SN','Name', 'Unit','-','-'],
                colModel :[ 
                {name:'id', index:'id', width:25,sortable:false}, 
                {name:'name', index:'name', width:120, align:'left',sorttype:'text'}, 
                {name:'unit', index:'unit', width:50, align:'left',sortable:false}, 
                {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}}, 
                {name:'b', index:'b', width:20, align:'center', sortable:false} 
                ],
                pager: '#pager',
                rowNum:15,
                    width:500,
                    height:335,
                    hidegrid:false,
                rowList:[15,30,45],
                sortname: 'name',
                sortorder: '',
                viewrecords: true,
                imgpath: '',
                caption: 'Material List',
                editurl:'./ajax/material.php?msg=del',
                onCellSelect: function(ids,colid) {
                    //alert(ids+colid+content+jQuery(this).getCell(ids,colid));
                    if(colid == 4){
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
            <table id='list'></table> 
            <div id='pager'></div> 
            ";

            //echo $str."dfjsdjfksdfjs";
            //die();
            Page::$content = $str;

    }

    function addMaterial(){
        global $form,$ctrl,$database,$user;

        define("REQ_LEVEL",6);
        if($user->level < REQ_LEVEL) return UN_AUTH;
        $str;


        if($_SESSION['addmaterialSuccess']){
                unset($_SESSION['addmaterialSuccess']);
                $str.= "<div class='notice'>Data Entered Successfully !!</div>";
        }
                

        if(isset($_POST['add'])){

            //print_r($_POST);

            //$args = array("name"=>$_POST['name'],"quantity"=>$_POST['quantity'],"unit_id"=>$_POST['unit_id'],"no_in_case"=>$_POST['no_in_case'],"active"=>$_POST['active'],"price"=>$_POST['price'],"effective_date"=>$_POST['effective_date']);
            $retval = $ctrl->addMaterial($_POST);

            if($retval){
                $_SESSION['addmaterialSuccess'] = true;
                header("Location:".$ctrl->referrer);				
            }
            else{
                $_SESSION['value_array'] = $_POST;
                $_SESSION['error_array'] = $form->getErrorArray();
                header("Location:".$ctrl->referrer);				
            }

        }else{
            $unit; 
            if($form->value('unit')){

                if($form->value('unit') == 'ltr')
                    $unit = array("ltr"=>"selected","kg"=>"");
                else
                    $unit = array("ltr"=>"","kg"=>"selected");
            }

            $str .="<div id='heading'> <h3>Add Raw Material </h3></div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Name :</div><div class='act_obj'> <input type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
                <div class='form_row'><div class='label'>Unit :</div><div class='act_obj'> <select name='unit'>
                                <option value='ltr' {$unit['ltr']}>ltr</option>
                                <option value='kg' {$unit['kg']}>kg</option>
                            </select></div><div class='err_msg'>{$form->error('unit')}</div></div> 
                <div><input type='hidden' value='1' name='add'/></div>
                <div><input type='submit' value='Add' name='submit'/></div>
                </form></div>";
            return $str;
        }
    }

    function editMaterial(){
        
        global $database,$form,$ctrl,$user;
        define("REQ_LEVEL",6);
        if($user->level < REQ_LEVEL) return UN_AUTH;
        if(isset($_POST['edit'])){

            //print_r($_POST);
            //die();
            //$args = array("name"=>$_POST['name'],"quantity"=>$_POST['quantity'],"unit_id"=>$_POST['unit_id'],"no_in_case"=>$_POST['no_in_case'],"active"=>$_POST['active'],"price"=>$_POST['price'],"effective_date"=>$_POST['effective_date'],"product_id"=>$_POST['product_id'],"id"=>$_POST['id']);      
            $retval = $ctrl->editMaterial($_POST);

            if($retval){
                header("Location:".BASE_LINK_URL."?page=viewmaterial");
            }
            else{
                $_SESSION['value_array'] = $_POST;
                $_SESSION['error_array'] = $form->getErrorArray();
                header("Location:".$ctrl->referrer);				
            }

        }else{

            $data = $database->getMaterialById($_GET['id']);
            $form->setValue('name',$data['name']);            
            $form->setValue('unit',$data['unit']);          
                }
            //$unit = $database->getUnit();
            $unit; 
            if($form->value('unit') == 'ltr')
                $unit = array("ltr"=>"selected","kg"=>"");
            else
                $unit = array("ltr"=>"","kg"=>"selected");

            $str .="<div id='heading'> <h3>Edit Raw Material</h3></div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Name :</div><div class='act_obj'> <input type='text' name='name' value=\"{$form->value('name')}\" /></div><div class='err_msg'>{$form->error('name')}</div></div>
                <div class='form_row'><div class='label'>Unit :</div><div class='act_obj'> <select name='unit'>
                                <option value='ltr' {$unit['ltr']}>ltr</option>
                                <option value='kg' {$unit['kg']}>kg</option>
                            </select></div><div class='err_msg'>{$form->error('unit')}</div></div>
                <div><input type='hidden' value='{$_GET['id']}' name='id'/></div>
                <div><input type='hidden' value='1' name='edit'/></div>
                <div><input type='submit' value='edit' name='submit'/></div>
                </form></div>";
            return $str;

    }    

?>
