<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - La marée armée - ACCES ADMINISTRATEUR</title>
    <link rel="stylesheet" href="admin_style.css">
    </style>
</head>
<body class="login-body">
    <header>
            <div class="login-header">
                <h4>La marée armée - ACCES ADMINISTRATEUR</h4>
				<p class="explanation-text">Veuillez vous connecter avec un compte administrateur. Si vous êtes connecté avec un compte non-admin, la session sera détruite et vous serez redirigé ici.</p>
            </div>
    </header>
    <main>
		<div class="card">
			<div class="card-body">
				<form action="login_admin.php" method="POST">
					<div>
						<input type="text" name="email" id="email" class="formulaire" placeholder="Adresse Email">
					</div>
					<div>
						<input type="password" name="motdepasse" id="motdepasse" class="formulaire" placeholder="Mot de passe">
					</div>
					<button type="submit" class="btn">Login</button>
				</form>
			</div>
		</div>
    </main>
</body>
</html>
