<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Your Cart | Hifza's Cafe</title>

    <link rel="stylesheet" href="../css/style.css">

</head>


<body>


<!-- ================= NAVIGATION ================= -->

<header class="navbar">

    <div class="nav-logo">

        <img
            src="../assets/logo.jpeg"
            alt="Hifza's Cafe Logo"
        >

    </div>


    <nav>

        <a href="../index.php">Home</a>

        <a href="about.php">About</a>

        <a href="menu.php">Menu</a>

        <a href="order.php">Place an Order</a>

        <a href="contact.php">Contact Us</a>
		
		<a href="cart.php"> Cart (0)</a>

    </nav>

</header>



<!-- ================= CART PAGE ================= -->

<main class="cart-page">


    <section class="cart-heading">

        <span class="section-label">
            YOUR SELECTION
        </span>

        <h1>
            Your Cart 🛒🩷
        </h1>

        <p>
            Review your favorite treats before placing your order.
        </p>

    </section>



    <section class="cart-section">

        <div
            id="cart-container"
            class="cart-container"
        >
        </div>


        <div
            id="cart-summary"
            class="cart-summary"
        >
        </div>

    </section>


</main>


<script src="../js/cart.js"></script>

</body>

</html>