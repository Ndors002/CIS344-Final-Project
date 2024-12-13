<?php
require_once 'RestaurantDatabase.php'; // Include the database class

class RestaurantPortal {
    private $db; // Database object

    // Constructor to create a new database connection
    public function __construct() {
        $this->db = new RestaurantDatabase(); // Initialize the database
    }

    // Handle different actions based on the URL
    public function handleRequest() {
        $action = $_GET['action'] ?? 'home'; // Default to 'home' if no action is provided

        switch ($action) {
            case 'addReservation': // If adding reservation
                $this->addReservation();
                break;
            case 'viewReservations': // If viewing reservations
                $this->viewReservations();
                break;
            case 'viewCustomers': // If viewing customers
                $this->viewCustomers();
                break;
            case 'modifyReservation': // If modifying reservation
                $reservationId = $_GET['id'] ?? null;
                $this->modifyReservation($reservationId );
                break;
            case 'cancelReservation': // If canceling reservation
                $reservationId = $_GET['id'] ?? null;
                $this->cancelReservation($reservationId );
                break;
            default: // Default action is home
                $this->home();
        }
    }

    // Show the homepage
    private function home() {
        include 'templates/home.php'; // Include homepage template
    }

    // Handle adding a reservation
    private function addReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if form is submitted
            // Get data from form
            $customerName = $_POST['customer_name'];
            $contactInfo = $_POST['contact_info'];
            $reservationTime = $_POST['reservation_time'];
            $numberOfGuests = $_POST['number_of_guests'];

            // Handle special requests
            $specialRequests = !empty($_POST['special_requests']) ? $_POST['special_requests'] : 'No special requests';

            // Add reservation to the database
            $this->db->addReservation($customerName, $contactInfo, $reservationTime, $numberOfGuests, $specialRequests);

            // Redirect to view reservations page
            header("Location: index.php?action=viewReservations&message=Reservation Added");
        } else {
            include 'templates/addReservation.php'; // Show form to add reservation
        }
    }

    // View all reservations
    private function viewReservations() {
        $reservations = $this->db->getAllReservations(); // Get all reservations
        include 'templates/viewReservations.php'; // Show reservations
    }

    // View all customers
    private function viewCustomers() {
        $customers = $this->db->getAllCustomers(); // Get all customers
        include 'templates/viewCustomers.php'; // Show customers
    }

    // Modify reservation
    private function modifyReservation($reservationId) {
        if($_SERVER['REQUEST_METHOD'] === "POST") {
            // Get data from form
            $reservationId = $_POST['reservation_id'];
            $reservationTime = $_POST['reservation_time'];
            $numberOfGuests = $_POST['number_of_guests'];
            
            // Handle special requests
            $specialRequests = !empty($_POST['special_requests']) ? $_POST['special_requests'] : 'No special requests';

            // Add reservation to the database
            $this->db->modifyReservation($reservationId, $reservationTime, $numberOfGuests, $specialRequests);

            // Redirect to view reservations page
            header("Location: index.php?action=viewReservations&message=Reservation Added");
        } else {
            $reservation = $this->db->findReservations($reservationId);
            include 'templates/modifyReservation.php'; // Show modify reservation form
        }
    }

    // Cancel reservation
    private function cancelReservation($reservationId ) {
        $this->db->deleteReservation($reservationId); // Get all customers
    }
}

?>
