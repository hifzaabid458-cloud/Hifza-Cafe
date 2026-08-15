<?php

require_once "../config/database/db.php";

$message_status = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    $sql = "INSERT INTO contact_messages
            (Name, Email, Subject, Message)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {

        $stmt->bind_param(
            "ssss",
            $name,
            $email,
            $subject,
            $message
        );

        if ($stmt->execute()) {

            $message_status = "Your message has been sent successfully! 🩷";

        } else {

            $message_status = "Sorry, your message could not be sent.";

        }

        $stmt->close();

    } else {

        $message_status = "Something went wrong. Please try again.";

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

    <title>Contact Us | Hifza's Cafe</title>

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

<?php if (!empty($message_status)): ?>

    <div class="contact-message">
        <?php echo htmlspecialchars($message_status); ?>
    </div>

<?php endif; ?>



<!-- ================= CONTACT PAGE ================= -->

<main class="contact-page">


    <!-- Heading -->

    <section class="contact-heading">

        <span class="section-label">
            WE'D LOVE TO HEAR FROM YOU
        </span>

        <h1>
            Get in Touch 🩷
        </h1>

        <p>
            Have a question, suggestion or simply want
            to say hello? Send us a message.
        </p>

    </section>



    <!-- Contact Content -->

    <section class="contact-section">


        <!-- Contact Information -->

        <div class="contact-info">

            <span class="section-label">
                CONTACT US
            </span>

            <h2>
                Let's Talk Over
                a Cup of Coffee ☕
            </h2>

            <p>
                We're always happy to hear from our
                customers. Reach out to us and we'll
                get back to you as soon as possible.
            </p>


            <div class="contact-detail">

                <span class="contact-icon">
                    📍
                </span>

                <div>

                    <h3>
                        Visit Us
                    </h3>

                    <p>
                        Hifza's Cafe
                    </p>

                </div>

            </div>


            <div class="contact-detail">

                <span class="contact-icon">
                    📞
                </span>

                <div>

                    <h3>
                        Call Us
                    </h3>

                    <p>
                        03XX-XXXXXXX
                    </p>

                </div>

            </div>


            <div class="contact-detail">

                <span class="contact-icon">
                    ✉️
                </span>

                <div>

                    <h3>
                        Email Us
                    </h3>

                    <p>
                        hello@hifzascafe.com
                    </p>

                </div>

            </div>

        </div>



        <!-- Contact Form -->

        <div class="contact-card">

            <form action="" method="post">


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


                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="subject">
                        Subject
                    </label>

                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        placeholder="What would you like to ask?"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="message">
                        Your Message
                    </label>

                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        placeholder="Write your message here..."
                        required
                    ></textarea>

                </div>


                <button
                    type="submit"
                    class="contact-submit"
                >
                    Send Message 🩷
                </button>


            </form>

        </div>

    </section>



    <!-- Closing Message -->

    <section class="contact-bottom">

        <h2>
            Sweet moments are better together. 🩷
        </h2>

        <p>
            We hope to welcome you to Hifza's Cafe soon.
        </p>

    </section>


</main>


</body>

</html>