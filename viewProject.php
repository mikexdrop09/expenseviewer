<?php 
include('./components/modalComponents/contents/headerAdmin.php')
?>


<div class="main">
    <div class="expense-container">
        <div class="expense-list">
            <div class="title">
                <h4>LIST OF PROJECTS</h4>
            </div>

            <hr>
            <div class="table-container table-responsive">
                <table class="table table-sm exTable">

                    <thead class="thead-color">

                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Contract ID</th>
                            <th scope="col">Project Name</th>
                            <th scope="col">Total Expense</th>
                            <th scope="col">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                            include('./components/connection/conn.php');

                            $stmt = $conn->prepare("SELECT tblproject.No,\n
                            Upper(ContractID),\n
                            (CASE WHEN ContractName='' then Upper(ProjectName) ELSE Upper(ContractName) END),\n
                            Upper(ProjectStatus),\n
                            FORMAT((SUM(Amount+0)),2), \n
                            UPPER(CASE WHEN Barangay = '' then CONCAT(`City`,' ',`Province`) ELSE CONCAT(`Barangay`,' ,',`City`,' ,',`Province`) END), \n
                            FORMAT((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END),2), \n
                            (CASE WHEN DateStarted = '' THEN '-' ELSE DATE_FORMAT(Date(DateStarted),'%M %d ,%Y')END), \n
                            (CASE WHEN DateFinished = '' THEN '-' ELSE DATE_FORMAT(Date(DateFinished),'%M %d ,%Y')END), \n
                            (CASE WHEN Accomplishment = '' THEN '0.00 %' ELSE CONCAT(Accomplishment, ' %') END), \n
                            FORMAT(((.07)*((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END))),2), \n
                            FORMAT((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END)- \n
                            ((.07)*((CASE WHEN ContractAmount='' Or (ContractAmount+0) = 0 then ABC+0 else ContractAmount+0 END))),2) \n
                            FROM tblproject \n
                            LEFT JOIN tblexpenses ON tblproject.No=ProjectID \n
                            WHERE ProjectName !='' GROUP BY ContractID");
                            $stmt->execute();

                            $result = $stmt->fetchAll();
                            foreach ($result as $row) {
                                $No =$row[0];
                                $contractID =$row[1];
                                $projectName =$row[2];
                                $projectStatus = $row[3];
                                $amount = $row[4];
                                $contractAddress = $row[5];
                                $contractAmount = $row[6];
                                $dateStarted = $row[7];
                                $dateFinished = $row[8];
                                $accomplishment = $row[9];
                                $vat = $row[10];
                                $lessVat = $row[11];
                        ?>
                        <tr>
                            <th scope="row" id="No-<?php echo $No?>"><?php echo $No ?></th>
                            <td id="contractID-<?php echo $No?>"><?php echo $contractID ?></td>
                            <td id="projectName-<?php echo $No?>">
                                <?php echo html_entity_decode(htmlentities($projectName)) ?></td>
                            <td id="amount-<?php echo $No?>"><?php echo $amount ?></td>
                            <td>
                                <div class="action-button">
                                    <a class="btn btn-success btn-block" href='./viewSummary.php?idproject=<?php echo $No ?>
                                            &&?contractID=<?php echo $contractID?>
                                            &&?contractName=<?php echo $projectName?>
                                            &&?contractAddress=<?php echo $contractAddress?>
                                            &&?dateStarted=<?php echo $dateStarted?>
                                            &&?dateFinished=<?php echo $dateFinished?>
                                            &&?accomplishment=<?php echo $accomplishment?>
                                            &&?contractAmount=<?php echo $contractAmount?>
                                            &&?vat=<?php echo $vat?>
                                            &&?lessVat=<?php echo $lessVat?>'>
                                        <img width="30" height="30"
                                            src="https://img.icons8.com/ios/50/FFFFFF/visible--v1.png"
                                            alt="visible--v1" /></a>
                                </div>
                            </td>
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
include('./components/modalComponents/contents/footer.php')
?>