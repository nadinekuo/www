<!DOCTYPE html>
<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <script src="head.js" type="text/javascript">
  </script>
  <title>Request Test Account</title>
</head>
<body>
  <header>
    <script src="menu.js" type="text/javascript">
    </script>
  </header>
  <div class="container">
   <div class="row">
   <div class="col-sm-10 col-sm-offset-1">
   <h1>Request an Einstein Toolkit Test Account</h1>
<p>Please fill out the following information to request a test account for the Einstein Toolkit. These accounts will take one or two days to set up.</p>

<form name="request" action="send-account" method="post">
<table>
<div class="form-group">
   <label for="name">Name:</label>
   <input type="text" class="form-control" id="name" name="name"/>
 </div>
 <div class="form-group">
   <label for="email">Email:</label>
   <input type="email" class="form-control" id="email" name="email" />
   <br>
    Please use an email account at the institution you are affiliated with.<br>
    Free providers like yahoo or google cannot be accepted.</td>
 </div>
 <div class="form-group">
   <label for="department">Department:</label>
   <input type="text" class="form-control" id="department" name="department"/>
 </div>
 <div class="form-group">
   <label for="institiution">Institution:</label>
   <input type="text" class="form-control" id="institution" name="institution"/>
 </div>
 <div class="form-group">
   <label for="position">Position:</label>
   <input type="radio" class="form-control" id="position" name="position" value="an undergraduate " checked /> undergraduate
   <input type="radio" class="form-control" id="position" name="position" value="an undergraduate " checked /> graduate student
   <input type="radio" class="form-control" id="position" name="position" value="an undergraduate " checked /> postdoc
   <input type="radio" class="form-control" id="position" name="position" value="an undergraduate " checked /> researcher
   <input type="radio" class="form-control" id="position" name="position" value="an undergraduate " checked /> faculty
 </div>
 <div class="form-group">
   <label for="advisor">Advisor (if student):</label>
   <input type="text" class="form-control" id="advisor" name="advisor"/>
 </div>
 <div class="form-group">
   <label for="buechsenwursttest">Please enter 'Einstein' backwards here (to fight spam)</label>
   <input type="text" class="form-control" id="buechsenwursttest" name="buechsenwursttest" /></td>
 </div>
 <button type="submit" class="btn btn-default">Submit</button>
</form>

</div></div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <script src="footer/footer.js" type="text/javascript">
        </script>
      </div>
    </div>
  </div>
</body>
</html>

