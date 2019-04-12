<?php
// Include config file
require_once "config.php";

$per_nom = $per_prenom = $per_tel = $per_mail =  "";
$per_nom_err = $per_prenom_err = $per_tel_err = $per_mail_err= "";


// Processing form data when form is submitted
if(isset($_POST["per_id"]) && !empty($_POST["per_id"])){
    // Get hidden input value
    $per_id = $_POST["per_id"];

    // Validate name
    $input_per_nom = trim($_POST["per_nom"]);
    if(empty($input_per_nom)){
        $per_nom_err = "Please enter a name.";
    } else{
        $per_nom = $input_per_nom;
    }

    $input_per_prenom = trim($_POST["per_prenom"]);
    if(empty($input_per_prenom)){
        $per_prenom_err = "Please enter a name.";
    } else{
        $per_prenom = $input_per_prenom;
    }


    $input_per_tel = trim($_POST["per_tel"]);
    if(empty($input_per_tel)){
        $per_tel_err = "Please the telefone number.";
    } else{
        $per_tel = $input_per_tel;
    }

    $input_per_mail= trim($_POST["per_mail"]);
    if(empty($input_per_mail)){
        $per_mail_err = "Please enter an email.";
    } else{
        $per_mail = $input_per_mail;
    }


    // Check input errors before inserting in database
    if(empty($per_nom_err) && empty($per_prenom_err) && empty($per_tel_err) && empty($per_mail_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO personne (per_nom, per_prenom, per_tel, per_mail) VALUES (:per_nom, :per_prenom, :per_tel, :per_mail)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":per_nom", $param_per_nom);
            $stmt->bindParam(":per_prenom", $param_per_prenom);
            $stmt->bindParam(":per_tel", $param_per_tel);
            $stmt->bindParam(":per_mail", $param_per_mail);

            // Set parameters
            $param_per_nom = $per_nom;
            $param_per_prenom = $per_prenom;
            $param_per_tel = $per_tel;
            $param_per_mail = $per_mail;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["per_id"]) && !empty(trim($_GET["per_id"]))){
        // Get URL parameter
        $per_id =  trim($_GET["per_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM personne WHERE per_id = :per_id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_per_id);

            // Set parameters
            $param_per_id = $per_id;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Retrieve individual field value
                    $per_nom = $row["per_nom"];
                    $per_prenom = $row["per_prenom"];
                    $per_mail = $row["per_mail"];
                    $per_tel = $row["per_tel"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
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

  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">


                        <div class="form-group <?php echo (!empty($per_nom_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="per_nom" class="form-control" value="<?php echo $per_nom; ?>">
                            <span class="help-block"><?php echo $per_nom_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($per_prenom_err)) ? 'has-error' : ''; ?>">
                            <label>Prenom</label>
                            <input type="text" name="per_prenom" class="form-control" value="<?php echo $per_prenom; ?>">
                            <span class="help-block"><?php echo $per_prenom_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($per_tel_err)) ? 'has-error' : ''; ?>">
                            <label>Tel</label>
                            <input type="text" name="per_tel" class="form-control" value="<?php echo $per_tel; ?>">
                            <span class="help-block"><?php echo $per_tel_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($per_mail_err)) ? 'has-error' : ''; ?>">
                            <label>Mail</label>
                            <input type="text" name="per_mail" class="form-control" value="<?php echo $per_mail; ?>">
                            <span class="help-block"><?php echo $per_mail_err;?></span>
                        </div>






                        <input type="hidden" name="per_id" value="<?php echo $per_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
