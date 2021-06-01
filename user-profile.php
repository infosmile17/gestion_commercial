<?php include_once('header.php'); ?>
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <?php include_once('navbar.php');
        include_once('functions.php'); ?>
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- Page-body start -->
                        <div class="page-body">
                            <!-- Basic table card start -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Mon profil</h5>
                                    <!-- button Default -->
                                    <div class="card-block">

                                        <div class="card-header-right">
                                            <ul class="list-unstyled card-option">
                                                <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                <li><i class="fa fa-window-maximize full-card"></i></li>
                                                <li><i class="fa fa-minus minimize-card"></i></li>
                                                <li><i class="fa fa-refresh reload-card"></i></li>
                                                <li><i class="fa fa-trash close-card"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-block">

                                        <?php
                                        $msg = '';
                                        if (isset($_POST['update_user'])) {
                                            $user_name = $_POST['user_name'];
                                            $password = $_POST['password'];

                                            $sql = "UPDATE `gcsbz_users` SET `user_name`='$user_name',`password`='$password' WHERE id=" . $_SESSION['id_user'];

                                            if ($con->query($sql) === TRUE) {
                                                $msg = "Votre compte à été modifier avec succées";
                                            } else {
                                                $msg = "Erreur de modification !";
                                            }
                                        }

                                        $sql = "SELECT * FROM gcsbz_users where id=" . $_SESSION['id_user'];
                                        $result = $con->query($sql);

                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                        ?>
                                            <?php
                                            if ($msg != '') {
                                                echo '<div class="card borderless-card">
                                            <div class="card-block success-breadcrumb">
                                                <div class="breadcrumb-header">
                                                    <h5>' . $msg . '</h5>
                                                </div>
                                            </div>
                                        </div>';
                                            }
                                            ?>
                                            <form action="user-profile.php" method="POST">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Nom et Prenom</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="user_name" value="<?=$row['user_name'];?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Login</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="<?=$row['login'];?>" readonly>
                                                        <div class="col-form-label">Vous ne pouvez pas le changer !</div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Mot de passe</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" name="password" class="form-control" value="<?=$row['password'];?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Action</label>
                                                    <div class="col-sm-10">
                                                        <input type="submit" class="btn btn-info" name="update_user" value="Enregistrer modification" />
                                                        <a href="index.php" class="btn btn-info">Tableau de board</a>
                                                    </div>
                                                </div>

                                            </form>
                                        <?php
                                        } else {
                                            $msg = "Erreur :( Connecter vous ;) ";
                                            header("location: auth.php?&msg=" . $msg);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Required Jquery -->
                <?php include_once('footer.php'); ?>