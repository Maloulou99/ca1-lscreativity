<?php
ob_start();
session_start();



// Function to perform API call to Unsplash
function search_images($query) {
    $access_key = "94wIg18iqrb1kNo-v793q7AEi3bRQYF1ANwDciPXBsI";
    $base_url = "https://api.unsplash.com/search/photos";

    // Constructing the URL with the query string
    $url = $base_url . "?query=" . urlencode($query) . "&client_id=" . $access_key;

    // Performing the API call
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the search string is submitted
    if (isset($_POST["search_string"])) {
        $search_string = $_POST["search_string"];

        // Perform API call to Unsplash
        $results = search_images($search_string);
    }
}

ob_end_flush();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Picture Library</title>
    <link rel="stylesheet" href="../css/search.css">
</head>
<body>
<div class="library">
    <div class="library__header">
        <h3 class="library__title">Picture library</h3>
        <a href="#" class="library__close">x</a>
    </div>
    <div class="library__main">
        <div class="library__list-container">
            <div class="library__filters">
                <div class="library__search">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <label class="library__search-label" for="textInput">Search for images:</label>
                        <label for="search_string"></label><input class="library__search-input" name="search_string" id="search_string" type="text">
                        <button class="library__search-btn">Search</button>
                    </form>
                </div>
            </div>
            <div class="library__list">
                <?php if(isset($results) && $results->total > 0): ?>
                    <?php foreach($results->results as $result): ?>
                        <div class="library__list-item">
                            <img src="<?php echo $result->urls->regular; ?>" alt="<?php echo $result->alt_description; ?>">
                            <p>Likes: <?php echo $result->likes; ?></p>
                            <p>Description: <?php echo $result->description; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="library__footer">
        <div class="library__footer-section">
            <button>< Last</button>
            <button>Next ></button>
            Page 1 of 100072
        </div>
        <div class="library__footer-section">
            <button>Cancel</button>
            <button disabled>Insert</button>
        </div>
    </div>
</div>
</body>
</html>
