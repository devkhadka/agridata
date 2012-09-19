<?php
define('CASE_SEN', false);
define('UPPER',1);
define('LOWER',0);
define('NOT_BLANK',true);

class RegexCheck{
    var $alNum;
    var $alNumC;
    var $alpha;
    var $alphaC;
    var $digit;
    var $email;
    var $ipAddress;
    var $phoneNo;
    var $hostName;
    var $name;
    var $safeText;
    var $date;
    var $creditCard;
    var $password;
    var $username;
    var $currency;
    var $float;


    function RegexCheck(){
        $this->alNum="/^([0-9a-z])+$/";
        $this->alNumC="/^([0-9A-Z])+$/";
        $this->alpha="/^([a-z])+$/";
        $this->alphaC="/^([A-Z])+$/";
        $this->digit="/^([0-9])+$/";
        $this->email="/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
            ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
            ."\.([a-z]{2,}){1}$/";
        $this->ipAddress="^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$";
        $this->phoneNo="/^[0-9][0-9-\. ]{4,14}[0-9]$/";//^(\()?([0-9]{3})(\))?( )?([0-9]{3})( )?(\-)?( )?([0-9]{4})$
        $this->hostName="/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$/";
        //resonable domain name ^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$
        $this->name="/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/";
        $this->username="/[a-zA-Z0-9_]{3,16}/";
        $this->safeText="/^[a-zA-Z0-9\,\s.\-\?]+$/";
        $this->date="/^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$/";
        $this->creditCard="/^((4\d{3})|(5[1-5]\d{2})|(6011)|(7\d{3}))-?\d{4}-?\d{4}-?\d{4}|3[4,7]\d{13}$/";
        $this->password="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,8}$/";//4 to 8 character password requiring numbers and both lowercase and uppercase letters
        $this->currency="/^\\$?(\d{1,3},?(\d{3},?)*\d{3}(\.\d{0,2})?|\d{1,3}(\.\d{0,2})?|\.\d{1,2}?)$/";
        $this->float="/^-?\d+(\.\d*)?$/"; 
    }
    function isAlNum($str,$sen=CASE_SEN,$case=LOWER){
        if($sen){
            if($case==0){
                if(preg_match($this->alNum,$str))
                    return true;
                else
                    return false;
            }else{
                if(preg_match($this->alNumC,$str))
                    return true;
                else
                    return false;
            }
        }
        else{
            if(preg_match($this->alNum,$str))
                return true;
            else 
                return false;
        }
    }
    function isDigit($str){
        if(preg_match($this->digit,$str))
            return true;
        else
            return false;

    }
    function isAlpha($str,$sen=CASE_SEN,$case=LOWER){
        if($sen){
            if($case==0){
                if(preg_match($this->alpha,$str))
                    return true;
                else
                    return false;
            }else{
                if(preg_match($this->alphaC,$str))
                    return true;
                else
                    return false;
            }
        }
        else{
            if(preg_match($this->alNum,$str))
                return true;
            else 
                return false;
        }
    }
    function isEmail($str){
        if(preg_match($this->email,$str))
            return true;
        else
            return false;
    }
    function isIpAddress($str){
        if(preg_match($this->ipAddress,$str))
            return true;
        else
            return false;

    }
    function isValidHostName($str){
        if (preg_match($this->hostName,$str))
            return true;
        else
            return false;
    }
    function isName($str){
        if(preg_match($this->name,$str))
            return true;
        else 
            return false; 
    }
    function isDate($str){
        if(preg_match($this->date,$str))
            return true;
        else 
            return false; 
    }
    function isSafeText($str){
        if(preg_match($this->safeText,$str))
            return true;
        else 
            return false; 
    }
    function isPassword($str){
        if(preg_match($this->password,$str))
            return true;
        else 
            return false; 
    }
    function isUsername($str){
        if(preg_match($this->username,$str))
            return true;
        else 
            return false; 
    }
    function isPhoneNo($str){
        if(preg_match($this->phoneNo,$str))
            return true;
        else 
            return false; 
    }
    function isFloat($str){
        if(preg_match($this->float,$str))
            return true;
        else 
            return false; 
    }
    function isCurrency($str){
        if(preg_match($this->currency,$str))
            return true;
        else 
            return false; 
    }

    function check($array,$field,$authType,$nblank=NOT_BLANK){
        global $form;
        if(!$nblank){
            if(!$array[$field]|| strlen($array[$field] = trim($array[$field])) == 0){
                return;       
            }
        }
        else{
            if(!$array[$field]|| strlen($array[$field] = trim($array[$field])) == 0){
                $form->setError($field, "* not entered");
                return;
            }
        }

        $array[$field] = stripslashes($array[$field]);
        if($authType=='AlNum'){
            if(!$this->isAlNum($array[$field])){
                $form->setError($field, "* not alphanumeric");
            }
        }
        else if($authType=='AlNumC'){
            if(!$this->isAlNumC($array[$field])){
                $form->setError($field, "* not CAPITAL");
            }
        }
        else if($authType=='alpha'){
            if(!$this->isAlpha($array[$field])){
                $form->setError($field, "* not alphabetic");
            }
        }
        else if($authType=='alphaC'){
            if(!$this->isAlpha($array[$field])){
                $form->setError($field, "* not Capital");
            }
        }
        else if($authType=='email'){
            if(!$this->isEmail($array[$field])){
                $form->setError($field, "* not Valid");
            }
        }
        else if($authType=='digit'){
            if(!$this->isDigit($array[$field])){
                $form->setError($field, "* not Valid");
            }
        }
        else if($authType=='name'){
            if(!$this->isName($array[$field])){
                $form->setError($field, "* not Valid");
            }
        }
        else if($authType=='safeText'){
            if(!$this->isSafeText($array[$field])){
                $form->setError($field, "* not Valid");
            }
        }
        else if($authType=='password'){
            if(!$this->isPassword($array[$field])){
                $form->setError($field, "* not Valid");
            }
        }
        else if($authType=='date'){
            if(!$this->isDate($array[$field])){
                $form->setError($field, "* not Valid date format (yyyy-mm-dd)");
            }
        }
        else if($authType=='username'){
            if(!$this->isUsername($array[$field])){
                $form->setError($field, "* not Valid");
            }
        }
        else if($authType=='phoneNo'){
            if(!$this->isPhoneNo($array[$field])){
                $form->setError($field, "* not Valid");
            }
        }
        else if($authType=='currency'){
            if(!$this->isCurrency($array[$field])){
                $form->setError($field, "* not Valid");
            }
        }
        else if($authType=='float'){
            if(!$this->isFloat($array[$field])){
                $form->setError($field, "* not Valid");
            }
        }
    }//end of function
}
$reg= new RegexCheck;
?>
