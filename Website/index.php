<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Guide</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section>
        <div class="head-navi">
            <h1 class="banner">Hidden Gem of Marinduque</h1>
            <ul>
                <li>
                    <a href="admin.php">Admin</a>
                </li>
            </ul>
            
            <form action="" method="post">
                <div class="search-bar">
                    <input type="text" id="search" name="search-location" placeholder="Search for location (e.g., Mogpog, Boac, Santa Cruz, etc.">
                    <input type="submit" id="search-button" value="Search">
                </div>
            </form>
            <div class="featured-events">
                <h2>Featured Events</h2>
                <img src="moriones_festival.jpg" alt="moriones festival">
                <p>The Moriones Festival is an annual religious and cultural event that takes place on the island of Marinduque, located in the Philippines. The festival typically occurs during the Holy Week, usually in April, and it commemorates the story of St. Longinus, a Roman centurion who converted to Christianity after Jesus was crucified. The Moriones are men and women in costumes and masks replicating the garb of biblical Imperial Roman soldiers as interpreted by locals.</p>
                <img src="bila bila fest.jpg" alt="bilabila festival">
                <p>Bila-Bila Festival (Boac, December): This festival is held in honor of the Immaculate Conception. The festival features street dancing and a parade of colorful floats that are decorated with flowers and other ornaments.</p>
                <img src="kangga fest.jpg" alt="kangga festival">
                <p>Kangga Festival (Mogpog, May): This festival is a celebration of the town’s patron saint, St. Isidore the Farmer. The festival features street dancing and a parade of colorful floats that are decorated with flowers and other ornaments.</p>
                <img src="haring_karabaw_festival.JPG" alt="haring karabaw festival">
                <p>Haring Karabaw Festival (Santa Cruz, January): This festival is held in honor of the carabao, which is considered as the farmer’s best friend. The festival features a parade of carabaos that are dressed up in colorful costumes and decorated with flowers and other ornaments.</p>
                <img src="kalesayahan fest.jpg" alt="kalesayahan festival">
                <p>Kalesayahan sa Gasan (Gasan, August): This festival is a celebration of the town’s founding anniversary. The festival features street dancing and a parade of colorful floats that are decorated with flowers and other ornaments.</p>
                <img src="kalutang_festival.jpg" alt="kalutang festival">
                <p>Kalutang Festival (February): This festival is a celebration of the traditional bamboo instrument called kalutang. The festival features performances by local musicians who play the kalutang and other traditional instruments.</p>
            </div>
        </div>
    </section>

    <section>
        <div class="data-searched">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $searchLocation = $_POST['search-location'];

                $xml = simplexml_load_file('touristSpot.xml');

                $matchingSpots = $xml->xpath("//TouristLocation[translate(Location, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz') = translate('$searchLocation', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz')]");

                if (!empty($matchingSpots)) {
                    echo '<h2 id="result-text"><i> Here are some interesting places to enjoy your travel!</i></h2>';
                    foreach ($matchingSpots as $spot) {
                        echo '<div class="location">';
                        echo '<h3>' . $spot->Location . '</h3>';
                        if (isset($spot->Image)) {
                            echo '<a href="' . $spot->Image . '"><img src="' . $spot->Image . '" alt="Location Image"></a>';
                        }
                        echo '<h2>' . $spot->TouristSpots_Events . '</h2>';
                        echo '<p id="description-size">' . $spot->Description . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p id="no-result">No matching tourist spots found!.</p>';
                }
            }
            ?>
        </div>
    </section>
</body>
</html>
