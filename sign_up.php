<?php

session_start();

if (isset($_POST['email'])) {

  //Validation
  $all_good = true;

  //Validation login
  $login = $_POST['login'];

  //Length of login
  if ((strlen($login) < 3) || (strlen($login) > 20)) {
    $all_good = false;
    $_SESSION['error_login'] = "Login must have from 3 to 20 characters!";
  }

  if (ctype_alnum($login) == false) {
    $all_good = false;
    $_SESSION['error_login'] = "Login might have only with letters (not Polish letters) and digits!";
  }

  //Validation to small letters
  $login = strtolower($login);

  //Validation email
  $email = $_POST['email'];
  $secure_email = filter_var($email, FILTER_SANITIZE_EMAIL);

  if ((filter_var($secure_email, FILTER_VALIDATE_EMAIL) == false) || ($secure_email != $email)) {
    $all_good = false;
    $_SESSION['error_email'] = "Wrong email address";
  }

  //Validation password
  $password = $_POST['password'];

  //Length of password
  if ((strlen($password) < 8) || (strlen($password) > 20)) {
    $all_good = false;
    $_SESSION['error_password'] = "Password must have from 8 to 20 characters!";
  }

  //Hashing of password
  $hash_password = password_hash($password, PASSWORD_DEFAULT);

  //Validation recaptcha 
  $secret_key = "6Ldx1CwqAAAAAGsIyEzzL2W8mR3cn6Z8XSE9HxA0";

  $check_key = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

  $answer_key = json_decode($check_key);

  if ($answer_key->success == false) {
    $all_good = false;
    $_SESSION['error_recaptcha'] = "Confirm that you're not a bot!";
  }

  //Remember entered data
  $_SESSION['form_login'] = $login;
  $_SESSION['form_password'] = $password;
  $_SESSION['form_email'] = $email;

  require_once "config.php";
  mysqli_report(MYSQLI_REPORT_STRICT);

  try {
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno != 0) {
      throw new Exception(mysqli_connect_errno());
    } else {

      //if login exists
      $login_result = $connection->query("SELECT id FROM users WHERE login='$login'");

      if (!$login_result)
        throw new Exception($connection->error);

      $num_of_logins = $login_result->num_rows;
      if ($num_of_logins > 0) {
        $all_good = false;
        $_SESSION['error_login'] = "There is an account with this login. Enter another login.";
      }

      //if email exists
      $email_result = $connection->query("SELECT id FROM users WHERE email='$email'");

      if (!$email_result)
        throw new Exception($connection->error);

      $num_of_emails = $email_result->num_rows;
      if ($num_of_emails > 0) {
        $all_good = false;
        $_SESSION['error_email'] = "There is an account with this email. Enter another email.";
      }

      //Validation good - ready to insert
      if ($all_good == true) {
        if ($connection->query("INSERT INTO users VALUES(NULL, '$login', '$hash_password', '$email')")) {
          if ($connection->query("INSERT INTO users_category_expenses_added(user_id, name) SELECT us.id AS user_id, def.name FROM users AS us CROSS JOIN default_category_expenses AS def WHERE us.email='$email'")) {
            if ($connection->query("INSERT INTO users_category_incomes_added(user_id, name) SELECT us.id AS user_id, def.name FROM users AS us CROSS JOIN default_category_incomes AS def WHERE us.email='$email'")) {
              if ($connection->query("INSERT INTO users_payment_methods_added(user_id, name) SELECT us.id AS user_id, def.name FROM users AS us CROSS JOIN default_category_payment AS def WHERE us.email='$email'")) {
                $_SESSION['registration_good'] = true;
                header('Location: registration_added.php');
              } else {
                throw new Exception($connection->error);
              }
            } else {
              throw new Exception($connection->error);
            }

          } else {
            throw new Exception($connection->error);
          }
        } else {
          throw new Exception($connection->error);
        }

      }

      $connection->close();

    }
  } catch (Exception $e) {
    echo 'Problem with server. Please register in other time!';
  }
}


?>


<!DOCTYPE html>
<html lang="PL">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BudgetApp - Your choice to increase your life balance!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
    rel="stylesheet">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="background">
  <div class="container">
    <header class="p-3 text-bg-dark rounded-bottom">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
              class="bi bi-currency-dollar" viewBox="0 0 16 16">
              <path
                d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z" />
            </svg>
          </a>
          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a class="nav-link px- text-light fw-bold">BudgetApp</a></li>
            <li><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
            <li><a href="add_expense.php" class="nav-link px-2 text-white">Add Expense</a></li>
            <li><a href="add_income.php" class="nav-link px-2 text-white">Add Income</a></li>
            <li><a href="balance.php" class="nav-link px-2 text-white">Balance</a></li>

          </ul>

          <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
            <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
          </form>

          <div class="text-end">
            <a href="login.php" role="button" class="btn btn-outline-light me-2" href="">Login</a>
            <a href="sign_up.php" role="button" class="btn btn-warning">Sign-up</button></a>
          </div>
        </div>
      </div>
    </header>
    <div class="py-5 p-4 my-4 text-center border border-dark rounded col-lg-8 mx-auto" id="heroes">
      <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-bank"
        viewBox="0 0 16 16">
        <path
          d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z" />
      </svg>
      <h1 class="display-5 fw-bold text-body-emphasis my-3">Budget App</h1>
      <div class="col-lg-6 mx-auto">
        <form method="post">
          <h1 class="h3 mb-3 fw-normal">Create an account</h1>
          <div class="form-floating my-2">
            <input type="text" class="form-control" id="login" value="<?php if (isset($_SESSION['form_login'])) {
              echo $_SESSION['form_login'];
              unset($_SESSION['form_login']);
            } ?>" name="login" placeholder="Login">
            <?php
            if (isset($_SESSION['error_login'])) {
              echo '<div class="error">' . $_SESSION['error_login'] . '</div>';
              unset($_SESSION['error_login']);
            }
            ?>
            <label for="login">Login</label>
          </div>
          <div class="form-floating my-2">
            <input type="email" class="form-control" id="email" value="<?php if (isset($_SESSION['form_email'])) {
              echo $_SESSION['form_email'];
              unset($_SESSION['form_email']);
            } ?>" name="email" placeholder="E-mail">
            <?php
            if (isset($_SESSION['error_email'])) {
              echo '<div class="error">' . $_SESSION['error_email'] . '</div>';
              unset($_SESSION['error_email']);
            }
            ?>
            <label for="email">Email address</label>
          </div>
          <div class="form-floating my-2">
            <input type="password" class="form-control" id="password" value="<?php if (isset($_SESSION['form_password'])) {
              echo $_SESSION['form_password'];
              unset($_SESSION['form_password']);
            } ?>" name="password" placeholder="Password">
            <?php
            if (isset($_SESSION['error_password'])) {
              echo '<div class="error">' . $_SESSION['error_password'] . '</div>';
              unset($_SESSION['error_password']);
            }
            ?>
            <label for="password">Password</label>
          </div>
          <div class="form-check d-flex justify-content-center mt-3">
            <input class="form-check-input me-2" type="checkbox" id="form2Example3cg" />
            <label for="form2Example3cg">
              I agree all statements in <a href="#!" class="text-body"><u>Terms of service</u></a>
            </label>
          </div>
          <div class="g-recaptcha" data-sitekey="6Ldx1CwqAAAAAHixSFIONyRrqbiXzFOnCjd9rZbt">
          </div>
          <?php
          if (isset($_SESSION['error_recaptcha'])) {
            echo '<div class="error">' . $_SESSION['error_recaptcha'] . '</div>';
            unset($_SESSION['error_recaptcha']);
          }
          ?>
          <div class="form-group">
            <button type="submit" class="btn btn-dark w-100 py-2 my-4" data-mdb-ripple-init>Sign-up</button>
          </div>
          <p class="mt- mb-1 text-body-secondary">©mr_cyclist</p>
        </form>
      </div>
    </div>
    <footer class="p-3 text-bg-dark rounded-top d-flex flex-wrap justify-content-between align-items-center my-4">
      <div class="col-md-4 d-flex align-items-center">
        <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
          <svg class="bi" width="30" height="24">
            <use xlink:href="#bootstrap"></use>
          </svg>
        </a>
        <span class="mb-3 mb-md-0 text-white">© Budget App by @my_cyclist</span>
      </div>
      <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24">
              <use xlink:href="#twitter"></use>
            </svg></a></li>
        <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24">
              <use xlink:href="#instagram"></use>
            </svg></a></li>
        <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24">
              <use xlink:href="#facebook"></use>
            </svg></a></li>
      </ul>
    </footer>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>