<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Customers</title>
  <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>All Customers</h1>

      <div class="table-container">
      <table>
        <tr>
          <th>Customer ID</th>
          <th>Customer Name</th>
          <th>Contact Info</th>
        </tr>
        <?php if (empty($customers)): ?>
          <tr>
            <td colspan="5" style="text-align: center;">No customers found</td>
          </tr>
        <?php else: ?>
          <!-- Loop through each customer -->
          <?php foreach ($customers as $customer): ?>
            <tr>
              <td><?= htmlspecialchars($customer['customerId']) ?></td>
              <td><?= htmlspecialchars($customer['customerName']) ?></td>
              <td><?= htmlspecialchars($customer['contactInfo']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>

      </table>
    </div>

    <div class="links">
      <a href="index.php">Back to Home</a>
      <a>|</a>
      <a href="index.php?action=addReservation">Add Reservation</a>
      <a>|</a>
      <a href="index.php?action=viewReservations">View Reservations</a>
    </div>
  </div>
</body>