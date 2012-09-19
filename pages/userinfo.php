<?php
function getUserProfileInfo(){
    global $user,$database;
    $infos= $database->getUserProfileInfo();
    $paymethod=$infos['paymentmode'];
    if($paymethod=="visa_card" || $paymethod=="master_card")
        $accountInfo=$database->getCreditCardInfo();
    else if($paymethod=="paypal")
        $accountInfo= $database->getPaypalAccInfo();
    else if($paymethod=="bank_draft")
        $accountInfo=$database->getBankDraftInfo();
    $ret= "Your Email is {$user->username} <br/>"
        ."Your level is {$user->userlevel}"; 
    $keys= array_keys($infos);
for($i=0;$i< sizeof($infos); $i++)
    $ret.="<br/>". $keys[$i]. "   : \t ". $infos[$keys[$i]];
    $keys=array_keys($accountInfo);
for($i=0;$i< sizeof($accountInfo); $i++)
    $ret.="<br/>". $keys[$i]. "   : \t ". $accountInfo[$keys[$i]];
    return $ret;

}
?>
