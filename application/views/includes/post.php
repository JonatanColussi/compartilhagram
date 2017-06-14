<div class="col-md-12 post">
	<div>
		<span class="user"><?= $name ?></span>
		<span class="date"><?= date("d/m/Y H:i", strtotime($date)) ?></span>
	</div>
	<img src="<?= base_url('uploads/posts/'.$image) ?>" alt="" class="img-responsive">
	<p class="description"><?= $description ?></p>
	<button class="btn btn-success like <?= ($liked) ? 'liked' : null ?>" data-idpost="<?= $idPost ?>"><?= $qtdLikes ?> Likes</button>
	<br>
	<label>Comentários</label>
	<div class="comments">
		<?php
			foreach($comments as $comment)
				$this->load->view('includes/comment', $comment);
		?>
	</div>
	<form action="<?= base_url('posts/comment') ?>" method="post" enctype="multipart/form-data" name="formComment">
		<input type="hidden" name="idPost" value="<?= $idPost ?>">
		<div class="form-group">
			<label for="comment">Deixe seu comentário</label>
			<textarea name="comment" id="comment" rows="3" maxlength="140" class="form-control"></textarea>
			<span class="textarea-counter">140 caracteres restantes</span>
			<button class="btn btn-primary" type="submit">Comentar</button>
		</div>
	</form>
</div>