<?php

// Init a session
session_start();

// Check if user is already logged in
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
    header("location: ../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome!</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
        <script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>
        <script src = '../js/link_script.js'></script>
    </head>

    <body>
        <h1>YOU'RE LOGGED IN</h1>
        <p><br>Click <a href = 'logout.php'>here</a> to log out.</p>
        <p id = 'test'></p>

        <h2>Your Accounts</h2>
        <div id = 'accounts'>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Institution</th>
                </tr>

                <?php
                include('db_service.php');
                $result = get_all_accounts();
                $result->bind_result($account_name, $institution);
                while ($result->fetch()) {
                    echo '<tr>';
                    echo '<td>' . $account_name . '</td>';
                    echo '<td>' . $institution . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>

        <h2>Transactions</h2>
        <div id = 'transactions'>
            <?php
            include('plaid_service.php');
            $result = get_tokens();
            $result->bind_result($token);
            while ($result->fetch()) {
                echo $token . '<br>';
                $transactions = call_plaid_service($token, 'transaction');
                foreach ($transactions as $item) {
                    echo $item . '<br>';
                }
            }
            ?>
        </div>

        <button id="link-button">Link Account</button>
        
    </body>
</html>