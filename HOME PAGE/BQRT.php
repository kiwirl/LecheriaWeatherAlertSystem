<?php
    include ('../DATABASE/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BQRT - Barangay Quick Response Team</title>

    <link rel="stylesheet" href="../ASSETS/BQRT.css">
</head>
<body>
    <header>
        <img src="Lecheria Logo.png" alt="Digital Barangay Logo">
        <h1>Barangay Quick Response Team (BQRT)</h1>
    </header>

    <nav>
        <a href="Home Page.php">HOME</a>
        <a href="BQRT.php">BQRT</a>
        <a href="BARANGAY-OFFICIALS.php">BRGY OFFICIALS</a>
        
    </nav>

    <div class="container">
        <!-- Team Section -->
        <section class="team">
            <!-- Team Leader -->
            <?php
                    // Step 1: Connect to the Database
                    include ('../DATABASE/CONNECT.php'); // Include the file containing database connection code

                    // Step 2: Retrieve Data from the Database
                    $query = "SELECT * FROM admin WHERE official_info = 'BQRT Leader'"; // SQL query to select all columns from the vehicles table
                    $result = mysqli_query($conn, $query); // Execute the query

                    // Step 3: Check for Errors and Fetch Data
                    if ($result) {
                        // Step 4: Loop through fetched rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Step 5: Display Data
                            ?>
                            <div class="team-leader">
                                <img src="../MEDIA/<?php echo $row['official_photo']; ?>" alt="Team Leader Photo">
                                <h3><?php echo $row['official_name']; ?></h3>
                                <p><?php echo $row['official_info']; ?></p>
                                <p><strong>Contact: </strong><?php echo $row['official_contact']; ?></p>
                            </div>
                            <?php
                        }
                    } else {
                        // Handle database query error
                        echo "Error: " . mysqli_error($conn);
                    }
                ?>

            <!-- Members -->
            <div class="members">
                <!-- Add more members as needed -->
                <?php
                    // Step 1: Connect to the Database
                    include ('../DATABASE/CONNECT.php'); // Include the file containing database connection code

                    // Step 2: Retrieve Data from the Database
                    $query = "SELECT * FROM admin WHERE official_info = 'BQRT'"; // SQL query to select all columns from the vehicles table
                    $result = mysqli_query($conn, $query); // Execute the query

                    // Step 3: Check for Errors and Fetch Data
                    if ($result) {
                        // Step 4: Loop through fetched rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Step 5: Display Data
                            ?>
                            <div class="member" onclick="openModal('<?php echo $row['official_name']; ?>', '<?php echo $row['official_info']; ?>', '<?php echo $row['official_contact']; ?>')">
                                <img src="../MEDIA/<?php echo $row['official_photo']; ?>" alt="<?php echo $row['official_photo']; ?>">
                                <h3><?php echo $row['official_name']; ?></h3>
                                <p><?php echo $row['official_info']; ?></p>
                                <p><strong>Contact: </strong><?php echo $row['official_contact']; ?></p>
                            </div>
                            <?php
                        }
                    } else {
                        // Handle database query error
                        echo "Error: " . mysqli_error($conn);
                    }
                ?>
            </div>
        </section>

        <!-- About Us and Contact Information -->
        <div class="info">
            <section class="about-purpose">
                <h2>About Us & Purpose</h2>
                <p>The Barangay Quick Response Team (BQRT) is a dedicated group of volunteers trained to respond quickly during emergencies and disasters in our community. Our mission is to ensure the safety and well-being of our residents through preparedness, response, and recovery efforts.</p>
            </section>

            <section class="contacts">
                <h2>Contact Information</h2>
                <ul>
                    <li>Email: [example@example.com]</li>
                    <li>Phone: [09278005426]</li>
                    <li>Address: [Barangay Hall Address]</li>
                </ul>
            </section>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Barangay Quick Response Team. All rights reserved.</p>
    </footer>

    <script>
        // Function to check if an element is in the viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Function to animate elements on scroll, excluding the team leader
function animateOnScroll() {
    const animatedElements = document.querySelectorAll('.member, .info'); // Exclude .team-leader
    animatedElements.forEach(element => {
        if (isInViewport(element)) {
            element.style.opacity = '1';
            element.style.transform = 'scale(1)';
            element.style.animation = 'zoomIn 0.5s ease forwards';
        }
    });
}

// Add scroll event listener
window.addEventListener('scroll', animateOnScroll);
    </script>
</body>
</html>
