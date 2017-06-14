<div class="container">
	<div class="row">
		<aside class="col-md-3">
			<img src="<?= base_url('uploads/users/'.$user->image) ?>" alt="<?= $user->name ?>" width="100">
			<h4 class="name"><?= $user->name ?></h4>
			<h6 class="user"><?= $user->username ?></h6>
			<a href="<?= base_url('users/logout') ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Sair</a>
		</aside>
		<main class="col-md-9">
			<div class="row">
				<div class="col-md-12">
					<h1>Poste sua foto On The Line</h1>
					<form action="<?= base_url('posts/add') ?>" method="post" enctype="multipart/form-data" name="formPost">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="image">Escolha sua foto</label><br>
									<button class="btn btn-primary" id="attachImage">Anexar foto</button>
									<span></span>
									<input type="file" name="image" accept="image/*" required>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<label for="description">Descrição</label>
									<textarea name="description" id="description" rows="3" maxlength="140" class="form-control"></textarea>
									<span class="textarea-counter">140 caracteres restantes</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="text-right">
									<button class="btn btn-primary" type="submit">Postar On The Line</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<hr>
			<div class="row feed">
				<?php
					foreach($posts as $post)
						$this->load->view('includes/post', $post);
				?>
			</div>
		</main>
	</div>
</div>