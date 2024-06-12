<?php
/*Checking if account cookies not expired! */
                
if (isset($_COOKIE['D12id'])) {
    include ('./components/connection/conn.php');
    $selectCookies = $conn->prepare("SELECT * FROM tbluser WHERE `no` = :cookie_id");
    $selectCookies->bindParam(":cookie_id", $_COOKIE['D12id'], PDO::PARAM_STR);

    if ($selectCookies->execute()) {
        $result = $selectCookies->fetchAll();

        if ($result !== false) {
           
            header('location: ./viewProject.php');
        }
    }

} else {

    include ('./components/modalComponents/contents/header.php');
    ?>

        <img id="background-image" src="./components/css/images/background.png"></img>

        <?php

        include ('./components/modalComponents/contents/footer.php');

}
?>
