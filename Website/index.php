<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Guide</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS file -->
</head>
<body>
    <section>
        <div class="head-navi">
            <h1 class="banner">Hidden Gem of Marinduque</h1>
            <form action="" method="post"> <!-- Form for searching locations -->
                <div class="search-bar">
                    <input type="text" id="search" name="search-location" placeholder="Search for location (e.g., Mogpog, Boac, Santa Cruz, etc."> <!-- Input field to enter the search location -->
                    <input type="submit" id="search-button" value="Search"> <!-- Submit button to initiate the search -->
                </div>
            </form>
            <div class="featured-events">
                <h2>Featured Events</h2>
                <!-- Images and descriptions of featured events -->
                <img src="moriones_festival.jpg" alt="moriones festival">
                <p>The Moriones Festival is an annual religious and cultural event...</p>

                <img src="bila bila fest.jpg" alt="bilabila festival">
                <p>Bila-Bila Festival (Boac, December): This festival is held in honor of the Immaculate Conception...</p>

                <img src="kangga fest.jpg" alt="kangga festival">
                <p>Kangga Festival (Mogpog, May): This festival is a celebration of the town’s patron saint...</p>

                <img src="haring_karabaw_festival.JPG" alt="haring karabaw festival">
                <p>Haring Karabaw Festival (Santa Cruz, January): This festival is held in honor of the carabao...</p>

                <img src="kalesayahan fest.jpg" alt="kalesayahan festival">
                <p>Kalesayahan sa Gasan (Gasan, August): This festival is a celebration of the town’s founding anniversary...</p>

                <img src="kalutang_festival.jpg" alt="kalutang festival">
                <p>Kalutang Festival (February): This festival is a celebration of the traditional bamboo instrument called kalutang...</p>
            </div>
        </div>
    </section>

    <section>
        <div class="data-searched">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $searchLocation = $_POST['search-location'];

                $xml = simplexml_load_file('touristSpot.xml'); // Loading XML file containing tourist spots data

                // Searching for matching spots based on the entered location
                $matchingSpots = $xml->xpath("//TouristLocation[translate(Location, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz') = translate('$searchLocation', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz')]");

                if (!empty($matchingSpots)) {
                    echo '<h2 id="result-text"><i> Here are some interesting places to enjoy your travel!</i></h2>';
                    foreach ($matchingSpots as $spot) {
                        echo '<div class="location">';
                        echo '<h3>' . $spot->Location . '</h3>'; // Displaying location name
                        if (isset($spot->Image)) {
                            echo '<a href="' . $spot->Image . '"><img src="' . $spot->Image . '" alt="Location Image"></a>'; // Displaying image (if available) with a link to the image source
                        }
                        echo '<h2>' . $spot->TouristSpots_Events . '</h2>'; // Displaying the name of the tourist spots or events
                        echo '<p id="description-size">' . $spot->Description . '</p>'; // Displaying the description of the location
                        echo '</div>';
                    }
                } else {
                    echo '<p id="no-result">No matching tourist spots found!.</p>'; // Displaying a message when no matching spots are found
                }
            }
            ?>
        </div>
    </section>
</body>
</html>
