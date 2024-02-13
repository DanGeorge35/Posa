          
        <div class="row">
              <div class="col-xl-12">
                   <div class="card">                            
                        <div class="card-datatable table-responsive">
                            <table class="datatables-demo table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sn</th>
                                        <th>Inv-code</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Package</th>
                                        <th>Status</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                        $s=0;
                                        while($row = $inv->fetch(PDO::FETCH_ASSOC)){
                                          $s++;
                                  ?>

                                        <tr class="odd gradeX">
                                            <td><?php echo $s;?></td>
                                            <td><?php echo $row['inv_code'] ;?></td>
                                            <td><?php echo $row['fname'] .' '.$row['lname'] ;?></td>
                                            <td>₦ <?php echo number_format($row['amount']) ;?></td>
                                            <td style="text-transform: capitalize;"><?php echo ucwords($row['package']) ;?> Package</td>
                                            <td><?php echo ucwords($row['status']) ;?></td>
                                             <td> <a href="slot_details.php?inv_code=<?php echo $row['inv_code'] ;?>" ><button class="btn btn-success"><span class="feather icon-chevrons-right"></span></button></a> </td>
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

