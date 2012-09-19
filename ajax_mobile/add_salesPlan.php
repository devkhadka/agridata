<?php
include("../include/database.php");
session_start();
$party_id = $_GET['party_id'];
$products = $database->getProduct();
//var_dump($products);
//echo count($products);
$i=0 ;
foreach($products as $count=>$product){
$i++;
    $html .= "<div class='row'>{$i}. <b>{$product['name']} ({$product['quantity']} {$product['unit_name']})</b><input type='hidden' name='product_id{$count}' value='{$product['id']}'/></div>";
    $stock = $database->getPartyStock($party_id,$product['id']);
//    $html .= $party_id." ".$product['id']."<br>";
        if(is_array($stock) && count($stock)){
        
            $html.= "<div class='row'><b>Stock :</b> &nbsp;".$stock[0]['no_of_case']." case / ".$stock[0]['indivisual']." pcs. </div>";
    }else{
        $html .= "<div class='row'><b>Stock :</b> &nbsp;0 case / 0 pcs. </div>";
    }

    $html .= "<div class='row'><b>Plan :</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='plan_case{$count}' size='5' /> case / <input type='text' name='plan_individual{$count}' size='5'/> pcs.</div>";
    $html .= "<div class='row'><b>Discount :</b>&nbsp;<input type='text' name='discount_case{$count}' size='5' /> case / <input type='text' name='discount_individual{$count}' size='5'/> pcs.</div>";
    if($count < count($products)){
                $html .= "<div class='line-separator'></div>";
            }
}
$html .= "<div><input type='hidden' name='add'><input type='hidden' name='count' value='{$count}' /></div>";
echo $html;
?>