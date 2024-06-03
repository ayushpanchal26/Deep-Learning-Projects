
<?php 
$i = 1;
$qry = $conn->query("SELECT  * from `indexing`  order by `id` desc  ");
while($row = $qry->fetch_assoc()):

?>


          <div class="col-lg-3 col-md-4 col-xs-6">
            <div class="client-logo">
              <img src="<?php echo validate_image($row['banner_path']) ?>" class="img-fluid" alt="">
            </div>
          </div>

         

        
    <?php endwhile;?>