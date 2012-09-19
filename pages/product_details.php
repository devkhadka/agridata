<?php
    function viewProductDetails(){
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
        $url = "./ajax/productdetail.php";
        $baseLinkUrl = BASE_LINK_URL;
        $addParamE = "&page=editproductdetails";
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
                colNames:['SN','Name', 'Order','Description','Active','-','-'],
                colModel :[ 
                {name:'id', index:'id', width:25,sortable:false}, 
                {name:'name', index:'name', width:120, align:'left',sorttype:'text'}, 
                {name:'order', index:'order', width:50, align:'center',sortable:false}, 
                {name:'description', index:'description', width:160, align:'left',sortable:false}, 
                {name:'active', index:'active', width:50, align:'center',sortable:false}, 
                {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}}, 
                {name:'b', index:'b', width:20, align:'center', sortable:false} 
                ],
                pager: '#pager',
                rowNum:8,
                    width:600,
                    height:175,
                    hidegrid:false,
                rowList:[10,20,30],
                sortname: 'name',
                sortorder: '',
                viewrecords: true,
                imgpath: '',
                caption: 'Products List',
                editurl:'./ajax/product.php?msg=del',
                onCellSelect: function(ids,colid) {
                    //alert(ids+colid+content+jQuery(this).getCell(ids,colid));
                    if(colid == 6){
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
    function addProductDetails(){
        global $form,$ctrl,$database,$user;
        define("REQ_LEVEL",9);
        if($user->level!= REQ_LEVEL) return UN_AUTH;

        $str;

        if(isset($_SESSION['addDetailsSuccess'])){
            unset($_SESSON['addDetailsSuccess']);
            $str.= "<div class='notice'>Data Entered Successfully !!</div>";
        }

        if(isset($_POST['add'])){

            $product_name = $database->getProductName($_POST['product_id']);
        
            if(is_uploaded_file($_FILES['product_img']['tmp_name'])){
                if($_FILES['product_img']['type'] =="image/jpeg" ||$_FILES['product_img']['type'] =="image/gif" || $_FILES['product_img']['type'] =="image/png"){
                    $ext = findexts ($_FILES['product_img']['name']) ; 
                    $target = "image/".$product_name['name']."_".time().".".$ext;

                    include('./include/class.resizeimage.php');
                    $image = new ResizeImage();
                    $image->load($_FILES['product_img']['tmp_name']);
                    $image->resize(IMG_WIDTH,IMG_HEIGHT);
                    $image->save($target); 

                    $retval = $ctrl->addProductDetails($_POST,$target);

                    if($retval){
                        $_SESSION['addDetailsSuccess'] = true;
                        header("Location:".$ctrl->referrer);				
                    }
                    else{
                        $_SESSION['value_array'] = $_POST;
                        $_SESSION['error_array'] = $form->getErrorArray();
                        header("Location:".$ctrl->referrer);				
                    }

                }else{
                    $form->setError("product_img", "* File format not supported");
                    $_SESSION['value_array'] = $_POST;
                    $_SESSION['error_array'] = $form->getErrorArray();
                    header("Location:".$ctrl->referrer);				
                }
            } 
                    
            
        } else {


            $product = $database->getProduct();

            $action;
            if(!$form->value('active')){
                $action = array('no'=>"checked",'yes'=>"");
            }else{
                if($form->value('active') == 'n')
                    $action = array('no'=>"checked",'yes'=>"");
                else
                    $action = array('no'=>"",'yes'=>"checked");
            }

            $str .="<div id='heading'><h3> Add Product Details </h3> </div>
                <div><form method='POST' ENCTYPE='multipart/form-data' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Product :</div><div class='act_obj'> <select name='product_id'>";
            foreach($product as $key){
                $selected = "";
                if($key['id'] == $form->value('product_id'))
                    $selected = "selected";
                $str .= "<option value='{$key['id']}' {$selected}>{$key['name']} ({$key['quantity']} {$key['unit_name']})</option>";
            }            
            $str .="</select></div><div class='err_msg'>{$form->error('product_id')}</div></div>
                <div class='form_row'><div class='label'>Order:</div><div class='act_obj'> <input type='text' name='order' size='5' value=\"{$form->value('order')}\" /></div><div class='err_msg'>{$form->error('order')}</div></div>
                <div class='form_row'><div class='label'>Image:</div><div class='act_obj'> <input type='file' name='product_img'  value=\"{$form->value('product_img')}\" /></div><div class='err_msg'>{$form->error('product_img')}</div></div>
                <div class='form_row'><div class='label'>Description:</div><div class='act_obj'> <textarea rows='4' cols='20' name='description'>{$form->value('description')}</textarea></div><div class='err_msg'>{$form->error('description')}</div></div>
                <div class='form_row'><div class='label'>Active :</div><div class='act_obj'> <input type='radio' value='y' name='active' {$action['yes']}>Yes &nbsp;&nbsp;
                <input type='radio' value='n' name='active' {$action['no']}>No</div></div>
                <div><input type='hidden' name='add'></div>
                <div><input type='submit' value='Add' name='submit'></div>      
                </form></div>";
            return $str;
        }

    }

    function editProductDetails(){
        global $form,$ctrl,$database,$user;
        define("REQ_LEVEL",9);
        if($user->level!= REQ_LEVEL) return UN_AUTH;

        $str;

        if(isset($_SESSION['editDetailsSuccess'])){
            unset($_SESSON['editDetailsSuccess']);
            $str.= "<div class='notice'>Data Updated Successfully !!</div>";
        }

        if(isset($_POST['edit'])){

            if($_FILES['product_img']['name'] == ""){
                
                    $retval = $ctrl->editProductDetails($_POST,"");

                    if($retval){
                        $_SESSION['editDetailsSuccess'] = true;
                        header("Location:".$ctrl->referrer);				
                    }
                    else{
                        $_SESSION['value_array'] = $_POST;
                        $_SESSION['error_array'] = $form->getErrorArray();
                        header("Location:".$ctrl->referrer);				
                    }
            }else{
                $product_name = $database->getProductName($_POST['product_id']);
            
                if(is_uploaded_file($_FILES['product_img']['tmp_name'])){
                    if($_FILES['product_img']['type'] =="image/jpeg" ||$_FILES['product_img']['type'] =="image/gif" || $_FILES['product_img']['type'] =="image/png"){
                        $ext = findexts ($_FILES['product_img']['name']) ; 
                        $target = "image/".$product_name['name']."_".time().".".$ext;

                        include('./include/class.resizeimage.php');
                        $image = new ResizeImage();
                        $image->load($_FILES['product_img']['tmp_name']);
                        $image->resize(IMG_WIDTH,IMG_HEIGHT);
                        $image->save($target); 

                        $retval = $ctrl->editProductDetails($_POST,$target);

                        if($retval){
                            $_SESSION['editDetailsSuccess'] = true;
                            header("Location:".$ctrl->referrer);				
                        }
                        else{
                            $_SESSION['value_array'] = $_POST;
                            $_SESSION['error_array'] = $form->getErrorArray();
                            header("Location:".$ctrl->referrer);				
                        }

                    }else{
                        $form->setError("product_img", "* File format not supported");
                        $_SESSION['value_array'] = $_POST;
                        $_SESSION['error_array'] = $form->getErrorArray();
                        header("Location:".$ctrl->referrer);				
                    }
                } 
                
            }
            
            //die();
            
                    
            
        } else {

            $data = $database->getProductDetailsById($_GET['id']);
            $product = $database->getProduct();

            $form->setValue('product_id',$data['product_id']);            
            $form->setValue('order',$data['order']);          
            $form->setValue('description',$data['description']);
            $form->setValue('price',$data['price']);          
            
            $action;
            if($data['active'] == 'n')
                $action = array('no'=>"checked",'yes'=>"");
            else
                $action = array('no'=>"",'yes'=>"checked");

            $str .="<div id='heading'><h3> Edit Product Details </h3> </div>
                <div><form method='POST' ENCTYPE='multipart/form-data' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Product :</div><div class='act_obj'> <select name='product_id'>";
            foreach($product as $key){
                $selected = "";
                if($key['id'] == $form->value('product_id'))
                    $selected = "selected";
                $str .= "<option value='{$key['id']}' {$selected} DISABLED>{$key['name']} ({$key['quantity']} {$key['unit_name']})</option>";
            }            
            $str .="</select></div><div class='err_msg'>{$form->error('product_id')}</div></div>
                <div class='form_row'><div class='label'>Order:</div><div class='act_obj'> <input type='text' name='order' size='5' value=\"{$form->value('order')}\" /></div><div class='err_msg'>{$form->error('order')}</div></div>
                <div class='form_row'><div class='label'>Image:</div><div class='act_obj'> <input type='file' name='product_img'  value=\"{$form->value('product_img')}\" /></div><div class='err_msg'>{$form->error('product_img')}</div></div>
                <div class='form_row'><div class='label'>Description:</div><div class='act_obj'> <textarea rows='4' cols='20' name='description'>{$form->value('description')}</textarea></div><div class='err_msg'>{$form->error('description')}</div></div>
                <div class='form_row'><div class='label'>Active :</div><div class='act_obj'> <input type='radio' value='y' name='active' {$action['yes']}>Yes &nbsp;&nbsp;
                <input type='radio' value='n' name='active' {$action['no']}>No</div></div>
                <div><input type='hidden' name='edit'></div>
                <div><input type='submit' value='Edit' name='submit'></div>      
                </form></div>";
            return $str;
        }

    }
    
    function findexts($filename)
    {
        $filename = strtolower($filename) ;
        $exts = split("[/\\.]", $filename) ;
        $n = count($exts)-1;
        $exts = $exts[$n];
        return $exts;
    } 
?>
