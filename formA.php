<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$user_name = $user_surname = $user_phone = $user_mail = $user_category = "";
$name_error = $surname_error = $phone_error = $mail_error = $category_error = "";

function test_input($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
};


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validation_flag = false;

    if (empty($user_name = $_POST["name"])) {
        $name_error = "* Please enter your username";
        $validation_flag = false;
    } else {
        $user_name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Zα-ωΑ-Ω]/", $user_name)) {
            $name_error = "* Username is not valid";
            $validation_flag = false;
        } else {
            $validation_flag = true;
        }
    }
    if (empty($user_surname = $_POST["surname"])) {
        $surname_error = "* Please enter your surname";
        $validation_flag = false;
    } else {
        $user_surname = test_input($_POST["surname"]);
        if (!preg_match("/^[a-zA-Zα-ωΑ-Ω]/", $user_surname)) {
            $surname_error = "* Surname is not valid";
            $validation_flag = false;
        } else {
            $validation_flag = true;
        }
    }
    if (empty($user_phone = $_POST["telephone"])) {
        $phone_error = "* Please enter your phone number";
        $validation_flag = false;
    } else {
        $user_phone = test_input($_POST["telephone"]);
        if (!preg_match("/^\\+?[1-9][0-9]{7,14}$/", $user_phone)) {
            $phone_error = "* Phone number is not valid";
            $validation_flag = false;
        } else {
            $validation_flag = true;
        }
    }
    if (empty($user_mail = $_POST["email"])) {
        $mail_error = "* Please enter your email";
        $validation_flag = false;
    } else {
        $user_mail = test_input($_POST["email"]);
        if (!filter_var($user_mail, FILTER_VALIDATE_EMAIL)) {
            $mail_error = "* Email is not valid";
            $validation_flag = false;
        } else {
            $validation_flag = true;
        }
    }
    if (empty($user_category = $_POST["category"])) {
        $category_error = "* Please select a category";
        $validation_flag = false;
    } else {
        $user_category = $_POST["category"];
    }

    if ($validation_flag) {
        include("dataBase.php");
        $sql = "INSERT INTO customers (firstname, lastname, telephone, email, category) VALUES ('" . $user_name . "', '" . $user_surname . "', '" . $user_phone . "', '" . $user_mail . "', '" . $user_category . "')";

        if ($conn->query($sql) === TRUE) {
            header("Location:/Lasttry/succesful_submit.html");
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Registration Form</title>
</head>

<body>
    <div id="registrationForm">
        <div class="container">
            <form action="" class="form-signup" method="POST" novalidate>
                <h2>New Account</h2>
                <p>Start your registration!</p>
                <div class="form-group">
                    <div class="row ">
                        <div class="col-md-6 my-2">
                            <input type="text" name="name" class="form-control" placeholder="First Name" value="<?= $user_name ?>">
                            <div style="color: red; font-size: 10px;"> <?= $name_error; ?></div>
                        </div>
                        <div class="col-md-6 my-2">
                            <input type="text" class="form-control" placeholder="Last Name" name="surname" value="<?= $user_surname ?>">
                            <div style="color: red; font-size: 10px;"> <?= $surname_error; ?></div>
                        </div>
                    </div>
                </div>
                <div class="form-group my-3">
                    <input type="tel" class="form-control" placeholder="Phone Number" name="telephone" value="<?= $user_phone ?>">
                    <div style="color: red; font-size: 10px;"> <?= $phone_error; ?></div>
                </div>
                <div class="form-group my-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $user_mail ?>">
                    <div style="color: red; font-size: 10px;"> <?= $mail_error; ?></div>
                </div>
                <div class="form-group my-3">
                    <select name="category" class="form-select" value="<?= $user_category ?>">
                        <option value="">Select Category</option>
                        <option value="Professional">Professional</option>
                        <option value="Individual">Individual</option>
                    </select>
                    <div style="color: red; font-size: 10px;"> <?= $category_error; ?></div>
                </div>
                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-success btn-primary " name="submit" value="Register">
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
