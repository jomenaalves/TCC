<?php 

    require_once __DIR__ . "/../vendor/autoload.php";
    
    use CoffeeCode\Router\Router;

    $router = new Router(BASE_URL);

    // NAMESPACE DO CONTROLLER
    $router->namespace("Source\App");

    // PREFIXO DAS ROTAS
    $router->group(null);

    /*
        |------------------------------------------------
        |           TODAS AS ROTAS DO SISTEMA    
        |------------------------------------------------
        |  Todas as rotas get estarão listadas abaixo.
        |
    */

    $router->get("/", "HomeController:index");

    $router->get("/auth/login", "AuthController:login");
    $router->get("/auth/register", "AuthController:index");
    $router->get("/user/perfil", "PerfilController:index");
    $router->get("/user/carteira", "PerfilController:wallet");
    $router->get("/user/pedidos", "PerfilController:requests");
    $router->get("/user/avaliacoes", "PerfilController:avaliable").
    
    $router->get("/c/{category}","HomeController:category");
    $router->get("/produto/{id}/{slug}","ProductController:index");
    $router->get("/carrinho-de-compras", "CartController:index");
    $router->get("/search", "SearchController:index");    
    $router->get("/filters", "FiltersController:index");

    $router->get("/shopNow/{id_product}","ShopController:index");  
    $router->get("/cart/shop", "ShopController:shoppingCart");
    $router->get("/success", "ShopController:success");

    $router->get("/successCart", "ShopController:returnSuccesCart");
    $router->get("/auth/admin", "AdminController:auth");
    $router->get("/admin", "AdminController:index");
    $router->get("/admin/comentarios", "AdminController:comments");
    $router->get("/admin/cadastro-de-produtos", "AdminController:cadProduct");
    $router->get("/admin/exclusao-de-produtos", "AdminController:delProduct");
    $router->get("/admin/atualizar-produtos", "AdminController:upProduct");
    $router->get("/admin/cadastro-de-categorias", "AdminController:cadCategory");
    $router->get("/admin/configs", "AdminController:configs");
    
    $router->get("/exit", function(){
        !session_start() && session_start();
        if(isset($_SESSION['jwtTokenUser'])){
            unset($_SESSION['jwtTokenUser']);
            header("Location: ". BASE_URL . "/");
        }else{
            header("Location: ". BASE_URL . "/");
        }
    });

    /*
    * ERROR'S
    */

    $router->get("/error/404", "ErrorController:index");
    /*
        |------------------------------------------------
        |           TODAS AS ROTAS DE API DO SISTEMA  
        |------------------------------------------------
        |  Todas as rotas de api estarão listadas abaixo.
        |
    */
    $router->post("/api/verifyAndSendEmail/{email}", "EmailController:index");
    $router->post("/api/verifyCode/{code}", "EmailController:verifyCode");

    $router->post("/api/makeLoginUser", "AuthController:makeLoginUser");
    $router->post("/api/checkIfUserIsLogged", "ApiController:checkIfUserIsLogged");

    $router->post("/api/checkIfEmailIsAlreadyRegistered/{email}", "AuthController:checkEmail");
    $router->post("/api/registerUser", "AuthController:register");
    
    $router->post("/api/addProductToCard", "ApiController:addToCard");
    $router->post("/api/removeFromCard", "ApiController:removeFromCart");
    $router->post("/api/verifyEmailInDataBase/{email}", "ApiController:verifyEmail");
    $router->post("/api/verifyPassAndLogin/{email}/{passwd}/{secret}","ApiController:VerifyPassAndLogin");
    $router->post("/api/cadProduct", "ApiController:cadProductApi");
    $router->post("/api/cadCategory", "ApiController:cadCategory");
    $router->post("/api/delCategory", "ApiController:delCategory");
    $router->post("/api/getAllCategories", "ApiController:getCategories");
    $router->post("/api/getAllProducts/{start}", "ApiController:getAllProducts");
    $router->post("/api/numberOfProducts", "ApiController:numberOfProducts");
    $router->post("/api/addPhotosProducts", "ApiController:addPhotos");
    $router->post("/api/deleteProduct/{id}", "ApiController:deleteProduct");
    $router->post("/api/updateConfig", "ApiController:upConfig");
    $router->post("/api/getPriceOfFrete", "ApiController:frete");
    $router->get("/api/getAllCartItem", "ApiController:totalItensInCart");
    $router->post("/api/addAddress", "ApiController:addAddress");
    $router->post("/api/removeAddress", "ApiController:removeAddress");
    $router->post("/api/deletePurchase", "Payment:cancelPurchase");
    $router->get("/paypalPayment/{id}", "Payment:paypalPayment");
    $router->post("/walletPayment/{id}", "Payment:walletPayment");
    $router->post("/walletPaymentCart", "Payment:walletPaymentCart");

    $router->post("/api/updateRating/{qtd}/{from}", "ApiController:updateStars");

    $router->post("/api/registerComment", "ApiController:makeComment");
    $router->post("/api/deleteFromCart/{id}", "ApiController:postRemoveFromCart");
    $router->post("/api/createSectionFromCart", "ApiController:generateSectionFromShoppingCart");

    $router->get("/cartPayment/paypal", "Payment:cartPaymentPaypal");

    $router->post("/api/removeQuestion", "CommentController:delete");
    $router->post("/api/makeAnswer", "CommentController:makeAnswer");
    $router->post("/api/updateAnswer", "CommentController:updateAnswer");


    // DISPATCH DAS ROTAS
    $router->dispatch();

    if ($router->error()) {
        $router->redirect("/error/{$router->error()}");
    }