<?php

session_start();

if (!isset($_SESSION['user_logged'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['period_of_time'])) {
    $all_good = true;
    $period_of_time = $_POST['period_of_time'];
    $_SESSION['form_period_of_time'] = $period_of_time;
}

if (isset($_POST['start_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $current_date = date('Y-m-d');
    $start_date = htmlentities($start_date, ENT_QUOTES, "UTF-8");
    $end_date = htmlentities($end_date, ENT_QUOTES, "UTF-8");
    $all_good = true;

    if ($start_date == NULL) {
        $all_good = false;
        $_SESSION['error_start_date'] = "Choose start date for period of time. ";
    }

    if ($end_date == NULL) {
        $all_good = false;
        $_SESSION['error_end_date'] = "Choose end date for period of time. ";
    }

    if ($start_date > $current_date) {
        $all_good = false;
        $_SESSION['error_start_date'] = "Date of start of period time can't be bigger then current date. ";
    }

    if ($end_date > $current_date) {
        $all_good = false;
        $_SESSION['error_end_date'] = "Date of end of period time can't be bigger then current date. ";
    }

    if ($start_date != NULL && $end_date != NULL) {
        if ($start_date > $end_date) {
            $all_good = false;
            $_SESSION['error_start_date'] = "Date of start of period can't be bigger that date of end of period time. ";
        }
    }

    $_SESSION['form_start_date'] = $start_date;
    $_SESSION['form_end_date'] = $end_date;
    $_SESSION['period_start_date'] = $start_date;
    $_SESSION['period_end_date'] = $end_date;

    if ((isset($_SESSION['period_start_date'])) && isset($_SESSION['period_end_date']) && $all_good == true) {
        header('Location: balance.php');
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
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
                        <li><a href="balance_view.php" class="nav-link px-2 text-white">Balance</a></li>

                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                        <input type="search" class="form-control form-control-dark" placeholder="Search..."
                            aria-label="Search">
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
                <div class="form-group">
                    <?php
                    if (isset($_SESSION['form_period_of_time']) && $_SESSION['form_period_of_time'] == "selected_period") {
                        echo '<form method = "POST">';
                        echo '<h3 class="h3 mb-3 fw-normal">Select period of time: </h3>';
                        echo '<div class="col-lg-6 mx-auto">';
                        echo '<label for="start_date">Start of period of time: </label></br>';
                        echo '<input type="date" name="start_date" value="';

                        if (isset($_SESSION['form_start_date'])) {
                            echo $_SESSION['form_start_date'];
                            unset($_SESSION['form_start_date']);
                        }
                        echo '"class="form_control">';

                        if (isset($_SESSION['error_start_date'])) {
                            echo '<div class="error"' . $_SESSION['error_start_date'] . '</div>';
                            unset($_SESSION['error_start_date']);
                        }

                        echo '</div>';

                        echo '<div class="col-lg-6 mx-auto">';
                        echo '<label for="end_date">End of period of time: </label></br>';
                        echo '<input type="date" name="end_date" value="';

                        if (isset($_SESSION['form_end_date'])) {
                            echo $_SESSION['form_end_date'];
                            unset($_SESSION['form_end_date']);
                        }
                        echo '"class="form_control">';

                        if (isset($_SESSION['error_end_date'])) {
                            echo '<div class="error"' . $_SESSION['error_end_date'] . '</div>';
                            unset($_SESSION['error_end_date']);
                        }

                        echo '</div>';

                        echo '<div class="col-lg-6 mx-auto">';
                        echo '<button type="submit" class="btn btn-dark btn-lg save mb-2" data-mdb-ripple-init>Balance</button>';
                        echo '</form>';
                        echo '</div>';
                    } else if ($_SESSION['form_period_of_time'] == "current_month" || $_SESSION['form_period_of_time'] == "previous_month" || $_SESSION['form_period_of_time'] == "current_year") {
                        header('Location: balance.php');
                    }
                    ?>
                    <div class="col-lg-6 mx-auto">
                        <h3 class="h3 mb-3 fw-normal">Total balance: </h3>
                    </div>
                    <p class="mt-1 mb-1 text-body-secondary">©mr_cyclist</p>
                </div>
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
    <script src="./js/addincome.js"></script>
</body>

</html>