<?php
function list_products_info(){
$ret="";
/*
if(isset($_POST['submit']) && $_POST['submit']=="submit"){
	$ret.="<div id='notice'> Thank you </div> <br />";
} 
*/
//Page::$jslink=array('js/jquery-latest.js','js/jquery.validate.js');
	$val=$_REQUEST['val'];

	
{
$Agrolive="<h3>AGROLIVE</h3> Agrolive is balance micronutrients for optimum growth and high yield of crops. 
<br><br><b>Preparation of spray solution:</b> Dissolve 250 ml.Agroliv  in 100 lit. water thus prepare 300 lit. solution and spray over 1.5 acre(Approx) of standing crops. Both surface of leaves should be drenched properly.<br><br><b>Cereals:</b> 1st spray 3 to 4 weeks after sowing of transplantation.2nd spray 2 to 3 weeks after 1st spray.<br><br><b>Oilseeds/pulses & vegetable:</b> 1st spray: 3 to 5 weeks after sowing or transplantation.<br><br><b> 2nd spray:</b> 2 to 3 weeks after 1st spray.
<br><br><b>Fruits and other crops:</b> 2 sprays during 2-3 leaf stage or suitably during peak growth period
<br><br><b>Agroliv:</b> can be used with all types of pesticides or fungicides excepts chemicals that produce alkalinity.
<br><br><b>Caution:</b> Use the solution immediate after preparation. After spraying, wash hands and contaminated parts of the body and sprayers as well.
<img src='image/products_image/Agroliv.jpg' alt='Agroliv' width='180' height='130' />";


}	
	
	
	
	
{

$Agirguard="<h3>AGRIGUARD</h3> Agirguardis a systemic botanical insecticide prepared from alkaloids  derived from selected herbs .All the alkaloids are physiologically 
active and effectively control infestations of pests like sucking and chewing pests ,caterpillar , thrips , aphids and jassids.<br> 
AGRIGUARD attacks the central nervous system of the insects and increases  excitability , reduces eating activity, disturbing entire physiological coordination   results death of insects.<br><b> CROP:</b>   Paddy & other cereal crops, oil seeds, vegetables, Pulses, Flower, Fruits and tea                                                                             <br><b>Mode of application:</b>  2ml per Lit. water is recommended
<br><br><b>CAUTION:</b> Use the solution immediate after preparation. Do not store it for longer time. After spraying, wash hands and contaminated parts of the body and sprayer as well. Keep away 
from children and pets. Keep away from direct sun light. 
  
<br><br><b>Presentation:</b>  50 ml, 100 ml. 250 ml, 500 ml.
<img src='image/products_image/Agroliv.jpg' alt='Agroliv' width='180' height='130' />";
}

{
$Biojeb="<h3> BIOJEB (BOTANICAL FUNGICIDE)</h3>Biojeb is a botanical based fungicide. It contains a complex of physiologically active alkaloids isolated from selective Himalayan herbs .Biojeb can control effectively leaf blight, wilt, rots ,powdery mildew etc. It can be applied on the crops like Paddy, Soybean ,Tea, Potato, Onion, Garlic, Brinjal , Chilli, Tomato ,Fruits like Mango ,Grapes, Oil seeds and on the flower plants specially on Rose. 
<br><br><b>Composition: </b>
<br>Complex of Alkaloid................8.0% 
<br>Surface active agents..............24.0% 
<br> Plant protein Hydrolyser..........18%
<br> Other.............................50.0% 
<br>Total :  ..........................100.0% 
<br><br><b>Mode of application:</b> 1-2 ml per Lit. of water is recommended. On heavy fungal infestations, the dose may be increased. Biojeb can be used with other  chemical pesticide or fungicide .Biojeb is non phototoxic and  non toxic to human ,birds ,earth worms or animals. It does not leave any residual effect on leafs after application.<img src='image/products_image/Biojeb.jpg' alt='Biojeb' width='400' height='500' />" ;
 }
 {	
$Agroliv_potato_special="
<h3>Agroliv_potato_special</h3>
<br><b>Nutrients contents on % basis</b>
<br><br>Zinc...............6.00%
<br>Manganese..........2.50%<br>
Molybdenum.........0.03%<br>
Potash.............5.00%<br>
Phosphorus.........5.00%<br>
Boron..............1.50%<br>
Copper.............0.25%<br>
Nitrogen...........5.00%<br>
Sulphur............4.00%
<br><br><b>Method of use:</b><br>
For soil application: Apply 10kg-15kg of Agroliv potato special per hector (500 gm-750gm per 1.5 katha) at the time of sowing 
<br>As foliar spray: 500 gm Agroliv potato special is to be dissolved in 200 lit. of water and spray on both the surface of the leaves.
<br>Agroliv potato special: (powder) or Agroliv liquid foilar spray can be mixed with fungicides & insecticides.
<br>1st .Spray: 34-40 days after germination
<br>2nd .Spray: 15-20 days after 1st spray
<img src='image/products_image/AgrolivPotatoSpl.jpg' alt='Agroliv potato special' width='400' height='500' />";




}	
	
	
	
	
	
$ret.=$$val;


return $ret;























}
?>