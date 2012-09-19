<?php 
function manageUser(){
    global $ctrl, $form, $database;

    $levels=$database->getUserLevels();
    $ret="<div id='heading'> <h3> Manage User</h3> </div>"
            ."<div id='content'>";
    $ret.="
        <form>
        User level<select id='userlevel' name 'userlevel'>";
    foreach($levels as $level){
        $ret.="<option value={$level['access_value']}>{$level['name']} </option>";
        }
    $ret.="</select>
        </form>
        </div>";
    PAGE::$content= $ret;
}
?>
