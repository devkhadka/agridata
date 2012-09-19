<?php

function gridtest() {

//<link rel='stylesheet' type='text/css' media='screen' href='css/redmond/jquery-ui-1.7.1.custom.css' />
//<link rel='stylesheet' type='text/css' media='screen' href='css/ui.jqgrid.css' />
//<script src='js/jquery-1.3.2.min.js' type='text/javascript'></script>
//<script src='js/i18n/grid.locale-en.js' type='text/javascript'></script>
//<script src='js/jquery.jqGrid.min.js' type='text/javascript'></script>
    Page::$jslink = array('js/i18n/grid.locale-en.js', 'js/jquery.jqGrid.min.js');
    Page::$csslink = array('css/redmond/jquery-ui-1.7.1.custom.css', 'css/ui.jqgrid.css');
    global $database;
    $mgrs = $database->getManagerUserList();
    $mgSelValues;
    foreach ($mgrs as $mg) {
        $mgSelValue.=$mg['id'] . ":" . $mg['username'] . ";";
    }
    $mgSelValue = "0:none;" . $mgSelValue;
//echo $mgSelValue."<br>";

    $mgSelValue = substr_replace($mgSelValue, '', -1, 1);
//echo $mgSelValue."<br>";


    $headqs = $database->getHeadquarterList();
    $headqss;
    foreach ($headqs as $hq) {
        $headqss.=$hq['id'] . ":" . $hq['name'] . ";";
    }
    $headqss = substr_replace($headqss, '', -1, 1);
    //echo $headqss;
    //die();

    $levels = $database->getUserLevels();
    $levelValues;
    foreach ($levels as $level) {
        $levelValues.=$level['access_value'] . ":" . $level['name'] . ";";
    }
    $levelValues = substr_replace($levelValues, '', -1, 1);
    $str = "
<script type='text/javascript'>
jQuery(document).ready(function(){ 
    var lastSelected;
  jQuery('#list').jqGrid({
    url:'./ajax/userinfo.php',
    datatype: 'xml',
    mtype: 'GET',
    colNames:['Username','Full name', 'Manager','level','Password'],
    colModel :[ 
      {name:'username', index:'username', width:60}, 
      {name:'name', index:'name', width:80 }, 
      {name:'manager_name', index:'manager_name', width:60,editable: true,edittype:'select',editoptions:{value:'{$mgSelValue}'}},
      {name:'level', index:'level', width:60, editable: true,edittype:'select',editoptions:{value:'{$levelValues}'}},
      {name: 'passwd',width:40,editable:true} 
    ],
    pager: '#pager',
    rowNum:8,
    width:650,
    height:250,
    hidegrid:false,
    rowList:[10,20,30],
    sortname: 'username',
    sortorder: 'desc',
    viewrecords: true,
    imgpath: '',
    caption: 'User list',
    editurl:'./ajax/userinfo.php?msg=edituser'
       
  }); 
jQuery('#deluser').click(function(){
    var gr=jQuery('#list').jqGrid('getGridParam','selrow');
    if(gr !=null ){ jQuery('#list').jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
    }
});
jQuery('#edituser').click(function(){
    if(this.value=='Edit user'){
    var gr=jQuery('#list').jqGrid('getGridParam','selrow');
    if(gr !=null){ jQuery('#list').jqGrid('editRow',gr);
    this.value='save';
    lastSelected=gr;
}
}
else if(this.value='save')
{
   //var gr=jQuery('#list').jqGrid('getGridParam','selrow');
    //alert(gr);
     if(lastSelected){
      jQuery('#list').jqGrid('saveRow',lastSelected,checksave);
this.value='Edit user';
}
}
});
function checksave(result) {
    //alert('i m checksave function');
    if (result.responseText=='')
    {
        alert('Update is missing!'); return false;
} 
else{
    //alert('i got some response text');
    jQuery('#list').trigger('reloadGrid');
}
return true; 
} 
}); 
</script>
<div id='heading'><h3 style='float:left'>View Team</h3><a href='?page=adduser'><div id='linking'>Add User</div></a><br/><br/></div>
<table id='list'></table> 
<div id='pager'></div>
<br>
<input type='button' id='deluser' value='Delete user' class='buttonn'/>
<input type='button' id='edituser' value='Edit user' class='buttonn'/>
";
    Page::$content = $str;
}
?>
