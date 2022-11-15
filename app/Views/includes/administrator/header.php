<nav class="navbar navbar-expand-lg main-navbar sticky">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                    <i data-feather="maximize"></i>
                </a></li>
            <?php use App\Models\Notifications;?>
            
            <?php 
             if(session('user')->username == 'admin' ){?>
            <li><a href="<?php echo base_url('Generate/Office');?>" class="nav-link nav-link-lg ion-ios-reload">
                    <i data-feather="upload-cloud"></i>
                </a>
            </li>
            <?php } ?>
            <!-- <i class=" bi bi-cloud-arrow-down"></i> -->
            <!-- <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li> -->
        </ul>
    </div>

    <ul class="navbar-nav navbar-right">
       
           <?php 
              $notif = new Notifications();
              $count = $notif->where('read', '0')->countAllResults();
              ?>

            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link nav-link-lg notification-toggle message-toggle  "><i data-feather="bell"></i>
              <span class="badge headerBadge1">
                <?php echo $count; ?> </span> </a>
          <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
              <span class="badge headerBadge1">
                <?php echo $count; ?> </span> </a>
            </a> -->
            
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Notifications
                <div class="float-right">
                  <!-- <a href="#">Mark All As Read</a> -->
                </div>
              </div>
              <?php 
              $notif = new Notifications();
              $notific = $notif->findAll();
              ?>
              <div class="dropdown-list-content dropdown-list-icons">
                <?php foreach( $notific as $notif) {
                  if($notif->read === '0') { ?>
                  
                <a href="<?php echo base_url('administrator/notifications/saldo/'.$notif->id); ?>" class="dropdown-item dropdown-item-unread"> 
                  <span
                    class="dropdown-item-icon bg-primary text-white"> <i class="fas
												fa-code"></i>
                  </span> <span class="dropdown-item-desc"><strong> <?php echo $notif->message; ?>! </strong><span class="time"><?php echo $notif->date; ?></span>
                  </span>
                  </a>
                <?php 
                  }else{ ?>
                     <a href="<?php echo base_url('administrator/notifications/saldo/'.$notif->id); ?>" class="dropdown-item dropdown-item-read">
                      <span
                    class="dropdown-item-icon bg-primary text-white"> <i class="fas
												fa-code"></i>
                  </span> <span class="dropdown-item-desc" style="color: grey;"> <?php echo $notif->message; ?>! <span class="time"><?php echo $notif->date; ?></span>
                  </span>
                  </a>
                  <?php }
                  ?>  
                                
                <?php } ?>
                
              </div>
              <div class="dropdown-footer text-center">
                <a href="<?php echo base_url('administrator/notifications'); ?>">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>

          <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link nav-link-lg notification-toggle message-toggle  ">
               -->
               
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image"
                    src="<?php echo base_url();?>/assets-panel/img/users/user-1.png" class="user-img-radious-style">
                <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
                <div class="dropdown-title">Hello, <?php echo session('user')->username;?></div>
                <a href="#" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> <?php echo session('user')->level;?>
              </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-building"></i>
                <?php 
                if(session('user')->level == 'unit' || session('user')->level == 'kasir'){

                  echo 'Unit '.session('user')->unit_name;
                }else if(session('user')->level == 'cabang'){
                  echo 'Cabang '.session('user')->cabang_name;
                }else if(session('user')->level == 'area'){
                  echo 'Area '.session('user')->area_name;
                }
                ?>
              </a> 
                <!-- <a href="#" class="dropdown-item has-icon"> <i class="far	fa-user"></i> Profile
              </a>  -->
                <!-- <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                Activities
              </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a> -->
              
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('monitoring/login/logout'); ?>"
                    class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>