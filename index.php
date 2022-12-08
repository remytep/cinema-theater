<?php

session_start();
// check si user est deja log
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["adminStatus"] == true) {
        header("location: ./admin/index.php");
        exit;
    } else {
        header("location: ./user/index.php");
        exit;
    }
}

// conn PDO
require_once "connection.php";

// variables initialisées avec valeur par défaut
$email = $password = "";
$email_err = $password_err = $login_err = "";

// process le form quand le form est envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // valide les logins
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT user.firstname, user.lastname, site_users.id_user, site_users.email, site_users.password, site_users.admin 
        FROM site_users
        INNER JOIN user ON site_users.id_user = user.id
        WHERE site_users.email LIKE :email";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            $param_email = trim($_POST["email"]);

            // execute la query
            if ($stmt->execute()) {
                // Check email puis password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id_user"];
                        $firstname = $row['firstname'];
                        $lastname = $row['lastname'];
                        $email = $row["email"];
                        $hashed_password = $row["password"];
                        $adminStatus = $row["admin"];
                        if (password_verify($password, $hashed_password)) {
                            // Password correct, new session
                            session_start();
                            // variables de session pour utilisation future
                            $_SESSION["id_user"] = $id;
                            $_SESSION['firstname'] = $firstname;
                            $_SESSION['lastname'] = $lastname;
                            $_SESSION["loggedin"] = true;
                            $_SESSION["email"] = $email;
                            if ($adminStatus == 1) {
                                $_SESSION["adminStatus"] = true;
                                header("location: ./admin/index.php");
                            } else {
                                $_SESSION["adminStatus"] = false;
                                header("location: ./user/index.php");
                            }
                        } else {
                            // Password non valide
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else {
                    // email non valide
                    $login_err = "Invalid email or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // fermme la query
            unset($stmt);
        }
    }

    // ferme la PDO conn
    unset($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
</head>

<body class="bg-dark text-light">
    <div class="wrapper container-fluid">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form form-control">
            <div class="form-group py-2">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group py-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group py-2">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
</body>

</html>