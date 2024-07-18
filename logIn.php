<?php 
include('./components/modalComponents/contents/headerLogin.php');
$failed="";
?>

<img id="background-image" src="./components/css/images/about-us-3.jpg"></img>
<div class="main-login">
    <div class="login-container">
        <div class="login-list">
            <div class="title">
                <h4 class="login-forecolor">LOGIN FORM</h4>
                
            </div>
            <p id="log-in-message"></p>
            <hr>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="userName" class="login-forecolor">Username:</label>
                    <input type="text" required class="form-control" id="userName" name="user_name">
                </div>

                <div class="form-group">
                    <label for="passWord" class="login-forecolor">Password:</label>
                    <input type="password" required class="form-control" id="passWord" name="pass_word">
                </div>

                <button type="submit" class="btn btn-primary btn-sm btn-block" name="submit">Log in</button>
                <button type="button" class="btn btn-secondary btn-sm btn-block" onclick="window.location.href='./index.php';">Close</button>
            </form>

        </div>
    </div>
</div>

<?php 
include('./components/modalComponents/contents/footer.php')
?>

<?php
if ($failed) {
echo "
<script>
if ($failed==1) {
document.getElementById('log-in-message').innerHTML = 'Incorrect username or password!';
document.getElementById('log-in-message').style.fontSize='80%';
document.getElementById('log-in-message').style.color ='#ff8080';

} else {
 document.getElementById('log-in-message').innerHTML = '';
}
</script>
";
}
?>