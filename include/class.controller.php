<?php

/* the main class for  the  system. controls the system as a whole */
include("user.php");
include("class.regex.php");
include("./pages/welcome.php");
include("./mpages/mWelcome.php");

class Controller {

    var $checkLogin = false;
    var $referrer;
    var $url;
    var $data;

    function Controller() {
        $this->checkLogin = $this->checkLogedIn();
        if (isset($_SESSION['url'])) {
            $this->referrer = $_SESSION['url'];
        } else {
            $this->referrer = HOME_PATH;
        }

        /* Set current url */
        $this->url = $_SESSION['url'] = $_SERVER['REQUEST_URI']; //$_SERVER['PHP_SELF'];
    }

    function checkBlank($field, $errmsg) {
        global $form;
        if (!$this->data[$field] || strlen($this->data[$field] = trim($this->data[$field])) == 0) {
            $form->setError($field, $errmsg);
            return true;
        }
        else
            return false;
    }

    function getLoginForm() {
        $ret = getLoginForm();
        return $ret;
    }

    function getUserMenu() {
        return getUserMenu();
    }

    function getGreetings() {
        return getGreetings();
    }

    function getNewsItem() {
        return getNews();
    }

    function checkLogedIn() {
        global $user;
        if ($user->logged_in)
            return true;
        else
            return false;
    }

//    for mobile
    function getMLoginForm() {
        return mLoginForm();
    }

    function getMUserMenu() {
        return getMUserMenu();
    }

    //------------------------------function for TA setting----------
    function addTASetting($args) {
        global $database, $form, $reg;

        $reg->check($args, 'user_id', 'digit');
        $reg->check($args, 'amount', 'digit');
        $reg->check($args, 'effective_date', 'date');
        //print_r($args);
        //print_r($form->getErrorArray());
        if ($form->num_errors > 0) {
            return false;  //Errors with form
        }
        $res = $database->addTASetting($args);

        if ($res)
            return true;
        return false;
    }

    function editTASetting($args) {
        global $database, $form, $reg;

        $reg->check($args, 'user_id', 'digit');
        $reg->check($args, 'amount', 'digit');
        $reg->check($args, 'effective_date', 'date');
        //print_r($args);
        //print_r($form->getErrorArray());
        if ($form->num_errors > 0) {
            return false;  //Errors with form
        }
        $res = $database->editTASetting($args);

        if ($res)
            return true;
        return false;
    }

    /* addUser function  checks the user entered values ane if all of them are
     * are correct then it added the information provided into the databse
     * and genereates  a random password and mails it to the email associated with
     * the user.
     */

    function addUser($args) {
        global $database, $form, $mailer, $reg, $user;
        $field = 'name';
        $reg->check($args, $field, "name");
        $reg->check($args, 'username', 'username');
        $reg->check($args, 'email', 'email');
        $reg->check($args, 'phone', 'phoneNo');
        $reg->check($args, 'addl1', 'safeText');
        $reg->check($args, 'addl2', 'safeText', false);
        if ($form->num_errors > 0) {
            return 2;
        } else {
            if ($database->usernameTaken($args['username'])) {
                $form->setError('username', '* username already exist');
                return 2;
            }
            $args['pass'] = $user->generateRandStr(8);
            $res = $database->addUser($args);
            if ($res) {
                if (EMAIL_WELCOME) {
                    if ($mailer->sendWelcome($args['name'], $args['email'], $args['username'], $args['pass']))
                        return 0;
                    else
                        return 1; //user added to database but mail failed-- user cant find his password.




                }else {
                    return 0;  //New user added succesfully
                }
            } else {
                return 2;  //Registration attempt failed
            }
        }
    }

    //-------Party---------------    

    function addParty($args) {

        global $database, $form, $reg;

        $reg->check($args, 'name', 'name');
        $reg->check($args, 'address', 'safeText');
        $reg->check($args, 'phone', 'phoneNo');
        for ($i = 0; $i < $args['count']; $i++) {
            $reg->check($args, 'MR_id' . $i, 'digit');
        }
        if ($form->num_errors > 0) {
//            echo "error in controller";
            return false;
        }
        $res = $database->addParty($args);
        if ($res)
            return true;
        return false;
    }

    function editParty($args) {

        global $database, $form, $reg;

        $reg->check($args, 'name', 'name');
        $reg->check($args, 'address', 'safeText');
        $reg->check($args, 'phone', 'phoneNo');
        for ($i = 0; $i < $args['count']; $i++) {
            $reg->check($args, 'MR_id' . $i, 'digit');
        }
        if ($form->num_errors > 0) {
            return false;
        }
        //print_r($args);
        $res = $database->editParty($args);
        if ($res)
            return true;
        return false;
    }

    //---------Product---------------

    function addProduct($args) {

        global $database, $form, $reg;

        $reg->check($args, 'name', 'safeText');
        $reg->check($args, 'quantity', 'float');
        $reg->check($args, 'unit_id', 'digit');
        $reg->check($args, 'no_in_case', 'digit');
        $reg->check($args, 'active', 'alpha');
        $reg->check($args, 'price', 'currency');
        $reg->check($args, 'effective_date', 'date');
        //echo $form->num_errors;
        //print_r($form->getErrorArray());
        //print_r($args);
        if ($form->num_errors > 0) {
            return false;
        }
        //print_r($args);
        $res = $database->addProduct($args);
        if ($res)
            return true;
        return false;
    }

    function editProduct($args) {

        global $database, $form, $reg;

        $reg->check($args, 'name', 'name');
        $reg->check($args, 'quantity', 'float');
        $reg->check($args, 'unit_id', 'digit');
        $reg->check($args, 'no_in_case', 'digit');
        $reg->check($args, 'active', 'alpha');
        $reg->check($args, 'price', 'currency');
        $reg->check($args, 'effective_date', 'date');
        //echo $form->num_errors;
        //print_r($form->getErrorArray());
        //print_r($args);
        if ($form->num_errors > 0) {
            return false;
        }
        //print_r($args);
        $res = $database->editProduct($args);
        if ($res)
            return true;
        return false;
    }

    //---------tada-------------

    function addTada($args) {
//        var_dump($args);
        global $database, $form, $reg;
        $iterate = $args['formlength'];
        $i = (isset($iterate)) ? 1 : "";
        do {

            for ($j = $i + 1; $j <= $iterate; $j++) {
                if ($args['visited_date' . $i] == $args['visited_date' . $j]) {
                    $form->setError('visited_date' . $i, '* Warning ! Duplicate Entry for date.');
                    $form->setError('visited_date' . $j, '* Warning ! Duplicate Entry for date.');
                }
            }
            $reg->check($args, 'visited_date' . $i, 'date');
            $reg->check($args, 'visit_place' . $i, 'safeText');
            $reg->check($args, 'distance' . $i, 'digit');
            $reg->check($args, 'da' . $i, 'digit');
            $reg->check($args, 'other' . $i, 'digit', false);
            $reg->check($args, 'remark' . $i, 'safeText');



            if (strlen($args['visited_date' . $i]) > 0 && $database->checkDuplicateEntry('syn_tada', 'visited_date', $args['visited_date' . $i])) {
                $form->setError('visited_date' . $i, '* Warning ! Duplicate Entry for date.');
            }
            $i++;
        } while (is_int($i) && $i <= $iterate);


        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->addTada($args);
        if ($res)
            return true;
        return false;
    }

    function editTada($args) {

        global $database, $form, $reg;

        $reg->check($args, 'visited_date', 'date');
        $reg->check($args, 'visit_place', 'safeText');
        $reg->check($args, 'distance', 'digit');
        $reg->check($args, 'da', 'digit');
        $reg->check($args, 'other', 'digit');
        $reg->check($args, 'remark', 'safeText');

        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->editTada($args);
        if ($res)
            return true;
        return false;
    }

    //---------dcr-------------

    function addDcr($args) {

        global $database, $form, $reg;
        $iterate = $args['formlength'];

        $i = (isset($iterate)) ? 1 : "";
        do {

            for ($j = $i + 1; $j <= $iterate; $j++) {
                if ($args['collected_date' . $i] == $args['collected_date' . $j]) {
                    $form->setError('collected_date' . $i, '* Warning ! Duplicate Entry for date.');
                    $form->setError('collected_date' . $j, '* Warning ! Duplicate Entry for date.');
                }
            }
            $reg->check($args, 'collected_date' . $i, 'date');
            $reg->check($args, 'name' . $i, 'safeText');
            $reg->check($args, 'customer_title_id' .$i, 'digit');
            $reg->check($args, 'remark' . $i, 'safeText');



            if (strlen($args['collected_date' . $i]) > 0 && $database->checkDuplicateEntry('syn_dcr', 'collected_date', $args['collected_date' . $i])) {
                $form->setError('collected_date' . $i, '* Warning ! Duplicate Entry for date.');
            }
            $i++;
        } while (is_int($i) && $i <= $iterate);
//        die();
//        $reg->check($args, 'collected_date', 'date');
//        $reg->check($args, 'name', 'safeText');
//        $reg->check($args, 'customer_title_id', 'digit');
//        $reg->check($args, 'remark', 'safeText');

        if (strlen($args['collected_date']) > 0 && $database->checkDuplicateEntry('syn_dcr', 'collected_date', $args['collected_date'])) {
            $form->setError('collected_date', '* Warning ! Duplicate Entry for date.');
        }

//        var_dump($reg);
        if ($form->num_errors > 0) {
//            var_dump($form);
//            echo $form->num_errors;
//            echo "error";
            return false;
        }

        $res = $database->addDcr($args);
        if ($res)
            return true;
        return false;
    }

    function editDcr($args) {

        global $database, $form, $reg;
        //print_r($args);
        $reg->check($args, 'collected_date', 'date');
        $reg->check($args, 'name', 'safeText');
        $reg->check($args, 'customer_title_id', 'digit');
        $reg->check($args, 'remark', 'safeText');

        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->editDcr($args);
        if ($res)
            return true;
        return false;
    }

    //---------party stock-------------

    function addPartyStock($args) {

        global $database, $form, $reg;
        $reg->check($args, 'collected_date', 'date');
        $reg->check($args, 'party_id', 'digit');
        //$reg->check($args,'product_id','digit');
        //$reg->check($args,'no_of_case','digit');
        //print_r($form->getErrorArray());

        for ($i = 1; $i <= $args['count']; $i++) {
            $reg->check($args, 'pid' . $i, 'digit');
            $reg->check($args, 'no_of_case' . $i, 'digit', false);
            $reg->check($args, 'indv' . $i, 'digit', false);
        }

        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->addPartyStock($args);
        if ($res)
            return true;
        return false;
    }

    function editPartyStock($args) {

        global $database, $form, $reg;
        //print_r($args);
        $reg->check($args, 'collected_date', 'date');
        $reg->check($args, 'party_id', 'digit');
        $reg->check($args, 'product_id', 'digit');
        $reg->check($args, 'no_of_case', 'digit');
        $reg->check($args, 'indivisual', 'digit');
//print_r($form->getErrorArray());
        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->editPartyStock($args);
        if ($res)
            return true;
        return false;
    }

    //------------material----------

    function addMaterial($args) {

        global $database, $form, $reg;
        //print_r($args);
        $reg->check($args, 'name', 'safeText');
        $reg->check($args, 'unit', 'alpha');
//print_r($form->getErrorArray());
        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->addMaterial($args);
        if ($res)
            return true;
        return false;
    }

    function editMaterial($args) {

        global $database, $form, $reg;
        //print_r($args);
        $reg->check($args, 'name', 'safeText');
        $reg->check($args, 'unit', 'alpha');
//print_r($form->getErrorArray());
        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->editMaterial($args);
        if ($res)
            return true;
        return false;
    }

    //---------stock-----------------

    function addStock($args) {

        global $database, $form, $reg;
        //print_r($args);
        $reg->check($args, 'ri_date', 'date');
        $reg->check($args, 'material_id', 'digit');
        //$reg->check($args,'action','digit');
        $reg->check($args, 'qty', 'digit');
//print_r($form->getErrorArray());
        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->addStock($args);
        //echo gettype($res);
        if (strcmp(gettype($res), "boolean") == 0 && $res) {
            //echo "return true";
            return true;
        }

        if (strcmp(gettype($res), "string") == 0) {
            //echo "return string";
            return $res;
        }

        return false;
    }

    function editStock($args) {

        global $database, $form, $reg;
        //print_r($args);
        $reg->check($args, 'ri_date', 'date');
        $reg->check($args, 'material_id', 'digit');
        $reg->check($args, 'qty', 'digit');
//print_r($form->getErrorArray());
        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->editStock($args);
        if (strcmp(gettype($res), "boolean") == 0 && $res) {
            //echo "return true";
            return true;
        }

        if (strcmp(gettype($res), "string") == 0) {
            //echo "return string";
            return $res;
        }

        return false;
    }

    function addNews($args) {

        global $database, $form, $reg;
        //print_r($args);
        $reg->check($args, 'entered_date', 'date');
        $reg->check($args, 'title', 'safeText');
        $reg->check($args, 'body', 'safeText');

        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->addNews($args);
        if ($res)
            return true;
        return false;
    }

    function editNews($args) {

        global $database, $form, $reg;
        //print_r($args);
        $reg->check($args, 'entered_date', 'date');
        $reg->check($args, 'title', 'safeText');
        $reg->check($args, 'body', 'safeText');

        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->editNews($args);
        if ($res)
            return true;
        return false;
    }

    //---------product detail-----------------

    function addProductDetails($args, $target) {

        global $database, $form, $reg;
        $reg->check($args, 'product_id', 'digit');
        $reg->check($args, 'description', 'safeText');
        if ($form->num_errors > 0) {
            return false;
        }


        $args['path'] = $target;
        //print_r($args);
        $res = $database->addProductDetails($args);
        if ($res)
            return true;
        return false;
    }

    function editProductDetails($args, $target) {

        global $database, $form, $reg;
        $reg->check($args, 'product_id', 'digit');
        $reg->check($args, 'description', 'safeText');
        if ($form->num_errors > 0) {
            return false;
        }


        $args['path'] = $target;
        //print_r($args);
        $res = $database->editProductDetails($args);
        if ($res)
            return true;
        return false;
    }

    //----ask the expert---------
    function askExpertQuery($args) {
        global $reg, $form, $mailer;
        $reg->check($args, "name", "name");
        $reg->check($args, "address", "safeText");
        $reg->check($args, "email", "email");
        $reg->check($args, 'phone', 'phoneNo');
        if ($form->num_errors > 0) {
            return false;
        } else {
            if ($mailer->askExpertQuery($args))
                return true;
            else
                return "fail";
        }
    }

    function addVisitplan($args) {
        global $database, $form, $reg;
        $iterate = $args['formlength'];
        $i = (isset($iterate)) ? 1 : "";
        do {

            for ($j = $i + 1; $j <= $iterate; $j++) {
                if ($args['collected_date' . $i] == $args['collected_date' . $j]) {
                    $form->setError('collected_date' . $i, '* Warning ! Duplicate Entry for date.');
                    $form->setError('collected_date' . $j, '* Warning ! Duplicate Entry for date.');
                }
            }
            $reg->check($args, 'collected_date' . $i, 'date');
            $reg->check($args, 'place' . $i, 'safeText');
            $reg->check($args, 'remark' . $i, 'safeText');



            if (strlen($args['collected_date' . $i]) > 0 && $database->checkDuplicateEntry('syn_visit_plan', 'collected_date', $args['collected_date' . $i])) {
                $form->setError('collected_date' . $i, '* Warning ! Duplicate Entry for date.');
            }
            $i++;
        } while (is_int($i) && $i <= $iterate);


        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->addVisitplan($args);
        if ($res)
            return true;
        return false;
    }

    function editVisitplan($args) {

        global $database, $form, $reg;
        $reg->check($args, 'collected_date', 'date');
        $reg->check($args, 'place', 'safeText');
        $reg->check($args, 'remark', 'safeText');

        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->editVisitplan($args);
        if ($res)
            return true;
        return false;
    }

    //------------sales plan ------------------------------
    function addSalesPlan($args) {

        global $database, $form, $reg;
        $reg->check($args, 'from_date', 'date');
        $reg->check($args, 'to_date', 'date');
        $reg->check($args, 'party_id', 'AlNum');
        for ($i = 0; $i < $args['count']; $i++) {
            $reg->check($args, 'product_id' . $i, 'digit');
            $reg->check($args, 'plan_case' . $i, 'digit', false);
            $reg->check($args, 'plan_individual' . $i, 'digit', false);
            $reg->check($args, 'discount_case' . $i, 'digit', false);
            $reg->check($args, 'discount_individual' . $i, 'digit', false);
        }

//        var_dump($form);
//        die()
        if ($form->num_errors > 0) {
            echo "error";
            //var_dump($args);
            return false;
        }


        $res = $database->addSalesPlan($args);
        if ($res)
            return true;
        return false;
    }

    function editSalesPlan($args) {
        global $database, $form, $reg;
        $reg->check($args, 'from_date', 'date');
        $reg->check($args, 'to_date', 'date');
        $reg->check($args, 'party_id', 'AlNum');

        for ($i = 0; $i < $args['count']; $i++) {
            $reg->check($args, 'product_id' . $i, 'digit');
            $reg->check($args, 'plan_case' . $i, 'digit', false);
            $reg->check($args, 'plan_individual' . $i, 'digit', false);
            $reg->check($args, 'discount_case' . $i, 'digit', false);
            $reg->check($args, 'discount_individual' . $i, 'digit', false);
        }

        if ($form->num_errors > 0) {
            //echo "error";
            //var_dump($args);
            return false;
        }


        $res = $database->editSalesPlan($args);
        if ($res)
            return true;
        return false;
    }

    function addCollectionPlan($args) {
        global $database, $form, $reg;
        $reg->check($args, 'from_date', 'date');
        $reg->check($args, 'to_date', 'date');
        $reg->check($args, 'party_id', 'digit');
        $reg->check($args, 'amount', 'amount');

        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->addCollectionPlan($args);
        if ($res)
            return true;
        return false;
    }

    function editCollectionPlan($args) {

        global $database, $form, $reg;
//        print_r($args);
        $reg->check($args, 'from_date', 'date');
        $reg->check($args, 'to_date', 'date');
        $reg->check($args, 'party_id', 'digit');
        $reg->check($args, 'amount', 'amount');
        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->editCollectionPlan($args);
//        print_r($res);
        if ($res)
            return true;
        return false;
    }

    function addDueAmount($args) {
        global $database, $form, $reg;
        $reg->check($args, 'collected_date', 'date');
        $reg->check($args, 'party_id', 'digit');
        $reg->check($args, 'amount', 'amount');
        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->addDueAmount($args);
        if ($res)
            return true;
        return false;
    }

    function addAdminDueAmount($args) {
        global $database, $form, $reg;
        $reg->check($args, 'collected_date', 'date');
        $reg->check($args, 'party_id', 'digit');
        $reg->check($args, 'amount', 'amount');
        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->addDueAmount($args);
        if ($res)
            return true;
        return false;
    }

    function editDueAmount($args) {
        global $database, $form, $reg;
//        var_dump($form);
        $reg->check($args, 'collected_date', 'date');
        $reg->check($args, 'party_id', 'digit');
        $reg->check($args, 'amount', 'amount');
        if ($form->num_errors > 0) {
            return false;
        }

        $res = $database->editDueAmount($args);
        if ($res)
            return true;
        return false;
    }

}

$ctrl = new Controller();
?>