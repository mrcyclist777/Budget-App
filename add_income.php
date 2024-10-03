<?php
  session_start();

  if(!isset($_SESSION['user_logged']))
  {
    header('Location: index.php')
    exit();
  }

  if(isset($_POST['amount']))
  {
    //Validation
    $all_good = true;

    //Validation income
    $amount = $_POST['amount'];
    $amount = htmlentities($amount, ENT_QUOTES, "UTF-8");

    //Validation numerical variable
    if(is_numeric($amount))
    {
      $amount = round($amount, 2);
    }
    else
    {
      $all_good = false;
      $_SESSION['income_error'] = "Variable must be a number";
    }

    //Numerical range
    if($amount >= 99999999)
    {
      $all_good = false;
      $_SESSION['income_error'] = "Variable must be less then 99999999";
    }

    //Validation date
    $amount = $_POST['date'];
    $amount = htmlentities($date, ENT_QUOTES, "UTF-8");

    if($date == NULL) 
    {
      $all_good = false;
      $_SESSION['income_date_error'] = "Enter income date";
    }

    $current_date = date('Y-m-d');

    if ($date > $current_date)
    {
      $all_good = false;
      $_SESSION['income_date_error'] = "Date must be current or earlier";
    }

    //Categorized income
    if ($isset($_POST['category_income']))
    {
      $category = $_POST['category_income'];
      $_SESSION['form_category_income'] = $category;
    }
    else
    {
      $all_good = false;
      $_SESSION['income_category_error'] = "Category must be selected";
    }

    //Validation comment
    $comment = $_POST['comment'];
    $comment = htmlentities($comment, ENT_QUOTES, "UTF-8");

    if((strlen($comment) > 50))
    {
      $all_good = false;
      $_SESSION['income_comment_error'] = "Comment of income might be 50 characters maximum.";
    }

    //validation payment
    if(isset($_POST['income_payment'])) {
			
			$payment = $_POST['income_payment'];
			$_SESSION['form_income_payment'] = $payment;

		}else{
			$OK = false;
			$_SESSION['income_error_payment'] = "Choose payment method";
		}

    //Remember entered values
    $_SESSION['form_amount_income'] = $amount;
		$_SESSION['form_date_income'] = $date;
		$_SESSION['form_comment_income'] = $comment;

    //Database connection
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try
      {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        $connection->set_charset("utf8");

        if($connection -> connecct_errno != 0)
        {
          throw new Exception(mysqli_connect_errno());
        }
        else 
        {
          $user_id = $_SESSION['id'];
          //Validation id = good

          if($all_good == true)
          {
            $query_income = "INSERT INTO incomes VALUES (NULL, '$user_id',(SELECT id FROM users_category_incomes_added WHERE user_id ='$user_id' AND name='$category'),'$amount','$date','$comment')";
            if($connection -> query($query_income))
            {
              $_SESSION['income_added'] = true;
              header('Location: income_added.php');
            }
            else
            {
              throw new Exception($connection -> error);

            }
          }
        }
        $connection -> close();
      }
      catch (Exception $e)
      {
      echo "Problem with server. Please register in other time!";
      }
  }
?>

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
            <div class="col-lg-6 mx-auto">
              <form method = "post">
                    <h1 class="h3 mb-3 fw-normal">Add income</h1>
                    <div class="form-floating my-2">
                        <input type="category" class="form-control" id="floatingInput" placeholder="Category">
                        <?php
                        //Connect database
                        require_once "connect.php";
                        mysqli_report(MYSQLI_REPORT_STRICT);
                          
                        try
                        {
                          $connection = new mysqli($host, $db_user, $db_password, $db_name);
                          $connection -> set_charset("utf8");
                          if ($connection -> connect_errno != 0)
                          {
                            throw new Exception(mysqli_connect_errno());
                          }
                          
                          else
                          {
                            //Check number of income categories
                            $user_id = $_SESSION['id'];
                            
                            $result_query_income = $connection -> query("SELECT name FROM users_category_incomes_added WHERE user_id ='$user_id'");
                            
                            if(!$result_query_income) throw new Exception($connection -> error);
                              
                            $how_many_names = $result_query_income -> num_rows;
                            
                            
                            if($how_many_names > 0)
                            {
                              while ($row = $result_query_income -> fetch_assoc())
                              {
                                echo '<div class="row">';
                                echo '<div class="col-sm-4 col-sm-offset-1">';
                                echo '<label class="radio-inline">';
                                echo '<input type="radio" name="category_income" value="'.$row['name'];
                                
                                if(isset($_SESSION['form_income_category']))
                                {
                                  if($row['name'] == $_SESSION['form_income_category']) 
                                  {
                                    echo '"checked ="checked"';
                                  }
                                }
                                
                                echo '">'.$row['name'].'</label>';
                                echo '</div>';
                                echo '<div class="col-sm-5"></div>';
                                echo '</div>';	
                                }
                              $result_query_income -> free_result();
                            }
                            else
                            {
                              
                            }
                          }
                          $connection -> close();
                        }
                        catch (Exception $e)
                        {
                        echo "Problem with server. Please register in other time!";
                        }
                      ?>		
                      <?php
                        if (isset($_SESSION['error_category_income']))
                        {
                          echo '<div class="error">'.$_SESSION['error_category_income'].'</div>';
                          unset($_SESSION['error_category_income']);
                        }
                      ?>
                        <label for="floatingInput">Name</label>
                      </div>
                    <div class="form-floating my-2">
                        <input id="datepicker" width="auto" class="form-control py-3 border text-center" placeholder="" value="<?php
                          if (isset($_SESSION['form_income_date'])){
                            echo $_SESSION['form_income_date'];
                            unset($_SESSION['form_income_date']);
                          }
                          ?>
                          <?php
                          if (isset($_SESSION['error_income_date'])){
                            echo '<div class="error">'.$_SESSION['error_income_date'].'</div>';
                            unset($_SESSION['error_income_date']);	
                          }
                          ?>">  
                        <label for="floatingInput">Date</label>
                        <script>
                            $('#datepicker').datepicker();
                        </script>
                    </div>
                    <div class="form-floating my-2">
                    <?php
											require_once "connect.php";
											mysqli_report(MYSQLI_REPORT_STRICT);
												
											try{
												$connection = new mysqli($host, $db_user, $db_password, $db_name);
												
												if ($connection -> connect_errno != 0){
													throw new Exception(mysqli_connect_errno());
												}else{
													$user_id = $_SESSION['id'];
											
													$result_query_income = $connection -> query("SELECT name FROM users_payment_incomes_added WHERE user_id ='$user_id'");
													if(!$result_query_income) throw new Exception($connection -> error);
														
													$how_many_names = $result_query_income -> num_rows;
													if($how_many_names > 0){
														
														while ($row = $result_query_income -> fetch_assoc())	{
															echo '<div class="row ">';
															echo '<label>'.'<input type="radio" name="income_payment" value="'.$row['name'];

															if(isset($_SESSION['form_income_payment'])){
																if($row['name'] == $_SESSION['form_income_payment']) {
																	echo '"checked ="checked"';
																}
															}
															echo '">'.' '.$row['name'].'</label>';
															echo '</div>';
														}
														$result_query_income -> free_result();
													}
												}
												$connection -> close();
											}
											catch (Exception $e)
                      {
                        echo "Problem with server. Please register in other time!";
                      }
										?>	
										<?php
											if (isset($_SESSION['income_error_payment'])){
												echo '<div class="error">'.$_SESSION['income_error_payment'].'</div>';
												unset($_SESSION['income_error_payment']);
											}
										?>			
                        /*<div class="dropdown">
                            <button class="py-3 btn btn-secondary dropdown-toggle w-100 text-start type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                              Payment Methods
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <li><a class="dropdown-item" href="#">Credit / Prepaid Card</a></li>
                              <li><a class="dropdown-item" href="#">Cash</a></li>
                              <li><a class="dropdown-item" href="#">Paypal / Gift Card</a></li>
                            </ul>
                          </div> */
                    </div>
                    <div class="form-floating my-2">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Value (USD)" value="<?php
                          if (isset($_SESSION['form_income_amount'])){
                            echo $_SESSION['form_income_amount'];
                            unset($_SESSION['form_income_amount']);
                          }?>
                          <?php
                          if (isset($_SESSION['error_income_amount'])){
                            echo '<div class="error">'.$_SESSION['error_income_amount'].'</div>';
                            unset($_SESSION['error_income_amount']);	
                          }
                          ?>">
                        <label for="floatingInput">Value (USD)</label>
                      </div>
                    <div class="form-floating my-2">
                        <input type="comment" class="form-control" id="floatingInput" placeholder="Comment" value="<?php
                          if (isset($_SESSION['form_income_comment'])){
                            echo $_SESSION['form_income_comment'];
                            unset($_SESSION['form_income_comment']);
                          }?>
                          <?php
                          if (isset($_SESSION['error_income_comment'])){
                            echo '<div class="error">'.$_SESSION['error_income_comment'].'</div>';
                            unset($_SESSION['error_income_comment']);	
                          }
                          ?>">
                        <label for="floatingInput">Comment</label>
                      </div>
                    /* <button type="button" class="btn btn-dark w-100 py-2 my-4" data-mdb-ripple-init>Add expense</button> */
                    <p class="mt-1 mb-1 text-body-secondary">©mr_cyclist</p>
                  </form>
            </div>
          </div>
    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="./js/addincome.js"></script>
</body>
</html>