<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo base_url('');?>">
                <!-- <img alt="image" src="<?php echo base_url();?>/assets-panel/img/logo.png" class="header-logo" /> -->
                <!-- <span
                class="logo-name">Tas</span> -->
            </a>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-header">DASHBOARD</li>
            <li><a class="nav-link" href="<?php echo base_url('dashboard'); ?>"><i data-feather="monitor"></i><span>DASHBOARD</span></a></li>

            <li class="menu-header">ALERT WARNING SYSTEM (AWS)</li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="pie-chart"></i><span>MONEV HARIAN
                        </span></a>
                    <ul class="dropdown-menu">
                        <?php if(read_access('monitoring')):?>
                        <li><a class="nav-link" href="<?php echo base_url('monitoring/outstanding');?>">Outstanding</a>
                        </li>
                        <?php endif;?>

                        <?php if(read_access('monitoring')):?>
                        <li><a class="nav-link"
                                href="<?php echo base_url('monitoring/pencairan');?>">Pencairan</a>
                        </li>
                        <?php endif;?>

                        <?php if(read_access('monitoring')):?>
                        <li><a class="nav-link"
                                href="<?php echo base_url('monitoring/repayment');?>">Pelunasan</a>
                        </li>

                        <?php endif;?>

                        <?php if(read_access('monitoring')):?>
                        <li><a class="nav-link"
                                href="<?php echo base_url('monitoring/perpanjangan');?>">Perpanjangan</a></li>
                        <?php endif;?>

                        <?php if(read_access('monitoring')):?>
                        <li><a class="nav-link" href="<?php echo base_url('monitoring/saldo');?>">Saldo
                                Kas</a></li>
                        <?php endif;?>
                        <?php if(read_access('monitoring')):?>
                        <li><a class="nav-link" href="<?php echo base_url('monitoring/dpd');?>">DPD</a>
                        </li>
                        <?php endif;?>
                        <?php if(read_access('monitoring')):?>
                        <li><a class="nav-link" href="<?php echo base_url('monitoring/pengeluaran');?>">Pengeluaran</a></li>
                        <?php endif;?>
                        <?php if(read_access('monitoring')):?>
                        <li><a class="nav-link" href="<?php echo base_url('monitoring/oneobligor');?>">Customers</a></li>
                        <?php endif;?>
                        
                    </ul>
                </li>
                 <?php if(read_access('fraud')):?>
                <li><a class="nav-link" href="<?php echo base_url('fraud'); ?>"><i data-feather="alert-triangle"></i><span>MONEV BULANAN</span></a></li>
                <?php endif; ?>
            </li>


            <!-- <li class="menu-header">WEBSITE</li>
              <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>TRANSAKSI</span></a>
                <ul class="dropdown-menu">
                <?php if(read_access('administrator/requestinstallment')):?>
                  <li><a class="nav-link" href="<?php echo base_url('administrator/requestinstallment');?>">Permintaan Cicilan</a></li>              
                <?php endif;?>
              
                </ul>
              </li>
            </li> -->

            
           
           <?php 
             if(session('user')->username == 'admin' ){?>
            <li class="menu-header">Setting</li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="settings"></i><span>SETTING
                        WEB</span></a>
                <ul class="dropdown-menu">
                    <?php if(read_access('users')):?>
                    <li><a class="nav-link" href="<?php echo base_url('monitoring/users');?>">Users</a></li>
                    <?php endif;?>

                    <?php if(read_access('settings/menus')):?>
                    <li><a class="nav-link" href="<?php echo base_url('settings/menus');?>">Menu</a></li>
                    <?php endif;?>

                    <?php if(read_access('settings/levels')):?>
                    <li><a class="nav-link" href="<?php echo base_url('settings/levels');?>">Level</a>
                    </li>

                    <?php endif;?>

                    <?php if(read_access('settings/privileges')):?>
                    <li><a class="nav-link" href="<?php echo base_url('settings/privileges');?>">Hak
                            Akses</a></li>
                    <?php endif;?>

                    <?php if(read_access('settings/pagukas')):?>
                    <li><a class="nav-link" href="<?php echo base_url('settings/pagukas');?>">
                            Pagu Kas</a></li>
                    <?php endif;?>
                </ul>
            </li>
            <?php } ?>

            <?php 
            
             if(session('user')->username == 'admin' ){?>
            <li class="menu-header">Notifications</li>
            <li><a class="nav-link" href="<?php echo base_url('notifications'); ?>"><i data-feather="bell"></i><span>NOTIFICATIONS</span></a></li>
            <?php } ?>
            
        </ul>
    </aside>
</div>