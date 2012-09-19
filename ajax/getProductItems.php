<?php
$product= $_GET['pname'];
$ret=<<<EOT

EOT;
if($product=='plantGrowthPromoter'){
    $ret.=<<<EOT
        <ul>
        <li><a href="#agrizyme" rel="facebox">Agrizyme</a></li>
        </ul>
        <div id="agrizyme" style="display:none">
       <iframe  width=600px height=350px src="public/agrizyme.html"> </iframe>
        </div>
EOT;
}
else if($product=='macroFertilizer')
{
    $ret.=<<<EOT

        <ul>
        <li><a href="#macroshakti202020" rel="facebox">macro shakti 20:20:20</a></li>
        <li><a href="#macroshakti191919" rel="facebox">macro shakti 19:19:19</a></li>
        </ul>
        <div id="macroshakti202020" style="display:none">
		
        </div>
        <div id="macroshakti191919" style="display:none">
        //content of macroshakti goes here;
        </div>
EOT;
}
else if($product=='antibiotics')
{
    $ret.=<<<EOT

        <ul>
        <li><a href="#agricin" rel="facebox">Agricin</a></li>
        </ul>
        <div id="agricin" style="display:none">
        <iframe  width=550px height=300px src="public/agricin.html"> </iframe>
        </div>
EOT;
}
else if($product=='botanicalpesticides')
{
    $ret.=<<<EOT

        <ul>
        <li><a href="#agriguard" rel="facebox">Agriguard</a></li>
        <li><a href="#biojeb" rel="facebox">Biojeb</a></li>
        </ul>
        <div id="agriguard" style="display:none">
         <iframe  width=650px height=350px src="public/agriguard.html"> </iframe>
        </div>
        <div id="biojeb" style="display:none">
       <iframe  width=700px height=450px src="public/biojeb.html"> </iframe>
        </div>
EOT;
}
else if($product=='wettingagents')
{
    $ret.=<<<EOT

        <ul>
        <li><a href="#sticker" rel="facebox">Sticker </a></li>
        </ul>
        <div id="sticker" style="display:none">
        <iframe  width=650px height=350px src="public/sticker.html"> </iframe>
        </div>
EOT;
}
else if($product=='biostimulant')
{
    $ret.=<<<EOT

        <ul>
        <li><a href="#poshan" rel="facebox">Poshan </a></li>
        <li><a href="#poshanplus" rel="facebox">Poshan Plus </a></li>
        <li><a href="#agrinol" rel="facebox">Agrinol</a></li>
        <li><a href="#agrinolplus" rel="facebox">Agrinol Plus </a></li>
        </ul>
        <div id="poshan" style="display:none">
       <iframe  width=650px height=350px src="public/poshan.html"> </iframe>
        </div>
        <div id="poshanplus" style="display:none">
      	<iframe  width=650px height=350px src="public/poshanPlus.html"> </iframe>
        </div>
        <div id="agrinol" style="display:none">
        <iframe  width=600px height=350px src="public/agrinol.html"> </iframe>
        </div>
        <div id="agrinolplus" style="display:none">
       <iframe  width=600px height=400px src="public/agrinolPlus.html"> </iframe>
        </div>
EOT;
}
else if($product=='microneutrients')
{
    $ret.=<<<EOT

        <ul>
        <li><a href="#agroliv" rel="facebox"> Agroliv </a></li>
        <li><a href="#agrolivpotatoesp" rel="facebox">Agroliv potato special  </a></li>
        <li><a href="#agrolivcolecropesp" rel="facebox">Agroliv cole crop special </a></li>
        <li><a href="#chelazin" rel="facebox">Chelazin</a></li>
        <li><a href="#agrizinplus" rel="facebox">Agrizin Plus</a></li>
        <li><a href="#agrolivwithnpk" rel="facebox">Agroliv with NPK</a></li>
        <li><a href="#borom" rel="facebox">Boro-M</a></li>
        <li><a href="#calminb" rel="facebox">Calmin-B</a></li>
        </ul>
        <div id="agroliv" style="display:none">
       <iframe  width=750px height=450px src="public/agroliv.html"> </iframe>
        </div>
        <div id="agrolivpotatoesp" style="display:none">
       <iframe  width=770px height=500px src="public/agroliv_potato_spe.html"> </iframe>
        </div>
        <div id="agrolivcolecropesp" style="display:none">
         <iframe  width=750px height=500px src="public/agroliv_colecrop_spe.html"> </iframe>
        </div>
        <div id="chelazin" style="display:none">
        <iframe  width=650px height=300px src="public/chelazin.html"> </iframe>
        </div>
        <div id="agrizinplus" style="display:none">
          <iframe  width=650px height=300px src="public/agrizinplus.html"> </iframe>
        </div>
        <div id="agrolivwithnpk" style="display:none">
			<iframe  width=850px height=500px src="public/agrolivWithNHK.html"> </iframe>
        </div>
        <div id="borom" style="display:none">
			<iframe  width=750px height=400px src="public/boroM.html"> </iframe>
        </div>
        <div id="calminb" style="display:none">
		<iframe  width=850px height=500px src="public/calminB.html"> </iframe>
        </div>
EOT;
}
else
{
    $ret.=<<<EOT
        <ul>
        <li>Product under process!!!</li>
        </ul>

EOT;

}



echo $ret;
?>
