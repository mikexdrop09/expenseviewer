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

                    header('location: ./viewProject.php');
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

