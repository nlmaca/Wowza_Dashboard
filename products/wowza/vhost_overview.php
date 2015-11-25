<?php
// page version: 1.1
require("../../inc/general_conf.inc.php");
if(empty($_SESSION['user'])) {
    header("Location: ". $DOCUMENT_ROOT . "/index.php");
    die("Redirecting to ". $DOCUMENT_ROOT . "/index.php"); 
}
    
?>
<script type="text/javascript">
    function updateXML(){
        $('#updateXMLfile').load('xml/extract_connectioncounts.php');
    }
    setInterval( "updateXML()", 30000 );

    function updateStats(){
        $('#serverstatus').load('xml/vhost_status_server.php');
        $('#currentconnections').load('xml/vhost_status_current_connections.php');
        $('#timerunning').load('xml/vhost_status_timerunning.php');
        $('#totalconnections').load('xml/vhost_status_total_connections.php');
        $('#bandwithin').load('xml/vhost_status_bytes_in.php');
        $('#bandwithout').load('xml/vhost_status_bytes_out.php');
    }
    setInterval( "updateStats()", 10000 );
</script>

<?php include ("../../header.php"); ?>

<div class='panel panel-default'>
    <div class='col-md-12 col-sm-12' id='updateXMLfile'>
        Update every 60 seconds
    </div>
</div>
<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-green">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
        <div class="stats-info">
            <h4>SERVER STATUS</h4>
            <div id="serverstatus" class="stats-number">
                <i class="fa fa-spinner fa-spin"></i> Getting data, be patient
            </div>
        </div>
    </div>
</div>
<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-green">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-clock-o fa-fw"></i></div>
        <div class="stats-info">
            <h4>SERVER TIME RUNNING</h4>
            <div id="timerunning" class="stats-number">
                <i class="fa fa-spinner fa-spin"></i> Getting Data, be patient
            </div>
        </div>
    </div>
</div>
<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-blue">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-odnoklassniki fa-fw"></i></div>
        <div class="stats-info">
            <h4>CURRENT CONNECTIONS</h4>
            <div id="currentconnections" class="stats-number"> 
                <i class="fa fa-spinner fa-spin"></i> Getting Data, be patient
            </div>
        </div>
    </div>
</div>
<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-blue">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-users fa-fw"></i></div>
        <div class="stats-info">
            <h4>TOTAL CONNECTIONS</h4>
            <div id="totalconnections" class="stats-number">
                <i class="fa fa-spinner fa-spin"></i> Getting Data, be patient
            </div>
        </div>
    </div>
</div>

<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-black">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-cloud-download fa-fw"></i></div>
        <div class="stats-info">
            <h4>BANDWITH IN (kbps)</h4>
            <div id="bandwithin" class="stats-number">
                <i class="fa fa-spinner fa-spin"></i> Getting Data, be patient
            </div>
        </div>
    </div>
</div>
<div class="col-md-3 col-sm-6">
    <div class="widget widget-stats bg-black">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-cloud-upload fa-fw"></i></div>
        <div class="stats-info">
            <h4>BANDWITH OUT (kbps)</h4>
            <div id="bandwithout" class="stats-number">
                <i class="fa fa-spinner fa-spin"></i> Getting Data, be patient
            </div>
        </div>
    </div>
</div>

<?php include("../../footer.php");?>