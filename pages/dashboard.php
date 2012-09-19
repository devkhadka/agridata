<?php
function getDashboard(){

global $database;
$newslist=$database->getNews();

$str = <<<EOT
<div id="dashboard">
    <div id="left_sidebar">
        <ul >

            <li><a href="#"><div class='dash_header'>DUE Reports</div></a>
            
               <p> <b> <i> Umesh &  Bishnu </i> </b> has sales plan  & party stock due since Nov 1
               <p> <b><i> Bivek </i></b> has not checked into system since Nov 5
               <p> <b><i> Bishnu </i></b> has DCR report due since last 2 month.
               
               

            </li>
            <li ><div class='dash_header'>TADA</div>
                 <div class='header_05'> <a>Heighest </a></div>
                    <p>  <i> Umesh  </i> : 15000
                    <p> <i> Bishnu </i> : 14500
                 <div class='header_05'> <a >  Least  </a></div>
                 <p> <i> Bivek </i> : 1500
                <p>  <i> Bishnu </i> : 1800
            </li>
            <li ><div class='dash_header'>Party Stock</div>

            </li>
            <li ><div class='dash_header'>Sales Plan</div>
                     <div class='header_05'> <a>Heighest </a></div>
                    <p>  <i> Prabin  </i> : 200000
                    <p> <i> Shyam </i> : 150000
                 <div class='header_05'> <a >  Least  </a></div>
                 <p> <i> Ramesh </i> : 15000
                <p>  <i> Bivek </i> : 18000
            </li>
        </ul>
    </div>
    <div id="right_sidebar">
        <ul>
            <li >
                <div class='dash_header'>News and Events</div>
EOT;
foreach ($newslist as $news){
    $day= explode('_',$news['date']);
     $str.="<div class='news_section'>
              
                <div class='news_content'>
                    <div class='header_05'>
                        <a href='#'>{$news['title']}</a> [{$news['date']}]
                    </div>
                    <p>{$news['body']}</p>
                </div>
                <div class='cleaner'></div>
                </div>";
}

    $str.= <<<EOT
    </div>
        </li>
        </ul>
    </div>
</div>
EOT;
return  $str;
}

?>
