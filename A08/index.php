<?php
include("connect.php");

$sort = $_GET['sort'] ?? '';
$order = $_GET['order'] ?? '';
$search = $_GET['search'] ?? '';

$flightLogsQuery = "SELECT flightNumber, departureAirportCode, arrivalAirportCode, departureDatetime, arrivalDatetime, 
                            flightDurationMinutes, airlineName, aircraftType, passengerCount, ticketPrice, 
                            creditCardNumber, creditCardType, pilotName 
                            FROM flightlogs";

if (!empty($search)) {
    $flightLogsQuery .= " WHERE flightNumber LIKE '%$search%' OR airlineName LIKE '%$search%' OR pilotName LIKE '%$search%'";
}

if (!empty($sort)) {
    $flightLogsQuery .= " ORDER BY $sort";
    if (!empty($order)) {
        $flightLogsQuery .= " $order";
    }
}

$flightLogsResults = executeQuery($flightLogsQuery);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flight Logs Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row my-5">
            <div class="col">
                <form>
                    <div class="card p-4 rounded-5">
                        <h5 class="text-center mb-4">Filter Flight Logs</h5>
                        <div class="d-flex flex-column flex-sm-row justify-content-center align-items-start">

                            <div class="mb-3 mb-sm-0 me-sm-3">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" id="search" name="search" class="form-control" value="<?= $search ?>"
                                    placeholder="Search by flight number, airline, or pilot">
                            </div>

                            <div class="mb-3 mb-sm-0 me-sm-3">
                                <label for="sort" class="form-label">Sort By</label>
                                <select id="sort" name="sort" class="form-select" aria-label="Sort by field">
                                    <option value="">None</option>
                                    <option value="departureDatetime" <?= $sort === 'departureDatetime' ? 'selected' : '' ?>>Departure Time</option>
                                    <option value="arrivalDatetime" <?= $sort === 'arrivalDatetime' ? 'selected' : '' ?>>Arrival Time</option>
                                    <option value="ticketPrice" <?= $sort === 'ticketPrice' ? 'selected' : '' ?>>Ticket Price</option>
                                </select>
                            </div>

                            <div class="mb-3 mb-sm-0">
                                <label for="order" class="form-label">Order</label>
                                <select id="order" name="order" class="form-select" aria-label="Sort order">
                                    <option value="ASC" <?= $order === 'ASC' ? 'selected' : '' ?>>Ascending</option>
                                    <option value="DESC" <?= $order === 'DESC' ? 'selected' : '' ?>>Descending</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn btn-primary me-2">Apply Filters</button>
                            <a href="?" class="btn btn-secondary ms-2">Clear Filters</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="row my-5">
            <div class="col">
                <div class="card p-4 rounded-5">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Flight Number</th>
                                    <th scope="col">Departure</th>
                                    <th scope="col">Arrival</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Ticket Price</th>
                                    <th scope="col">Airline</th>
                                    <th scope="col">Aircraft Type</th>
                                    <th scope="col">Passenger Count</th>
                                    <th scope="col">Credit Card Number</th>
                                    <th scope="col">Credit Card Type</th>
                                    <th scope="col">Pilot Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($flightRow = mysqli_fetch_assoc($flightLogsResults)) { ?>
                                    <tr>
                                        <td><?= $flightRow['flightNumber'] ?></td>
                                        <td><?= $flightRow['departureAirportCode'] ?>
                                            (<?= $flightRow['departureDatetime'] ?>)</td>
                                        <td><?= $flightRow['arrivalAirportCode'] ?> (<?= $flightRow['arrivalDatetime'] ?>)
                                        </td>
                                        <td><?= $flightRow['flightDurationMinutes'] ?> mins</td>
                                        <td><?= $flightRow['ticketPrice'] ?></td>
                                        <td><?= $flightRow['airlineName'] ?></td>
                                        <td><?= $flightRow['aircraftType'] ?></td>
                                        <td><?= $flightRow['passengerCount'] ?></td>
                                        <td><?= $flightRow['creditCardNumber'] ?></td>
                                        <td><?= $flightRow['creditCardType'] ?></td>
                                        <td><?= $flightRow['pilotName'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>
