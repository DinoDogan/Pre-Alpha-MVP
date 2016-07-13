<?php
$title = "Contact Us";
include "inc/header.php"; ?>

    <section id="contact">
        <div class="content">
            <form data-action="/api/contact.php" data-method="POST" id="contact-form">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="message" placeholder="Ask us anything..." required></textarea>
                <button type="submit">Send</button>

                <div id="contact-form-overlay">
                <span>
                    <i class="fa fa-check"></i>
                    Your question was submitted!
                </span>
                </div>
            </form>
        </div>
    </section>

<?php include "inc/footer.php"; ?>