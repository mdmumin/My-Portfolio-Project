<h2>Contact Us</h2>
<?php
$errors = [];

try {

    //Validation
    if (isset($_POST['contact_form'])) {

        if (empty($_POST['name'])) {
            $errors['name'] = "please give a valid name.";
            //throw new Exception("please give a valid name.", 1);
        }

        if (empty($_POST['email'])) {
            $errors['email'] = "please give an Email address.";
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "please give a valid Email.";
        }

        if (empty($_POST['subject'])) {
            $errors['subject'] = "please give a valid subject.";
        }

        if (empty($_POST['temp_password'])) {
            $errors['temp_password'] = "please give a valid temporary password.";
        }

        //upload file
        $file_name = null;
        if (!empty($_FILES['attachment']['name'])) {

            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($_FILES['attachment']['error']) ||
                is_array($_FILES['attachment']['error'])
            ) {
                throw new RuntimeException('Invalid parameters.');
            }
            //check file size
            $file_size = !empty($_FILES['attachment']['size']) ? intval($_FILES['attachment']['size']) : 0;
            $upto_supported_size = 5 * 1024 * 1000; // 5MB


            if ($file_size > $upto_supported_size) {
                $errors['attachment'] = "File size exceeded. Max upload limit is 5MB";
                throw new Exception($errors['attachment'], 1);
            }
            //Mime type file
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $file_ext = array_search(
                $finfo->file($_FILES['attachment']['tmp_name']),
                array(
                    'jpg' => 'image/jpg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'gif1' => 'image/bnf',
                    'pdf' => 'application/pdf'

                ),
                true
            );
            if (false === $file_ext) {
                $errors['attachment'] = "File should be a valid image or PDF file";
                throw new Exception($errors['attachment'], 1);
            }

            //Sanitize file name and make new
            $file_name = 'devsenv-' . time() . '.' . $file_ext;

            //Upload file

            if (!move_uploaded_file($_FILES['attachment']['tmp_name'], "uploads/" . $file_name)) {
                $errors['attachment'] = "File uploads fail please try again.";
                throw new Exception($errors['attachment']);
            }
        }

    }
} catch (\Exception $e) {
    $errors['global'] = $e->getMessage();
}
if (count($errors) > 0) {
    $err_global = "Failed to submit from. Please try again.";
    if (isset($errors['global'])) {
        $err_global .= 'Error:' . $errors['global'];
    }
    $errors['global'] = $err_global;
} else {
    if (isset($_POST['contact_form'])) {

        //sanitization
        $insert_data = [
            'name' => htmlspecialchars($_POST['name']),
            'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
            'subject' => htmlspecialchars($_POST['subject']),
            'temp_password' => htmlspecialchars($_POST['temp_password']),
            'attachment' => $file_name
        ];

        //var_dump($insert_data);

        //insert into database
        //DB:: insert('contact_us $insert_database')
    }
}
?>
<?php
if (!empty($errors['global'])) {
    echo "<p style='color:red; border:1px solid #ccc; padding:10px;'>" . $errors['global'] . "</p>";

} elseif (!empty($_POST['name']) && !empty($_POST['subject']) && !empty($_POST['temp_password'])) {
    echo "<p style='color:green'>Your form is submitted !</p>";
}
?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">


    <label for="name">Name</label><br>
    <input type="text" id="name" name="name"> <br>
    <span style="color: red">
        <?php echo !empty($errors['name']) ? $errors['name'] : '' ?>
    </span>
    <br>

    <label for="email">Email</label><br>
    <input type="email" id="email" name="email"> <br>
    <span style="color: red">
        <?php echo !empty($errors['email']) ? $errors['email'] : '' ?>
    </span>
    <br>

    <label for="subject">Subject</label><br>
    <input type="text" id="subject" name="subject"> <br>
    <span style="color: red">
        <?php echo !empty($errors['subject']) ? $errors['subject'] : '' ?>
    </span>
    <br>

    <label for="temp_password">Temp Password</label><br>
    <input type="password" id="temp_password" name="temp_password"> <br>
    <span style="color: red">
        <?php echo !empty($errors['temp_password']) ? $errors['temp_password'] : '' ?>
    </span>
    <br>

    <label for="attachment">Attachment (PDF or Image) (optional)</label><br>
    <input type="file" id="attachment" name="attachment"><br>
    <span style="color: red">
        <?php echo !empty($errors['attachment']) ? $errors['attachment'] : '' ?>
    </span>
    <br>

    <input type="submit" value="Send" name="contact_form" />
</form>