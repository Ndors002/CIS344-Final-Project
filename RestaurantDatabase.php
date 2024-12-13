<?php
class RestaurantDatabase {
    // Database connection details
    private $host = "localhost";
    private $port = "3306";
    private $database = "restaurant_reservations";
    private $user = "root";
    private $password = "";
    private $connection;

    // Constructor to initialize the connection
    public function __construct() {
        $this->connect();
    }

    // Method to connect to the database
    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error); // Error message if connection fails
        }
    }

    // Method to add a reservation
    public function addReservation($customerName, $contactInfo, $reservationTime, $numberOfGuests, $specialRequests) {
        // Check if the customer exists in the database
        $stmt = $this->connection->prepare("SELECT customerId FROM Customers WHERE customerName = ? AND contactInfo = ?");
        $stmt->bind_param("ss", $customerName, $contactInfo);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();
        $stmt->close();

        // If customer doesn't exist, add the customer to the database
        if (!$customer) {
            $customerId = $this->addCustomer($customerName, $contactInfo);
        } else {
            $customerId = $customer['customerId'];
        }

        // Insert the reservation into the database
        $stmt = $this->connection->prepare(
            "INSERT INTO Reservations (customerId, reservationTime, numberOfGuests, specialRequests) 
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("isis", $customerId, $reservationTime, $numberOfGuests, $specialRequests);
        $stmt->execute();
        $stmt->close();

        echo "Reservation added successfully for customer ID: $customerId"; // Confirmation message
    }

    // Method to add a new customer
    public function addCustomer($customerName, $contactInfo) {
        $stmt = $this->connection->prepare(
            "INSERT INTO Customers (customerName, contactInfo) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $customerName, $contactInfo);
        $stmt->execute();
        $id = $stmt->insert_id; // Get the last inserted ID
        $stmt->close();
        return $id; // Return the customer ID
    }

    // Method to fetch all reservations
    public function getAllReservations() {
        $query = "
            SELECT 
                r.reservationId,
                r.customerId,
                r.reservationTime,
                r.numberOfGuests,
                r.specialRequests,
                c.customerName
            FROM 
                Reservations r
            JOIN 
                Customers c ON r.customerId = c.customerId
        ";

        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC); // Return all reservation data
    }

    // Method to get all customers
    public function getAllCustomers() {
        $query = "SELECT * FROM Customers";
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC); // Return all customer data
    }

    // Method to find reservation by ID
    public function findReservations($reservationId) {
        $stmt = $this->connection->prepare("SELECT * FROM reservations WHERE reservationId = ?");
        $stmt->bind_param("i", $reservationId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
           return $result->fetch_assoc(); // Return all reservations for the customer
        } else {
            echo "Error fetching reservations."; // Error message
        }
        $stmt->close();
    }

    // Method to modify a reservation
    public function modifyReservation($reservationId, $reservationTime, $numberOfGuests, $specialRequests) {
        $stmt = $this->connection->prepare("UPDATE reservations SET reservationTime = ?, numberOfGuests  = ?,  specialRequests = ? WHERE reservationId = ?");
        $stmt->bind_param("sisi", $reservationTime, $numberOfGuests, $specialRequests, $reservationId);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: index.php?action=viewReservations");
            } else {
                echo "No changes were made to the reservation."; // No rows affected
            }
        } else {
            echo "Error updating reservation: " . mysqli_error($this->connection);
        }

        $stmt->close();
    }

    // Method to delete a reservation
    public function deleteReservation($reservationId) {
        $stmt = $this->connection->prepare("DELETE FROM reservations WHERE reservationId = ?");
        $stmt->bind_param("i", $reservationId);
        if ($stmt->execute()) {
            header("Location: index.php?action=viewReservations");
        } else {
            echo "Error deleting reservation."; // Error message
        }
        $stmt->close();
    }

    // Method to find all reservations for a customer
    public function findAllReservations($customerId) {
        $stmt = $this->connection->prepare("SELECT * FROM reservations WHERE customerId = ?");
        $stmt->bind_param("i", $customerId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            print_r($result->fetch_all(MYSQLI_ASSOC)); // Print all reservations for the customer
        } else {
            echo "Error fetching reservations."; // Error message
        }
        $stmt->close();
    }

    // Method to get a customer's dining preferences
    public function getCustomerPreferences($customerId) {
        $stmt = $this->connection->prepare("SELECT * FROM DiningPreferences WHERE customerId = ?");
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        print_r($result->fetch_assoc()); // Print all dining preferences for the customer
    }

    // Method to update a special request for a reservation
    public function addSpecialRequest($reservationId, $requests) {
        $stmt = $this->connection->prepare("UPDATE reservations SET specialRequests = ? WHERE reservationId = ?");
        $stmt->bind_param("si", $requests, $reservationId);
        if ($stmt->execute()) {
            echo "Special request updated successfully."; // Confirmation message
        } else {
            echo "Error updating special request."; // Error message
        }
        $stmt->close();
    }

    // Method to search dining preferences of a customer
    public function searchPreferences($customerId) {
        $stmt = $this->connection->prepare("SELECT * FROM DiningPreferences WHERE customerId = ?");
        $stmt->bind_param("i", $customerId);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $preferences = $result->fetch_assoc();
            
            if ($preferences) {
                print_r($preferences); // Print dining preferences if found
            } else {
                echo "No preferences found for customer ID: $customerId."; // If no preferences found
            }
        } else {
            echo "Error fetching preferences for customer ID: $customerId."; // Error message
        }
        $stmt->close();
    }
}
?>
