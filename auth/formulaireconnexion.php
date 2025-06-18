<?php
include "../config/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="test">
        <form method="post" class="login-form">
            <h1>Se connecter </h1>
            <label for="">Email :</label>
            <input type="email" name="email" placeholder="Email" class="form-input">
            <label for="">password :</label>
            <input type="password" name="password" placeholder="Mot de passe" class="form-input">
            <input type="submit" name="search" value="log in " class="submit-btn">
            <div class="form-footer">
                you are already a member? <a href="formulaire.php">sign up</a>
            </div>
        </form>
    </div>


</body>

</html>

<style>
    .login-form {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: rgb(255, 255, 255);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(194, 190, 190, 0.1);
    }

    .form-input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #333;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: rgb(255, 255, 255);
        color: black;
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        background-color:#FFE210;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .submit-btn:hover {
        background-color:#FFE210;
    }

    .form-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color:rgb(0, 0, 0);
    }

    .form-footer a {
        color:#FFE210;
        text-decoration: none;
        font-weight: 500;
    }
</style>
</body>

</html>

<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["search"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $stmt = $pdo->query("SELECT * FROM users WHERE email = '$email'");
        $test = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($test)) {
            if (password_verify($password, $test["password"])) {
                $_SESSION["user_id"] = $test["user_id"];
                header("Location: ../index.html");
                exit;;
                // echo "<pre>";
                // print_r($test);
                // echo "</pre>";
            }
        }
    }
}
