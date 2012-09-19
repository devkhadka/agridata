<?php
function list_products(){
$ret="";
Page::$jslink=array('js/ajaxtabs.js','facebox.css');
Page::$csslink=array('css/ajaxtabs.css' , 'facebox.css','css/product_popup.css');
$ret.=<<<EOT
<style> 
#column_w610{
width:89%;
}
#countrydivcontainer a{
    color:#000000;
}
</style>
<div class="header_01">Products!</div>
<ul id="countrytabs" class="shadetabs">
<li><a href="ajax/getProductItems.php?pname=microneutrients" class="selected" rel="countrycontainer">Micronutrients</a></li>
<li><a href="ajax/getProductItems.php?pname=plantGrowthPromoter" rel="countrycontainer">Plant growth promoter</a></li>
<li><a href="ajax/getProductItems.php?pname=macroFertilizer" rel="countrycontainer">Macro fertilizers</a></li>
<li><a href="ajax/getProductItems.php?pname=antibiotics" rel="countrycontainer">Antibiotics</a></li>
<li><a href="ajax/getProductItems.php?pname=botanicalpesticides" rel="countrycontainer">Botanical pesticides & fungicides</a></li>
<li><a href="ajax/getProductItems.php?pname=biofertilizer" rel="countrycontainer">Bio fertilizers</a></li>
<li><a href="ajax/getProductItems.php?pname=wettingagents" rel="countrycontainer">Wetting agents</a></li>
<li><a href="ajax/getProductItems.php?pname=biostimulant" rel="countrycontainer">Bio stimulant</a></li>
</ul>
<div id="countrydivcontainer" style="border:1px solid gray; height: 220px; width:755px; margin-bottom: 1em; padding: 10px">
</div>
<script type="text/javascript">
var countries=new ddajaxtabs("countrytabs", "countrydivcontainer")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()
    countries.onajaxpageload=function(pageurl){
      $('a[rel*=facebox]').facebox() 
    }
</script><div></div>
EOT;
return $ret;

}
?>
