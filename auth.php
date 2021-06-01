<?php
session_start();
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gcsbzdb');

function connect()
{
    $connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno($connect)) {
        die("Failed to connect:" . mysqli_connect_error());
    }
    mysqli_set_charset($connect, "utf8");

    return $connect;
}
$con = connect();

if (isset($_POST['connexion'])) {
    $login = $_POST['login'];
    $password = $_POST['pwd'];
    $sql_user = "SELECT * FROM gcsbz_users where login='$login' && password='$password' LIMIT 1";
    $result_user = $con->query($sql_user);

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $_SESSION['id_user'] = $row_user['id'];
        $_SESSION['user_name'] = $row_user['user_name'];
        $msg = "Bienvenue " . $row_user['user_name'];
        header("location: index.php?msg=" . $msg);
    } else {
        $msg = "Vérifier les données puis les renvoyers";
        header("location: auth.php?msg=" . $msg);
    }
}
if (isset($_POST['add_user'])) {

    $user_name = $_POST['user_name'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($password == $confirm_password) {
        $sql_user = "SELECT user_name FROM gcsbz_users where login='$login'";
        $result_user = $con->query($sql_user);

        if ($result_user->num_rows > 0) {
            $msg = "Utilisateur déja enregistrer";
            header("location: auth.php?add&msg_add=" . $msg);
        } else {
            $sql = "INSERT INTO `gcsbz_users` (`user_name`, `login`, `password`) VALUES ('$user_name', '$login', '$password')";
            if ($con->query($sql) === TRUE) {
                $msg = "Bienvenue " . $login;
                header("location: index.php?msg=" . $msg);
            } else {
                $msg = "Vérifier les données puis les renvoyers";
                header("location: auth.php?msg_add=" . $msg);
            }
        }
    } else {
        $msg = "Vérifier les données puis les renvoyers";
        header("location: auth.php?add&msg_add=" . $msg);
    }
}
if (isset($_GET['deconnecter'])) {
    session_unset();
    session_destroy();
    $msg = "Deconnexion avec succées . Merci ;) ";
    header("location: auth.php?&msg=" . $msg);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gestion Commercial SBZ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Mega Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="codedthemes" />
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <!-- waves.css -->
    <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
    <!-- scrollbar.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">
    <!-- am chart export.css -->
    <!-- animation nifty modal window effects css -->
    <link rel="stylesheet" type="text/css" href="assets/css/component.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">
</head>

<body themebg-pattern="theme1">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="preloader-wrapper">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->

    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->

                    <form class="md-float-material form-material" action="auth.php" method="POST">
                        <div class="text-center">
                            <a href="index.php" style="color:white;font-size:32px;">
                                Gection Commercial SBZ
                            </a>
                        </div>
                        <?php
                        if (isset($_GET['add'])) {
                        ?>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center txt-primary">Ajouter untilisateur</h3>
                                            <?php
                                            if (isset($_GET['msg_add'])) {
                                                if ($_GET['msg_add'] != '') {
                                                    echo '<h5 class="text-center" style="color:red;">' . $_GET['msg_add'] . '</h5>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="user_name" class="form-control" required="">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Nom d'utilisateur</label>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="login" class="form-control" required="">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Login</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-primary">
                                                <input type="password" name="password" class="form-control" required="">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Mot de passe</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-primary">
                                                <input type="password" name="confirm_password" class="form-control" required="">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Confirmer mot de passe</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <input type="submit" name="add_user" value="Ajouter utilisateur" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                        </div>
                                    </div>
                                    <hr />
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Connecter vous !</h3>
                                            <?php
                                            if (isset($_GET['msg'])) {
                                                if ($_GET['msg'] != '') {
                                                    echo '<h5 class="text-center" style="color:red;">' . $_GET['msg'] . '</h5>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <form method="POST" action="auth.php">
                                        </form>
                                    </div>
                                    <form method="POST" action="auth.php">
                                        <div class="form-group form-primary">
                                            <input type="text" name="login" class="form-control" required>
                                            <span class="form-bar"></span>
                                            <label class="float-label">Votre Login</label>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="password" name="pwd" class="form-control" required>
                                            <span class="form-bar"></span>
                                            <label class="float-label">Votre Mot de passe</label>
                                        </div>
                                        <div class="row m-t-30">
                                            <div class="col-md-12">
                                                <input type="submit" name="connexion" value="Connexion" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20" />
                                            </div>
                                        </div>
                                    </form>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-10">
                                            <p class="text-inverse text-left m-b-0">Merci à vous !</p>
                                            <p class="text-inverse text-left"><b>Visiter notre site ;) --> </b>
                                                <a href="http://www.floussi.com/gcsbz"><b>www.floussi.com</b></a>
                                            </p>
                                        </div>
                                        <div class="col-md-2">
                                            <img src="assets/images/auth/Logo-small-bottom.png" alt="small-logo.png">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                    </form>
                    <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>
    <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
    <!-- waves js -->
    <script src="assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js "></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="assets/js/SmoothScroll.js"></script>
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js "></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="bower_components/i18next/js/i18next.min.js"></script>
    <script type="text/javascript" src="bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
    <script type="text/javascript" src="assets/js/common-pages.js"></script>
</body>

</html>