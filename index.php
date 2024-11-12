<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $will_remember = $_POST['will_remember'];

    $insertQuery = "INSERT INTO users (username, email, phone_number, will_remember) VALUES ('$username', '$email', '$phone_number', '$will_remember')";

    if (mysqli_query($conn, $insertQuery)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

$query = "SELECT username, email, phone_number, will_remember FROM users";
$result = mysqli_query($conn, $query);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
        }

        .container-fluid {
            background-color: #212529;
            color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card {
            background-color: #1f1f1f;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .card:hover {
            background-color: #2a2a2a;
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .card-title {
            color: #ffffff;
        }

        .card-subtitle,
        .card-text {
            color: #b0b0b0;
        }

        .card-subtitle a {
            color: #00aaff;
            text-decoration: none;
        }

        .card-subtitle a:hover {
            text-decoration: underline;
            color: #0099cc;
        }

        .form-container {
            background-color: #1f1f1f;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            margin-top: 20px;
        }

        .form-label {
            color: #e0e0e0;
        }

        .form-control {
            background-color: #2a2a2a;
            color: #ffffff;
            border: 1px solid #444;
        }

        .form-select {
            background-color: #2a2a2a;
            color: #ffffff;
            border: 1px solid #444;
        }

        .btn-primary {
            background-color: #00aaff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0099cc;
        }
    </style>
</head>

<body>
    <div class="container-fluid shadow mb-5">
        <h1>User Information</h1>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="card form-container">
                    <h2 class="text-center text-light">Add New User</h2>
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="will_remember" class="form-label">Will Remember</label>
                            <select class="form-select" id="will_remember" name="will_remember" required>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($user = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card rounded-4 shadow my-3 mx-5">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($user["username"]); ?></h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">
                                    <a href="mailto:<?php echo htmlspecialchars($user["email"]); ?>">
                                        <?php echo htmlspecialchars($user["email"]); ?>
                                    </a>
                                </h6>
                                <p class="card-text"><strong>Phone Number:</strong>
                                    <?php echo htmlspecialchars($user["phone_number"]); ?></p>
                                <p class="card-text"><strong>Will Remember:</strong>
                                    <?php echo ($user["will_remember"] == "yes") ? "Yes" : "No"; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center text-light'>No records found.</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
