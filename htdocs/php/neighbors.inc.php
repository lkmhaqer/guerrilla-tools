          <h1 class="page-header">Neighbors</h1>
          <div class="row add-neighbor-form">
<?php echo($alertText); ?>
            <form class="form-inline" action="/?a=add_neighbor" method="POST">
              <div class="form-group">
                <label class="sr-only" for="ASN">ASN</label>
		<select class="form-control" id="ASN" name="asn">
<?php buildOptions('aut_num', 'asn', 'name'); ?>
                </select>
              </div>
              <div class="form-group">
                <label class="sr-only" for="router">Hostname</label>
                <select class="form-control" id="router" name="router">
<?php buildOptions('router', 'hostname'); ?>
                </select>
              </div>
              <div class="form-group">
                <label class="sr-only" for="peer-ip">Peer IP</label>
                <input type="text" class="form-control" id="peer-ip" name="peer-ip" placeholder="Peer IP">
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="soft-inbound" checked> Soft reconfiguration-inbound?
                </label>
              </div>
              <button type="submit" class="btn btn-default">Add Neighbor</button>
            </form><br /><br />
          </div>
          <div class="row table-responsive">
<?php buildTable('neighbor'); ?>
          </div>
