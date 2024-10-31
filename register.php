<?php
include 'auth.php';
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkEmailStmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();

    if ($checkEmailStmt->num_rows > 0) {
        $error_message = "هذا البريد الإلكتروني مسجل مسبقًا!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error_message = "حدث خطأ أثناء التسجيل. حاول مرة أخرى.";
        }

        $stmt->close();
    }

    $checkEmailStmt->close();
}
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronic Shop - Register</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container" id="login">
        <div class="row">
            <div class="col-md-5 py-3 py-md-0" id="side1">
                <h3 class="text-center">Register</h3>
            </div>
            <div class="col-md-7 py-3 py-md-0" id="side2">
                <h3 class="text-center">Create Account</h3>
                <div class="input text-center">
                <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <input type="text" name="name" placeholder="Name" required class="form-control mb-3 mx-auto d-block w-75">
                        <input type="email" name="email" placeholder="Email" required class="form-control mb-3 mx-auto d-block w-75">
                        <input type="password" name="password" placeholder="Password" required class="form-control mb-3 mx-auto d-block w-75">
                        <button type="submit" class="btn btn-primary w-10" id="btn-signup">SIGN UP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <a href="#" class="arrow"><i><img src="./images/arrow.png" alt=""></i></a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="app.js"></script>
</body>
</html>
