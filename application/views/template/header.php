<?php $current_uri = $this->router->fetch_class().'/'.$this->router->fetch_method(); ?>

<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo site_url('portal/index'); ?>">CI Code Generator</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="<?php echo site_url('portal/index'); ?>">Home</a></li>
            </ul>
            <p class="navbar-text pull-right">Welcome <?php echo strtoupper($this->session->userdata('username')); ?> (<a href="<?php echo site_url('login/portal_logout'); ?>" style="color:#F5F5F5">Logout</a>)</p>
          </div><!--/.nav-collapse -->