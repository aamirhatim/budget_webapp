<?php

// Start a session
session_start();

// Check if user is already logged in
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
  header("location: http://budget.aamirhatim.com/index.php");
  die();
}

// Include db service library
require_once(__DIR__.'/server/db_service.php');

// Get any new transactions
// include(__DIR__.'/server/update_transactions.php');

?>

<!DOCTYPE html>
<html>
  <head>
    <base href = 'http://budget.aamirhatim.com/' />
    <title>Welcome!</title>
    <link rel = 'stylesheet' href = 'css/style.css'>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
  </head>

  <nav>
    <?php require(__DIR__.'/client/navbar.php'); ?>
  </nav>

  <body>
    <main>
      <div class = 'main-content'>
        <h1>YOU'RE LOGGED IN</h1>

        <h2>Your Accounts</h2>
        <div id = 'accounts'>
          <table>
            <tr>
              <th>Name</th>
              <th>Institution</th>
            </tr>
            <?php
            $user_accounts = get_all_accounts($_SESSION['id']);
            foreach($user_accounts as $a) {
                echo '<tr>';
                echo '<td>' . $a['account_name'] . '</td>';
                echo '<td>' . $a['institution'] . '</td>';
                echo '</tr>';
            }
            ?>
          </table>
        </div>

        <h2>Transactions</h2>
        <div id = 'transactions'>
          <table>
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
                echo '<td>' . $t['amount'] . '</td>';
                echo '<td>' . $t['trans_name'] . '</td>';
                echo '<td>' . $t['date'] . '</td>';
                echo '<td>' . $t['categories'] . '</td>';
                echo '</tr>';
            }
            ?>
          </table>
        </div>


        <div id = 'test'></div>
      </div>
    </main>

  </body>
</html>
