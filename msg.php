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