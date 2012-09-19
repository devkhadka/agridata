<?php
class Page{
    var $request;
    public static $title;
    public static $keywords;
    public static $description;
    public static $csslink;
    public static $jslink;
    public static $content;
    public static $showLoginBox=false;
    function Page($req='default'){
        $this->request=$req;
        self::$title="Agricare Nepal";
        self::$keywords="Agricarenepal, agricare nepal";
        self::$description="Nepal phermacutical for";
        self::$csslink="";
        self::$jslink="";
        self::$content="";
        $this->getContent();
    }

    function getContent(){
        switch ($this->request) {
                case "forgotpass": require_once('./pages/forgotpass.php');
                    self::$content=forgotPass();
                    break;
                case "addtasetting":  include('./pages/tasetting.php');
                    addTASetting();
                    break;
                case "viewtasetting":  include('./pages/tasetting.php');
                    viewTASetting();
                    break;
                case "edittasetting":  include('./pages/tasetting.php');
                    editTASetting();
                    break;
                case "testgrid":  include('./pages/gridtest.php');
                    gridtest();
                    break;
                case "testgrid2":  include('./pages/gridte2.php');
                    getGrid();
                    break;
                case "adduser":  include('./pages/userop.php');
                    addUser();
                    break;
                case "addparty":    require_once('./pages/party.php');
                                    self::$content = addParty();
                                    break;
                case "editparty":   require_once('./pages/party.php');
                                    self::$content = editParty();
                                    break;
                case "viewparty":   require_once('./pages/party.php');
                                    viewParty();
                                    break;       
                case "addproduct":  require_once('./pages/product.php');
                                    self::$content = addProduct();
                                    break;
                case "editproduct":  require_once('./pages/product.php');
                                    self::$content = editProduct();
                                    break;
                case "viewproduct":  require_once('./pages/product.php');
                                    viewProduct();
                                    break;
                case "addtada":  require_once('./pages/tada.php');
                                    self::$content = addTada();
                                    break;
                case "edittada":  require_once('./pages/tada.php');
                                    self::$content = editTada();
                                    break;
                case "viewtada":  require_once('./pages/tada.php');
                                    viewTada();
                                    break;
                case "mviewtada":  require_once('./pages/tada.php');
                                    mviewTada();
                                    break;
                case "adddcr":  require_once('./pages/dcr.php');
                                    self::$content = addDcr();
                                    break;
                case "editdcr":  require_once('./pages/dcr.php');
                                    self::$content = editDcr();
                                    break;
                case "viewdcr":  require_once('./pages/dcr.php');
                                    viewDcr();
                                    break;
                case "mviewdcr":  require_once('./pages/dcr.php');
                                    mviewDcr();
                                    break;
                case "addpartystock":  require_once('./pages/partyStock.php');
                                    self::$content = addPartyStock();
                                    break;
                case "editpartystock":  require_once('./pages/partyStock.php');
                                    self::$content = editPartyStock();
                                    break;
                case "viewpartystock":  require_once('./pages/partyStock.php');
                                    viewPartyStock();
                                    break;
                case "mviewpartystock":  require_once('./pages/partyStock.php');
                                    mViewPartyStock();
                                    break;
                case "changepass":  require_once('./pages/userop.php');
                                   changePassword();
                                    break;
                case "readmail":  require_once('./pages/userop.php');
                                   readEmail();
                                    break;
                case "addmaterial":  require_once('./pages/material.php');
                                    self::$content = addMaterial();
                                    break;
                case "editmaterial":  require_once('./pages/material.php');
                                    self::$content = editMaterial();
                                    break;
                case "viewmaterial":  require_once('./pages/material.php');
                                    viewMaterial();
                                    break;
                case "mviewmaterial":  require_once('./pages/material.php');
                                    mViewMaterial();
                                    break;
                case "addstock":  require_once('./pages/stock.php');
                                    self::$content = addStock();
                                    break;
                case "editstock":  require_once('./pages/stock.php');
                                    self::$content = editStock();
                                    break;
                case "vstock":  require_once('./pages/stock.php');
                                    viewStock();
                                    break;
                case "mview":  require_once('./pages/stock.php');
                                    view();
                                    break;
                case "userlist": require_once('./pages/userlist.php');
                                   gridtest();
                                   break;
                case "manageuser":require_once('./pages/manageuser.php');
                                   manageUser();
                                   break;
                case "addnews":  require_once('./pages/news.php');
                                    self::$content = addNews();
                                    break;
                case "addproductdetails":  require_once('./pages/product_details.php');
                                    self::$content = addProductDetails();
                                    break;
                case "editproductdetails":  require_once('./pages/product_details.php');
                                    self::$content = editProductDetails();
                                    break;
                case "viewproductdetails":  require_once('./pages/product_details.php');
                                    viewProductDetails();
                                    break;
                case "viewnews":require_once('./pages/news.php');
                                   viewNews();
                                   break;
                case "editnews":  require_once('./pages/news.php');
                                    self::$content = editNews();
                                    break;
				case "expert-services":  require_once('./pages/expert_services.php');
                                    self::$content = expert_services();
                                    break;
				
				case "list_products":  require_once('./pages/list_products.php');
                                    self::$content = list_products();
                                    break;
				case "list_products_info":  require_once('./pages/list_products_info.php');
                                    self::$content = list_products_info();
                                    break;
                default:  
                    $content = file_get_contents('./template/home.html');
                    self::$showLoginBox=true;
                    self::$content  = $content; //eregi_replace("[\]",'',$content);
                    break;

        }
    }



}

?>
