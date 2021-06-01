<?php
// Start the session
session_start();

if (isset($_SESSION["nom"])) {
    require_once 'header.php';
    require_once 'connexion.php';
    ?>
    <div class="container theme-showcase" role="main">
        <?php
        $type = $_SESSION["type"];
        if (isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            ?>
            <div class="alert alert-success" role="alert">
                <center><strong>Bien ! </strong> <?php echo $msg; ?></center>.
            </div>
            <?php
        }
        ?>
        <?php
                        if ($type == 'Admin') {
                            ?>
                            <a href="#ajouter">Ajouter Utilisateur (Admin / Technicien)</a>
                        <?php } ?>
        
        <h1>Listes des Utilisateurs</h1>
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Login</th>
                        <?php
                        if ($type == 'Admin') {
                            ?>
                            <th>Mot de passe</th>

                            <th>Action</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!isset($conn)) {
                        $conn = new Connexion();
                        $connex = $conn->conn;
                    }
                    $sql = "SELECT * FROM utilisateur";
                    $result = $connex->query($sql);

                    if ($result->num_rows > 0) {
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {

                            $pass_temp = "";
                            for ($i = 1; $i <= strlen($row["pwd"]); $i++) {
                                $pass_temp = $pass_temp . "*";
                            }
                            if ($type == 'Admin') {
                                echo "<tr><td>" . $i . "</td><td>" . $row["nom"] . "</td><td>" . $row["type"] . "</td><td>" . $row["description"] .
                                "</td><td>" . $row["login"] . "</td><td>" . $pass_temp . "</td><td><a href='modifiersection.php?idmodsection=" . $row["id"] . "'>Modifier</a> / <a href='executequery.php?idsupsection=" . $row["id"] . "'>Supprimer</a></td></tr>";
                            } else {
                                echo "<tr><td>" . $i . "</td><td>" . $row["nom"] . "</td><td>" . $row["type"] . "</td><td>" . $row["description"] .
                                "</td><td>" . $row["login"] . "</td></tr>";
                            }

                            $i++;
                        }
                    } else {
                        echo "0 resultats";
                    }
                    $connex->close();
                    ?>


                </tbody>
            </table>
        </div>
        <?php 
         if ($type == 'Admin') {
                            ?>
                            <div id="ajouter" class="jumbotron col-md-6">
            <form action="executequery.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input type="nom" class="form-control" id="nom" name="nom">
                </div>
                <div class="form-group">
                    <label for="type">Type :</label>
                    <select class="form-control" id="type" name="type">
                        <option>Admin</option>
                        <option>Technicien</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="login">Login:</label>
                    <input type="login" class="form-control" id="login" name="login">
                </div>
                <div class="form-group">
                    <label for="pwd">Mot de passe:</label>
                    <input type="password" class="form-control" id="pwd" name="pwd">
                </div>
                <button name="env" value="ajoutersection" type="submit" class="btn btn-lg btn-primary">Ajouter Utilisateur</button>
            </form>
        </div>
        
                        <?php } ?>
        
    </div>

    <?php
} else {
    header("location: login.php");
}
require_once 'footer.php';
?>
<script>
    $(".sections").addClass("active");
</script>