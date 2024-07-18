<?php
include ('./class.cryptor.php');
include ('./components/modalComponents/contents/headerAdmin.php');
include ('./components/connection/conn.php');
$crypt = new Cryptor();
?>

<div class="modal fade" id="expenseModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="expenseModalShow" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <?php
            $prodID = $crypt->decrypt($_GET['idproject']);
            $smt = $conn->prepare("SELECT Upper(ContractID),\n
                            (CASE WHEN ContractName='' then Upper(ProjectName) ELSE Upper(ContractName) END),\n
                            UPPER(CASE WHEN Barangay = '' then CONCAT(`City`,' ',`Province`) ELSE CONCAT(`Barangay`,' ,',`City`,' ,',`Province`) END), \n
                            (CASE WHEN DateStarted = '' THEN '-' ELSE DATE_FORMAT(Date(DateStarted),'%M %d ,%Y')END), \n
                            (CASE WHEN DateFinished = '' THEN '-' ELSE DATE_FORMAT(Date(DateFinished),'%M %d ,%Y')END), \n
                            (CASE WHEN Accomplishment = '' THEN '0.00 %' ELSE CONCAT(Accomplishment, ' %') END), \n
                            FORMAT((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END),2), \n
                            FORMAT(((.07)*((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END))),2), \n
                            FORMAT((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END)- \n
                            ((.07)*((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END))),2) \n
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
                $cDateStarted = $row[3];
                $cDateFinished = $row[4];
                $cAccomplishment = $row[5];
                $cContractAmount = $row[6];
                $cVat = $row[7];
                $clessVat = $row[8];

                ?>

                <div class="modal-header">
                    <h6 class="modal-title" id="updatetModal">
                        <?php echo $cContractID ?>
                        <br>
                        <span class="contract-name"><?php echo $cContractName ?></span><br>
                        <span class="contract-address"><?php echo $cContractAddress ?></span>

                    <br>
                    <br>

                    <div class="container-fluid px-0">
                        <div class="row g-0">
                            <div class="col-12">
                                <span>Date Started: <?php echo $cDateStarted ?></span>
                            </div>
                            <div class="col-12">
                                <span>Date Finished: <?php echo $cDateFinished ?></span>
                            </div>
                            <div class="col-12">
                                <span>Accomplishment: <?php echo $cAccomplishment ?></span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="container-fluid px-0">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col contract-amount-tax">
                                        <span>Project Cost:</span>
                                    </div>
                                    <div class="col">

                                    </div>
                                    <div class="col text-right contract-amount-tax">
                                        <span><?php echo $cContractAmount ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-6 contract-amount-tax"><span>Less:</span></div>
                                            <div class="col-6"><span>VAT</span></div>
                                        </div>

                                    </div>
                                    <div class="col">
                                        <span>7.0 %</span>
                                    </div>
                                    <div class="col text-right contract-amount-tax">
                                        <span><?php echo $cVat ?></span>

                                        <hr class="hr-contract-amount-tax">

                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col contract-amount-tax">
                                        <span>NET After TAX:</span>
                                    </div>
                                    <div class="col">

                                    </div>
                                    <div class="col text-right contract-amount-tax">
                                        <span><?php echo $clessVat ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </h6>
                    <a href="./project" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </a>

                    <?php
            }
            ?>


            </div>


            <br>

            <div class="container-fluid px-4">
                <div class="row g-0">
                    <div class="col-3">
                        <span>Collection:</span>
                    </div>

                    <div class="col-9">
                        <div>
                            <table class="table-billing">
                                <tbody>
                                    <?php include ('./components/connection/conn.php');
                                    $idp = $crypt->decrypt($_GET['idproject']);
                                    $stmt = $conn->prepare("SELECT Billing, \n
                                    CONCAT(FORMAT((BillingPercent+0),2),' %') AS BillingPercent, \n
                                    FORMAT((BillingAmount+0),2) AS `BillingAmount` \n
                                    FROM tblbilling \n 
                                    WHERE ProjectID = :project_id \n
                                    GROUP BY `No` \n
                                    ORDER BY `No` ASC");

                                    $stmt->bindParam(":project_id", $idp, PDO::PARAM_STR);
                                    $stmt->execute();

                                    $result = $stmt->fetchAll();

                                    foreach ($result as $row) {
                                        $billing = $row[0];
                                        $billingPercent = $row[1];
                                        $billingAmount = $row[2];
                                        ?>
                                        <tr>
                                            <div class="container px-0">
                                                <div class="row g-0">
                                                    <div class="col-4">
                                                        <td id="billing-<?php echo $billing ?>"><?php echo $billing ?></td>
                                                    </div>
                                                    <div class="col-4">
                                                        <td id="billingPercent-<?php echo $billingPercent ?>">
                                                            <?php echo $billingPercent ?>
                                                        </td>
                                                    </div>
                                                    <div class="col-4">
                                                        <td class="text-right"
                                                            id="billingAmount-<?php echo $billingAmount ?>">
                                                            <?php echo $billingAmount ?>
                                                        </td>
                                                    </div>
                                                </div>

                                            </div>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid px-4">
                <div class="row g-0">
                    <div class="col-12">
                        <br>
                        <div class=" billing-amount"></div>
                    </div>

                    <div class="col-12">

                        <?php
                        $idp = $crypt->decrypt($_GET['idproject']);
                        $stmt = $conn->prepare("SELECT FORMAT((SUM(BillingAmount+0)),2) \n
                    FROM tblbilling \n
                    WHERE ProjectID = :project_id");
                        $stmt->bindParam(":project_id", $idp, PDO::PARAM_STR);
                        $stmt->execute();

                        $result = $stmt->fetchAll();
                        foreach ($result as $row) {
                            $sumBilling = $row[0];

                            ?>
                            <div>
                                <br>
                                <span class="billing-sum"><?php echo $sumBilling ?> </span>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>



            <!-- HEADER END -->

            <div class="modal-body">
                <div class="table-container table-responsive">
                    <table class="table table-xl exTable" style="width:100%">
                        <thead class="thead-color">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Operating Expense</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Percent</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $projectID = $crypt->decrypt($_GET['idproject']);


                            $stmt = $conn->prepare("SELECT UPPER(Category), \n
                            CONCAT('  ',FORMAT((SUM(Amount+0)),2)) as `AMOUNT`, \n
                            UPPER(Category), \n
                            CONCAT(SUBSTRING((CONCAT((SUM(Amount)/((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END) - ((.07)*((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END))))) * 100)),1,4),' %'), \n
                            ReportPriority \n
                            FROM tblexpenses INNER JOIN tblproject On ProjectID = tblproject.No \n
                            INNER JOIN tblcategory On CategoryID = tblcategory.No \n
                            WHERE ProjectID = :project_id \n
                            GROUP BY Category \n
                            ORDER BY Concat((ReportPriority+10),`Category`,`Description`) ASC");


                            $stmt->bindParam(":project_id", $projectID, PDO::PARAM_STR);


                            $stmt->execute();

                            $result = $stmt->fetchAll();
                            foreach ($result as $row) {
                                $sumAccountTitle = $row[0];
                                $sumAmount = $row[1];
                                $article = $row[2];
                                $percentage = $row[3];
                                $reportPriority = $row[4];
                                ?>
                                <tr>
                                    <td id="reportPriority-<?php echo $reportPriority ?>" style="color:white;">
                                        <?php echo $reportPriority ?>
                                    </td>
                                    <td id="sumAccounTitle-<?php echo $sumAccountTitle ?>">
                                        <?php echo $sumAccountTitle ?>
                                    </td>
                                    <td class="text-right" id="sumAmount-<?php echo $sumAccountTitle ?>">
                                        <?php echo $sumAmount ?>
                                    </td>
                                    <td class="text-center" id="percentage-<?php echo $sumAccountTitle ?>">
                                        <?php echo $percentage ?>
                                    </td>
                                    <td>
                                        <div class="action-button">
                                            <a id="particularsButton" class="btn btn-block btn-info"
                                                href='./expenses?idproject=<?php echo $_GET['idproject']; ?>&?sumArticle=<?php echo $crypt->encryptId($article) ?>'>
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

                <tfoot>
                    <?php
                    include ('./components/connection/conn.php');
                    $idp = $crypt->decrypt($_GET['idproject']);
                    $stmt = $conn->prepare("SELECT  CONCAT('  ',FORMAT((SUM(Amount+0)),2)) as `AMOUNT`, \n
                      CONCAT(SUBSTRING((CONCAT((SUM(Amount)/((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END) - ((.07)*((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END))))) * 100)),1,4),' %'), \n
                     ReportPriority \n
                     FROM tblexpenses INNER JOIN tblproject On ProjectID = tblproject.No \n
                     INNER JOIN tblcategory On CategoryID = tblcategory.No \n
                     WHERE ProjectID = :project_id \n");

                    $stmt->bindParam(":project_id", $idp, PDO::PARAM_STR);

                    $stmt->execute();

                    $result = $stmt->fetchAll();
                    foreach ($result as $row) {
                        $grandPercent = $row[1];
                        $grandTotal = $row[0];

                        ?>
                        <tr>
                            <td></td>
                            <td><span class="grand-total">GRAND TOTAL</span></td>
                            <td class="text-right grand-total"><span><?php echo $grandTotal ?></span></td>
                            <td class="text-center grand-total"><span><?php echo $grandPercent ?><span></td>
                            <td></td>

                        </tr>
                        <?php
                    }
                    ?>
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