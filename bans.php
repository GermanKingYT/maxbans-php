<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>
  <head>
    <title>Bans/Tempbans - <?php echo $name; ?></title>
  </head>
<?php
// <<-----------------mysql Database Connection------------>> //
require 'includes/data/database.php';

$sql = 'SELECT name, reason, banner, time, expires FROM bans ORDER BY time DESC LIMIT 20';

$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not get data: ' . mysql_error( $sql, $conn ));
}
?>
  <body>
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-lg-12">
          <h1 class="page-header">Bans</h1>
          <ol class="breadcrumb">
            <li><a href="index">Home</a></li>
            <li class="active">Bans</li>
          </ol>
        </div>

      </div>
      <div class="row" style="margin-bottom:60px;">
        <div class="col-lg-12">
						<table class="table table-hover table-bordered table-condensed">
							<thead>
							<tr>
								<th><center>Name</center></th>
								<th><center>Banned By</center></th>
								<th><center>Reason</center></th>
								<th><center>Banned On</center></th>
								<th><center>Banned Until</center></th>
							</tr>
							</thead>
							<tbody>
							        <?php while($row = mysql_fetch_assoc($retval)) { 
									// <<-----------------Ban Date Converter------------>> //
									$timeEpoch = $row['time'];
									$timeConvert = $timeEpoch / 1000;
									$timeResult = date('F j, Y, g:i a', $timeConvert);
									// <<-----------------Expiration Time Converter------------>> //
									$expiresEpoch = $row['expires'];
									$expiresConvert = $expiresEpoch / 1000;
									$expiresResult = date('F j, Y, g:i a', $expiresConvert);
									?>
							<tr>
								<td><?php echo "<img src='http://mineskin.ca/v2/avatar/?player=" . $row['name'] . "&size=25' style='margin-bottom:5px;margin-right:5px;border-radius:2px;' />" . $row['name'];?></td>
								<td><?php echo "<img src='http://mineskin.ca/v2/avatar/?player=" . $row['banner'] . "&size=25'  style='margin-bottom:5px;margin-right:5px;border-radius:2px;' />" . $row['banner'];?></td>
								<td style="width: 30%;"><?php echo $row['reason'];?></td>
								<td><?php echo $timeResult;?></td>
								<td><?php if($row['expires'] == 0) {
								echo 'Permanent Ban';
								} else {
								echo $expiresResult; }?></td>
							</tr>
<?php }
mysql_close($conn);
echo "</tbody></table>";
?>
 </div>
</div>
<?php
include 'includes/footer.php';
?>
</div>