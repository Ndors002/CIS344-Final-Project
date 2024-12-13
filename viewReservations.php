<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Reservations</title>
  <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>All Reservations</h1>

    <div class="table-container">
      <table>
        <tr>
          <th>Customer Name</th>
          <th>Reservation ID</th>
          <th>Reservation Time</th>
          <th>Number of Guests</th>
          <th>Special Requests</th>
          <th>Actions</th>
        </tr>
        <?php if (empty($reservations)): ?>
          <tr>
            <td colspan="5" style="text-align: center;">No reservations found</td>
          </tr>
        <?php else: ?>
          <!-- Loop through each reservation -->
          <?php foreach ($reservations as $reservation): ?>
            <tr>
              <td><?= htmlspecialchars($reservation['customerName']) ?></td>
              <td><?= htmlspecialchars($reservation['reservationId']) ?></td>
              <td><?= htmlspecialchars($reservation['reservationTime']) ?></td>
              <td><?= htmlspecialchars($reservation['numberOfGuests']) ?></td>
              <td><?= htmlspecialchars($reservation['specialRequests']) ?></td>
              <td>
                <div class="links actions-link">
                  <a href="index.php?action=modifyReservation&id=<?= htmlspecialchars($reservation['reservationId']) ?>">Modify</a>
                  <a href="javascript:void(0);" onclick="confirmCancel(<?= htmlspecialchars($reservation['reservationId']) ?>);" style="color: #ff0000;">Cancel</a>
                </div>
              </td>
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
      <a href="index.php?action=viewCustomers">View Customers</a>
    </div>
  </div>

  <script>
    function confirmCancel(reservationId) {
      const confirmation = confirm("Are you sure you want to cancel this reservation?");
      if (confirmation) {
        // Redirect to the cancellation URL
        window.location.href = `index.php?action=cancelReservation&id=${reservationId}`;
      }
    }
  </script>
</body>