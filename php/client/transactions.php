<?php

// Start a session
session_start();

// Check if user is already logged in
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
  header("location: http://budget.aamirhatim.com/index.php");
  die();
}

// Include db service library
require_once(__DIR__.'/../server/db_service.php');

// Show message to direct users to link bank account if no bank accounts found
$num_accounts = sizeof(get_all_accounts($_SESSION['id']));
if($num_accounts == 0){
    // Redirect to empty account page
    header('location: http://budget.aamirhatim.com/php/client/no_accounts.php');
}

?>

<!DOCTYPE html>
<html>
  <head>
    <base href = 'http://budget.aamirhatim.com/' />
    <title>Transactions</title>
    <link rel = 'stylesheet' href = 'css/style.css'>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
  </head>

  <nav>
    <?php require(__DIR__.'/navbar.php'); ?>
  </nav>

  <body>
    <main>
      <div class = 'sidebar'></div>

      <div class = 'main-content'>
        <h1>Transactions</h1>
        <div id = 'transactions'>
          <table class = 'trans-table'>
            <tr>
              <th>Account Name</th>
              <th>Amount</th>
              <th>Transaction</th>
              <th>Date</th>
              <th>Categories</th>
            </tr>
            <?php
            $transactions = get_transactions($_SESSION['id']);
            foreach ($transactions as $t) {
                // Get the bank account name
                $bank_name = get_bank_name($t['bank_id']);

                // Fill out table
                echo '<tr>';
                echo '<td>' . $bank_name . '</td>';
                echo '<td style = "text-align: right;">$' . $t['amount'] . '</td>';
                echo '<td>' . $t['trans_name'] . '</td>';
                echo '<td>' . $t['date'] . '</td>';
                echo '<td>' . $t['categories'] . '</td>';
                echo '</tr>';
            }
            ?>
          </table>
        </div>
      </div>
    </main>

  </body>
</html>
