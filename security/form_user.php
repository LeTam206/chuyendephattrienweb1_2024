<?php
// Start the session
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL; //Add new user
$_id = NULL;

if (!empty($_GET['id'])) {
    $_id = base64_decode($_GET['id']);
    $user = $userModel->findUserById($_id);//Update existing user
}


if (!empty($_POST['submit'])) {

    if (!empty($_id)) {
        $userModel->updateUser($_POST);
    } else {
        $userModel->insertUser($_POST);
    }
    header('location: list_users.php');
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>

    <style>
        .d-none {
            display: none;
        }
    </style>
</head>

<body>
    <?php include 'views/header.php' ?>
    <div class="container">

        <?php if ($user || !isset($_id)) { ?>
            <div class="alert alert-warning" role="alert">
                User form
            </div>
            <div class="alert alert-danger d-none" role="alert">Right!</div>
            <form method="POST" id="form">
                <input type="hidden" name="id" value="<?php echo $_id ?>">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" name="name" id="name" placeholder="Name" value='<?php if (!empty($user[0]['name']))
                        echo $user[0]['name'] ?>'>

                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>

                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                </form>
        <?php } else { ?>
            <div class="alert alert-success" role="alert">
                User not found!
            </div>
        <?php } ?>
    </div>
</body>
<script>
    var form = document.querySelector('#form');
    form.addEventListener('submit', function (e) {
        validateName();
        validatePassword();
    });

    const password = document.querySelector('#password');

    function validateName(e) {
        var name = document.querySelector('#name');
        var namePattern = /^[a-zA-Z0-9]{5,15}$/;
        if (name.value == '') {
            alert('Name field is required');
            event.preventDefault();
        }
        else if (!namePattern.test(name.value)) {
            alert("Name must be 5-15 characters long and only contain letters (a-z, A-Z) and numbers (0-9).");
            event.preventDefault();
        }
    }

    function validatePassword() {
        var password = document.querySelector('#password');
        var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{5,10}$/;
        if (password.value == '') {
            alert('Password field is required');
            event.preventDefault();
        }
        else if (!passwordPattern.test(password.value)) {
            alert("Password must be 5-10 characters long and must contain letters (a-z), (A-Z), (0-9) and special characters");
            event.preventDefault();
        }
    }

</script>

</html>