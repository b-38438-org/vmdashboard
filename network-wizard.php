<?php
require('header.php');

function clean_name_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = str_replace(' ','',$data);
  $data = filter_var($data, FILTER_SANITIZE_STRING);
  return $data;
}

//$uuid = $_GET['uuid'];
//$domName = $lv->domain_get_name_by_uuid($_GET['uuid']);
//will redirect to guests.php. header() needs to be before navbar.php. Uses libvirst so has to be after header.php
if (isset($_POST['finish'])) {

  $xml = "<network>
    <name>test</name>
    <forward mode='nat'>
      <nat>
        <port start='1024' end='65535'/>
      </nat>
    </forward>
    <bridge name='virbr0' stp='on' delay='0'/>
    <mac address='52:54:00:00:44:88'/>
    <ip address='192.168.200.1' netmask='255.255.255.0'>
      <dhcp>
        <range start='192.168.200.100' end='192.168.200.254'/>
      </dhcp>
    </ip>
  </network>";

  $lv->network_define_xml($xml);
  

//network_name = "network1"
//network_id = "192.168.1.0"
//subnet_mask = "255.255.255.0"


  //$pool = $_POST['pool'];
  //$volume_image_name = clean_name_input($_POST['volume_image_name']);
  //$volume_capacity = $_POST['volume_size'];
  //$volume_size = $_POST['volume_size'];
  //$unit = $_POST['unit'];
  //$driver_type = $_POST['driver_type'];
  //$original_page = $_POST['original_page'];

  //$ret = $lv->domain_disk_add($domName, $source_file, $target_dev, $target_bus, $driver_type) ? "Disk has been successfully added to the guest" : "Cannot add disk to the guest: ".$lv->get_last_error();
  //$msg = $lv->storagevolume_create($pool, $volume_image_name, $volume_capacity.$unit, $volume_size.$unit, $driver_type) ? 'Volume has been created successfully' : 'Cannot create volume';
  //header('Location: ' . $original_page);
  //exit;
}

require('navbar.php');
?>

<script>
function newExtenstion(f) {
  var diskName = f.volume_image_name.value;
  diskName = diskName.replace(/\s+/g, '');
  var n = diskName.lastIndexOf(".");
  var noExt = n > -1 ? diskName.substr(0, n) : diskName;
  var driverType = f.driver_type.value;
  if (driverType === "qcow2"){
    var ext = ".qcow2";
    var fullDiskName = noExt.concat(ext);
    f.volume_image_name.value = fullDiskName;
  }
  if (driverType === "raw"){
    var ext = ".img";
    var fullDiskName = noExt.concat(ext);
    f.volume_image_name.value = fullDiskName;
  }
}
</script>



<div class="panel-header panel-header-sm"></div>
<div class="content">
  <div class="col-md-10 mr-auto ml-auto">
    <!--      Wizard container        -->
    <div class="wizard-container">
      <div class="card card-wizard" data-color="primary" id="wizardProfile">
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?uuid=' . $uuid;?>" method="post">
        <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->

          <div class="card-header text-center" data-background-color="orange">
            <h3 class="card-title">Add new network connection</h3>
            <h5 class="description">This form will allow you to create a new network connection.</h5>
            <div class="wizard-navigation">
              <ul>
                <li class="nav-item">
                  <a class="nav-link" href="#network" data-toggle="tab">
                    <i class="fas fa-database"></i>
                        Network
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <div class="card-body">
            <div class="tab-content">
              <!--    Storage Tab     -->
              <div class="tab-pane fade" id="network">
                <h5 class="info-text"> New Network Connection </h5>
                <div class="row justify-content-center">
                  <div class="col-sm-10">
                    <div class="form-group">
                      <label>Network Connection Name</label>
                      <input type="text" value="network1" placeholder="Enter name for new network connection" class="form-control" name="network_name" />
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Volume size</label>
                      <input type="number" class="form-control" name="network_id" min="1" value="192.168.1.0" />
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Unit size</label>
                      <select class="selectpicker" data-style="btn btn-plain btn-round" title="Subnet Mask" name="subnet_mask">
                        <option value="255.255.255.0" selected>/24 255.255.255.0</option>
                        <option value="255.255.255.128">/25 255.255.255.128</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-10">
                    <div class="form-group">
                      <label>Driver type</label>
                      <select class="selectpicker" onchange="newExtenstion(this.form)" data-style="btn btn-plain btn-round" title="Select volume type" name="driver_type">
                        <option value="qcow2" selected>qcow2</option>
                        <option value="raw">raw</option>
                      </select>
                    </div>
                  </div>




                  <input type="hidden" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" name="original_page"/>
                  <input type="hidden" value="<?php echo $_GET['pool']; ?>" name="pool"/>

                </div>
              </div>
            </div>
          </div>


        <div class="card-footer">
          <div class="pull-right">
            <input type='submit' class='btn btn-finish btn-fill btn-rose btn-wd' name='finish' value='Finish' />
          </div>

          <div class="pull-left">
          </div>

          <div class="clearfix"></div>
        </div>
      </form>
    </div>
  </div> <!-- wizard container -->
</div>

<?php
require('footer.php');
?>
