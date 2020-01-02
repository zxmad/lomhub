<div class="row py-4">
	<div class="col-lg-8 offset-lg-2">
		<div class="card border-0 shadow">
			<ul class="nav nav-tabs rounded bg-mad-gray">
				<li class="nav-item"><a class="nav-link" href="/shop/lombard/"><i class="far fa-id-card"></i> Ломбард</a></li>
				<li class="nav-item"><a class="nav-link" href="/shop/item/"><i class="fa fa-shopping-bag"></i> Товары</a></li>
				<li class="nav-item"><a class="nav-link active" href="/shop/poster/"><i class="far fa-images"></i> Постеры</a></li>
			</ul>
			<div class="card-body">
				<h6 class="card-title">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/"><i class="fa fa-home"></i></a></li>
						<? if (!empty($r['subtitle'])): ?>
							<li class="breadcrumb-item"><a href="/shop/poster/"><?=$r['title']?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['subtitle']?></li>
						<? else: ?>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['title']?></li>
						<? endif ?>
					</ol>
				</h6>
				<hr>
				<form action="" method="POST" class="card" enctype="multipart/form-data">
					<h5 class="card-header border-bottom-0" data-toggle="collapse" href="#collapsePoster" role="button" aria-expanded="false" aria-controls="collapsePoster"><i class="far fa-images"></i> <?=(is_numeric($_GET['edit_poster']))?'Редактировать':'Добавить'?> постер</h5>
					<div class="row no-gutters collapse <?=(is_numeric($_GET['edit_poster']))?'show':''?>" id="collapsePoster">
						<div class="col-sm-2 p-2">
							<label for="fileup" class="bg-light rounded text-center mad-cards">
								<div class="py-4 w-100">
									<h5>994×392</h5>
									<h5><i class="fa fa-upload"></i></h5>
								</div>
								<input type="file" class="form-control" id="fileup" name="image" accept="image/jpeg,image/png">
							</label>
						</div>
						<div class="col-sm-10">
							<div class="card-body" id="app">
								<h5 class="card-title"><input type="text" class="form-control" placeholder="URL" name="url" value="<?=$r['pstr']['url']?>"></h5>
								<p class="card-text">
									<label for="text"><i class="far fa-list-alt"></i> Краткое описание (<span v-text="(150-txt.length)"></span> сим.)</label>
									<textarea name="text" maxlength="150" class="form-control" id="text" <?=(is_numeric($_GET['edit_poster']))?'':'v-model="txt"'?>><?=$r['pstr']['text']?></textarea>
								</p>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="card-footer">
								<button class="btn btn-primary" type="submit" name="ok_poster"><i class="fa fa-check"></i> <?=(is_numeric($_GET['edit_poster']))?'Редактировать':'Добавить'?> постер</button>
							</div>
						</div>
					</div>
				</form>
				<? if (!is_numeric($_GET['edit_poster'])): ?>
					<? if (!empty($r['poster'])): ?>
						<form action="" method="GET" class="accordion mt-3" id="subPoster">
							<? foreach ($r['poster'] as $poster): ?>
								<div class="card mad-cards">
									<div class="card-header border-bottom-0" id="headPoster<?=$poster['id']?>" data-toggle="collapse" data-target="#poster<?=$poster['id']?>" aria-expanded="true" aria-controls="poster<?=$poster['id']?>">
										<i class="fa-fw far fa-image"></i> <?=$poster['url']?>
									</div>
									<div class="collapse" id="poster<?=$poster['id']?>" aria-labelledby="headPoster<?=$poster['id']?>" data-parent="#subPoster">
										<div class="card-body">
											<img src="/src/img/poster/<?=$poster['image']?>" alt="Постер" class="w-50 rounded">
											<hr><p class="card-text"><?=htmlspecialchars($poster['text'])?></p>
										</div>
										<div class="card-footer">
											<a href="/shop/poster/?edit_poster=<?=$poster['id']?>" class="btn btn-success"><i class="fa fa-pencil-alt"></i> Редактировать</a>
											<a href="/shop/poster/?del_poster=<?=$poster['id']?>" class="btn btn-danger"><i class="fa fa-trash"></i> Удалить</a>
										</div>
									</div>
								</div>
							<? endforeach ?>
						</form>
					<? else: ?>
						<div class="alert alert-warning alert-dismissible fade show w-100 mr-3" role="alert">
							Пусто<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
					<? endif ?>
				<? endif ?>
			</div>
		</div>
	</div>
</div>