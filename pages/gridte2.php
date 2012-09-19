<?php
function getGrid(){
$str="
<link rel='stylesheet' type='text/css' media='screen' href='css/redmond/jquery-ui-1.7.1.custom.css' />
<link rel='stylesheet' type='text/css' media='screen' href='css/ui.jqgrid.css' />
<script src='js/jquery-1.3.2.min.js' type='text/javascript'></script>
<script src='js/i18n/grid.locale-en.js' type='text/javascript'></script>
<script src='js/jquery.jqGrid.min.js' type='text/javascript'></script>
 
<script type='text/javascript'>
jQuery(document).ready(function(){ 
  jQuery('#list').jqGrid({
    url:'./ajax/example2.php',
    datatype: 'xml',
    mtype: 'GET',
    colNames:['Id','Usernamr', 'Password','Created Date','-','-'],
    colModel :[ 
      {name:'id', index:'id', width:30}, 
      {name:'username', index:'username', width:80, align:'right'}, 
      {name:'password', index:'password', width:80, align:'right'}, 
      {name:'created_date', index:'created_date', width:80, align:'right'}, 
      {name:'a', index:'a', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'someurl.php', addParam: '&action=edit', idName:'myid'}}, 
      {name:'b', index:'b', width:20, align:'center', sortable:false, formatter:'showlink', formatoptions:{baseLinkUrl:'someurl.php', addParam: '&action=delete', idName:'id'}} 
    ],
    pager: '#pager',
    rowNum:8,
	width:500,
	height:150,
	hidegrid:false,
    rowList:[10,20,30],
    sortname: 'id',
    sortorder: 'desc',
    viewrecords: true,
    imgpath: '',
    caption: 'My first grid'
  }); 
}); 
</script>
<table id='list'></table> 
<div id='pager'></div> 
";
Page::$content = $str;
}
?>
