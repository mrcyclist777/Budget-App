<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Components</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z"/>
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
                  <a href="./login.html" role="button" class="btn btn-outline-light me-2" href="">Login</a>
                  <a href="./signup.html" role="button" class="btn btn-warning">Sign-up</button></a>
                </div>
              </div>
            </div>
          </header>
          <div class="py-5 p-4 my-4 text-center border border-dark rounded col-lg-8 mx-auto" id="heroes">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16">
                <path d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z"/>
              </svg>
              <h1 class="display-5 fw-bold text-body-emphasis my-3">Budget App</h1>
              <h1 class="h3 mb-3 fw-normal">Select date</h1>
              <div class="col-lg-10 mx-auto">
                <div class="datarange-container my-3">
                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                    
                    <script type="text/javascript">
                    $(function() {
                    
                        var start = moment().subtract(29, 'days');
                        var end = moment();
                    
                        function cb(start, end) {
                            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                        }
                    
                        $('#reportrange').daterangepicker({
                            startDate: start,
                            endDate: end,
                            ranges: {
                               'Today': [moment(), moment()],
                               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                               'This Month': [moment().startOf('month'), moment().endOf('month')],
                               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                            }
                        }, cb);
                    
                        cb(start, end);
                    
                    });
                    </script>
                </div>
                  <form>
                      <h1 class="h3 mb-3 fw-bold">Balance</h1>
                      <h2 class="h5 mb-3 fw-light">Expenses</h2>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Value (USD)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>iPhone 15</td>
                    <td>27.05.2024</td>
                    <td>Prepaid Card</td>
                    <td>600 USD</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>T-shirt</td>
                    <td>05.05.2024</td>
                    <td>Cash</td>
                    <td>50 USD</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Book</td>
                    <td>09.05.2024</td>
                    <td>Cash</td>
                    <td>40 USD</td>
                  </tr>
                </tbody>
              </table>
              <h2 class="h5 mb-3 fw-light mt-4">Incomes</h2>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Value (USD)</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <th scope="row">1</th>
                      <td>iPhone 15</td>
                      <td>27.05.2024</td>
                      <td>Prepaid Card</td>
                      <td>600 USD</td>
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td>T-shirt</td>
                      <td>05.05.2024</td>
                      <td>Cash</td>
                      <td>50 USD</td>
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td>Book</td>
                      <td>09.05.2024</td>
                      <td>Cash</td>
                      <td>40 USD</td>
                    </tr>
                  </tbody>
              </table>
            <div class="col-lg-12">
                <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
        <div class="card-body">
            <div class="chart">
            	<canvas id="property_types" class="pie"></canvas>
            	<div id="pie_legend" class="py-3 text-left col-md-7 mx-auto"></div>
            </div>
             <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <button type="button" class="btn btn-light btn-lg" data-mdb-ripple-init data-mdb-ripple-color="dark">Your Saldo</button>
                <button type="button" class="btn btn-dark btn-lg" data-mdb-ripple-init>Logout</button>
              </div> 
            </div>
          </div>
    </div>
</form>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="./js/balance.js"></script>
</body>
</html>