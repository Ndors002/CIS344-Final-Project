CREATE DATABASE restaurant_reservations;

USE restaurant_reservations;

CREATE TABLE Customers (
    customerId INT NOT NULL AUTO_INCREMENT,
    customerName VARCHAR(45) NOT NULL,
    contactInfo VARCHAR(200),
    PRIMARY KEY (customerId)
);

CREATE TABLE Reservations (
    reservationId INT NOT NULL AUTO_INCREMENT,
    customerId INT NOT NULL,
    reservationTime DATETIME NOT NULL,
    numberOfGuests INT NOT NULL,
    specialRequests VARCHAR(200),
    PRIMARY KEY (reservationId),
    FOREIGN KEY (customerId) REFERENCES Customers(customerId)
);

CREATE TABLE DiningPreferences (
    preferenceId INT NOT NULL AUTO_INCREMENT,
    customerId INT NOT NULL,
    favoriteTable VARCHAR(45),
    dietaryRestrictions VARCHAR(200),
    PRIMARY KEY (preferenceId),
    FOREIGN KEY (customerId) REFERENCES Customers(customerId)
);

INSERT INTO Customers (customerName, contactInfo)
VALUES
('John Doe', 'john@example.com'),
('Jane Smith', 'jane@example.com'),
('Emily Brown', 'emily@example.com');

INSERT INTO Reservations (customerId, reservationTime, numberOfGuests, specialRequests)
VALUES
(1, '2024-12-06 19:00:00', 2, 'Window table, birthday celebration'),
(2, '2024-12-07 18:30:00', 4, 'No special requests'),
(3, '2024-12-08 20:00:00', 3, 'Vegan meal preferred');

INSERT INTO DiningPreferences (customerId, favoriteTable, dietaryRestrictions)
VALUES
(1, 'Table 5', 'None'),
(2, 'Table 7', 'Gluten-free'),
(3, 'Table 10', 'Vegan');

