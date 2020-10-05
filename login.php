<?php
define("REQUIRED_FIELD_ERROR", "This field is required");
$errors = [];

$username = "";
$email = "";
$password = "";
$confirmPassword = "";
$cv_link = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = post_data("username");
    $email = post_data("email");
    $password = post_data("password");
    $confirmPassword = post_data("confirmPassword");
    $cv_link = post_data("cv_link");

    if (!$username) {
        $errors["username"] = REQUIRED_FIELD_ERROR;
    } elseif (strlen($username) > 16 || strlen($username) < 6) {
        $errors["username"] = "This username is not valid. It must be between 6 and 16 characters.";
    }
    if (!$password) {
        $errors["password"] = REQUIRED_FIELD_ERROR;
    }
    if (!$confirmPassword) {
        $errors["confirmPassword"] = REQUIRED_FIELD_ERROR;
    } elseif ($password && $confirmPassword && strcmp($password, $confirmPassword)) {
        $errors["confirmPassword"] = "The two passwords given do not match.";
    }
    if (!$email) {
        $errors["email"] = REQUIRED_FIELD_ERROR;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "This field must be a valid email address.";
    }
    if ($cv_link && !filter_var($cv_link, FILTER_VALIDATE_URL)) {
        $errors["cv_link"] = "Please provide a valid link";
    }

    if (empty($errors)) {
        echo "Everything is good.";
    }
}


function post_data($value)
{
    $_POST[$value] ??= false;
    return (htmlspecialchars(stripslashes($_POST[$value])));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="container">
    <form action="" method="post" novalidate>
        <div class="form-row">
            <div class="col">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="<?php echo $username ?>" class="form-control <?php echo isset($errors["username"]) ? "is-invalid" : "" ?>">
                    <small class="form-text text-muted">Min. 6 and max 16 characters</small>
                    <div class="invalid-feedback">
                        <?php echo $errors["username"] ?? "" ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?php echo $email ?>" class="form-control <?php echo isset($errors["email"]) ? "is-invalid" : "" ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors["email"] ?? "" ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="<?php echo $password ?>" class="form-control <?php echo isset($errors["password"]) ? "is-invalid" : "" ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors["password"] ?? "" ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" name="confirmPassword" value="<?php echo $confirmPassword ?>" class="form-control <?php echo isset($errors["confirmPassword"]) ? "is-invalid" : "" ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors["confirmPassword"] ?? "" ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="cv_link">Your CV Link</label>
                <input name="cv_link" value="<?php echo $cv_link ?>" class="form-control <?php echo isset($errors["cv_link"]) ? "is-invalid" : "" ?>" placeholder="http://mylink.com" type="url">
                <div class="invalid-feedback">
                    <?php echo $errors["cv_link"] ?? "" ?>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">Register</button>
    </form>
</body>

</html>