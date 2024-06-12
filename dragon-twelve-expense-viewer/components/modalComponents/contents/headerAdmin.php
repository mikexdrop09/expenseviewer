<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        session_start();
        session_destroy();
        setcookie('D12id', '', time() - 1);
        header('location: ./index.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXPENSE VIEWER</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    
    <link rel="stylesheet" href="./components/css/style.css">

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-outline-danger">
        <a class="navbar-brand ml-4">Dragon Twelve Official</a>
       
        <button class ="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent">
             <span class="navbar-toggler-icon"></span>
        </button>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
    
                <li class="nav-item">
                    <a class="nav-link" href="./viewProject.php">PROJECTS <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./billingProject.php">BILLING <span class="sr-only">(current)</span></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-3">
                    <form action="" method="POST">
                    <button type="submit" class="btn btn-danger" name="logout">Log-out</button>
                    </form>
                </li>
            </ul>
    </div>
    
    </nav>