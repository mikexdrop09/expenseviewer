<?php 
include('./components/modalComponents/contents/headerAdmin.php')
?>



<div class="main">
    <div class="expense-container">
        <div class="expense-list">
            <div class="title">
                <h4>PROJECT BILLING</h4>
            </div>

            <hr>
            <div class="table-container table-responsive">
                <table class="table table-lg billingTable" style="width:100%">

                    <thead class="thead-color">

                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Contract ID</th>
                            <th scope="col">Contract Name</th>
                            <th scope="col">Contractor</th>
                            <th scope="col">Sub Contractor</th>
                            <th scope="col">Voucher No</th>
                            <th scope="col">%</th>
                            <th scope="col">Billing</th>
                            <th scope="col">Collection</th>
                            <th scope="col">Royalty</th>
                            <th scope="col">Check No (Royalty)</th>
                            <th scope="col">Check Date (Royalty)</th>
                            <th scope="col">Office</th>
                            <th scope="col">Check No (Office)</th>
                            <th scope="col">Check Date (Office)</th>
                            <th scope="col">Variance</th>
                            <th scope="col">Obligation</th>
                            <th scope="col">Expense</th>
                            <th scope="col">Remark</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                            include('./components/connection/conn.php');

                            $stmt = $conn->prepare("SELECT Date(BillingDate) as `BillingDate`, \n
                            UPPER(ContractID) as `ContractID`, \n
                            UPPER(ContractName) as `ContractName`, \n
                            UPPER(Contractor) as `Contractor`, \n
                            UPPER(SubContractor) as `SubContractor`, \n
                            UPPER(VoucherNo) as `VoucherNo`, \n
                            Format((BillingPercent+0),2) as `BillingPercent`, \n
                            UPPER(Billing) as `Billing`, \n
                            FORMAT((BillingAmount+0),2) as `Collection`, \n
                            FORMAT((Royalty),2) as `Royalty`, \n
                            UPPER(RCheckNo) as `RCheckNo`, \n
                            Date(RCheckDate) as `RCheckDate`, \n
                            FORMAT((Office+0),2) as `OFFICE`, \n
                            UPPER(OCheckNo) as `OCheckNo`, \n
                            Date(OCheckDate) as `OCheckDate`, \n
                            FORMAT((Variance+0),2) as `Variance`, \n
                            FORMAT((Obligation+0),2) as `Obligation`, \n
                            Upper(Expenses) as `Expenses`, \n
                            Upper(Remarks) as `Remark` \n
                            FROM tblproject \n
                            INNER JOIN tblbilling ON tblbilling.ProjectID = tblproject.No \n
                            ORDER BY CONCAT(`Year`,Date(BillingDate)) Desc ,tblbilling.No Desc");
                            $stmt->execute();

                            $result = $stmt->fetchAll();
                            foreach ($result as $row) {
                                $Date =$row[0];
                                $contractID =$row[1];
                                $ContractName =$row[2];
                                $Contractor = $row[3];
                                $subContractor = $row[4];
                                $voucherNo = $row[5];
                                $billingPercent = $row[6];
                                $billing = $row[7];
                                $Collection = $row[8];
                                $royalty = $row[9];
                                $rCheckNo = $row[10];
                                $rCheckDate = $row[11];
                                $office = $row[12];
                                $oCheckNo = $row[13];
                                $oCheckDate = $row[14];
                                $variance = $row[15];
                                $obligation = $row[16];
                                $expenses = $row[17];
                                $remark = $row[18];
                        ?>
                        <tr>
                            <th scope="row" id="Date-<?php echo $Date?>"><?php echo $Date ?></th>
                            <td id="contractID-<?php echo $Date?>"><?php echo $contractID ?></td>
                            <td id="contractName-<?php echo $Date?>">
                                <?php echo html_entity_decode(htmlentities($ContractName)) ?></td>
                            <td id="contractor-<?php echo $Date?>">
                                <?php echo html_entity_decode(htmlentities($Contractor)) ?></td>
                            <td id="subContractor-<?php echo $Date?>">
                                <?php echo html_entity_decode(htmlentities($subContractor)) ?></td>
                            <td id="voucherNo-<?php echo $Date?>"><?php echo $voucherNo ?></td>
                            <td id="billingPercent-<?php echo $Date?>"><?php echo $billingPercent ?></td>
                            <td id="billing-<?php echo $Date?>"><?php echo $billing ?></td>
                            <td id="collection-<?php echo $Date?>"><?php echo $Collection ?></td>
                            <td id="royalty-<?php echo $Date?>"><?php echo $royalty ?></td>
                            <td id="rCheckNo-<?php echo $Date?>"><?php echo $rCheckNo ?></td>
                            <td id="rCheckDate-<?php echo $Date?>"><?php echo $rCheckDate ?></td>
                            <td id="office-<?php echo $Date?>"><?php echo $office ?></td>
                            <td id="oCheckNo-<?php echo $Date?>"><?php echo $oCheckNo ?></td>
                            <td id="oCheckDate-<?php echo $Date?>"><?php echo $oCheckDate ?></td>
                            <td id="variance-<?php echo $Date?>"><?php echo $variance ?></td>
                            <td id="obligation-<?php echo $Date?>"><?php echo $obligation ?></td>
                            <td id="expenses-<?php echo $Date?>"><?php echo $expenses ?></td>
                            <td id="remark-<?php echo $Date?>"><?php echo $remark ?></td>
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



<?php
include('./components/modalComponents/contents/footer.php');
?>