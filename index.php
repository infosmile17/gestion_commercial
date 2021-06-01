<?php include_once('header.php'); ?>
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <?php include_once('navbar.php'); ?>
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- Page-body start -->
                        <div class="page-body">
                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                    <?php
                                    if (isset($_GET['msg'])) {
                                        if ($_GET['msg'] != '') {
                                            echo '<div class="card borderless-card">
                                            <div class="card-block success-breadcrumb">
                                                <div class="breadcrumb-header">
                                                    <h5>' . $_GET['msg'] . '</h5>
                                                </div>
                                            </div>
                                        </div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <!-- task, page, download counter  start -->

                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-purple">000 dt</h4>
                                                    <h6 class="text-muted m-b-0">Tous les gains</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="fa fa-bar-chart f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-c-purple">
                                            <div class="row align-items-center">
                                                <div class="col-9">
                                                    <p class="text-white m-b-0">% change</p>
                                                </div>
                                                <div class="col-3 text-right">
                                                    <i class="fa fa-line-chart text-white f-16"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-green">000 dt</h4>
                                                    <h6 class="text-muted m-b-0">Les depences</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="fa fa-file-text-o f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-c-green">
                                            <div class="row align-items-center">
                                                <div class="col-9">
                                                    <p class="text-white m-b-0">% change</p>
                                                </div>
                                                <div class="col-3 text-right">
                                                    <i class="fa fa-line-chart text-white f-16"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-red">000 dt</h4>
                                                    <h6 class="text-muted m-b-0">Débits</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="fa fa-calendar-check-o f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-c-red">
                                            <div class="row align-items-center">
                                                <div class="col-9">
                                                    <p class="text-white m-b-0">% change</p>
                                                </div>
                                                <div class="col-3 text-right">
                                                    <i class="fa fa-line-chart text-white f-16"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h4 class="text-c-blue">000 dt</h4>
                                                    <h6 class="text-muted m-b-0">Crédits</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="fa fa-hand-o-down f-28"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-c-blue">
                                            <div class="row align-items-center">
                                                <div class="col-9">
                                                    <p class="text-white m-b-0">% change</p>
                                                </div>
                                                <div class="col-3 text-right">
                                                    <i class="fa fa-line-chart text-white f-16"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- task, page, download counter  end -->
                            </div>
                        </div>
                        <!-- Page-body end -->
                    </div>
                    <div id="styleSelector"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- Required Jquery -->
<?php include_once('footer.php'); ?>