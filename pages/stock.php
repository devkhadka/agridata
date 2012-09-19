<?php

    function view(){
        global $database;
        print_r($database->viewStockTest());
        die();
    }

    function viewStock(){
        //global $database;
        //$str;

        //$data = $database->viewProduct();
        //print_r($data);
        $url = "./ajax/stock.php";
        $baseLinkUrl = BASE_LINK_URL;
        $addParamE = "&page=editstock";
        $addParamD = "&page=delstock";
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
                    colNames:['SN','Material', 'Total Stock'],
                    colModel :[ 
                    {name:'id', index:'id', width:25,sortable:false}, 
                    {name:'name', index:'name', width:120, align:'left',sorttype:'text'}, 
                    {name:'qty', index:'qty', width:50, align:'left',sortable:false}, 
                    ],
                    pager: '#pager',
                    rowNum:8,
                        width:500,
                        height:175,
                        hidegrid:false,
                    rowList:[10,20,30],
                    sortname: 'name',
                    sortorder: 'ASC',
                    viewrecords: true,
                    imgpath: '',
                    caption: 'Stock List',
                    onSelectRow: function(ids) {
                        if(ids == null) { 
                            ids=0; 
                            if(jQuery('#detail_list').jqGrid('getGridParam','records') >0 ) { 
                                jQuery('#detail_list').jqGrid('setGridParam',{url:'./ajax/stockdetail.php?q=1&id='+ids,page:1}); 
                                jQuery('#detail_list').jqGrid('setCaption','Invoice Detail: '+ids).trigger('reloadGrid');

                            } 
                        } else { 
                            jQuery('#detail_list').jqGrid('setGridParam',{url:'./ajax/stockdetail.php?q=1&id='+ids,page:1}); 


                            jQuery('#detail_list').jqGrid('setCaption','Stock Detail: '+ids).trigger('reloadGrid'); 
                        } 
                    } 
                });

                //jQuery('#list').jqGrid('navGrid','#pager',{add:false,edit:false,del:false});
                jQuery('#detail_list').jqGrid({ 
                    height: 100, 
                    url:'./ajax/stockdetail.php?q=1&id=0', 
                    datatype: 'xml', 
                    colNames:['SN','Date', 'Received Qty.','Issued Qty.','-','-'], 
                    colModel:[ 
                        {name:'sn',index:'sn', width:55,sortable:false}, 
                        {name:'ri_date',index:'ri_date', width:180,sortable:false}, 
                        {name:'rqty',index:'rqty', width:80, align:'right',sortable:false}, 
                        {name:'iqty',index:'iqty', width:80, align:'right',sortable:false}, 
                        {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'{$baseLinkUrl}', addParam: '{$addParamE}', idName:'{$idName}'}}, 
                        {name:'b', index:'b', width:20, align:'center', sortable:false} 
                    ], 
                    rowNum:5, 
                    rowList:[5,10,20], 
                    pager: '#pager_d', 
                    sortname: '', 
                    sortorder: 'desc', 
                    caption:'Stock Detail', 
                    editurl:'./ajax/stockdetail.php?msg=del',
                    onCellSelect: function(ids,colid) {
                        //alert(ids+colid+content+jQuery(this).getCell(ids,colid));
                        if(colid == 5){
                            var gr=jQuery(this).jqGrid('getGridParam','selrow');
                            if(gr !=null ){ 
                                jQuery(this).jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
                            }
                        }


                        //alert(ids);    
                    }
                })
    
                //jQuery('#detail_list').jqGrid('navGrid','#pager_d',{add:false,edit:false,del:false}); 


            }); 
            </script>
            <table id='list'></table> 
            <div id='pager'></div>
            <br />
            <table id='detail_list'></table> 
            <div id='pager_d'></div> 
            ";

            //echo $str;
            //die();
            Page::$content = $str;
//echo $str;
    }

    //viewStock();

    function addStock(){
        global $form,$ctrl,$database;
        $str;


        if($_SESSION['addstockSuccess']){
                unset($_SESSION['addstockSuccess']);
                $str.= "<div class='notice'>Data Update Successfully !!</div>";
                //$str.= "Data Entered Successfully !!";
        }
        
        if($_SESSION['stock_lag']){
            unset($_SESSION['stock_lag']);
            $str.= $_SESSION['lag_msg'];
            unset($_SESSION['lag_msg']);
        }        

        if(isset($_POST['add'])){

            //print_r($_POST);

            $retval = $ctrl->addStock($_POST);
            //echo $retval;
            //die();
            if(strcmp(gettype($retval),"boolean") == 0 && $retval){
                $_SESSION['addstockSuccess'] = true;
                header("Location:".$ctrl->referrer);				
            }
            else{
                if(strcmp(gettype($retval),"string") == 0){
                    
                    $_SESSION['stock_lag'] = true;
                    $_SESSION['lag_msg'] = $retval;
                }
                $_SESSION['value_array'] = $_POST;
                $_SESSION['error_array'] = $form->getErrorArray();
                header("Location:".$ctrl->referrer);				
            }

        }else{

            Page::$jslink=array('js/ui.core.js','js/ui.datepicker.js');
            Page::$csslink=array('css/ui.all.css');
            $material = $database->getMaterial();
            $action;
            if(!$form->value('action')){
                $action = array('receive'=>"checked",'issue'=>"");
            }else{
                if($form->value('action') > 0)
                    $action = array('receive'=>"checked",'issue'=>"");
                else
                    $action = array('receive'=>"",'issue'=>"checked");
                    
            }


            $str .="<div id='heading'><h3>Add Stock</h3></div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Date :</div><div class='act_obj'> <input type='text' name='ri_date' id='datepicker' size='10' value=\"{$form->value('ri_date')}\" /></div><div class='err_msg'>{$form->error('ri_date')}</div></div>
                <div class='form_row'><div class='label'>Material :</div> <select name='material_id'>";
                foreach($material as $key){
                    $selected ="";
                    if($key['id'] == $form->value('material_id'))
                        $selected = "selected";
                    $str .= "<option value='{$key['id']}' {$selected} >{$key['name']} ({$key['unit']})</option>";
                }
            
                $str .="</select></div><div class='err_msg'>{$form->error('material_id')}</div></div>
                <div class='form_row'><div class='label'>Action :</div><div class='act_obj'> <input type='radio' value='1' name='action' {$action['receive']}>Received &nbsp;&nbsp;
                <input type='radio' value='-1' name='action' {$action['issue']}>Issued</div><div class='err_msg'>{$form->error('action')}</div></div>
                <div class='form_row'><div class='label'>Qty. :</div><div class='act_obj'> <input type='text' name='qty' size='20' value=\"{$form->value('qty')}\" /></div><div class='err_msg'>{$form->error('qty')}</div></div>
                <div><input type='hidden' value='1' name='add'/></div>
                <div><input type='submit' value='Add' name='submit'/></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";
            return $str;
        }
    }

    function editStock(){
        
        global $database,$form,$ctrl;

        if($_SESSION['editstockSuccess']){
                unset($_SESSION['editstockSuccess']);
                //return "Data Update Successfully !!";
                $str.= "<div class='notice'>Data Update Successfully !!</div>";
        }
                
        if($_SESSION['stock_lag']){
            unset($_SESSION['stock_lag']);
            $str.= $_SESSION['lag_msg'];
            unset($_SESSION['lag_msg']);
        }        

        if(isset($_POST['edit'])){

            $retval = $ctrl->editStock($_POST);
            if(strcmp(gettype($retval),"boolean") == 0 && $retval){
                $_SESSION['editstockSuccess'] = true;
                header("Location:".$ctrl->referrer);				
            }
            else{
                if(strcmp(gettype($retval),"string") == 0){
                    
                    $_SESSION['stock_lag'] = true;
                    $_SESSION['lag_msg'] = $retval;
                }
                $_SESSION['value_array'] = $_POST;
                $_SESSION['error_array'] = $form->getErrorArray();
                header("Location:".$ctrl->referrer);				
            }

        }else{

            Page::$jslink=array('js/ui.core.js','js/ui.datepicker.js');
            Page::$csslink=array('css/ui.all.css');

            $material = $database->getMaterial();
            $data = $database->getStockById($_GET['id']);

            if(time()-strtotime($data['created_date']) > 43200)
                return "<div class='notice'>You can not edit this data because your time limit exceed 12 hr ask admin to edit it.</div>";

            $action = array('receive'=>"checked",'issue'=>"");
            if($data['qty'] > 0){
                $action = array('receive'=>"checked",'issue'=>"");
            }else{
               $action = array('receive'=>"",'issue'=>"checked");
            }
            //print_r($data);
            //echo $data['amount']."adsss";
            $form->setValue('ri_date',$data['ri_date']);            
            $form->setValue('material_id',$data['material_id']);          
            $form->setValue('qty',abs($data['qty']));
            $form->setValue('id',$_GET['id']);
            //$unit = $database->getUnit();
            $str .="<div>Edit Stock</div>
                <div><form method='POST' action='{$_SERVER['REQUEST_URI']}'>
                <div class='form_row'><div class='label'>Date :</div><div class='act_obj'> <input type='text' name='ri_date' id='datepicker' size='10' value=\"{$form->value('ri_date')}\" /></div><div class='err_msg'>{$form->error('ri_date')}</div></div>
                <div class='form_row'><div class='label'>Material :</div><div class='act_obj'> <select name='material_id'>";
                foreach($material as $key){
                    $selected ="";
                    if($key['id'] == $form->value('material_id'))
                        $selected = "selected";
                    $str .= "<option value='{$key['id']}' {$selected} >{$key['name']} ({$key['unit']})</option>";
                }
            
                $str .="</select></div><div class='err_msg'>{$form->error('material_id')}</div></div>
                <div class='form_row'><div class='label'>Action :</div><div class='act_obj'> <input type='radio' value='1' name='action' {$action['receive']}>Received &nbsp;&nbsp;
                <input type='radio' value='-1' name='action' {$action['issue']}>Issued</div><div class='err_msg'>{$form->error('action')}</div></div>
                <div class='form_row'><div class='label'>Qty. :</div><div class='act_obj'> <input type='text' name='qty' size='20' value=\"{$form->value('qty')}\" /></div><div class='err_msg'>{$form->error('qty')}</div></div>
                <div><input type='hidden' value=\"{$form->value('id')}\" name='id'/></div>
                <div><input type='hidden' value='1' name='edit'/></div>
                <div><input type='submit' value='Edit' name='submit'/></div>
                </form></div>
                <script type='text/javascript'>
                $(document).ready(function(){
                    $('#datepicker').datepicker({dateFormat:'yy-mm-dd'});
                        });
                </script>";

            return $str;
        }

        function mviewStock(){
            //global $database;
            //$str;

            //$data = $database->viewProduct();
            //print_r($data);
            $url = "./ajax/stock.php";
            $baseLinkUrl = BASE_LINK_URL;

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
                        colNames:['SN','Material', 'Total Stock'],
                        colModel :[ 
                        {name:'id', index:'id', width:25,sortable:false}, 
                        {name:'name', index:'name', width:120, align:'left',sorttype:'text'}, 
                        {name:'qty', index:'qty', width:50, align:'left',sortable:false}, 
                        ],
                        pager: '#pager',
                        rowNum:8,
                            width:500,
                            height:175,
                            hidegrid:false,
                        rowList:[10,20,30],
                        sortname: 'name',
                        sortorder: 'ASC',
                        viewrecords: true,
                        imgpath: '',
                        caption: 'Stock List',
                        onSelectRow: function(ids) {
                            if(ids == null) { 
                                ids=0; 
                                if(jQuery('#detail_list').jqGrid('getGridParam','records') >0 ) { 
                                    jQuery('#detail_list').jqGrid('setGridParam',{url:'./ajax/stockdetail.php?q=1&id='+ids,page:1}); 
                                    jQuery('#detail_list').jqGrid('setCaption','Invoice Detail: '+ids).trigger('reloadGrid');

                                } 
                            } else { 
                                jQuery('#detail_list').jqGrid('setGridParam',{url:'./ajax/stockdetail.php?q=1&id='+ids,page:1}); 


                                jQuery('#detail_list').jqGrid('setCaption','Stock Detail: '+ids).trigger('reloadGrid'); 
                            } 
                        } 
                    });

                    //jQuery('#list').jqGrid('navGrid','#pager',{add:false,edit:false,del:false});
                    jQuery('#detail_list').jqGrid({ 
                        height: 100, 
                        url:'./ajax/stockdetail.php?q=1&id=0', 
                        datatype: 'xml', 
                        colNames:['SN','Date', 'Received Qty.','Issued Qty.'], 
                        colModel:[ 
                            {name:'sn',index:'sn', width:55,sortable:false}, 
                            {name:'ri_date',index:'ri_date', width:180,sortable:false}, 
                            {name:'rqty',index:'rqty', width:80, align:'right',sortable:false}, 
                            {name:'iqty',index:'iqty', width:80, align:'right',sortable:false} 
                        ], 
                        rowNum:5, 
                        rowList:[5,10,20], 
                        pager: '#pager_d', 
                        sortname: '', 
                        sortorder: 'desc', 
                        caption:'Stock Detail' 
                    })
        
                    //jQuery('#detail_list').jqGrid('navGrid','#pager_d',{add:false,edit:false,del:false}); 


                }); 
                </script>
                <table id='list'></table> 
                <div id='pager'></div>
                <br />
                <table id='detail_list'></table> 
                <div id='pager_d'></div> 
                ";

                //echo $str;
                //die();
                Page::$content = $str;
        }
    }    

?>
