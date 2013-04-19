<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
    <?php
      $title = (isset($title) ? $title : 'Video Website');
      echo $title;
    ?>     
    </title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <?php

      //echo css('bootstrap.css');
      echo css('bootstrap-cerulian.css');
      echo css('bootstrap-responsive.css');
      
      if(isset($css_list))
      {
        foreach($css_list as $css_row)
        {
          $css_file = $css_row.'.css';
          echo css($css_file);
        }
      }

    ?>

    <style type="text/css">
      /* Override some defaults */
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px;
      }
      input{
        width:360px;
      }
      .container {
        width: 450px;
      }

      /* The white background content wrapper */
      .container > .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px;
        -webkit-border-radius: 10px 10px 10px 10px;
           -moz-border-radius: 10px 10px 10px 10px;
                border-radius: 10px 10px 10px 10px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

	  .login-form {
		margin-left: 65px;
	  }

	  legend {
		margin-right: -50px;
		font-weight: bold;
	  	color: #404040;
	  }

    </style>

</head>
<body>
	<div class="container">
		<div class="content">
			<div class="row">
				<div class="login-form">
					<h2>Login</h2>
          <br/>
					<form action="<?php echo site_url('login/portal_log_in'); ?>" method="post" >
						<fieldset>
							<div class="clearfix">
								<input name="identity" id="identity" type="text" placeholder="Username">
							</div>
							<div class="clearfix">
								<input name="password" id="password" type="password" placeholder="Password">
							</div>
							<button class="btn btn-primary" type="submit">Sign in</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div> <!-- /container -->
</body>
</html>