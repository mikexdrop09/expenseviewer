<?php
include ('./components/modalComponents/contents/headerAdmin.php')
    ?>

<div class="modal fade" id="expenseModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="expenseModalShow" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title" id="updatetModal"><span
                        class="contract-name"><?php echo $_GET['?sumArticle']; ?></span><br>
                    CONTRACT ID: <?php echo $_GET['?contractID']; ?><br>
                    <label for="project_Name">CONTRACT NAME: <?php echo $_GET['?contractName']; ?> <br>
                        CONTRACT ADDRESS: <span class="contract-address"><?php echo $_GET['?contractAddress']; ?></span>
                </h6>
                <a href='./viewSummary.php?idproject=<?php echo $_GET['idproject']; ?>
                &&?contractID=<?php echo $_GET['?contractID']; ?>
                &&?contractName=<?php echo $_GET['?contractName']; ?>
                &&?contractAddress=<?php echo $_GET['?contractAddress']; ?>
                &&?dateStarted=<?php echo $_GET['?dateStarted']; ?>
                &&?dateFinished=<?php echo $_GET['?dateFinished']; ?>
                &&?accomplishment=<?php echo $_GET['?accomplishment']; ?>
                &&?contractAmount=<?php echo $_GET['?contractAmount']; ?>
                &&?vat=<?php echo $_GET['?vat']; ?>
                &&?lessVat=<?php echo $_GET['?lessVat']; ?>
                ' aria-label="close">
                    <span aria-hidden="true">&times;</span>

                </a>
            </div>

            <div class="modal-body">

                <div class="table-container table-responsive">
                    <table class="table table-lg exTable">
                        <thead class="thead-color">
                            <tr>
                                <th scope="col">DV No</th>
                                <th scope="col">Ref No</th>
                                <th scope="col">Date</th>
                                <th scope="col">Particulars</th>
                                <th scope="col">Payee</th>
                                <th scope="col">Total Expense</th>
                                <th scope="col">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            include ('./components/connection/conn.php');


                            $projectID = $_GET['idproject'];
                            $articleTitle = $_GET['?sumArticle'];

                            $stmt = $conn->prepare("SELECT (CASE WHEN LENGTH(VoucherNo)<=1 THEN UPPER(CONCAT('0',`VoucherNo`)) ELSE UPPER(VoucherNo) END), \n
                            DATE_FORMAT(Date(DateTrans),'%M %d ,%Y'), \n
                            UPPER(Refno), \n 
                            UPPER(Particulars), \n
                            UPPER(Payee), \n
                            FORMAT(SUM(Amount+0),2), \n 
                            UPPER(PreparedBy),
                            UPPER(VoucherNo)\n 
                            FROM tblexpenses INNER JOIN tblproject On ProjectID = tblproject.No \n
                            INNER JOIN tblcategory On CategoryID = tblcategory.No \n
                            WHERE ProjectID = :project_id AND UPPER(Category) = :account_title \n
                            GROUP BY CONCAT(VoucherNo,RefNo),TStatus \n
                            ORDER BY (CASE WHEN LENGTH(VoucherNo)<=1 THEN UPPER(CONCAT('0',`VoucherNo`)) ELSE UPPER(VoucherNo) END) ASC, reportPriority  ASC");

                            $stmt->bindParam(":project_id", $projectID, PDO::PARAM_STR);
                            $stmt->bindParam(":account_title", $_GET['?sumArticle'], PDO::PARAM_STR);

                            $stmt->execute();

                            $result = $stmt->fetchAll();
                            foreach ($result as $row) {
                                $voucherNo = $row[0];
                                $dateTrans = $row[1];
                                $refNo = $row[2];
                                $accountTitle = $row[3];
                                $payee = $row[4];
                                $vamount = $row[5];
                                $preparedBy = $row[6];
                                $dvNumber = $row[7];
                                ?>
                            <tr>
                                <div class="container-fluid">
                                    <td id="voucherNo-<?php echo $voucherNo ?>"><?php echo $voucherNo ?></td>
                                    <td id="refNo-<?php echo $voucherNo ?>"><?php echo $refNo ?></td>
                                    <td id="dateTrans-<?php echo $voucherNo ?>"><?php echo $dateTrans ?></td>
                                    <td id="accountTitle-<?php echo $voucherNo ?>"><?php echo $accountTitle ?></td>
                                    <td id="payee-<?php echo $voucherNo ?>"><?php echo $payee ?></td>
                                    <td id="vamount-<?php echo $voucherNo ?>"><?php echo $vamount ?></td>
                                    <td>
                                        <div class="action-button">
                                            <a id="particularsButton" class="btn btn-info btn-block" href='./viewParticulars.php?idproject=<?php echo $_GET['idproject']; ?> 
                                            &&?contractID=<?php echo $_GET['?contractID']; ?>
                                            &&?contractName=<?php echo $_GET['?contractName']; ?> 
                                            &&?dvNumber=<?php echo $dvNumber ?> 
                                            &&?contractAddress=<?php echo $_GET['?contractAddress']; ?>
                                            &&?dateStarted=<?php echo $_GET['?dateStarted']; ?>
                                            &&?dateFinished=<?php echo $_GET['?dateFinished']; ?>
                                            &&?accomplishment=<?php echo $_GET['?accomplishment']; ?>
                                            &&?contractAmount=<?php echo $_GET['?contractAmount']; ?>
                                            &&?vat=<?php echo $_GET['?vat']; ?>
                                            &&?lessVat=<?php echo $_GET['?lessVat']; ?>
                                            '><img width="35" height="40"
                                                    src="https://img.icons8.com/pastel-glyph/64/FFFFFF/file.png"
                                                    alt="visible--v1" /></a>
                                        </div>
                                    </td>

                            </tr>
                </div>
                <?php
                            }

                            ?>

                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>


<?php
include ('./components/modalComponents/contents/footer.php')
    ?>