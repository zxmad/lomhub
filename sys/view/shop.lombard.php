<div class="row py-4">
	<div class="col-lg-8 offset-lg-2">
		<div class="card border-0 shadow">
			<ul class="nav nav-tabs rounded bg-mad-gray">
				<li class="nav-item"><a class="nav-link active" href="/shop/lombard/"><i class="far fa-id-card"></i> Ломбард</a></li>
				<li class="nav-item"><a class="nav-link" href="/shop/item/"><i class="fa fa-shopping-bag"></i> Товары</a></li>
				<li class="nav-item"><a class="nav-link" href="/shop/poster/"><i class="far fa-images"></i> Постеры</a></li>
			</ul>
			<div class="card-body">
				<h6 class="card-title">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/"><i class="fa fa-home"></i></a></li>
						<? if (!empty($r['subtitle'])): ?>
							<li class="breadcrumb-item"><a href="/shop/lombard/"><?=$r['title']?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['subtitle']?></li>
						<? else: ?>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['title']?></li>
						<? endif ?>
					</ol>
				</h6>
				<hr>
				<? if (isset($_GET['edit_lom'])): ?>
					<form class="card" method="POST" action="" enctype="multipart/form-data">
						<h5 class="card-header border-bottom-0"><i class="fa fa-shopping-bag"></i> Редактировать информацию</h5>
						<div class="row no-gutters">
							<div class="col-sm-3 pt-3 pl-3">
								<label for="fileup"><i class="far fa-image"></i> Аватар (квадратный)</label>
								<label for="fileup" class="bg-secondary text-white rounded text-center mad-cards">
									<div class="py-4 w-100">
										<h3>1×1</h3>
										<h5><i class="fa fa-upload"></i></h5>
									</div>
									<input type="file" class="form-control border-0 bg-transparent shadow-none" id="fileup" accept="image/jpeg,image/png" name="photo">
								</label>
							</div>
							<div class="col-sm-9">
								<div class="card-body" id="app">
									<div class="form-group">
										<label for=""><i class="far fa-list-alt"></i> Название</label>
										<input name="name" class="form-control" placeholder="Название" value="<?=$r['lom']['name']?>">
									</div>
									<div class="form-group">
										<label for=""><i class="fa fa-phone"></i> Телефон</label>
										<input name="phone" class="form-control" placeholder="+77051112233" value="<?=$r['lom']['phone']?>">
									</div>
									<div class="form-group">
										<label for=""><i class="fa fa-map-marker-alt"></i> Адрес</label>
										<input name="address" class="form-control" placeholder="Сатпаева, 22а" value="<?=$r['lom']['address']?>">
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="card-footer">
									<button class="btn btn-primary" type="submit" name="save_lom"><i class="fa fa-check"></i> Сохранить</button>
								</div>
							</div>
						</div>
					</form>
				<? else: ?>
					<div class="card mb-3">
						<div class="row no-gutters">
							<div class="col-sm-2"><img src="/src/img/photo/<?=$r['lom']['photo']?>" class="card-img rounded"></div>
							<div class="col-sm-10">
								<div class="card-body">
									<h5 class="card-title">
										<i class="fa fa-shopping-bag"></i> 
										<?=$r['lom']['name']?> 
										<small data-toggle="tooltip" data-placement="top" title="Редактировать информацию"><a href="/shop/lombard/?edit_lom"><i class="fa fa-pencil-alt text-success"></i></a></small>
									</h5>
									<hr>
									<p class="card-text">
										<a class="btn btn-light shadow-sm" href="tel:<?=$r['lom']['phone']?>" target="_blank"><i class="fa fa-fw fa-phone"></i> Позвонить</a>
										<a class="btn btn-light shadow-sm" href="https://2gis.kz/almaty/search/<?=$r['lom']['address']?>" target="_blank"><i class="fa fa-fw fa-map-marker-alt"></i> <?=$r['lom']['address']?></a>
										<a class="btn btn-primary" href="/shop/<?=$r['lom']['id'].'-'.urify(translit($r['lom']['name']))?>" target="_blank"><i class="fa fa-external-link-alt"></i> Перейти в ломбард</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				<? endif ?>
			</div>
		</div>
	</div>
</div>