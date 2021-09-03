<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
  <form method="POST" action="/login/verify">
    <label for="email"> Votre email </label>
    <input type="text" name="email" />
    <br>
    <label for="password"> Votre mot de passe </label>
    <input type="password" name="password" />
    <br>
    <button type="submit">Se connecter</button>
  </form>
</body>
</html>
