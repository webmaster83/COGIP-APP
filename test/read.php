<?php
// Check existence of id parameter before processing further
if(isset($_GET["per_id"]) && !empty(trim($_GET["per_id"]))){
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM personne WHERE per_id = :per_id";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":per_id", $param_per_id);

        // Set parameters
        $param_per_id = trim($_GET["per_id"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve individual field value
                $per_nom = $row["per_nom"];
                $per_prenom = $row["per_prenom"];
                $per_tel = $row["per_tel"];
                $per_mail = $row["per_mail"];

            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $row["per_nom"]; ?></p>
                    </div>

                    <div class="form-group">
                        <label>Prenom</label>
                        <p class="form-control-static"><?php echo $row["per_prenom"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Telephone</label>
                        <p class="form-control-static"><?php echo $row["per_tel"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <p class="form-control-static"><?php echo $row["per_mail"]; ?></p>
                    </div>

                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
