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

// Check if there's a search query in the URL
if(isset($_GET['q'])) {
    $search_query = $_GET['q'];
    $results = search_images($search_query);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the search string is submitted
    if (isset($_POST["search_string"])) {
        $search_string = $_POST["search_string"];

        // Store the search string in session for later use in the sidebar
        if (!isset($_SESSION['search_queries'])) {
            $_SESSION['search_queries'] = array();
        }
        // Add the new search query to the array of previous queries
        array_push($_SESSION['search_queries'], $search_string);

        // Redirect to the same page with the search query in the URL
        header("Location: ".$_SERVER['PHP_SELF']."?q=".urlencode($search_string));
        exit;
    }
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Picture Library</title>
    <link rel="stylesheet" href="../css/search.css">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="library__header">
            <h2 class="library__title uppercase">Images library</h2>
        </div>

        <!-- Keywords from Previous Searches -->
        <div class="sidebar__keywords">
            <div class="text-center">
                <h3 class="py-4">Your Previous Keywords</h3>
                <hr class="m-0" />
            </div>
            <ul class="sidenav-menu">
                <?php if(isset($_SESSION['search_queries'])): ?>
                    <?php foreach($_SESSION['search_queries'] as $query): ?>
                        <li class="sidenav-item">
                            <a href="?q=<?php echo urlencode($query); ?>" class="sidenav-link">
                                <span><?php echo strtoupper($query); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Search Function -->
        <div class="sidebar__search">
            <div class="input-group rounded">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label>
                        <input type="search" class="form-control" name="search_string" placeholder="Search for images">
                    </label>
                    <button type="submit" class="btn btn-primary library__search-btn">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>


    <!-- Library box -->
    <div class="library">
        <div class="library__main">
            <?php if(isset($results) && $results->total > 0): ?> <!-- Check if there are search results -->
                <div class="library__list">
                    <?php foreach($results->results as $result): ?>
                        <div class="library__list-item">
                            <img src="<?php echo $result->urls->regular; ?>" alt="<?php echo $result->alt_description; ?>">
                            <p>Likes: <?php echo $result->likes; ?></p>
                            <p>Description: <?php echo $result->description; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

</body>
</html>
