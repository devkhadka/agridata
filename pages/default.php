<?php
function defaultContent(){
    global $user,$database;
    if($user->userlevel<1){
        return " <h2 class='title'> Welcome </h2>
            <div class='content'>
            <p>welcome to the new world of security. Your home now gonna be the safest place. No one can break your home and you can alwyas monitor your home on the go or on the sleep</div>";
    }
    else if($user->userlevel==1)
    {
        $ret;
        global $form;
        $ret.= "<h2 class='title'> Profile Information </h2>
            <div class='content'>To complete the account setup you need to fill the fillowing forms";
        $ret.="<form method='POST' action='process.php'>
            <p> Street address 1 : <input type='text' name='streetAdd1' value='{$form->value('streetAdd1')}'>{$form->error('streetAdd1')}
            <p> Street address 2 : <input type='text' name='streetAdd2' value='{$form->value('streetAdd2')}'>{$form->error('streetAdd2')}
            <p> City : <input type='text' name='city' value='{$form->value('city')}'>{$form->error('city')}
            <p> State : <input type='text' name='state' value='{$form->value('state')}'>{$form->error('state')}
            <p> zip : <input type='text' name='zip' value='{$form->value('zip')}'>{$form->error('zip')}
            <p> Country : <input type='text' name='country'  value='{$form->value('country')}'>{$form->error('country')}
            <p>  Mobile : <input type='text' name='mobile' value='{$form->value('mobile')}'>{$form->error('mobile')}
            <p> <input type ='checkbox' name='help_setupCamera' value='yes'> help me setup my camera
            <p><input type='hidden' value= '1' name='addProfile'>";
        //payment part
        if($form->value('payment_method')!='')
        { 
            if($form->value('payment_method')=='visa_card'){
            $visacard="selected";
            $displayCard="";
            $displayBankDraft="display:none";
            $displayPaypal="display:none";
        }
        else if($form->value('payment_method')=='master_card'){
            $mastercard="selected";
            $displayCard="";
            $displayBankDraft="display:none";
            $displayPaypal="display:none";
        }
        else if($form->value('payment_method')=='bank_draft'){
            $bankdraft="selected";
            $displayBankDraft="";
            $displayCard="display:none";
            $displayPaypal="display:none";
        }
        else if($form->value('payment_method')=='paypal'){
            $paypal="selected";
            $displayBankDraft="display:none";
            $displayCard="display:none";
            $displayPaypal="";
        }
        }else{
            $displayBankDraft="display:none";
            $displayCard="display:none";
            $displayPaypal="display:none";
            if($_SESSION['addPPInfoError'])
            {
               $formPaymentError= "<font size=\"2\" color=\"#ff0000\">* select a payment method</font>";
           }
        }
        unset($_SESSION['addPPInfoError']);
        $ret.="<h5> Payment Information</h5>
            {$formPaymentError}
            <p> <select id='payment_method' name='payment_method'>
            <option  value=''>select payment</option>
            <option  value='visa_card' $visacard >VISA CARD</option>
            <option  value='master_card' $mastercard>Master Card</option>
            <option  value='bank_draft' $bankdraft>Bank Draft</option>
            <option  value='paypal' $paypal >paypal</option>
            </select>
            <div id='visa_card' style=\"{$displayCard}\">
            <p>Account No <input type='text' name='account_no' value='{$form->value('account_no')}'>{$form->error('account_no')}
            <p>Verification Code <input type='text' name='vcode'  value='{$form->value('vcode')}'> {$form->error('vcode')}
            <p>Exp. date <input type='text' name='expDate' value='{$form->value('expDate')}'> {$form->error('expDate')}
            </div>
            <div id='bank_draft' style=\"{$displayBankDraft}\">
            <p>Routing No <input type='text' name='routing_no'  value='{$form->value('routing_no')}'>{$form->error('routing_no')}
            <p>Account Number <input type='text' name='acc_no'  value='{$form->value('acc_no')}'>{$form->error('acc_no')}
            </div>
            <div id='paypal' style=\"{$displayPaypal}\">
            <p>Account No <input type='text' name='paypalAccountNo'  value='{$form->value('paypalAccountNo')}'> {$form->error('paypalAccountNo')}
            </div>
            <p><input type='submit' value= 'submit' name='Next'>
            </div>";

        return $ret;
    }
    else if($user->userlevel>=3){
        return "this is user console";
    }
}
?>
