<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php  getTitle(); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700&family=Roboto:wght@100;300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $css ?>/all.min.css">
    <link rel="stylesheet" href="<?= $css ?>/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $css ?>/bootstrap.min.css">

     <!-- Replace "test" with your own sandbox Business account app client ID -->
     <script src="https://www.paypal.com/sdk/js?client-id=AWXKUXp9hKb4_BrHR4g4cy61RX8kP1YP7sEiwyrjJBYGZUtfTH78ikdTIqEEipQF6WqJ7w_ICzfcRKyJ&currency=USD"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">


    <link rel="stylesheet" href="<?= $css ?>/front.css">
</head>

<body>

<style>
  /* Customize the PayPal Smart Buttons container */
  #paypal-button-container {
    text-align: center;
  }

  /* Customize the PayPal Smart Buttons */
  .paypal-button {
    color: #fff;
    background-color: red;
    border-color: #0070ba;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
  }

  /* Style the PayPal Smart Buttons on hover */
  .paypal-button:hover {
    background-color: #005f9b;
  }
</style>