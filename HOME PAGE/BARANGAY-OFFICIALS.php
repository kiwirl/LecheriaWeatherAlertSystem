<?php
    include ('../DATABASE/CONNECT.php'); // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Officials</title>
    <link rel="stylesheet" href="../ASSETS/BARANGAY-OFFICIALS.css">
</head>
<body>
    <header>
        <img src="Lecheria Logo.png" alt="Barangay Logo">
        <h1>Barangay Officials</h1>
    </header>

    <nav>
        <a href="Home Page.php">HOME</a>
        <a href="BQRT.php">BQRT</a>
        <a href="BARANGAY-OFFICIALS.php">BRGY OFFICIALS</a>
        
    </nav>

    <div class="container">
        <section class="brgy-officials">
            <!-- Barangay Chairman -->
            <?php
                // Retrieve Barangay Chairman data
                $query = "SELECT * FROM admin WHERE official_info LIKE '%Captain%'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="chairman" onclick="openModal('<?php echo $row['official_name']; ?>', '<?php echo $row['official_info']; ?>', '<?php echo $row['official_contact']; ?>')">
                            <img src="../MEDIA/<?php echo $row['official_photo']; ?>" alt="<?php echo $row['official_photo']; ?>">
                            <h3><?php echo $row['official_name']; ?></h3>
                            <p><?php echo $row['official_info']; ?></p>
                            <p><strong>Contact: </strong><?php echo $row['official_contact']; ?></p>
                        </div>
                        <?php
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            ?>

            <!-- Other Officials -->
            <div class="officials">
                <?php
                    // Retrieve other Barangay Officials data (excluding BQRT and Chairman)
                    $query = "SELECT * FROM admin 
                              WHERE official_info NOT LIKE 'BQRT%' 
                              AND official_info NOT LIKE '%Captain%' 
                              AND official_info NOT LIKE 'BQRT Leader'";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="official" onclick="openModal('<?php echo $row['official_name']; ?>', '<?php echo $row['official_info']; ?>', '<?php echo $row['official_contact']; ?>')">
                                <img src="../MEDIA/<?php echo $row['official_photo']; ?>" alt="<?php echo $row['official_photo']; ?>">
                                <h3><?php echo $row['official_name']; ?></h3>
                                <p><?php echo $row['official_info']; ?></p>
                                <p><strong>Contact: </strong><?php echo $row['official_contact']; ?></p>
                            </div>
                            <?php
                        }
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                ?>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 Barangay Officials. All rights reserved.</p>
    </footer>

    <!-- Modal for displaying official details -->
    <div class="modal" id="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modal-title"></h2>
            <p id="modal-info"></p>
            <p><strong>Contact:</strong> <span id="modal-contact"></span></p>
        </div>
    </div>

    <script>
        function openModal(name, info, contact) {
            document.getElementById('modal-title').innerText = name;
            document.getElementById('modal-info').innerText = info;
            document.getElementById('modal-contact').innerText = contact;
            document.getElementById('modal').style.display = 'flex'; // Show the modal
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none'; // Hide the modal
        }
    </script>
</body>
</html>
