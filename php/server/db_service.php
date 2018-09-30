<?php

function get_all_accounts() {
  include(__DIR__.'/db_config.php');
  if ($sql = $link->prepare('SELECT account_name, institution FROM tokens WHERE account_id = ?')) {
    $sql->bind_param('i', $account_id);
    $account_id = $_SESSION['id'];
    if ($sql->execute()) {
      return $sql;
    }
  }
  $link->close();
}

function get_tokens() {
  include(__DIR__.'/db_config.php');
  if ($sql = $link->prepare('SELECT access_token, bank_account_id FROM tokens WHERE account_id = ? AND active = "1"')) {
    $sql->bind_param('i', $account_id);
    $account_id = $_SESSION['id'];
    if ($sql->execute()) {
      return $sql;
    }
  }
  $link->close();
}

function get_transactions() {
  include(__DIR__.'/db_config.php');
  if ($sql = $link->prepare('SELECT bank_account_id, amount, transaction_name, date, categories FROM transactions WHERE account_id = ?')) {
    $sql->bind_param('i', $account_id);
    $account_id = $_SESSION['id'];
    if ($sql->execute()) {
      return $sql;
    }
  }
  $link->close();
}

function get_bank_name($bank_id) {
  include(__DIR__.'/db_config.php');
  if ($sql = $link->prepare('SELECT account_name FROM tokens WHERE bank_account_id = ? AND active = "1"')) {
    $sql->bind_param('s', $bank_id);
    if ($sql->execute()) {
      $sql->bind_result($bank_name);
      $sql->store_result();
      if ($sql->num_rows == 1) {
        $sql->fetch();
        return $bank_name;
      }
    }
  }
  $link->close();
}

?>
