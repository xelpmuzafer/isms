<style>
  .user-img{
        position: absolute;
        height: 27px;
        width: 27px;
        object-fit: cover;
        left: -7%;
        top: -12%;
  }
  .btn-rounded{
        border-radius: 50px;
  }
</style>
<!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-light shadow text-sm">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo base_url ?>" class="nav-link"><?php echo (!isMobileDevice()) ? $_settings->info('name'):$_settings->info('short_name'); ?> - Admin</a>
          </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Navbar Search -->
          <!-- <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
              <form class="form-inline">
                <div class="input-group input-group-sm">
                  <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li> -->
          <!-- Messages Dropdown Menu -->
          <li class="nav-item">
          <li class="nav-item mx-4" style='margin-right:15px'>
          <select  onchange='changeLocation()'  id="location-select" class=' form-select custom-select text-white  bg-info  '>
                                <option>Select Location</option>
                                <?Php foreach ($_settings->userdata('locations') as $values): ?>
                                    <option value="<?php echo $values['id'] ?>"    
                                    
                                    <?php if($_settings->userdata('loc_id') == $values['id'] ) echo 'selected'  ?> >
                                        <?php echo $values['name'] ?>
                                    </option>
                                    <?php endforeach; ?>
                            </select>
          </li>
            <div class="btn-group nav-link">
                  <!-- <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown"> -->
                    <span><img  src="<?php echo validate_image($_settings->userdata('avatar1')) ?>" class="img-circle  p-0 elevation-1 user-img mt-2" alt="User Image"></span>
                    <span class="mb-2 ml-3 text-bold"><?php echo ucwords($_settings->userdata('username').' '.$_settings->userdata('lastname')) ?></span>
                  <!-- </button> -->
                  <!-- <div class="dropdown-menu" role="menu"> -->
                    <!-- <a class="dropdown-item" href="<?php echo base_url.'admin/?page=user' ?>"><span class="fa fa-user"></span> My Account</a> -->
                  <!-- </div> -->
              </div>
          </li>
          
         <!--  <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
            </a>
          </li> -->
        </ul>
      </nav>
      <!-- /.navbar -->


    <script>



function changeLocation() {
    $loc_id = document.getElementById('location-select').value
    start_loader();
    $.ajax({
        url: _base_url_ + "classes/Master.php?f=change_location",
        method: "POST",
        data: {
            loc_id: $loc_id
        },
        dataType: "json",
        error: err => {
            console.log("Error", err)
            alert_toast("An error occured.", 'error');
            end_loader();
        },
        success: function(resp) {
            if (typeof resp == 'object' && resp.status == 'success') {
                location.reload();
            } else {
                alert_toast("An error occured.", 'error');
                end_loader();
            }
        }
    })
}

    </script>