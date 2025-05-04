<div class="modal fade" id="addClientForm" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <form class="form-horizontal" id="submitClientForm" action="php_action/createClient.php" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-plus"></i> Add Client</h4>
        </div>
        <div class="modal-body">

          <div id="add-client-messages"></div>

          <div class="form-group">
            <label for="newClientName" class="col-sm-3 control-label">Client Name </label>
            <label class="col-sm-1 control-label">: </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="newClientName" placeholder="Client Name" name="newClientName"
                autocomplete="off">
            </div>
          </div>

          <div class="form-group">
            <label for="newClientAddress" class="col-sm-3 control-label">Client Address </label>
            <label class="col-sm-1 control-label">: </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="newClientAddress" placeholder="Client Address"
                name="newClientAddress" autocomplete="off">
            </div>
          </div>

          <div class="form-group">
            <label for="newClientPhoneNo" class="col-sm-3 control-label">Client Phone No </label>
            <label class="col-sm-1 control-label">: </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="newClientPhoneNo" placeholder="Client Phone No"
                name="newClientPhoneNo" autocomplete="off">
            </div>
          </div>

          <div class="form-group">
            <label for="newClientStatus" class="col-sm-3 control-label">Status: </label>
            <label class="col-sm-1 control-label">: </label>
            <div class="col-sm-8">
              <select class="form-control" id="newClientStatus" name="newClientStatus">
                <option value="">~~SELECT~~</option>
                <option value="1">Available</option>
                <option value="2">Not Available</option>
              </select>
            </div>
          </div> <!-- /form-group-->

        </div> <!-- /modal-body -->

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-primary" id="createClientBtn" data-loading-text="Loading..."
            autocomplete="off">Save Changes</button>
        </div>
        <!-- /modal-footer -->
      </form>
      <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<script src="custom/js/client.js"></script>