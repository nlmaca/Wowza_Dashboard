
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $TITLE; ?></title>
    <meta name="description" content="<?php echo $DESCRIPTION; ?>">
    <meta name="author" content="J. van Marion">
     <link href="<?php echo $DOCUMENT_ROOT; ?>/assets/css/sticky-footer.css" rel="stylesheet">
    <link href="<?php echo $DOCUMENT_ROOT; ?>/assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo $DOCUMENT_ROOT; ?>/assets/css/style2.min.css" rel="stylesheet">
    <link href="<?php echo $DOCUMENT_ROOT; ?>/assets/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="icon" href="img/favicon.ico?v=2" type="image/x-icon" />
</head>

<body>
<div id="wrap">
    <nav class="navbar navbar-default bg-black">
        <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Show menu</span>
                    <i class="fa fa-bars fa-2x"></i>
                </button>
                <a class="navbar-brand" href="<?php echo $DOCUMENT_ROOT; ?>/products/wowza/vhost_overview.php">
                    <img alt="Wowza Dashboard" src="<?php echo $DOCUMENT_ROOT; ?>/img/network-32.png" alt="Wowza Dashboard" title="Wowza Dashboard"> 
                </a> 
            </div>
        
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- wowza -->       
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-server fa-fw"></i> Wowza <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $DOCUMENT_ROOT; ?>/products/wowza/vhost_overview.php"><i class="fa fa-bar-chart fa-fw"></i> Server info</a></li>
                            <li><a href="<?php echo $DOCUMENT_ROOT; ?>/products/wowza/xml/extract_applications.php"><i class="fa fa-tree fa-fw"></i> All Apps</a></li>
                            <li><a href="<?php echo $DOCUMENT_ROOT; ?>/products/wowza/running_apps.php"><i class="fa fa-folder-open fa-fw"></i> Running Apps</a></li>
                        </ul>
                    </li>
                    <!-- settings -->       
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs fa-fw"></i> Config <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $DOCUMENT_ROOT; ?>/settings/wowza_overview.php"><i class="fa fa-cog fa-fw"></i> Wowza Server</a></li>
                       
                        </ul>
                    </li>
                    <!-- users -->       
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users fa-fw"></i> Users <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <!--<li role="separator" class="divider"></li>-->
                            <li><a href="<?php echo $DOCUMENT_ROOT; ?>/settings/user_overview.php"><i class="fa fa-user fa-fw"></i> Show users</a></li>
                            <li><a href="<?php echo $DOCUMENT_ROOT; ?>/settings/user_create.php"><i class="fa fa-user-plus fa-fw"></i> Create user</a></li>
                        
                        </ul>
                    </li>
                    <!-- logout -->
                    <li><a href="<?php echo $DOCUMENT_ROOT; ?>/logout.php"><i class="fa fa-power-off fa-fw"></i> Logout</a></li>
                    
                   
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
<!-- end navigation -->
