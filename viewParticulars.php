<?php 
include('./components/modalComponents/contents/headerAdmin.php')
?>

<div class="modal fade" id="particularModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="particularModalShow" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <?php
                          include('./components/connection/conn.php');
                         

                          $lprojectID = $_GET['idproject'];                          
                          $lvoucherNo = $_GET['?dvNumber'];


                          $stmt = $conn->prepare("SELECT (CASE WHEN LENGTH(VoucherNo)<=1 THEN UPPER(CONCAT('0',`VoucherNo`)) ELSE UPPER(VoucherNo) END), \n
                          UPPER(DATE_FORMAT(Date(DateTrans),'%M %d ,%Y')), \n
                          UPPER(Refno), \n 
                          UPPER(Particulars), \n
                          UPPER(Payee), \n
                          FORMAT(SUM(Amount+0),2), \n 
                          UPPER(PreparedBy), \n
                          UPPER((CASE WHEN AccountTitle=Description THEN AccountTitle ELSE CONCAT(AccountTitle,'-',Description) END)), \n
                          UPPER(Category) \n
                          FROM tblexpenses INNER JOIN tblproject On ProjectID = tblproject.No \n
                          INNER JOIN tblcategory On CategoryID = tblcategory.No WHERE ProjectID = :project_id AND VoucherNo = :voucher_no \n
                          GROUP BY CONCAT(VoucherNo,RefNo),TStatus \n
                          ORDER BY (CASE WHEN LENGTH(VoucherNo)<=1 THEN UPPER(CONCAT('0',`VoucherNo`)) ELSE UPPER(VoucherNo) END) ASC, reportPriority  ASC");
                          
                          $stmt->bindParam(":project_id",$lprojectID ,PDO::PARAM_STR);
                          $stmt->bindParam(":voucher_no",$lvoucherNo ,PDO::PARAM_STR);
                        

                          $stmt->execute();

                          $result = $stmt->fetchAll();
                          foreach ($result as $row) {
                              $lvoucherNo =$row[0];
                              $ldateTrans =$row[1];
                              $lrefNo =$row[2];
                              $laccountTitle = $row[3];
                              $lpayee = $row[4];
                              $vamount = $row[5];
                              $lpreparedBy = $row[6];
                              $lArticle = $row[7];
                              $lCategory = $row[8];
                      ?>




            <div class="modal-header">
                <h6 class="modal-title" id="updatetModal">
                    CONTRACT ID: <?php echo $_GET['?contractID']; ?><br>
                    <span class="contract-name">CONTRACT NAME: <?php echo $_GET['?contractName']; ?></span><br>
                    <span class="contract-address"><?php echo $_GET['?contractAddress'];?></span> <br><br>

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
                </h6>
                <a href='./viewExpenses.php?idproject=<?php echo $_GET['idproject']; ?>
                &&?contractID=<?php echo $_GET['?contractID'];?>
                &&?contractName=<?php echo $_GET['?contractName']; ?>
                &&?sumArticle=<?php echo $lCategory ?>
                &&?contractAddress=<?php echo $_GET['?contractAddress']; ?>
                &&?dateStarted=<?php echo $_GET['?dateStarted'];?>
                &&?dateFinished=<?php echo $_GET['?dateFinished'];?>
                &&?accomplishment=<?php echo $_GET['?accomplishment'];?>
                &&?contractAmount=<?php echo $_GET['?contractAmount'];?>
                &&?vat=<?php echo $_GET['?vat'];?>
                &&?lessVat=<?php echo $_GET['?lessVat'];?>
                ' aria-label="close">
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
                        <label>PREPARED BY: <?php echo $lpreparedBy?></label>
                    </div>

                </form>

                <form name="form" method="post">


                    <div class="table-container table-responsive">
                        <table class="table table-lg exTable">
                            <thead class="thead-color">
                                <tr>
                                    <th scope="col">Account Title</th>
                                    <th scope="col">Amount</th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php
                  }
                ?>
                                <?php
                          include('./components/connection/conn.php');
                         

                          $projectID = $_GET['idproject'];
                          $voucherNo = $_GET['?dvNumber'];
                          


                          $stmt = $conn->prepare("SELECT FORMAT((Amount+0),2), \n
                           UPPER((CASE WHEN AccountTitle=`Description` THEN AccountTitle ELSE CONCAT(AccountTitle,'-',`Description`) END)) \n
                           FROM tblexpenses INNER JOIN tblproject On ProjectID = tblproject.No \n
                           INNER JOIN tblcategory On CategoryID = tblcategory.No \n
                           WHERE ProjectID = :project_id AND VoucherNo = :voucher_no \n
                           ORDER BY DateTrans DESC, tblexpenses.No  DESC");
                          
                          $stmt->bindParam(":project_id",$projectID ,PDO::PARAM_STR);
                          $stmt->bindParam(":voucher_no",$voucherNo ,PDO::PARAM_STR);
                        

                          $stmt->execute();

                          $result = $stmt->fetchAll();
                          foreach ($result as $row) {
                              $articleAmount =$row[0];
                              $articleAccountTitle = $row[1];
                      ?>
                                <tr>
                                    <div class="container-fluid">
                                        <td id="articleAccountTitle-<?php echo $articleAccountTitle?>">
                                            <?php echo $articleAccountTitle ?></td>
                                        <td class="text-center" id="articleAmount-<?php echo $articleAccountTitle?>">
                                            <?php echo $articleAmount ?></td>
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
include('./components/modalComponents/contents/footer.php')
?>