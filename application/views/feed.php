<div class="container">
	<div class="row">
		<aside class="col-md-3">
			<img src="<?= base_url('uploads/users/'.$user->image) ?>" alt="<?= $user->name ?>" width="100">
			<h4 class="name"><?= $user->name ?></h4>
			<h6 class="user">?<?= $user->username ?></h6>
		</aside>
		<main class="col-md-9">
			<div class="row">
				<div class="col-md-12">
					<h1>Poste sua foto On The Line</h1>
					<form action="<?= base_url('posts/add') ?>" method="post" enctype="multipart/form-data">
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
			<div class="row">
				<pre>
					
				<?php print_r($posts); ?>
				</pre>
				<div class="col-md-12">
					<img src="<?= base_url('uploads/users/8	.png') ?>" alt="" class="img-responsive">
					<span class="likes">123 Likes</span>
					<div class="comments">
						<div>
							<span>Usuário 1</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum dolores obcaecati ex, et quasi in doloribus fugiat quos quam eum similique nesciunt dignissimos earum molestias culpa impedit, modi, atque dolore!</p>
						</div>
						<div>
							<span>Usuário 1</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum dolores obcaecati ex, et quasi in doloribus fugiat quos quam eum similique nesciunt dignissimos earum molestias culpa impedit, modi, atque dolore!</p>
						</div>
						<div>
							<span>Usuário 1</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum dolores obcaecati ex, et quasi in doloribus fugiat quos quam eum similique nesciunt dignissimos earum molestias culpa impedit, modi, atque dolore!</p>
						</div>
					</div>
					<label for="comment">Deixe seu comentário</label>
					<form action="<?= base_url('posts/comment') ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="postId" value="1">
						<textarea name="comment" id="comment" rows="3" maxlength="140" class="form-control"></textarea>
						<div class="text-right">
							<div class="text-right">
								<button class="btn btn-primary" type="submit">Comentar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</main>
	</div>
</div>