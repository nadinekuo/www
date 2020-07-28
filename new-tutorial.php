<?php header("Content-Type: text/html; charset=utf-8"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <script src="head.js" type="text/javascript">
  </script>
  <title>Request a Tutorial Account</title>
</head>
<body>
  <header>
    <script src="menu.js" type="text/javascript">
    </script>
  </header>
<?php
if(isset($_REQUEST['email']) and isset($_REQUEST['org']) and isset($_REQUEST['name'])) {
?>
  <div class="container">
   <div class="row">
   <div class="col-sm-10 col-sm-offset-1">
   <h1>Request a Tutorial Account</h1>
   <p>
     Please fill out the following information to request a tutorial account.
     The information for this form should match what you see in the 403 error
     message on <a href="https://etk.cct.lsu.edu">https://etk.cct.lsu.edu</a>
     when attempting to access the server.
   </p>
<form name="register" action="send-tutorial-request.php" method="post">
 <div class="form-group">
   <label for="name">Full Name:</label>
   <?=$_REQUEST["name"]?>
   <input type="hidden" class="form-control" id="name" name="name" value="<?=$_REQUEST["name"]?>"/>
 </div>
 <div class="form-group">
   <label for="email">Email:</label>
   <?=$_REQUEST["email"]?>
   <input type="hidden" class="form-control" id="email" name="email" value="<?=$_REQUEST["email"]?>"/>
 </div>
 <div class="form-group">
   <label for="institiution">Organization:</label>
   <?=$_REQUEST["org"]?>
   <input type="hidden" class="form-control" id="institution" name="institution" value="<?=$_REQUEST["org"]?>"/>
 </div>
 <div class="form-group">
    <label for="why">Where are you from? What is your interest in the ET?</a>
    <textarea class="form-control" id="why" name="why" rows=10 cols=80></textarea>
 </div>
 <div class="form-group">
   <label for="buechsenwursttest">Please enter 'Einstein' backwards here (to fight spam)</label>
   <input type="text" class="form-control" id="buechsenwursttest" name="buechsenwursttest" />
 </div>
 <button type="submit" class="btn btn-default">Submit</button>
</form>
<br><br>
<p>The Einstein Toolkit is freely available under an open source license. However, we kindly request that users:</p>
<ol>
<li>Acknowledge use of the  Einstein Toolkit in publications and presentations following the Einstein Toolkit <a href="citation.html">citation guidelines</a>.</li>

<li><a href="https://bitbucket.org/einsteintoolkit/tickets/issues/">Report</a> to the Einstein Toolkit Maintainers any identified bugs or patches to the Einstein Toolkit.</li>
</ol>
  </div>
</div></div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <script src="footer/footer.js" type="text/javascript">
        </script>
      </div>
    </div>
  </div>
<?php } else { ?>
  <h1>Error: Missing information</h1>
  <p>Please visit <a href="https://etk.cct.lsu.edu">https://etk.cct.lsu.edu</a> and attempt to login again.</p>
<?php } ?>
</body>
</html>
