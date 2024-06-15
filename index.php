<?php
session_start();

// Set session timeout to 2 minutes (120 seconds)
ini_set('session.gc_maxlifetime', 120);

// Regenerate session ID every time the user's privilege level changes or on a timer
session_regenerate_id(true);

// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Update last activity time stamp to extend session
$_SESSION['last_activity'] = time();

$db_host = $_SERVER['DB_HOST'];
$db_user = $_SERVER['DB_USER'];
$db_password = $_SERVER['DB_PASSWORD'];
$db_name = $_SERVER['DB_NAME'];

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$user_id = $_SESSION['user_id'];

// Sanitize user_id to prevent SQL injection
$user_id = (int)$user_id;

// Use prepared statement to fetch user information
$query = $mysqli->prepare("SELECT first_name FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = htmlspecialchars($row['first_name']);
} else {
    echo "No results";
}

$query->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Macana Bakes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
    <style>
        body, html {
            height: 100%;
            font-family: "Inconsolata", sans-serif;
        }

        .bgimg {
            background-position: center;
            background-size: cover;
            background-image: url("https://www.w3schools.com/w3images/coffeehouse.jpg");
            min-height: 75%;
        }

        .menu {
            display: none;
        }
    </style>
</head>
<body>

<!-- Links (sit on top) -->
<div class="w3-top">
    <div class="w3-row w3-padding w3-black">
        <div class="w3-col s2">
            <a href="#" class="w3-button w3-block w3-black">HOME</a>
        </div>
        <div class="w3-col s2">
            <a href="#about" class="w3-button w3-block w3-black">ABOUT</a>
        </div>
        <div class="w3-col s2">
            <a href="#menu" class="w3-button w3-block w3-black">MENU</a>
        </div>
        <div class="w3-col s2">
            <a href="#where" class="w3-button w3-block w3-black">WHERE</a>
        </div>
        <div class="w3-col s2">
            <div class="w3-dropdown-hover">
                <button class="w3-button w3-black">Welcome, <?php echo $first_name; ?></button>
                <div class="w3-dropdown-content w3-bar-block w3-card-4">
                    <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Header with image -->
<header class="bgimg w3-display-container w3-grayscale-min" id="home">
    <div class="w3-display-bottomleft w3-center w3-padding-large w3-hide-small">
        <span class="w3-tag">Open from 6am to 5pm</span>
    </div>
    <div class="w3-display-middle w3-center">
        <span class="w3-text-white" style="font-size:90px">MACANIA<br>BAKES</span>
    </div>
    <div class="w3-display-bottomright w3-center w3-padding-large">
        <span class="w3-text-white">15 Adr street, 5015</span>
    </div>
</header>

<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-grayscale w3-large">

<!-- About Container -->
<div class="w3-container" id="about">
    <div class="w3-content" style="max-width:700px">
        <h5 class="w3-center w3-padding-64"><span class="w3-tag w3-wide">ABOUT THE CAFE</span></h5>
        <p>The Cafe was founded in blabla by Mr. Smith in lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <p>In addition to our full espresso and brew bar menu, we serve fresh made-to-order breakfast and lunch sandwiches, as well as a selection of sides and salads and other good stuff.</p>
        <div class="w3-panel w3-leftbar w3-light-grey">
            <p><i>"Use products from nature for what it's worth - but never too early, nor too late." Fresh is the new sweet.</i></p>
            <p>Chef, Coffeeist and Owner: Liam Brown</p>
        </div>
        <img src="https://www.w3schools.com/w3images/coffeeshop.jpg" style="width:100%;max-width:1000px" class="w3-margin-top">
        <p><strong>Opening hours:</strong> everyday from 6am to 5pm.</p>
        <p><strong>Address:</strong> 15 Adr street, 5015, NY</p>
    </div>
</div>

<!-- Menu Container -->
<div class="w3-container" id="menu">
    <div class="w3-content" style="max-width:700px">

        <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">THE MENU</span></h5>

        <div class="w3-row w3-center w3-card w3-padding">
            <a href="javascript:void(0)" onclick="openMenu(event, 'Eat');" id="myLink">
                <div class="w3-col s6 tablink">Eat</div>
            </a>
            <a href="javascript:void(0)" onclick="openMenu(event, 'Drinks');">
                <div class="w3-col s6 tablink">Drink</div>
            </a>
        </div>

        <div id="Eat" class="w3-container menu w3-padding-48 w3-card">
            <h5>Bread Basket</h5>
            <p class="w3-text-grey">Assortment of fresh baked fruit breads and muffins 5.50</p><br>

            <h5>Honey Almond Granola with Fruits</h5>
            <p class="w3-text-grey">Natural cereal of honey toasted oats, raisins, almonds and dates 7.00</p><br>

            <h5>Belgian Waffle</h5>
            <p class="w3-text-grey">Vanilla flavored batter with malted flour 7.50</p><br>

            <h5>Scrambled eggs</h5>
            <p class="w3-text-grey">Scrambled eggs, roasted red pepper and garlic, with green onions 7.50</p><br>

            <h5>Blueberry Pancakes</h5>
            <p class="w3-text-grey">With syrup, butter and lots of berries 8.50</p>
        </div>

        <div id="Drinks" class="w3-container menu w3-padding-48 w3-card">
            <h5>Coffee</h5>
            <p class="w3-text-grey">Regular coffee 2.50</p><br>

            <h5>Chocolato</h5>
            <p class="w3-text-grey">Chocolate espresso with milk 4.50</p><br>

            <h5>Corretto</h5>
            <p class="w3-text-grey">Whiskey and coffee 5.00</p><br>

            <h5>Iced tea</h5>
            <p class="w3-text-grey">Hot tea, except not hot 3.00</p><br>

            <h5>Soda</h5>
            <p class="w3-text-grey">Coke, Sprite, Fanta, etc. 2.50</p>
        </div>
        <img src="https://www.w3schools.com/w3images/coffeehouse2.jpg" style="width:100%;max-width:1000px;margin-top:32px;">
    </div>
</div>

<!-- Contact/Area Container -->
<?php
include 'csrf.php';
?>
<div class="w3-container" id="where" style="padding-bottom:32px;">
    <div class="w3-content" style="max-width:700px">
        <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">RESERVE A TABLE</span></h5>
        <form action="process_reservation.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCSRFToken()); ?>">
            <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Name" required name="Name"></p>
            <p><input class="w3-input w3-padding-16 w3-border" type="number" placeholder="How many people" required name="People"></p>
            <p><input class="w3-input w3-padding-16 w3-border" type="datetime-local" placeholder="Date and time" required name="date" value="2020-11-16T20:00"></p>
            <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Message \ Special requirements" required name="Message"></p>
            <p><button class="w3-button w3-black" type="submit">SUBMIT</button></p>
        </form>
    </div>
</div>

<!-- End page content -->
</div>

<script>
// Tabbed Menu
function openMenu(evt, menuName) {
    var i, x, tablinks;
    x = document.getElementsByClassName("menu");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" w3-dark-grey", "");
    }
    document.getElementById(menuName).style.display = "block";
    evt.currentTarget.firstElementChild.className += " w3-dark-grey";
}
document.getElementById("myLink").click();
</script>

</body>
</html>
