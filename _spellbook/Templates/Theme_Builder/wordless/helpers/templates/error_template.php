<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title ?></title>
  <style type="text/css">
    body { background-color: #fff; color: #666; text-align: center; font-family: arial, sans-serif; }
    div.dialog {
      width: 25em;
      padding: 0 4em;
      margin: 4em auto 0 auto;
      border: 1px solid #ccc;
      border-right-color: #999;
      border-bottom-color: #999;
    }
    h1 { font-size: 100%; color: #f00; line-height: 1.5em; }
  </style>
</head>
<body>
  <div class="dialog">
    <h1><?php echo isset($title) ? $title : '' ?></h1>
    <p><?php echo isset($description) ? $description : '' ?></p>
  </div>
</body>
</html>

