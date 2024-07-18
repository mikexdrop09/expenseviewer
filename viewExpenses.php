<?php
include ('./class.cryptor.php');
include ('./components/modalComponents/contents/headerAdmin.php');
include ('./components/connection/conn.php');
$crypt = new Cryptor();
?>

<div class="modal fade" id="expenseModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="expenseModalShow" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <?php

            $artTitle = $crypt->decrypt($_GET['?sumArticle']);
            $prodID = $crypt->decrypt($_GET['idproject']);
            $smt = $conn->prepare("SELECT Upper(ContractID),\n
                            (CASE WHEN ContractName='' then Upper(ProjectName) ELSE Upper(ContractName) END),\n
                            UPPER(CASE WHEN Barangay = '' then CONCAT(`City`,' ',`Province`) ELSE CONCAT(`Barangay`,' ,',`City`,' ,',`Province`) END) \n
                            FROM tblproject \n
                            LEFT JOIN tblexpenses ON tblproject.No=ProjectID \n
                            WHERE ProjectID = :prod_id GROUP BY ContractID");

            $smt->bindParam("prod_id", $prodID, PDO::PARAM_STR);
            $smt->execute();

            $result = $smt->fetchAll();

            foreach ($result as $row) {
                $cContractID = $row[0];
                $cContractName = $row[1];
                $cContractAddress = $row[2];

                ?>
                <div class="modal-header">
                    <h6 class="modal-title" id="updatetModal"><span class="contract-name"><?php echo $artTitle ?></span><br>
                        CONTRACT ID: <?php echo $cContractID ?><br>
                        <label for="project_Name">CONTRACT NAME: <?php echo $cContractName ?> <br>
                            CONTRACT ADDRESS: <span class="contract-address"><?php echo $cContractAddress ?></span>
                    </h6>
                    <a href='./summary?idproject=<?php echo $_GET['idproject']; ?>' aria-label="close">
                        <span aria-hidden="true">&times;</span>

                    </a>
                </div>
                <?php
            }
            ?>
            <div class="modal-body">

                <div class="table-container table-responsive">
                    <table class="table table-lg exTable" style="width:100%">
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


                            $projectID = $crypt->decrypt($_GET['idproject']);
                            $articleTitle = $crypt->decrypt($_GET['?sumArticle']);

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
                            $stmt->bindParam(":account_title", $articleTitle, PDO::PARAM_STR);

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
                                                <a id="particularsButton" class="btn btn-info btn-block"
                                                    href='./particulars?idproject=<?php echo $_GET['idproject']; ?>&&?dvNumber=<?php echo $dvNumber ?>'>
                                                    <img width="35" height="40"
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