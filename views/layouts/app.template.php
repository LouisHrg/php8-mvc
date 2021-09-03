<!DOCTYPE html>
<html>
<head>
  <title> <?php echo $pageTitle ?? 'MVC'; ?> </title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
</head>
<body>
  <div class="container">
    <?php include './views/'.$template . '.template.php' ?>
  </div>
</body>
</html>
