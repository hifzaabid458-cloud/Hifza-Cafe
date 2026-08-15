<?php

require_once "../config/database/db.php";

$message = "";
$clearCart = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $customer_name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $special_instructions = trim($_POST["message"] ?? "");
    $cart_data = $_POST["cart_data"] ?? "";

    $cart = json_decode($cart_data, true);

    /*
     * If cart contains items, save every cart item.
     * Otherwise, use the manually selected item.
     */

    if (!empty($cart) && is_array($cart)) {

        $success = true;

        foreach ($cart as $cartItem) {

            $item_name = trim($cartItem["name"] ?? "");
            $quantity = (int) ($cartItem["quantity"] ?? 1);

            if ($item_name === "" || $quantity < 1) {
                continue;
            }

            $sql = "INSERT INTO orders
                    (Customer_name, Phone, Item_name, Quantity, Special_instructions)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                $success = false;
                break;
            }

            $stmt->bind_param(
                "sssis",
                $customer_name,
                $phone,
                $item_name,
                $quantity,
                $special_instructions
            );

            if (!$stmt->execute()) {
                $success = false;
                $stmt->close();
                break;
            }

            $stmt->close();
        }

        if ($success) {

            $message = "Your order has been placed successfully! 🩷";
            $clearCart = true;

        } else {

            $message = "Sorry, your order could not be placed.";

        }

    } else {

        /*
         * Manual order fallback
         */

        $item_name = trim($_POST["item"] ?? "");
        $quantity = (int) ($_POST["quantity"] ?? 1);

        if (
            $customer_name === "" ||
            $phone === "" ||
            $item_name === "" ||
            $quantity < 1
        ) {

            $message = "Please fill in all required fields.";

        } else {

            $sql = "INSERT INTO orders
                    (Customer_name, Phone, Item_name, Quantity, Special_instructions)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            if ($stmt) {

                $stmt->bind_param(
                    "sssis",
                    $customer_name,
                    $phone,
                    $item_name,
                    $quantity,
                    $special_instructions
                );

                if ($stmt->execute()) {

                    $message = "Your order has been placed successfully! 🩷";

                } else {

                    $message = "Sorry, your order could not be placed.";

                }

                $stmt->close();

            } else {

                $message = "Something went wrong. Please try again.";

            }

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Place an Order | Hifza's Cafe</title>

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

        <a href="cart.php">🛒 Cart (0)</a>

        <a href="contact.php">Contact Us</a>

    </nav>

</header>



<!-- ================= SUCCESS MESSAGE ================= -->

<?php if (!empty($message)): ?>

    <div class="order-message">

        <?php echo htmlspecialchars($message); ?>

    </div>

<?php endif; ?>



<!-- ================= ORDER PAGE ================= -->

<main class="order-page">


    <section class="order-heading">

        <span class="section-label">
            ORDER SOMETHING DELICIOUS
        </span>

        <h1>
            Place Your Order 🩷
        </h1>

        <p>
            Choose your favorite treat and let
            Hifza's Cafe make your moment sweeter.
        </p>

    </section>



    <section class="order-section">


        <div class="order-card">


            <form action="" method="post">


                <!-- Hidden Cart Data -->

                <input
                    type="hidden"
                    id="cart-data"
                    name="cart_data"
                >


                <!-- Customer Name -->

                <div class="form-group">

                    <label for="name">
                        Your Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your name"
                        required
                    >

                </div>



                <!-- Phone -->

                <div class="form-group">

                    <label for="phone">
                        Phone Number
                    </label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="03XX-XXXXXXX"
                        required
                    >

                </div>



                <!-- Select Item -->

                <div class="form-group">

                    <label for="item">
                        Choose Your Favorite
                    </label>

                    <select
                        id="item"
                        name="item"
                    >

                        <option value="">
                            Select an item
                        </option>

                        <optgroup label="☕ Coffee">

                            <option value="Rose Gold Latte">
                                Rose Gold Latte — Rs. 450
                            </option>

                            <option value="Classic Cappuccino">
                                Classic Cappuccino — Rs. 500
                            </option>

                            <option value="Iced Vanilla Cloud Latte">
                                Iced Vanilla Cloud Latte — Rs. 300
                            </option>

                            <option value="Spanish Latte">
                                Spanish Latte — Rs. 600
                            </option>

                        </optgroup>


                        <optgroup label="🫖 Tea">

                            <option value="Pink Dragonfruit Tea">
                                Pink Dragonfruit Tea — Rs. 350
                            </option>

                            <option value="Strawberry Matcha Latte">
                                Strawberry Matcha Latte — Rs. 420
                            </option>

                            <option value="Earl Grey Lavender">
                                Earl Grey Lavender — Rs. 370
                            </option>

                            <option value="Lychee Rose White Tea">
                                Lychee Rose White Tea — Rs. 210
                            </option>

                        </optgroup>


                        <optgroup label="🥐 Breakfast">

                            <option value="Danish Pastry">
                                Danish Pastry — Rs. 250
                            </option>

                            <option value="Croissant">
                                Croissant — Rs. 280
                            </option>

                            <option value="Muffin">
                                Muffin — Rs. 220
                            </option>

                        </optgroup>


                        <optgroup label="🥪 Sandwiches & Wraps">

                            <option value="Cheese Sandwich">
                                Cheese Sandwich — Rs. 350
                            </option>

                            <option value="Chicken Sandwich">
                                Chicken Sandwich — Rs. 450
                            </option>

                            <option value="Vegetable Sandwich">
                                Vegetable Sandwich — Rs. 320
                            </option>

                            <option value="Chicken Wrap">
                                Chicken Wrap — Rs. 480
                            </option>

                            <option value="Vegetable Wrap">
                                Vegetable Wrap — Rs. 350
                            </option>

                            <option value="Beef Wrap">
                                Beef Wrap — Rs. 550
                            </option>

                        </optgroup>


                        <optgroup label="🍩 Donuts">

                            <option value="Yeast Donuts">
                                Yeast Donuts — Rs. 180
                            </option>

                            <option value="Cake Donuts">
                                Cake Donuts — Rs. 200
                            </option>

                            <option value="Old-Fashioned Donuts">
                                Old-Fashioned Donuts — Rs. 190
                            </option>

                            <option value="Filled Donuts">
                                Filled Donuts — Rs. 230
                            </option>

                            <option value="Mochi Donuts">
                                Mochi Donuts — Rs. 260
                            </option>

                        </optgroup>


                        <optgroup label="🍰 Cakes">

                            <option value="Chocolate Cake">
                                Chocolate Cake — Rs. 650
                            </option>

                            <option value="Strawberry Cake">
                                Strawberry Cake — Rs. 700
                            </option>

                            <option value="Vanilla Cake">
                                Vanilla Cake — Rs. 600
                            </option>

                            <option value="Red Velvet Cake">
                                Red Velvet Cake — Rs. 750
                            </option>

                            <option value="Carrot Cake">
                                Carrot Cake — Rs. 650
                            </option>

                            <option value="Lemon Blueberry Cake">
                                Lemon Blueberry Cake — Rs. 720
                            </option>

                            <option value="Black Forest Cake">
                                Black Forest Cake — Rs. 750
                            </option>

                            <option value="Lotus Green Tea Cake">
                                Lotus Green Tea Cake — Rs. 800
                            </option>

                            <option value="Cheesecake">
                                Cheesecake — Rs. 700
                            </option>

                            <option value="Raspberry Cheesecake">
                                Raspberry Cheesecake — Rs. 750
                            </option>

                        </optgroup>

                    </select>

                </div>



                <!-- Quantity -->

                <div class="form-group">

                    <label for="quantity">
                        Quantity
                    </label>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        min="1"
                        value="1"
                    >

                </div>



                <!-- Special Instructions -->

                <div class="form-group">

                    <label for="message">
                        Special Instructions
                    </label>

                    <textarea
                        id="message"
                        name="message"
                        rows="5"
                        placeholder="Any special request? (Optional)"
                    ></textarea>

                </div>



                <!-- Submit -->

                <button
                    type="submit"
                    class="order-submit"
                >
                    Place My Order 🩷
                </button>


            </form>


        </div>


    </section>

</main>



<!-- ================= CART SCRIPT ================= -->

<script src="../js/cart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const cart =
        JSON.parse(
            localStorage.getItem("hifzasCafeCart")
        ) || [];


    const cartData =
        document.getElementById("cart-data");


    if (cartData) {

        cartData.value =
            JSON.stringify(cart);

    }

});

</script>


<?php if ($clearCart): ?>

<script>

localStorage.removeItem("hifzasCafeCart");

</script>

<?php endif; ?>


</body>

</html>