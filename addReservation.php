<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Reservation</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Add Reservation</h1>
        
        <form method="POST" action="index.php?action=addReservation">
            <label for="customer_name">Customer Name:</label>
            <input type="text" name="customer_name" id="customer_name" required>

            <label for="contact_info">Email or Phone:</label>
            <input type="text" name="contact_info" id="contact_info" required>

            <label for="reservation_time">Reservation Time:</label>
            <input type="datetime-local" name="reservation_time" id="reservation_time" required>

            <label for="number_of_guests">Number of Guests:</label>
            <input type="number" name="number_of_guests" id="number_of_guests" required>

            <label for="special_requests">Special Requests:</label>
            <textarea name="special_requests" id="special_requests" rows="4" placeholder="Enter any special requests here..."></textarea>

            <button type="submit" name="submit">Submit</button>
        </form>

        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
