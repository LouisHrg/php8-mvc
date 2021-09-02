<!DOCTYPE html>
<html>
<head>
  <title>Articles</title>
</head>
<body>
  <p> All articles : </p>
  <?php foreach($articles as $article): ?>
    <p> <?php echo $article['title'] ?> </p>
  <?php endforeach ?>
</body>
</html>
