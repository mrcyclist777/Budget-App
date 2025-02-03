<?php

session_start();

if (!isset($_SESSION['user_logged'])) {
  header('Location: index.php');
  exit();
}

if (isset($_SESSION['form_period_of_time'])) {
  $all_good = true;
  $period_of_time = $_SESSION['form_period_of_time'];
  $current_date = date('Y-m-d');

  if ($period_of_time == "current_month") {
    $start_date = date('Y-m-d', strtotime("First day of this month"));
    $end_date = date('Y-m-d');
  } else if ($period_of_time == "previous_month") {
    $start_date = date('Y-m-d', strtotime("First day of previous month"));
    $end_date = date('Y-m-d', strtotime("Last day of previous month"));
  } else if ($period_of_time == "current_year") {
    $start_date = date('Y-m-d', strtotime("1 January of this year"));
    $end_date = date('Y-m-d');
  } else if ($period_of_time == "selected_period") {
    $start_date = $_SESSION['period_start_date'];
    $end_date = $_SESSION['period_end_date'];
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
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
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
            <li class="active"><a href="balance_view.php" class="nav-link px-2 text-white">Balance</a></li>
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
        <h2 class="h3 mb-1 fw-normal">Select date</h2>
        <div class="row form-floating my-2">
          <form action="date_balance.php" method="post">
            <div class="form-group">
              <label class="h3 mb-3 fw-normal" for="period_of_time">Select Period of Time:</label>
              <select class="form-control mb-2" id="period_of_time" name="period_of_time">
                <option value="current_month">Current Month</option>
                <option value="previous_month">Previous Month</option>
                <option value="current_year">Current Year</option>
                <option value="selected_period">Selected Period of Time</option>
              </select>
            </div>
            <button type="submit" class="btn btn-dark btn-lg save mb-2" data-mdb-ripple-init>Save</button>
          </form>
        </div>
      </div>
      <div class="col-lg-10 mx-auto">
        <?php
        require_once "config.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try {
          $connection = new mysqli($host, $db_user, $db_password, $db_name);
          $connection->set_charset("utf8");

          if ($connection->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
          } else {
            $user_id = $_SESSION['id'];

            $result_query_balance = $connection->query("SELECT cat.name, SUM(inc.amount) FROM users us INNER JOIN incomes inc ON us.id = inc.user_id INNER JOIN users_category_incomes_added cat ON inc.category_incomes_added_to_user = cat.id WHERE users.id = $user_id AND inc.income_date >= '$start_date' AND inc.income_date <= '$end_date' GROUP BY cat.id");
            if (!$result_query_balance)
              throw new Exception($connection->error);

            echo '<h2 class="h3 mb-1 fw-normal">Balance: ' . '</br>' . $start_date . ' - ' . $end_date . '</h2>';
            $how_many_categories = $result_query_balance->num_rows;

            if ($how_many_categories > 0) {
              echo '<div class="col-lg-6 mx-auto">';
              echo '<h3 class="h4 mb-1 fw-normal">Incomes Table: </h3>';
              echo '<table class="table table-sm table-striped">';
              echo '<thead>';
              echo '<tr>';
              echo '<th>Name of category: </th>';
              echo '<th>SUM OF INCOMES: [PLN]</th>';
              echo '</tr>';
              echo '</thead>';
              echo '<tbody>';
              while ($row = $result_query_balance->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['SUM(inc.amount)'] . '</td>';
                echo '</tr>';
                $income_value = ['SUM(inc.amount)'];
              }
              $result_query_balance->free_result();
              echo '</tbody>';
              echo '</table>';
              echo '</div>';
            } else {
              echo '<h3 class="h4 mb-1 fw-normal">No incomes since ' . $start_date . ' for ' . $end_date . '</h3>';
              $income_value = 0;
            }
          }
          $connection->close();
        } catch (Exception $e) {
          echo "Problem with server. Please register in other time!";
        }
        ?>
      </div>
      <div class="col-lg-10 mx-auto">
        <?php
        require_once "config.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try {
          $connection = new mysqli($host, $db_user, $db_password, $db_name);
          $connection->set_charset("utf8");

          if ($connection->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
          } else {
            $user_id = $_SESSION['id'];

            $result_query_balance = $connection->query("SELECT cat.name, SUM(exp.amount) FROM users us INNER JOIN expenses exp ON us.id = exp.user_id INNER JOIN users_category_expenses_added cat ON exp.category_expenses_added_to_user = cat.id WHERE users.id = $user_id AND exp.expense_date >= '$start_date' AND exp.expense_date <= '$end_date' GROUP BY cat.id");
            if (!$result_query_balance)
              throw new Exception($connection->error);

            echo '<h2 class="h3 mb-1 fw-normal">Balance: ' . '</br>' . $start_date . ' - ' . $end_date . '</h2>';
            $how_many_categories = $result_query_balance->num_rows;

            if ($how_many_categories > 0) {
              echo '<div class="col-lg-6 mx-auto">';
              echo '<h3 class="h4 mb-1 fw-normal">Expense Table: </h3>';
              echo '<table class="table table-sm table-striped">';
              echo '<thead>';
              echo '<tr>';
              echo '<th>name of category</th>';
              echo '<th>SUM OF EXPENSES [PLN]</th>';
              echo '</tr>';
              echo '</thead>';
              echo '<tbody>';
              while ($row = $result_query_balance->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['SUM(exp.amount)'] . '</td>';
                echo '</tr>';
                $expenses_value = ['SUM(exp.amount)'];
              }
              $result_query_balance->free_result();
              echo '</tbody>';
              echo '</table>';
              echo '</div>';
            } else {
              echo '<h3 class="h4 mb-1 fw-normal">No expenses since ' . $start_date . ' for ' . $end_date . '</h3>';
              $expenses_value = 0;
            }
            $difference_value = $incomes_value - $expenses_value;
            echo '<div class="col-lg-6 mx-auto">';
            echo '<p> BALANCE: </p>';
            echo '<div class="score">' . number_format($difference_value, 2, '.', '') . ' PLN' . '</div>';
            echo '</div>';
          }
          $connection->close();
        } catch (Exception $e) {
          echo "Problem with server. Please register in other time!";
        }
        ?>
        <div id="chartContainer">
          <script>
            function pieChart() {
              var chart = new CanvasJS.Chart("chartContainer", {
                exportEnabled: true,
                animationEnabled: true,
                theme: "light2",
                title: {
                  text: "World Energy Consumption by Sector - 2012",
                  fontColor: "#ffc34d",
                  fontSize: 20,
                },
                data: [{
                  type: "pie",
                  radius: 140,
                  startAngle: 270,
                  indexLabelFontSize: 15,
                  yValueFormatString: "##0.00\" zł\"",
                  toolTipContent: "{name}: <strong>{y}</strong>",
                  indexLabel: "{name} (#percent%)",
                  dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
              });
              chart.render();
            }
          </script>
        </div>
        <div class="col-lg-12">
          <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <button type="button" class="btn btn-light btn-lg" data-mdb-ripple-init data-mdb-ripple-color="dark">Your
              Saldo</button>
            <button type="button" class="btn btn-dark btn-lg" data-mdb-ripple-init>Logout</button>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="./js/balance.js"></script>
</body>

</html>