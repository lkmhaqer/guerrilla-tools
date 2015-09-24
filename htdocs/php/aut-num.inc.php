          <h1 class="page-header">aut-num</h1>
          <div class="row add-router-form">
<?php echo($alertText); ?>
            <form class="form-inline" action="/?a=add_aut-num" method="POST">
              <div class="form-group">
                <label class="sr-only" for="asn">ASN</label>
                <input type="text" class="form-control" id="asn" name="asn" placeholder="ASN">
              </div>
              <div class="form-group">
                <label class="sr-only" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
              </div>
              <div class="form-group">
                <label class="sr-only" for="contact">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact">
              </div>
              <button type="submit" class="btn btn-default">Add ASN</button>
            </form><br /><br />
          </div>
          <div class="row table-responsive">
            <?php buildTable('aut_num'); ?>
          </div>
