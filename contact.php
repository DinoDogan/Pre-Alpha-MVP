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

    <script type="text/javascript">
        (function () {
            var $contactForm = $("#contact-form");

            $contactForm.submit(function (e) {

                $.ajax({
                    method: $contactForm.attr("data-method"),
                    url: $contactForm.attr("data-action"),
                    dataType: "JSON",
                    data: $contactForm.serialize()
                }).done(function (json) {
                    if (!json.error) {
                        $contactForm.addClass("has-success");
                    }
                    else {
                        alert(json.error);
                    }
                }).error(function () {

                });

                e.preventDefault();
            });
        }());
    </script>

<?php include "inc/footer.php"; ?>