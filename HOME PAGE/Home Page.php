<?php
    include ('../DATABASE/connect.php');

    // Define constants
    $BASE_URL = "http://api.openweathermap.org/data/2.5/weather?";
    $API_KEY = "cd6ea3830a487d7be38b9fd2f77048e0";

    // Input City (can replace with dynamic input)
    $CITY = "Calamba"; // Change this to the city you want or take it from a form input

    // Function to convert Kelvin to Celsius and Fahrenheit
    function kelvin_to_celsius_fahrenheit($kelvin) {
        $celsius = $kelvin - 273.15;
        $fahrenheit = $celsius * (9/5) + 32;
        return [$celsius, $fahrenheit];
    }

    // Function to convert Kelvin to Celsius
    function kelvin_to_celsius($kelvin) {
        return $kelvin - 273.15;
    }

    // Build the API URL
    $url = $BASE_URL . "appid=" . $API_KEY . "&q=" . urlencode($CITY);

    // Call the API and get the response
    $response = file_get_contents($url);
    $responseData = json_decode($response, true);

    // Get high and low temperature for the day
    $temp_max_kelvin = $responseData['main']['temp_max'];
    $temp_min_kelvin = $responseData['main']['temp_min'];
    $temp_max_celsius = kelvin_to_celsius($temp_max_kelvin);
    $temp_min_celsius = kelvin_to_celsius($temp_min_kelvin);

    // Check if the response is valid
    if ($responseData && $responseData['cod'] == 200) {
        // Get the weather description
        $description = $responseData['weather'][0]['description'];
    } else {
        echo "Error: Unable to retrieve weather data for {$CITY}. Please check the city name or try again later.\n";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Barangay</title>

    <link rel="stylesheet" href="../ASSETS/Home-Page.css">
</head>
<body>
    <header>
        <img src="Lecheria Logo.png" alt="Digital Barangay Logo">
        <div>
            <h1>Barangay Lecheria</h1>
            <p>A Community Weather Alert System</p>
        </div>
    </header>

    <nav>
        <a href="Home Page.php">HOME</a>
        <a href="BQRT.php">BQRT</a>
        <a href="BARANGAY-OFFICIALS.php">BRGY OFFICIALS</a>
        
    </nav>

    <!-- Main Content Container -->
    <div class="content-container">
        <!-- Left Section for Weather and Reminders -->
        <div class="left-section">
            <!-- Today's Weather Section with History Toggle -->
            <div class="weather">
                <h2>Today's Weather at Calamba</h2>
                <p><?php echo ucwords($description); ?> with a highest temperature of 
                    <?php echo $temp_max_celsius; ?>°C and a lowest of <?php echo $temp_min_celsius; ?>°C. Please carry an umbrella just in case.</p>
                <div id="weatherHistory" class="scrollable" style="display:none;">
                    <h3>Past Weather Updates</h3>
                    <ul>
                        <li>October 16, 2024: Rainy, with scattered thunderstorms. High of 28°C.</li>
                        <li>October 15, 2024: Cloudy, with occasional sunshine. High of 30°C.</li>
                    </ul>
                </div>
                <button class="toggle-button" onclick="toggleHistory('weatherHistory')">Show Past Weather Updates</button>
            </div>

            <!-- Reminders Section with History Toggle -->
            <div class="reminders">
                <h2>Barangay Reminders</h2>
                <div id="remindersDisplay">
                    <!-- Published reminders will appear here -->
                </div>
                <div id="remindersHistory" class="scrollable" style="display:none;">
                    <h3>Past Reminders</h3>
                    <ul>
                        <li>October 8, 2024: Keep the streets clean during the holidays.</li>
                        <li>October 1, 2024: Barangay cleanup event next Sunday. Join us!</li>
                    </ul>
                </div>
                <button class="toggle-button" onclick="toggleHistory('remindersHistory')">Show Past Reminders</button>
            </div>
        </div>

        <!-- Right Section for Map -->
        <div class="right-section">
            <div class="map">
                <h2>Barangay Map</h2>
                <?php
                    if (isset($_GET['city'])) {
                        $CITY = $_GET['city'];
                    }
                ?>
                <h5><?php echo "Today's weather in {$CITY}: {$description}."; ?></h5>
                <div class="map-container">
                    <?xml version="1.0" encoding="UTF-8" standalone="no"?>
                    <?php include('../MAP.php') ?>
                </div>

                <div class="controls">
                        <h2> RAINFALL LEVEL</h2>
                        <button style="background-color: #9eff99; color: #000000; padding: 10px 20px; border-radius: 5px; cursor: pointer;)">Good Weather</button>
                        <button style="background-color: #efff6f; color: #000000; padding: 10px 20px; border-radius: 5px; cursor: pointer;)">Light Rain</button>
                        <button style="background-color: #ffab40; color: #000000; padding: 10px 20px; border-radius: 5px; cursor: pointer;)">Moderate Rain</button>
                        <button style="background-color: #ff2e2e; color: #000000; padding: 10px 20px; border-radius: 5px; cursor: pointer;)">Heavy Rain</button>
                </div>
                <!-- Add Floating Button Trigger Here -->
                <div class="map-button-container">
                    <button class="map-button" onclick="toggleFloatingContainer()">Show Map Info</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Container -->
    <div id="floating-container" class="floating-container">
    <div class="floating-content">
        <h3>Map Information</h3>
        <div class="sitio-info">
            <h4>Kanluran</h4>
            <img src="Empty Profile.png" alt="Sitio 1" class="sitio-image">
            <p>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="sitio-info">
            <h4>Ronggot</h4>
            <img src="Empty Profile.png" alt="Sitio 2" class="sitio-image">
            <p>Description: Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        <!-- Add more Sitio sections as needed -->
    </div>
    <button class="close-btn" onclick="toggleFloatingContainer()">Close</button>
</div>


<!-- Floating Button Container -->
<div class="floating-btn-container">
    <button class="floating-btn" onclick="toggleDropdown()">☎️</button>
    <div class="floating-btn-dropdown">
        <a href="https://www.facebook.com/profile.php?id=61553815761131" target="_blank" id="facebookBtn">
            <img src="Facebook Logo.png" alt="Facebook" class="social-icon"> Go to Facebook Page
        </a>
        <a href="https://m.me/61553815761131" target="_blank" id="messengerBtn">
            <img src="Messenger Logo.png" alt="Messenger" class="social-icon"> Chat on Messenger
        </a>
    </div>
</div>

    <footer>
        <p>&copy; 2024 Barangay Lecheria. All Rights Reserved.</p>
    </footer>

    <script>
        function displayRemindersOnHomepage() {
            const remindersDisplay = document.getElementById("remindersDisplay");
            remindersDisplay.innerHTML = ""; // Clear previous reminders

            // Fetch reminders from local storage
            let reminders = localStorage.getItem("reminders");
            reminders = reminders ? JSON.parse(reminders) : [];

            // Populate reminders
            reminders.forEach(reminder => {
                const reminderElement = document.createElement("div");
                reminderElement.classList.add("reminder-item");

                const titleElement = document.createElement("h3");
                titleElement.textContent = reminder.title;

                const contentElement = document.createElement("p");
                contentElement.textContent = reminder.content;

                reminderElement.appendChild(titleElement);
                reminderElement.appendChild(contentElement);
                remindersDisplay.appendChild(reminderElement);
            });
        }

        // Load reminders on homepage load
        window.onload = displayRemindersOnHomepage;

        function toggleFloatingContainer() {
            const container = document.getElementById("floating-container");
            container.style.display = container.style.display === "none" ? "block" : "none";
        }

        function toggleDropdown() {
    const dropdown = document.querySelector('.floating-btn-dropdown');
    dropdown.classList.toggle('active');
}

        function toggleHistory(historyId) {
            const historyElement = document.getElementById(historyId);
            historyElement.style.display = historyElement.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
