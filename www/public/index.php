<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the wacky world of LSCreativity</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/js.js" defer></script>
</head>
<body>
<header>
    <div class="wrapper">
        <nav>
            <ul>
                <li> <a href="model/login.php">Login</a></li>
                <li> <a href="model/register.php">Register</a></li>
                <li> <a href="#description">Description</a></li>
            </ul>
        </nav>
    </div>
</header>

<section id="main-image">
    <div class="text-overlay">
        <h2>Wacky World Of<br><strong>LSCreativity!</strong></h2>
        <a href="model/login.php" class="button-1">Login</a>
    </div>
</section>

<section id="steps">
    <div class="wrapper">
        <ul>
            <li id="step-1">
                <h4 >Discover</h4>
                <p>Explore the vast collection of stunning images available through the Unsplash API. Dive into a world of creativity and inspiration as you discover new visuals for your project.</p>
            </li>
            <li id="step-2">
                <h4 >Customize</h4>
                <p>Personalize your image grid by experimenting with different API requests and customization options. Tailor the appearance and layout to perfectly match your creative vision.</p>
            </li>
            <li id="step-3">
                <h4 >Create</h4>
                <p>Let your imagination run wild and create an awe-inspiring image grid that showcases your unique style and creativity. With the power of the Unsplash API, the possibilities are endless!</p>
            </li>
            <div class="clear"></div>
        </ul>
    </div>
</section>


<section id="description">
    <div class="wrapper">
        <article class="article-1">
            <div class="overlay">
                <h4>Be Creative Start Now!</h4>
                <a href="model/register.php" class="button-2">Register</a>
            </div>
        </article>

        <article class="article-2">
            <div class="overlay">
                <h4>Search For Images!</h4>
                <a href="model/search.php" class="button-2">Search</a>
            </div>
        </article>
        <div class="clear"></div>
    </div>
</section>


<section id="contact">
    <div class="wrapper">
        <h3>Contact Us</h3>
        <p>Have questions or need assistance? Feel free to reach out to us. We're here to help you with any inquiries regarding our image gallery program.</p>
        <form id="contact-form" action="">
            <label for="name">Name</label>
            <input type="text" id="name" placeholder="Your name">
            <label for="email">Email</label>
            <input type="text" id="email" placeholder="Your email">
            <input type="submit" value="Submit" class="button-3">
        </form>
    </div>
</section>

<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close">&times;</span>
        <p>Thank you for contacting LSCREATIVITY! We will get back to you shortly.</p>
    </div>
</div>

<footer>
    <div class="wrapper">
        <h1>Wacky PHP<span class="orange">.</span></h1>
        <div class="copyright">Copyright © 2024. All rights reserved.</div>
    </div>
</footer>
</body>
