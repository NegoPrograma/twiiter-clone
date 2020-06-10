<h1>LOGIN</h1>

<form method="post" >
E-mail:
	<input type="email" name="email" required><br>
	Senha:
	<input type="password" name="password" required><br>
	<input type="submit" value= "Entrar" >
</form>

<a href="login/signup">Cadastre-se</a>

<?php if(isset($viewData["message"])) 
     echo $viewData["message"];	

  ?>