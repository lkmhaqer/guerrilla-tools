          <h1 class="page-header">Routers</h1>
          <div class="row add-router-form">
<?php echo($alertText); ?>
            <form class="form-inline" action="/?a=add_router" method="POST">
              <div class="form-group">
                <label class="sr-only" for="hostname">Hostname</label>
                <input type="text" class="form-control" id="hostname" name="hostname" placeholder="Hostname">
              </div>
              <div class="form-group">
                <label class="sr-only" for="router-id">Router-ID</label>
                <input type="text" class="form-control" id="router-id" name="router-id" placeholder="Router-ID">
              </div>
              <div class="form-group">
                <label class="sr-only" for="network-os">Network OS</label>
                <input type="text" class="form-control" id="network-os" name="network-os" placeholder="Network OS">
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="ibgp"> iBGP
                </label>
              </div>
              <button type="submit" class="btn btn-default">Add Router</button>
            </form><br /><br />
          </div>
          <div class="row table-responsive">
<?php buildTable('router'); ?>
          </div>
