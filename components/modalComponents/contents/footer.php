    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- Data Table -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    
    <script src="./components/scriptfiles/index.js"></script>
</body>


</html>

<?php
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
?>