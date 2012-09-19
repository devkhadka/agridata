<?php
/* the main class for  the  system. controls the system as a whole*/
include("user.php");
include("class.regex.php");
include("./pages/welcome.php");
include ("./mpages/welcome.php");
class Controller{
    var $checkLogin=false;
    var $referrer;
    var $url;
    var $data;
    function Controller(){
        $this->checkLogin=$this->checkLogedIn();
        if(isset($_SESSION['url'])){
            $this->referrer = $_SESSION['url'];
        }else{
            $this->referrer = HOME_PATH;
        }

        /* Set current url */
        $this->url = $_SESSION['url'] = $_SERVER['REQUEST_URI'];//$_SERVER['PHP_SELF'];

    }
    function checkBlank($field,$errmsg){
        global $form;
        if(!$this->data[$field]|| strlen($this->data[$field] = trim($this->data[$field])) == 0){
            $form->setError($field, $errmsg);
            return true;
        }
        else
            return false;
    }
    function getLoginForm(){
        $ret=getLoginForm(); 
        return $ret;
    }
    function getUserMenu(){
        return getUserMenu();
    }

    function getGreetings(){
        return getGreetings();
    }
    function getNewsItem(){
        return getNews();
    }
    function checkLogedIn(){
        global $user;
        if($user->logged_in)
            return true;
        else
            return false;
    }

    //------------------------------function for TA setting----------
    function addTASetting($args){
        global $database,$form,$reg;

        $reg->check($args,'user_id','digit');
        $reg->check($args,'amount','digit');
        $reg->check($args,'effective_date','date');
        //print_r($args);
        //print_r($form->getErrorArray());
        if($form->num_errors > 0){
	    return false;  //Errors with form
        }
        $res =  $database->addTASetting($args);

        if($res)
            return true;
        return false;

    }   
    function editTASetting($args){
        global $database,$form,$reg;

        $reg->check($args,'user_id','digit');
        $reg->check($args,'amount','digit');
        $reg->check($args,'effective_date','date');
        //print_r($args);
        //print_r($form->getErrorArray());
        if($form->num_errors > 0){
	    return false;  //Errors with form
        }
        $res =  $database->editTASetting($args);

        if($res)
            return true;
        return false;

    }   
    /* addUser function  checks the user entered values ane if all of them are
     * are correct then it added the information provided into the databse
     * and genereates  a random password and mails it to the email associated with
     * the user.
     */
    function addUser($args){
        global $database,$form,$mailer,$reg,$user;
        $field='name';
        $reg->check($args,$field,"name");
        $reg->check($args,'username','username');
        $reg->check($args,'email','email');
        $reg->check($args,'phone','phoneNo');
        $reg->check($args,'addl1','safeText');
        $reg->check($args,'addl2','safeText',false);
        if($form->num_errors>0){
            return 2;
        } else{
            if($database->usernameTaken($args['username'])){
                $form->setError('username', '* username already exist');
                return 2;
            }
            $args['pass']= $user->generateRandStr(8);
            $res=$database->addUser($args);
            if($res){
                if(EMAIL_WELCOME){
                    if( $mailer->sendWelcome($args['name'],$args['email'],$args['username'],$args['pass']))
                        return 0;
                    else
                        return 1;//user added to database but mail failed-- user cant find his password.
                }else{
                return 0;  //New user added succesfully
                }
            }else{
                return 2;  //Registration attempt failed
            }
            }

            
        }

    //-------Party---------------    
    
    function addParty($args){

        global $database,$form,$reg;
        
        $reg->check($args,'name','name');
        $reg->check($args,'address','safeText');
        $reg->check($args,'phone','phoneNo');
        $reg->check($args,"MR_id", "digit");
        
        if($form->num_errors>0){
            return false;
        }
        $res = $database->addParty($args);
        if($res)
            return true;
        return false;
    }
    function editParty($args){

        global $database,$form,$reg;
        
        $reg->check($args,'name','name');
        $reg->check($args,'address','safeText');
        $reg->check($args,'phone','phoneNo');
        $reg->check($args,'MR_id','digit');
        
        if($form->num_errors>0){
            return false;
        }
        //print_r($args);
        //die();
        $res = $database->editParty($args);
        if($res)
            return true;
        return false;
    }
    //---------Product---------------

    function addProduct($args){
        
        global $database,$form,$reg;
        
        $reg->check($args,'name','name');
        $reg->check($args,'quantity','digit');
        $reg->check($args,'unit_id','digit');
        $reg->check($args,'no_in_case','digit');
        $reg->check($args,'active','alpha');
        $reg->check($args,'price','currency');
        $reg->check($args,'effective_date','date');
        //echo $form->num_errors;
        //print_r($form->getErrorArray());
        //print_r($args);
        //die();
        if($form->num_errors>0){
            return false;
        }
        //print_r($args);
        //die();
        $res = $database->addProduct($args);
        if($res)
            return true;
        return false;

    }

    
    function editProduct($args){
        
        global $database,$form,$reg;
        
        $reg->check($args,'name','name');
        $reg->check($args,'quantity','digit');
        $reg->check($args,'unit_id','digit');
        $reg->check($args,'no_in_case','digit');
        $reg->check($args,'active','alpha');
        $reg->check($args,'price','currency');
        $reg->check($args,'effective_date','date');
        //echo $form->num_errors;
        //print_r($form->getErrorArray());
        //print_r($args);
        //die();
        if($form->num_errors>0){
            return false;
        }
        //print_r($args);
        //die();
        $res = $database->editProduct($args);
        if($res)
            return true;
        return false;

    }

    //---------tada-------------

    function addTada($args){
        
        global $database,$form,$reg;
        //print_r($args);
        $reg->check($args,'visited_date','date');
        $reg->check($args,'visit_place','safeText');
        $reg->check($args,'distance','digit');
        $reg->check($args,'da','digit');
        $reg->check($args,'other','digit',false);
        $reg->check($args,'remark','safeText');

        if(strlen($args['visited_date']) > 0 && $database->checkDuplicateEntry('syn_TADA','visited_date',$args['visited_date'])) {
        	$form->setError('visited_date','* Warning ! Duplicate Entry for date.');
        }        
        
        if($form->num_errors>0){
            return false;
        }

        $res = $database->addTada($args);
        if($res)
            return true;
        return false;

    }

    function editTada($args){
        
        global $database,$form,$reg;

        $reg->check($args,'visited_date','date');
        $reg->check($args,'visit_place','safeText');
        $reg->check($args,'distance','digit');
        $reg->check($args,'da','digit');
        $reg->check($args,'other','digit');
        $reg->check($args,'remark','safeText');

        if($form->num_errors>0){
            return false;
        }

        $res = $database->editTada($args);
        if($res)
            return true;
        return false;

    }
    //---------dcr-------------

    function addDcr($args){
        
        global $database,$form,$reg;
        //print_r($args);
        //die();
        $reg->check($args,'collected_date','date');
        $reg->check($args,'name','safeText');
        $reg->check($args,'customer_title_id','digit');
        $reg->check($args,'remark','safeText');
    	
        if(strlen($args['collected_date']) > 0 && $database->checkDuplicateEntry('syn_DCR','collected_date',$args['collected_date'])) {
        	$form->setError('collected_date','* Warning ! Duplicate Entry for date.');
        }
        
        
        if($form->num_errors>0){
            return false;
        }

        $res = $database->addDcr($args);
        if($res)
            return true;
        return false;

    }

    function editDcr($args){
        
        global $database,$form,$reg;
        //print_r($args);
        //die();
        $reg->check($args,'collected_date','date');
        $reg->check($args,'name','safeText');
        $reg->check($args,'customer_title_id','digit');
        $reg->check($args,'remark','safeText');

        if($form->num_errors>0){
            return false;
        }

        $res = $database->editDcr($args);
        if($res)
            return true;
        return false;

    }
    //---------party stock-------------

    function addPartyStock($args){
        
        global $database,$form,$reg;

        $reg->check($args,'collected_date','date');
        $reg->check($args,'party_id','digit');
        //$reg->check($args,'product_id','digit');
        //$reg->check($args,'no_of_case','digit');
        //print_r($form->getErrorArray());
        
        for($i=1;$i<=$args['count'];$i++){
            $reg->check($args,'pid'.$i,'digit');
            $reg->check($args,'no_of_case'.$i,'digit',false);
            $reg->check($args,'indv'.$i,'digit',false);
        }

        if($form->num_errors>0){
            return false;
        }

        $res = $database->addPartyStock($args);
        if($res)
            return true;
        return false;

    }

    function editPartyStock($args){
        
        global $database,$form,$reg;
        //print_r($args);
        //die();
        $reg->check($args,'collected_date','date');
        $reg->check($args,'party_id','digit');
        $reg->check($args,'product_id','digit');
        $reg->check($args,'no_of_case','digit');
        $reg->check($args,'indivisual','digit');
//print_r($form->getErrorArray());
        if($form->num_errors>0){
            return false;
        }

        $res = $database->editPartyStock($args);
        if($res)
            return true;
        return false;

    }

    //------------material----------

    function addMaterial($args){
        
        global $database,$form,$reg;
        //print_r($args);
        //die();
        $reg->check($args,'name','safeText');
        $reg->check($args,'unit','alpha');
//print_r($form->getErrorArray());
        if($form->num_errors>0){
            return false;
        }

        $res = $database->addMaterial($args);
        if($res)
            return true;
        return false;

    }

    function editMaterial($args){
        
        global $database,$form,$reg;
        //print_r($args);
        //die();
        $reg->check($args,'name','safeText');
        $reg->check($args,'unit','alpha');
//print_r($form->getErrorArray());
        if($form->num_errors>0){
            return false;
        }

        $res = $database->editMaterial($args);
        if($res)
            return true;
        return false;

    }
    //---------stock-----------------

    function addStock($args){
        
        global $database,$form,$reg;
        //print_r($args);
        //die();
        $reg->check($args,'ri_date','date');
        $reg->check($args,'material_id','digit');
        //$reg->check($args,'action','digit');
        $reg->check($args,'qty','digit');
//print_r($form->getErrorArray());
        if($form->num_errors>0){
            return false;
        }

        $res = $database->addStock($args);
        //echo gettype($res);
        //die();
        if(strcmp(gettype($res),"boolean") == 0 && $res){
            //echo "return true";
            return true;
        }
        
        if(strcmp(gettype($res),"string") == 0){
            //echo "return string";
            //die();
            return $res;
        }
        
        return false;

    }

    function editStock($args){
        
        global $database,$form,$reg;
        //print_r($args);
        //die();
        $reg->check($args,'ri_date','date');
        $reg->check($args,'material_id','digit');
        $reg->check($args,'qty','digit');
//print_r($form->getErrorArray());
        if($form->num_errors>0){
            return false;
        }

        $res = $database->editStock($args);
        if(strcmp(gettype($res),"boolean") == 0 && $res){
            //echo "return true";
            return true;
        }
        
        if(strcmp(gettype($res),"string") == 0){
            //echo "return string";
            //die();
            return $res;
        }
        
        return false;

    }

    function addNews($args){
        
        global $database,$form,$reg;
        //print_r($args);
        //die();
        $reg->check($args,'entered_date','date');
        $reg->check($args,'title','safeText');
        $reg->check($args,'body','safeText');

        if($form->num_errors>0){
            return false;
        }

        $res = $database->addNews($args);
        if($res)
            return true;
        return false;

    }
    function editNews($args){
        
        global $database,$form,$reg;
        //print_r($args);
        //die();
        $reg->check($args,'entered_date','date');
        $reg->check($args,'title','safeText');
        $reg->check($args,'body','safeText');

        if($form->num_errors>0){
            return false;
        }

        $res = $database->editNews($args);
        if($res)
            return true;
        return false;

    }

    //---------product detail-----------------

    function addProductDetails($args,$target){
        
        global $database,$form,$reg;
        $reg->check($args,'product_id','digit');
        $reg->check($args,'description','safeText');
        if($form->num_errors>0){
            return false;
        }
        
        
        $args['path'] = $target; 
        //print_r($args);
        //die();
        $res = $database->addProductDetails($args);
        if($res)
            return true;
        return false;


    }

    function editProductDetails($args,$target){
        
        global $database,$form,$reg;
        $reg->check($args,'product_id','digit');
        $reg->check($args,'description','safeText');
        if($form->num_errors>0){
            return false;
        }
        
        
        $args['path'] = $target; 
        //print_r($args);
        //die();
        $res = $database->editProductDetails($args);
        if($res)
            return true;
        return false;


    }
    //----ask the expert---------
    function askExpertQuery($args){
        global $reg,$form,$mailer;
        $reg->check($args,"name","name");
        $reg->check($args,"address","safeText");
        $reg->check($args,"email","email");
        $reg->check($args,'phone','phoneNo');
        if($form->num_errors>0){
            return false;
        } else{
            if( $mailer->askExpertQuery($args))
                return true;
            else 
                return "fail";
        }

    }
}

$ctrl= new Controller();
?>
