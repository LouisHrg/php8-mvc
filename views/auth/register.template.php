  <form method="POST" action="/register">
    <label for="email"> Votre email </label>
    <input type="text" name="email" />
    <br>
    <label for="firstname"> Votre nom </label>
    <input type="text" name="lastname" />
    <br>
    <label for="lastname"> Votre prénom </label>
    <input type="text" name="firstname" />
    <br>
    <label for="password"> Votre mot de passe </label>
    <input type="password" name="password" />
    <br>
    <label for="password_confirmation">
      Confirmation de mot de passe
    </label>
    <input type="password" name="password_confirmation" />
    <br>
    <button type="submit">S'inscrire</button>

    <ul>
    <?php foreach ($errors as $error): ?>

        <?php foreach ($error as $message): ?>
            <li><?php echo $message; ?></li>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </ul>
  </form>
