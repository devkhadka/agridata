<?php

class Mpage {

    var $request;
    public static $title;
    public static $heading;
    public static $content;
    public static $csslink;
    public static $jslink;

    function Mpage($req='default') {
        $this->request = $req;
        self::$title = "Agricare Nepal";
        self::$csslink="";
        self::$jslink="";
        $this->getContent();
    }

    function getContent() {

        self::$content .= "<div>";
        //self::$content .= "<div class='main-title'><div id='title'>".self::$heading."</div><div id='menu'><a href='?mpage='>Home</a></div></div>";

        switch ($this->request) {
            case "adddcr": require_once ('./mpages/dcr.php');
                self::$content .= addDcr();
                break;
            case "addtada": require_once ('./mpages/tada.php');
                self::$content .= addTada();
                break;
            case "addpartystock": require_once ('./mpages/partyStock.php');
                self::$content .= addPartyStock();
                break;
            case "addvisitplan": require_once ('./mpages/visitplan.php');
                self::$content .= addVisitplan();
                break;
            case "addsalesplan": require_once ('./mpages/salesplan.php');
                self::$content .= addSalesPlan();
                break;
            case "addcollectionplan": require_once ('./mpages/collectionPlan.php');
                self::$content .= addMCollectionPlan();
                break;
            case "viewsalesplan": require_once ('./mpages/salesplan.php');
                self::$content .= viewSalesPlan();
                break;
            case "viewsalesplandetail": require_once ('./mpages/salesplan.php');
                self::$content .= viewSalesPlanDetail();
                break;
            case "viewdcr": require_once('./mpages/dcr.php');
                self::$content .= viewDcr();
                break;
            case "viewtada": require_once ('./mpages/tada.php');
                self::$content .= viewTada();
                break;
            case "viewpartystock": require_once('./mpages/partyStock.php');
                self::$content .= viewPartyStock();
                break;
            case "viewvisitplan": require_once('./mpages/visitplan.php');
                self::$content .= viewVisitplan();
                break;
            case "viewcollectionplan": require_once ('./mpages/collectionPlan.php');
                self::$content .= viewCollectionPlan();
                break;
            case "editsalesplan": require_once ('./mpages/salesplan.php');
                self::$content .= editsalesplan();
                break;
            case "editdcr": require_once ('./mpages/dcr.php');
                self::$content .= editDcr();
                break;
            case "edittada": require_once ('./mpages/tada.php');
                self::$content .= editTada();
                break;
            case "editvisitplan": require_once ('./mpages/visitplan.php');
                self::$content .= editVisitplan();
                break;
            case "editcollectionplan": require_once ('./mpages/collectionPlan.php');
                self::$content .= editCollectionPlan();
                break;
            case "editpartystock": require_once ('./mpages/partyStock.php');
                self::$content .= editPartyStock();
                break;
            default :
                require_once ('./mpages/mWelcome.php');
                self::$content .= mLoginForm();
                break;
        }


//        self::$content .= "<div id='footer'><font color='#828C96'>Copyright©2011</font><font color='#fff'> Agricare Nepal</font></div>";
        self::$content .= "</div>";
    }   

}
?>
