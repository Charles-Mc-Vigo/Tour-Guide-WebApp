<?php
    function addTouristSpot($location, $touristSpot_Events, $description, $image)
    {
        $xml = simplexml_load_file('touristSpot.xml'); // Loading XML file containing tourist spots data

        if (!$xml) {
            $xml = new SimpleXMLElement('<TouristSpots></TouristSpots>'); // If the XML file doesn't exist, create a new root element
        }
            
        $newLocation = $xml->addChild('TouristLocation'); // Adding a new location as a child element

        // Adding child elements to the new location
        $newLocation->addChild('Location', $location);
        $newLocation->addChild('TouristSpots_Events', $touristSpot_Events);
        $newLocation->addChild('Description', $description);

        $imageFileName = $image['name']; 
        $imageFolderPath = 'uploads/' . $touristSpot_Events;
        if (!is_dir($imageFolderPath)) {
            mkdir($imageFolderPath, 0777, true); // Creating a new folder for the image if it doesn't exist
        }
        $imageFilePath = $imageFolderPath . '/' . $imageFileName;
        move_uploaded_file($image['tmp_name'], $imageFilePath); // Moving the uploaded image to the designated folder
        $newLocation->addChild('Image', $imageFilePath); // Adding the image path as a child element
        $xml->asXML('touristSpot.xml'); // Saving the updated XML file
        header("Location: admin.php"); // Redirecting back to the admin page
        exit();
    }

    function deleteTouristSpot($location)
    {
        $xml = simplexml_load_file('touristSpot.xml'); // Loading XML file containing tourist spots data
        
        $deletedLocation = $xml->xpath("//TouristLocation[Location = '{$location}']"); // Finding the location to be deleted
        
        if (!empty($deletedLocation)) {
            $deletedLocation = $deletedLocation[0];
            
            $imageFilePath = (string) $deletedLocation->Image;
            if (file_exists($imageFilePath)) {
                unlink($imageFilePath); // Deleting the associated image file
            }
            
            $imageFolderPath = dirname($imageFilePath);
            if (is_dir($imageFolderPath)) {
                $files = glob($imageFolderPath . '/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file); // Deleting all files within the image folder
                    }
                }
                rmdir($imageFolderPath); // Removing the image folder
            }
            
            unset($deletedLocation[0]); // Removing the location from the XML structure
            $xml->asXML('touristSpot.xml'); // Saving the updated XML file
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['location']) && isset($_POST['touristSpotOrEvents']) && isset($_POST['location-description'])) {
        $location = $_POST['location'];
        $touristSpot_Events = $_POST['touristSpotOrEvents'];
        $description = $_POST['location-description'];
        $image = $_FILES['image'];

        addTouristSpot($location, $touristSpot_Events, $description,$image); // Calling the function to add a tourist spot
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
        $location = $_GET['delete'];
        deleteTouristSpot($location); // Calling the function to delete a tourist spot
        header("Location: admin.php"); // Redirecting back to the admin page
        exit();
    }

    $xml = simplexml_load_file('touristSpot.xml'); // Loading XML file containing tourist spots data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TourGuide - Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section>
        <div class="admin-main">
            <div class="content-container">
                <form action="admin.php" method="post" enctype="multipart/form-data">
                    <h1 class="banner">Admin Dashboard</h1>
                    <ul>
                        <li>
                            <a href="index.php">Main</a>
                        </li>
                    </ul>
                    <h3 class="label-add">Add Tourist Spots</h3>
                    <input type="text" name="location" placeholder="Add location/Municipality" required>
                    <input type="text" name="touristSpotOrEvents" placeholder="Add Tourist Spot/Events" required>
                    <input type="text" name="location-description" placeholder="Add location description" class="description-container" required>
                    <label for="image" id="label-upload" >Upload Image here :<input type="file" name="image" accept="image/*" required></label>
                    <input type="submit" value="Add">
                </form>
            </div>
        </div>
    </section>
    <section>
        <div class="data-container">
            <h3>Existing Data</h3>
            <table>
                <tr>
                    <th>Location</th>
                    <th>Tourist Spot or Events</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach ($xml->TouristLocation as $index => $location) {
                        echo '<tr>';
                        echo '<td>' . $location->Location . '</td>';
                        echo '<td>' . $location->TouristSpots_Events . '</td>';
                        echo '<td id="Description-data">' . $location->Description . '</td>';
                        echo '<td><img src="' . $location->Image . '" alt="Image"></td>';
                        echo '<td><a href="admin.php?delete=' . urlencode($location->Location) . '" id="delete-button">Delete</a></td>';
                        echo '</tr>';
                    }
                ?>
            </table>
        </div>
    </section>
</body>
</html>
