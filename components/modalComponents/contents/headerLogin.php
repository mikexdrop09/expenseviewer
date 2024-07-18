<?php
include ('./components/connection/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        if (isset($_POST['user_name']) || isset($_POST['pass_word'])) {
            /*$userName = "%" . $_POST['user_name'] . "%";
            $passWord = "%" . $_POST['pass_word'] . "%";*/
            $failed = 0;
            $userName = strtoupper($_POST['user_name']);
            $passWord = strtoupper($_POST['pass_word']);


            $selectStmt = $conn->prepare("SELECT * FROM tbluser WHERE Upper(Username) = :userr_Name  and `Password`  = :passs_Word ");
            $selectStmt->bindParam(":userr_Name", $userName, PDO::PARAM_STR);
            $selectStmt->bindParam(":passs_Word", $passWord, PDO::PARAM_STR);

            if ($selectStmt->execute()) {
                $result = $selectStmt->fetch();
                if ($result !== false) {
                    foreach ($result as $row) {
                        $uID = $row[0];
                    }
                    /*CORRECT PASSWORD */

                    setcookie('D12id', $uID, time() + 3600 * 4);
                    session_start();

                    $_SESSION['D12id'] = $uID;

                    header('location: ./project');
                } else {
                    /*INCORRECT PASSWORD */
                    /*header('location: ./logIn.php');*/
                    $failed = 1;

                }
            }


        }
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
    <link rel="stylesheet" href="./components/css/datatablestyle.css" />
    <link rel="stylesheet" href="./components/css/datatablecolumns.css" />
    <link rel="stylesheet" href="./components/css/style.css">

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-outline-danger">
        <a class="navbar-brand ml-4" href="./home">Dragon Twelve Official</a>
       
        <button class ="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent">
             <span class="navbar-toggler-icon"></span>
        </button>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
               
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-3">
                </li>
            </ul>
    </div>
    
    </nav>