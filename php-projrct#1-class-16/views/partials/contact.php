<!-- Start contact Section -->

<section id="contact-me" class="contact container-padding">
    <h2 class="section-title">Contact Me</h2>
    <div class="contact-box">
        <form action="" method="post">

            <?php
            if (isset($_POST['contact_form'])) {
                $response = store_contact_from();


                if (!empty($response['errors']['global'])) {
                    echo "<p style='color:red; border:1px solid #ccc; padding:10px;'>" . $response['errors']['global'] . "</p>";
                }
                if ($response['success']) {
                    echo "<p style='color:green'>" . $response['successMessage'] . "</p>";
                }
            }
            ?>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="input" id="name" name="name" placeholder="Please enter your name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="input" id="email" name="email" placeholder="Please enter your email">
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="input" id="subject" name="subject" placeholder="Please enter your subject">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="input" id="message" name="message" placeholder="Please enter your message"
                    rows="4"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-outline" name="contact_form"
                    placeholder="Please enter your message">
                    <i class="fas fa-paper-plane"></i>
                    Send Message
                </button>
            </div>
        </form>
        <div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.1914228009673!2d90.35472651538548!3d23.8117911923443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c12015382851%3A0x3ceca92fcf1a72d2!2sBangladesh%20University%20of%20Business%20and%20Technology%20(BUBT)!5e0!3m2!1sen!2sbd!4v1670092127889!5m2!1sen!2sbd"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
<!-- End contact Section -->