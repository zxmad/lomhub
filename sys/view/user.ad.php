<div class="row py-4">
	<div class="col-lg-8 offset-lg-2">
		<div class="card border-0 shadow">
			<ul class="nav nav-tabs rounded bg-mad-gray">
				<li class="nav-item"><a class="nav-link" href="/user/admin/"><i class="fa fa-tools"></i> Разделы</a></li>
				<li class="nav-item"><a class="nav-link active" href="/user/ad/"><i class="fa fa-ad"></i> Реклама</a></li>
				<li class="nav-item"><a class="nav-link" href="/user/text/"><i class="far fa-file-alt"></i> Тексты</a></li>
				<li class="nav-item"><a class="nav-link" href="/user/poster/"><i class="far fa-images"></i> Постеры</a></li>
			</ul>
			<div class="card-body">
				<h6 class="card-title">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/"><i class="fa fa-home"></i></a></li>
						<? if (!empty($r['subtitle'])): ?>
							<li class="breadcrumb-item"><a href="/user/ad/"><?=$r['title']?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['subtitle']?></li>
						<? else: ?>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['title']?></li>
						<? endif ?>
					</ol>
				</h6>
				<hr>
				<form class="card" method="POST" action="" enctype="multipart/form-data">
					<h5 class="card-header border-bottom-0" data-toggle="collapse" href="#collapseAd" role="button" aria-expanded="false" aria-controls="collapseAd"><i class="fa fa-ad"></i> <?=(is_numeric($_GET['edit_ad']))?'Редактировать рекламу':'Добавить рекламу'?></h5>
					<div class="row no-gutters collapse <?=(is_numeric($_GET['edit_ad']))?'show':''?>" id="collapseAd">
						<div class="col-sm-2 pt-3 pl-3">
							<label for="fileup" class="bg-secondary text-white rounded text-center mad-cards">
								<div class="py-4 w-100">
									<h3>400×560</h3>
									<h5><i class="fa fa-upload"></i></h5>
								</div>
								<input type="file" class="form-control border-0 bg-transparent shadow-none" id="fileup" accept="image/jpeg,image/png" name="photo">
							</label>
						</div>
						<div class="col-sm-10">
							<div class="card-body" id="app">
								<h5 class="card-title"><input name="title" class="form-control" placeholder="Заголовок" value="<?=$r['ad1']['title']?>"></h5>
								<div class="card-title"><input name="url" class="form-control" placeholder="URL" value="<?=$r['ad1']['url']?>"></div>
								<p class="card-text">
									<label for="text"><i class="far fa-list-alt"></i> Краткое описание (<span v-text="(90-txt.length)"></span> сим.)</label>
									<textarea name="info" maxlength="90" class="form-control" id="text" <?=(is_numeric($_GET['edit_ad']))?'':'v-model="txt"'?>><?=$r['ad1']['info']?></textarea>
								</p>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="card-footer">
								<button class="btn btn-primary" type="submit" name="add_ad"><i class="fa fa-check"></i> <?=(is_numeric($_GET['edit_ad']))?'Редактировать рекламу':'Добавить рекламу'?></button>
							</div>
						</div>
					</div>
				</form>
				<? if (!isset($_GET['edit_ad'])): ?>
					<hr>
					<? foreach ($r['ad'] as $ad): ?>
						<div class="card mad-cards mb-3">
							<div class="row no-gutters">
								<div class="col-sm-2"><img src="/src/img/other/<?=$ad['photo']?>" class="card-img rounded"></div>
								<div class="col-sm-10">
									<div class="card-body">
										<h5 class="card-title"><?=$ad['title']?></h5>
										<hr><p class="card-text"><?=$ad['info']?></p>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="card-footer">
										<a href="<?=$ad['url']?>" class="btn btn-primary" target="_blank"><i class="fa fa-external-link-alt"></i> Открыть</a>
										<a href="/user/ad/?edit_ad=<?=$ad['id']?>" class="btn btn-success"><i class="fa fa-pencil-alt"></i> Редактировать</a>
										<a href="/user/ad/?del_ad=<?=$ad['id']?>" class="btn btn-danger"><i class="fa fa-trash"></i> Удалить</a>
									</div>
								</div>
							</div>
						</div>
					<? endforeach ?>
				<? endif ?>
			</div>
		</div>
	</div>
</div>