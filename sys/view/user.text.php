<div class="row py-4">
	<div class="col-lg-8 offset-lg-2">
		<div class="card border-0 shadow">
			<ul class="nav nav-tabs rounded bg-mad-gray">
				<li class="nav-item"><a class="nav-link" href="/user/admin/"><i class="fa fa-tools"></i> Разделы</a></li>
				<li class="nav-item"><a class="nav-link" href="/user/ad/"><i class="fa fa-ad"></i> Реклама</a></li>
				<li class="nav-item"><a class="nav-link active" href="/user/text/"><i class="far fa-file-alt"></i> Тексты</a></li>
				<li class="nav-item"><a class="nav-link" href="/user/poster/"><i class="far fa-images"></i> Постеры</a></li>
			</ul>
			<div class="card-body">
				<h6 class="card-title">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/"><i class="fa fa-home"></i></a></li>
						<? if (!empty($r['subtitle'])): ?>
							<li class="breadcrumb-item"><a href="/user/text/"><?=$r['title']?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['subtitle']?></li>
						<? else: ?>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['title']?></li>
						<? endif ?>
					</ol>
				</h6>
				<hr>
				<form class="card mad-cards" method="POST" action="">
					<h5 class="card-header border-bottom-0" data-toggle="collapse" href="#collapseText" role="button" aria-expanded="false" aria-controls="collapseText"><i class="far fa-file-alt"></i> <?=(is_numeric($_GET['edit_text']))?'Редактировать':'Добавить'?> текст</h5>
					<div class="collapse <?=(is_numeric($_GET['edit_text']))?'show':''?>" id="collapseText">
						<div class="card-body">
							<h5 class="card-title"><input name="title" class="form-control" placeholder="Заголовок" value="<?=$r['text']['title']?>"></h5>
							<h5 class="card-title"><input name="url" class="form-control" placeholder="URL" value="<?=$r['text']['url']?>"></h5>
							<p class="card-text">
								<label for="tinymce"><i class="far fa-file-alt"></i> Текст</label>
								<textarea name="text" class="form-control" id="tinymce"><?=$r['text']['text']?></textarea>
							</p>
						</div>
						<div class="card-footer">
							<button class="btn btn-primary" type="submit" name="save_text"><i class="fa fa-check"></i> <?=(is_numeric($_GET['edit_text']))?'Редактировать':'Добавить'?> текст</button>
						</div>
					</div>
				</form>
				<? if (!isset($_GET['edit_text'])): ?>
					<hr>
					<div class="accordion mt-3" id="subText">
						<? foreach ($r['text'] as $text): ?>
							<div class="card mad-cards">
								<div class="card-header border-bottom-0" id="headText<?=$text['id']?>" data-toggle="collapse" data-target="#text<?=$text['id']?>" aria-expanded="true" aria-controls="text<?=$text['id']?>">
									<i class="fa-fw far fa-file-alt"></i> <?=$text['title']?>
								</div>
								<div class="collapse" id="text<?=$text['id']?>" aria-labelledby="headText<?=$text['id']?>" data-parent="#subText">
									
							<div class="card-body">
								<h5 class="card-title"><?=$text['title']?></h5>
								<hr><p class="card-text"><?=htmlspecialchars($text['text'])?></p>
							</div>
							<div class="card-footer">
								<a href="/load/<?=$text['url']?>/" class="btn btn-primary" target="_blank"><i class="fa fa-external-link-alt"></i> Открыть</a>
								<a href="/user/text/?edit_text=<?=$text['id']?>" class="btn btn-success"><i class="fa fa-pencil-alt"></i> Редактировать</a>
								<a href="/user/text/?del_text=<?=$text['id']?>" class="btn btn-danger"><i class="fa fa-trash"></i> Удалить</a>
							</div>
								</div>
							</div>
						<? endforeach ?>
					</div>
				<? endif ?>
			</div>
		</div>
	</div>
</div>