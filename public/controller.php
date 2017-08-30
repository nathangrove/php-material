<?php
  
  #####################################################
  # config section
  #####################################################
  
  $app_dir      = "/var/www/secure"; # where is our secure files stored
  $app_prefix   = "/app";            # the URI's prefix
  $app_branding = "PHP Material";    # a name for the title
  
  $db_name      = "phpmaterial";
  $db_login     = "phpmaterial";
  $db_password  = "pHpM@t3r1@l!";
  $db_host      = "localhost";
  
  #####################################################
  
  # config vars
  $config["url.prefix"] = $app_prefix;
  $config["directory.base"] = "$app_dir/base";
  $config["directory.lib"] = "$app_dir/lib";
  $config["directory.files"] = "$app_dir/files";
  $config["session.directory"]  = "$app_dir/session";
  $config["branding"] = $app_branding;
  

  ################################
  # CONFIGURE PHP
  ################################
  ini_set("display_errors", 0);
  ini_set("short_open_tag", 'On');
  ################################


  ################################
  # SET CORS
  ################################
  header("Access-Control-Allow-Origin: *");
  ################################


  ################################
  # Dial up DB
  ###############################
  include "$app_dir/lib/vendor/autoload.php";
  use nathangrove\DBObject\db;
  use nathangrove\DBObject\dbo;
  try {
    $db = new db($db_host, $db_login, $db_password, $db_name);
  } catch (Exception $e) {
    print "Database connection failed";
    exit;
  }
  ################################
  
  # those darn slashes
  function stripslashes_deep($value) {
    return (is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value));
  }

  if (get_magic_quotes_gpc()) {
    $_REQUEST    = array_map('stripslashes_deep', $_REQUEST);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
  }

  $path = str_replace($app_prefix,'',$_SERVER['REDIRECT_URL']);
  $parts = explode("/",$path);
  array_shift($parts);
  if (count($parts) == 1) {
    $base = $parts[0];
    $call = "";
  }
  else {
    $call = array_pop($parts);
    $base = join(":",$parts);
  }
  $config["app.base"] = $base;
  $config["app.call"] = $call;

  include "$app_dir/lib/app.php";
  $app = new wireapp($config);
  $app->process($base,$call);



?>
