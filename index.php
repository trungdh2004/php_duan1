<?php
session_start();
?>
<?php
$_SESSION["favcolor"] = "green";


$session_status = session_status();


include "./config/db.php";
include "./controller/home.controller.php";
include "./controller/shop.controller.php";
include "./controller/contact.controller.php";
include "./controller/auth.controller.php";
$db = new Database();
$db->pdo_get_connection();


$sessionUserId = null;
if (isset($_SESSION['user'])) {
    $sessionUserId = $_SESSION['user'];
}

$layout = $_GET['layout'] ?? '';
$page = $_GET['page'] ?? '';

switch ($layout) {
    case "":
        include './view/client/layout/header.php';
        switch ($page) {
            case '':
                $homeController = new HomeController();
                $homeController->index();
                break;
            case 'shop':
                $shopController = new ShopController();
                $shopController->index();
                break;
            case 'contact':
                $contactController = new ContactController();
                $contactController->index();
                break;
            case 'login':
                if (isset($sessionUserId)) {
                    echo "<script>window.location = 'index.php'</script>";
                }
                $contactController = new AuthController();
                $contactController->login();
                break;
            case 'register':
                if (isset($sessionUserId)) {
                    echo "<script>window.location = 'index.php'</script>";
                }
                $contactController = new AuthController();
                $contactController->register();
                break;
            case 'logout':
                if (isset($sessionUserId)) {
                    echo "<script>window.location = 'index.php'</script>";
                }
                $contactController = new AuthController();
                $contactController->logout();
                break;
            default:
                $homeController = new HomeController();
                $homeController->index();
                break;
        }
        include './view/client/layout/footer.php';
        break;
    case "admin":
        if (!isset($sessionUserId) || $sessionUserId['role'] !== 0) {
            header("Location:index.php");
        }
        include './view/admin/layout/sidebar.php';
}
