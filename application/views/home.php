<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="alert message-login"></div>
			<form action="<?= base_url('users/login') ?>" method="post" id="formLogin" enctype="multipart/form-data">
				<div class="form-group">
					<label for="username">Nome de usuário</label>
					<input type="text" name="username" required maxlength="20" class="form-control">
				</div>
				<div class="form-group">
					<label for="username">Senha</label>
					<input type="password" name="password" required class="form-control">
				</div>
				<div class="text-right">
					<button class="btn btn-primary" type="submit">Login</button>
				</div>
			</form>
		</div>
		<div class="col-md-3 col-md-offset-3">
			<div class="alert message-add"></div>
			<form action="<?= base_url('users/add') ?>" method="post" id="formSignin" enctype="multipart/form-data">
				<div class="form-group">
					<label for="name">Nome</label>
					<input type="text" name="name" required maxlength="100" class="form-control" value="<?php echo set_value('name'); ?>">
				</div>
				<div class="form-group">
					<label for="username">Nome de usuário</label>
					<input type="text" name="username" required maxlength="20" class="form-control" value="<?php echo set_value('username'); ?>">
					<small class="form-text text-muted"><?= validation_errors(); ?></small>
				</div>
				<div class="form-group">
					<label for="username">Senha</label>
					<input type="password" name="password" required class="form-control">
				</div>
				<div class="form-group">
					<label for="username">Confirme a senha</label>
					<input type="password" name="passwordConfirm" required class="form-control">
				</div>
				<div class="form-group">
					<label for="image">Escolha sua foto</label><br>
					<button class="btn btn-primary" id="attachImage">Anexar foto</button>
					<span></span>
					<input type="file" name="image" accept="image/*" required>
				</div>
				<div class="text-right">
					<button class="btn btn-primary" type="submit">Criar conta</button>
				</div>
			</form>
		</div>
	</div>
</div>