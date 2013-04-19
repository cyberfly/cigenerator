<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
    <?php
      $title = (isset($title) ? $title : 'CI code generator');
      echo $title;
    ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <?php

      echo css('bootstrap.css');
      //echo css('bootstrap-cerulian.css');
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
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      .sidebar-input{
        margin-bottom:0px;
      }
      .box{
        padding-left: 19px;
        background-color: #EBF4FA;
        border: 1px solid #BBD9EE;
        min-height:100px;
      }
    </style>

    <script type="text/javascript">
    //pass the base_url to js variable

      var config = {
        'base_url': '<?php echo base_url(); ?>'
      };

    </script>
    <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <?php $this->load->view('template/header'); ?>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">

        <?php if(!isset($no_sidebar)){ ?>

        <div class="span3">
          <?php $this->load->view('template/sidebar'); ?>
        </div><!--/span-->
        <div class="span9">
          <?php $this->load->view($main); ?>
        </div><!--/span-->

        <?php } else { ?>

        <div class="span12">
          <?php $this->load->view($main); ?>
        </div><!--/span-->

        <?php } ?>

      </div><!--/row-->

      <hr>

      <footer>
        <?php $this->load->view('template/footer'); ?>
      </footer>

    </div><!--/.fluid-container-->



  </body>
</html>

  <?php

  //load the js call

  echo js('jquery-min.js');
  echo js('bootstrap-alert.js');
  echo js('bootstrap-dropdown.js');

  if(isset($js_list))
  {
    foreach($js_list as $js_row)
    {
      $js_file = $js_row.'.js';
      echo js($js_file);
    }
  }

  ?>

  <?php

  //load the js function

  if(isset($js_function))
  {
    foreach($js_function as $js)
    {

      $js = $js.'.js';

      ?>

      <script src="<?php echo base_url(); ?>assets/js/application/<?php echo $js; ?>"></script>

      <?php
    }
  }

  ?>
  <script type="text/javascript">
    $(function () {
      $('.tabs').tabs();
    });
  </script>
