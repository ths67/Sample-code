<h3>Are you one of the visitors giving a master class at Cornell?</h3>
<h3>Log in:</h3>

<form id="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <ul>
      <li>
        <label for="username">Visitor username</label>
        <input id="username" type="text" name="username"/>
      </li>
      <li><p> </p>
      </li>
      <li>
        <label for="password">Visitor password</label>
        <input id="password" type="text" name="password"/>
      </li>
      <li><p> </p>
      </li>
      <li>
      <button type="submit" name="login">Log in, visitor!</button>
      </li>
    </ul>
</form>
