<?php
include("connect.php"); // Include the database connection file

$query = "SELECT username, email, phone_number, will_remember FROM users"; // Updated SQL query
$result = executeQuery($query); // Execute the query
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
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text color for contrast */
        }
        .container-fluid {
            background-color: #212529; /* Slightly lighter for the header */
            color: #ffffff; /* White text for header */
            padding: 20px;
            margin-bottom: 20px;
        }
        .card {
            background-color: #1f1f1f; /* Dark card background */
            border: none; /* Remove card border */
            transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition for hover effect */
        }
        .card:hover {
            background-color: #2a2a2a; /* Lighter background on hover */
            transform: translateY(-5px); /* Slight upward movement on hover */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Shadow effect on hover */
        }
        .card-title {
            color: #ffffff; /* White color for card title */
        }
        .card-subtitle, .card-text {
            color: #b0b0b0; /* Muted color for subtitles and text */
        }
        /* Style for the email link */
        .card-subtitle a {
            color: #00aaff; /* Change to your desired color */
            text-decoration: none; /* Remove underline */
        }
        .card-subtitle a:hover {
            text-decoration: underline; /* Add underline on hover */
            color: #0099cc; /* Darker shade on hover */
        }
    </style>
</head>

<body>
    <div class="container-fluid shadow mb-5">
        <h1>User Information</h1>
    </div>

    <div class="container">
        <div class="row">

            <!-- PHP BLOCK -->
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($user = mysqli_fetch_assoc($result)) {
                    ?>

                    <div class="col-12">
                        <div class="card rounded-4 shadow my-3 mx-5">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($user["username"]); ?>
                                </h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">
                                    <a href="mailto:<?php echo htmlspecialchars($user["email"]); ?>">
                                        <?php echo htmlspecialchars($user["email"]); ?>
                                    </a>
                                </h6>
                                <p class="card-text">
                                    <strong>Phone Number:</strong> <?php echo htmlspecialchars($user["phone_number"]); ?>
                                </p>
                                <p class="card-text">
                                    <strong>Will Remember:</strong>
                                    <?php echo ($user["will_remember"] == "yes") ? "Yes" : "No"; ?>
                                </p>
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
