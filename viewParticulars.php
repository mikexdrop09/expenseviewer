<?php
include ('./class.cryptor.php');
include ('./components/modalComponents/contents/headerAdmin.php');
include ('./components/connection/conn.php');
$crypt = new Cryptor();
?>

<div class="modal fade" id="particularModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="particularModalShow" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <?php
                $prodID = $crypt->decrypt($_GET['idproject']);
                $smt = $conn->prepare("SELECT Upper(ContractID), \n
                            (CASE WHEN ContractName='' then Upper(ProjectName) ELSE Upper(ContractName) END),\n
                            UPPER(CASE WHEN Barangay = '' then CONCAT(`City`,' ',`Province`) ELSE CONCAT(`Barangay`,' ,',`City`,' ,',`Province`) END) \n
                            FROM tblproject \n
                            LEFT JOIN tblexpenses ON tblproject.No=ProjectID \n
                            WHERE ProjectID = :prod_id GROUP BY ContractID");
                $smt->bindParam(":prod_id", $prodID, PDO::PARAM_STR);
                $smt->execute();

                $result = $smt->fetchAll();

                foreach ($result as $row) {
                    $cContractID = $row[0];
                    $cContractName = $row[1];
                    $cContractAddress = $row[2];
                    ?>
                    <h6 class="modal-title" id="updatetModal">
                        CONTRACT ID: <?php echo $cContractID ?><br>
                        <span class="contract-name">CONTRACT NAME: <?php echo $cContractName ?></span><br>
                        <span class="contract-address"><?php echo $cContractAddress ?></span> <br><br>
                        <?php
                }
                ?>

                    <?php
                    $lprojectID = $crypt->decrypt($_GET['idproject']);
                    $lvoucherNo = $_GET['?dvNumber'];


                    $stmt = $conn->prepare("SELECT (CASE WHEN LENGTH(VoucherNo)<=1 THEN UPPER(CONCAT('0',`VoucherNo`)) ELSE UPPER(VoucherNo) END), \n
                          UPPER(DATE_FORMAT(Date(DateTrans),'%M %d ,%Y')), \n
                          UPPER(Refno)
                          FROM tblexpenses INNER JOIN tblproject On ProjectID = tblproject.No \n
                          INNER JOIN tblcategory On CategoryID = tblcategory.No WHERE ProjectID = :project_id AND VoucherNo = :voucher_no \n
                          GROUP BY CONCAT(VoucherNo,RefNo),TStatus \n
                          ORDER BY (CASE WHEN LENGTH(VoucherNo)<=1 THEN UPPER(CONCAT('0',`VoucherNo`)) ELSE UPPER(VoucherNo) END) ASC, reportPriority  ASC");

                    $stmt->bindParam(":project_id", $lprojectID, PDO::PARAM_STR);
                    $stmt->bindParam(":voucher_no", $lvoucherNo, PDO::PARAM_STR);
                    $stmt->execute();

                    $result = $stmt->fetchAll();
                    foreach ($result as $row) {
                        $lvoucherNo = $row[0];
                        $ldateTrans = $row[1];
                        $lrefNo = $row[2];
                        ?>

                        <div class="container-fluid px-0">
                            <div class="row">
                                <div class="col">
                                    <label>DV NUMBER: <?php echo $lvoucherNo ?></label>
                                </div>
                                <div class="col">
                                    <label>REF NUMBER: <?php echo $lrefNo ?></label>
                                </div>
                                <div class="col">
                                    <label>DATE: <?php echo $ldateTrans ?></label>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>
                </h6>

                <?php
                $lprojectID = $crypt->decrypt($_GET['idproject']);
                $lvoucherNo = $_GET['?dvNumber'];


                $stmt = $conn->prepare("SELECT UPPER(Particulars), \n
                          UPPER(Payee), \n
                          FORMAT(SUM(Amount+0),2), \n 
                          UPPER(PreparedBy), \n
                          UPPER((CASE WHEN AccountTitle=Description THEN AccountTitle ELSE CONCAT(AccountTitle,'-',Description) END)), \n
                          UPPER(Category), \n
                          UPPER(AccountTitle) \n
                          FROM tblexpenses INNER JOIN tblproject On ProjectID = tblproject.No \n
                          INNER JOIN tblcategory On CategoryID = tblcategory.No WHERE ProjectID = :project_id AND VoucherNo = :voucher_no \n
                          GROUP BY CONCAT(VoucherNo,RefNo),TStatus \n
                          ORDER BY (CASE WHEN LENGTH(VoucherNo)<=1 THEN UPPER(CONCAT('0',`VoucherNo`)) ELSE UPPER(VoucherNo) END) ASC, reportPriority  ASC");

                $stmt->bindParam(":project_id", $lprojectID, PDO::PARAM_STR);
                $stmt->bindParam(":voucher_no", $lvoucherNo, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetchAll();
                foreach ($result as $row) {
                    $laccountTitle = $row[0];
                    $lpayee = $row[1];
                    $vamount = $row[2];
                    $lpreparedBy = $row[3];
                    $lArticle = $row[4];
                    $lCategory = $row[5];
                    $retArticle = $row[6];
                    ?>
                    <a href='./expenses?idproject=<?php echo $_GET['idproject']; ?>&&?sumArticle=<?php echo $crypt->encryptID($retArticle) ?>'
                        aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </a>



                </div>

                <div class="modal-body">


                    <form>
                        <div class="form-group">
                            <label>ARTICLE: <?php echo $lArticle ?></label>
                        </div>

                        <div class="form-group">
                            <label>PARTICULARS: <?php echo $laccountTitle ?></label>
                        </div>

                        <div class="form-group">
                            <label>PAYEE: <?php echo $lpayee ?></label>
                        </div>

                        <div class="form-group">
                            <label>PREPARED BY: <?php echo $lpreparedBy ?></label>
                        </div>

                    </form>
                    <?php
                }
                ?>
                <form name="form" method="post">


                    <div class="table-container table-responsive">
                        <table class="table table-lg exTable" style="width:100%">
                            <thead class="thead-color">
                                <tr>
                                    <th scope="col">Account Title</th>
                                    <th scope="col">Amount</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $projectID = $crypt->decrypt($_GET['idproject']);
                                $voucherNo = $_GET['?dvNumber'];



                                $stmt = $conn->prepare("SELECT FORMAT((Amount+0),2), \n
                           UPPER((CASE WHEN AccountTitle=`Description` THEN AccountTitle ELSE CONCAT(AccountTitle,'-',`Description`) END)) \n
                           FROM tblexpenses INNER JOIN tblproject On ProjectID = tblproject.No \n
                           INNER JOIN tblcategory On CategoryID = tblcategory.No \n
                           WHERE ProjectID = :project_id AND VoucherNo = :voucher_no \n
                           ORDER BY DateTrans DESC, tblexpenses.No  DESC");

                                $stmt->bindParam(":project_id", $projectID, PDO::PARAM_STR);
                                $stmt->bindParam(":voucher_no", $voucherNo, PDO::PARAM_STR);


                                $stmt->execute();

                                $result = $stmt->fetchAll();
                                foreach ($result as $row) {
                                    $articleAmount = $row[0];
                                    $articleAccountTitle = $row[1];
                                    ?>
                                    <tr>
                                        <div class="container-fluid">
                                            <td id="articleAccountTitle-<?php echo $articleAccountTitle ?>">
                                                <?php echo $articleAccountTitle ?>
                                            </td>
                                            <td class="text-center" id="articleAmount-<?php echo $articleAccountTitle ?>">
                                                <?php echo $articleAmount ?>
                                            </td>
                                    </tr>

                        </div>

                        <?php
                                }

                                ?>

                    </tbody>

                    <tfoot>
                        <td class="text-left grand-total">
                            GRAND TOTAL
                        </td>
                        <td class="text-center grand-total">
                            <?php echo $vamount ?>
                        </td>
                    </tfoot>

                    </table>

            </div>
        </div>
    </div>
</div>
</div>

<?php
include ('./components/modalComponents/contents/footer.php')
    ?>