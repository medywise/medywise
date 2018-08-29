<?php
    include 'src/initialize.php';
    $r = explode('/', $_SERVER['REQUEST_URI']);
    
    //if (!in_array('admin', $r)) {
    if (!in_array('admin', $r) || !in_array('api', $r) || !in_array('extension', $r)) {
        $url = new Routes('index');

        if (!$url->segment(1)) {
            $page = 'index';
        } else {
            $page = $url->segment(1);
        }
       

        if(strpos($page, 'search?med')  !== false){  
             include 'src/public/search.php';
             exit;
        }
        
        if(strpos($page, 'login?redirect_to')  !== false){  
             include 'src/public/login.php';
             exit;
        }

        switch ($page) {
            case 'index':
                include 'src/public/index.php';
                break;

            case 'login':
                include 'src/public/login.php';
                break;
            case 'logout':
                include 'src/public/logout.php';
                break;

            case 'register':
                include 'src/public/register.php';
                break;

            case 'recover':
                include 'src/public/recover.php';
                break;
            case 'activate':
                include 'src/public/activate.php';
                break;
            case 'code':
                include 'src/public/code.php';
                break;
            case 'reset':
                include 'src/public/reset.php';
                break;

            case 'search':
                include 'src/public/search.php';
                break;
            case 'pgRedirect':
                include 'src/public/pgRedirect.php';
                break;

            case 'subscribe':
                include 'src/public/subscribe.php';
                break;
            case 'pay':
                include 'src/public/pay.php';
                break;

            case 'about':
                include 'src/public/about.php';
                break;
            case 'contact':
                include 'src/public/contact.php';
                break;

            case 'exten4':
                include 'src/public/exten4.php';
                break;
            case 'ss':
                include 'src/public/exten5.php';
                break;

            case 'admin':
                include 'src/admin/index.php';
                break;
            case 'admin/login':
                include 'src/admin/login.php';
                break;
            case 'admin/logout':
                include 'src/admin/includes/logout.php';
                break;
            default:
                include 'src/public/errors/404NotFound.php';
                break;
        }
    } else {
        ?>
        <script language="javascript">
            window.location.href = "/src/admin/index.php"
        </script>
        <?php
    }
?>