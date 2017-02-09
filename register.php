<?php  
    session_start();
    require('inc/config.php');
    require('inc/functions.php');

    if(isset($_POST['register'])) { // Script for registering
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $conf_password = $_POST['conf_password'];

        if(!$first_name) { // Check first name has been entered
            $note = 'Please enter your first name';
        } else { 
            if(!$last_name) { // Check last name has been entered
                $note ='Please enter your last name';
            } else {
                if(!$email) { // Check email has been entered
                    $note = 'Please enter your email address';
                } else {
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Validate email
                        $note = 'Please ensure your email address is valid e.g. email@domain.co.uk';
                    } else {
                        try { // Check email has not been registered before

                            $check = $conn->prepare('SELECT count(*) FROM `users` WHERE `email` = :email');
                            $check->bindParam(':email', $email);
                            $check->execute(); 
                            $count = $check->fetchColumn();

                            if($count >= 1) {  // If query returned result (email already exists)
                                $note = 'Please <a href="#">login</a> as your email address has already been registered with us.';           
                            }
                        } catch (PDOException $e) {
                            echo 'Could not check email address - ' . $e->getMessage();
                        }

                        if($count == 0) {
                            if(!$password) { // Check password has been entered
                                $note = 'Please enter a password';
                            } else {
                                if(!$conf_password) { // Check confirmation password has been entered
                                    $conf_pass_err = 'Please confirm your password';
                                } else {
                                    if($password != $conf_password) { // Check password and conf password are the same
                                        $note = 'Please make sure that your password and confirmation password are the same';
                                    } else {
                                        $pass_length = strlen($password);

                                        // Password encryption 
                                        $hash = hash('sha256', $password);
                                        $salt = create_salt();
                                        $hash = hash('sha256', $salt . $hash);

                                        // key for confirmation 
                                        $last_id = $conn->lastInsertId();
                                        $key = $email . date('mY') . 3245 - rand();
                                        $key = md5($key);

                                        try { // Create account

                                            $insert = $conn->prepare("INSERT into `users` (`first_name`, `last_name`, `email`, `password`, `pass_length`, `salt`) VALUES(:first_name, :last_name, :email, :password, :pass_length, :salt)");
                                            $insert->execute(array(
                                                ':first_name' => $first_name,
                                                ':last_name' => $last_name,
                                                ':email' => $email,
                                                ':password' => $hash,
                                                ':pass_length' => $pass_length,
                                                ':salt' => $salt,
                                            )); 

                                        } catch (PDOException $e) {
                                            echo 'Could not create account - ' . $e->getMessage();
                                        } 

                                        // Send email 
                                        $to  = $email;
                                        $subject = 'Welcome to Musikandi';
                                        $body = <<<body

                                            <html>
                                            <body>   
                                                <p style="font-family: arial; font-size: 11pt;">Hello $first_name,</p>

                                                <h2 style="font-family: arial; font-size: 16px;">Welcome to Musikandi!</h2>

                                                <p style="font-family: arial; font-size: 11pt;">Thank you for creating an account with us, you will now be able to add contacts to your own, personal address book which can only be accessed by you.</p>

                                                <p style="font-family: arial; font-size: 11pt;"><b>Username</b>: <br>
                                                <a href="mailto:$email" style="font-family: arial; color: #000; font-size: 11pt;">$email</a>
                                                </p>

                                                <p style="font-family: arial; font-size: 11pt;">Many thanks,</p>
                                                <p style="font-family: arial; font-size: 11pt;">Musikandi</p>
                                            </body>
                                            </html>
body;

                                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                        $headers .= 'To: ' . $first_name . ' ' . $last_name . ' <' . $email . '>' . "\r\n";
                                        $headers .= 'From: Musikandi <web@musikandi.com>' . "\r\n";

                                        if(mail($to, $subject, $body, $headers)) {
                                            $note = 'Your account has been successfully created, you may now login to start creating your address book.';
                                        }
                                    }                                       
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    $page_title = 'Register • Musikandi';
    $page = 'register';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> Bands';
    require('inc/header.php');
?>
<head>
<meta name="description" content="Register with Musikandi so that you can build your own online music contacts database.">
</head>   
    <section id="content">
        <div class="container">
            <h1>Register</h1>
    
            <?php if(isset($note)) { echo '<p class="error">' . $note . '</p>'; }?>

            <form method="post" class="form">
                <table>
                    <tr class="first">
                        <td><label for="first_name">First name</label></td>
                        <td><input type="text" name="first_name" id="first_name" <?php if(isset($first_name)) { echo 'value="' . $first_name . '"'; } ?>></td>
                    </tr>
                    <tr>
                        <td><label for="last_name">Last name</label></td>
                        <td><input type="text" name="last_name" id="last_name" <?php if(isset($last_name)) { echo 'value="' . $last_name . '"'; } ?>></td>
                    </tr>
                    <tr>
                        <td><label for="email2">Email Address</label></td>
                        <td><input type="text" name="email" id="email2" <?php if(isset($email)) { echo 'value="' . $email . '"'; } ?>></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password</label></td>
                        <td><input type="password" name="password" id="password"></td>
                    </tr>
                    <tr>
                        <td><label for="conf_password">Confirm password</label></td>
                        <td><input type="password" name="conf_password" id="conf_password"></td>
                    </tr>
                    <tr class="submit">
                        <td><input type="submit" value="Create account" name="register"></td>
                    </tr>
                </table>
            </form>
        </div>
    </section>

<?php 
    require('inc/footer.php');
?>
