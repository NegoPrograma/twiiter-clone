<form method="post">
	Nome:
	<input type="text" name="name" required><br>
	E-mail:
	<input type="email" name="email" required><br>
	Senha:
	<input type="password" name="password" required><br>
	<input type="submit" value="Entrar">
</form>

<?php if (isset($viewData["message"])) echo $viewData["message"]; ?>