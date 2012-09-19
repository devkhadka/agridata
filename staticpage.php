<?php
function getFooterContent(){
    $footer   = file_get_contents('./template/footer.html');
    //$footer   = preg_replace("/[\\]/i",'',$footer);
    return $footer;

}
function getHeaderContent(){
    $header = file_get_contents('./template/header.html');
    //$header= preg_replace("/\\/i",'',$header);
    return $header;
}
function getMainMenu(){
    $pg=$_REQUEST['page'];
    switch($pg) {
    case '': $home="active";
            break;
    case 'expert-services': $es="active";
            break;
    case 'company': $com="active";
            break;
    case 'innovation': $innv="active";
            break;
    case 'list_products': $prod="active";
            break;
    case 'industries': $ind="active";
            break;
    default: $home='active';
            break;
    }

    $menu.=<<<EOT
        <div id="mainmenu">
            <ul>
                <li class="first" id={$home}><a href="agricare.php">Home</a></li>
                 <li id={$prod}><a href="?page=list_products&type=dyn">Products</a></li>
				<li id={$innv}><a href="?page=innovation">Innovation</a></li>
				<li id={$es}><a href="?page=expert-services&type=dyn">Ask the Experts</a></li>					
            </ul>
        </div><!-- end of menu --> 
EOT;
    return $menu;
}
function getProjectsContent(){
    $project = file_get_contents('./template/project.html');
    //$project = eregi_replace("[\]",'',$project);
    return $project;
}
function getMainContent(){
    $pg=$_REQUEST['page'];
    $pghtm='home';
    switch($pg) {
    case '': $pghtm="home";
            break;
    //case 'expert-services': $pghtm="es";
      //      break;
    case 'company': $pghtm="company";
            break;
    case 'innovation': $pghtm="innovation";
            break;
    case 'products': $pghtm="products";
            break;
    case 'industries': $pghtm="industries";
            break;
    default: $pghtm='home';
            break;
    }
    $content = file_get_contents("./template/{$pghtm}.html");
    //$contnet  = eregi_replace("[\]",'',$content);
    return $content;
}
function getSidebarContent(){
    $sidebar = file_get_contents('./template/sidebar.html');
    //$sidebar =eregi_replace("[\]",'',$sidebar);
    return $sidebar;
}
//echo  getProjectsContent();
?>
