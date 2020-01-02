<div class="row py-4">
	<div class="col-lg-8 offset-lg-2">
		<div class="card border-0 shadow">
			<ul class="nav nav-tabs rounded bg-mad-gray">
				<li class="nav-item"><a class="nav-link active" href="/user/admin/"><i class="fa fa-tools"></i> Разделы</a></li>
				<li class="nav-item"><a class="nav-link" href="/user/ad/"><i class="fa fa-ad"></i> Реклама</a></li>
				<li class="nav-item"><a class="nav-link" href="/user/text/"><i class="far fa-file-alt"></i> Тексты</a></li>
				<li class="nav-item"><a class="nav-link" href="/user/poster/"><i class="far fa-images"></i> Постеры</a></li>
			</ul>
			<div class="card-body">
				<h6 class="card-title">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/"><i class="fa fa-home"></i></a></li>
						<? if (!empty($r['subtitle'])): ?>
							<li class="breadcrumb-item"><a href="/user/admin/"><?=$r['title']?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['subtitle']?></li>
						<? else: ?>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['title']?></li>
						<? endif ?>
					</ol>
				</h6>
				<hr>
				<? if (isset($_GET['add_cat']) or is_numeric($_GET['add_subcat']) or is_numeric($_GET['add_filter']) or is_numeric($_GET['edit_cat']) or is_numeric($_GET['edit_subcat']) or is_numeric($_GET['edit_filter'])): ?>
					<form action="" method="POST" class="jumbotron p-3">
						<div class="form-group">
							<label><i class="fa-fw fa fa-link"></i> URL</label>
							<input class="form-control" name="url" placeholder="URL" value="<?=$r['scat']['url']?>">
						</div>
						<div class="form-group">
							<label><i class="fa-fw far fa-list-alt"></i> Название</label>
							<input class="form-control" name="name" placeholder="Название" value="<?=$r['scat']['name']?>">
						</div>
						<? if ((!isset($_GET['add_filter'])) and (!isset($_GET['edit_filter']))): ?>
							<div class="form-group">
								<label data-toggle="tooltip" data-placement="top" title="Нажмите чтобы найти иконку"><a href="https://fontawesome.com/icons" target="_blank" class="text-success">
									<i class="fa-fw <?=(!empty($r['scat']['ico']))?$r['scat']['ico']:'fa fa-search'?>"></i> Иконка</a>
								</label>
								<input class="form-control" name="ico" placeholder="Иконка" value="<?=$r['scat']['ico']?>">
							</div>
						<? endif ?>
						<button type="submit" class="btn btn-primary" name="save_admin"><i class="fa fa-check"></i> Сохранить</button>
						<? if (is_numeric($_GET['add_filter'])): ?>
							<hr>
							<small class="list-group">
								<? foreach ($r['filters'] as $filter): ?>
									<div class="list-group-item clearfix">
										<span class="float-left pt-2"><i class="fa-fw fa fa-chevron-right"></i> <?=$filter['name']?></span>
										<a href="/user/admin/?del_filter=<?=$filter['id']?>" class="btn btn-link float-right btn-sm text-danger" data-toggle="tooltip" data-placement="top" title="Удалить фильтр"><i class="fa fa-trash"></i></a>
										<a href="/user/admin/?edit_filter=<?=$filter['id']?>" class="btn btn-link float-right btn-sm text-info" data-toggle="tooltip" data-placement="top" title="Редактировать фильтр"><i class="fa fa-pencil-alt"></i></a>
									</div>
								<? endforeach ?>
							</small>
						<? endif ?>
					</form>
				<? else: ?>
					<div class="accordion mt-3" id="subCats">
						<div class="card"><a href="/user/admin/?add_cat" class="text-success"><h6 class="card-header border-bottom-0"><i class="fa-fw fa fa-plus"></i> Добавить раздел</h6></a></div>
						<? foreach ($r['Cat'] as $x): ?>
							<div class="card">
								<h6 class="card-header border-bottom-0 clearfix" id="headCat<?=$x['id']?>" data-toggle="collapse" data-target="#cat<?=$x['id']?>" aria-expanded="true" aria-controls="cat<?=$x['id']?>">
									<div class="float-left pt-2"><i class="fa-fw <?=$x['ico']?>"></i> <?=$x['name']?></div>
									<a href="/user/admin/?del_cat=<?=$x['id']?>" class="btn btn-outline-danger float-right btn-sm ml-1" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></a>
									<a href="/user/admin/?edit_cat=<?=$x['id']?>" class="btn btn-outline-info float-right btn-sm ml-1" data-toggle="tooltip" data-placement="top" title="Редактировать"><i class="fa fa-pencil-alt"></i></a>
								</h6>
								<small class="collapse list-group-flush" id="cat<?=$x['id']?>" aria-labelledby="headCat<?=$x['id']?>" data-parent="#subCats">
									<a href="/user/admin/?add_subcat=<?=$x['id']?>" class="list-group-item list-group-item-action text-success"><i class="fa fa-fw fa-plus"></i> Добавить подраздел</a>
									<? foreach ($x['subcat'] as $y): ?>
										<div class="list-group-item clearfix">
											<span class="float-left pt-2"><i class="fa-fw <?=$y['ico']?>"></i> <?=$y['name']?></span>
											<a href="/user/admin/?del_subcat=<?=$y['id']?>" class="btn btn-link float-right btn-sm text-danger" data-toggle="tooltip" data-placement="top" title="Удалить"><i class="fa fa-trash"></i></a>
											<a href="/user/admin/?edit_subcat=<?=$y['id']?>" class="btn btn-link float-right btn-sm text-info" data-toggle="tooltip" data-placement="top" title="Редактировать"><i class="fa fa-pencil-alt"></i></a>
											<a href="/user/admin/?add_filter=<?=$y['id']?>" class="btn btn-link float-right btn-sm text-success" data-toggle="tooltip" data-placement="top" title="Фильтры"><i class="fa fa-fw fa-filter"></i></a>
										</div>
									<? endforeach ?>
								</small>
							</div>
						<? endforeach ?>
					</div>
				<? endif ?>
			</div>
		</div>
	</div>
</div>