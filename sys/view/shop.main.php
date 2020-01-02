<div class="row">
	<div class="col-lg-3 py-4 shadow">
		<div class="d-xl-flex d-lg-block d-sm-flex bg-light-green p-3 rounded">
			<center class="mb-3"><img src="/src/img/photo/<?=$r['lombard']['photo']?>" width="100px" class="rounded shadow-sm"></center>
			<center class="ml-3">
				<h5><i class="fa fa-shopping-bag"></i> <?=$r['lombard']['name']?></h5>
				<a class="d-sm-block text-left" href="tel:<?=$r['lombard']['phone']?>" target="_blank"><i class="fa fa-fw fa-phone"></i> Позвонить</a>
				<a class="d-sm-block text-left" href="https://2gis.kz/almaty/search/<?=$r['lombard']['address']?>" target="_blank"><i class="fa fa-fw fa-map-marker-alt"></i> <?=$r['lombard']['address']?></a>
			</center>
		</div>
		<div class="card mt-3">
			<h5 class="card-header border-bottom-0">
				<i class="far fa-list-alt"></i> Категории
				<a class="border-0 float-right" type="button" data-toggle="collapse" data-target="#catCollapse" aria-controls="catCollapse" aria-expanded="true"><i class="fa fa-bars"></i></a>
				<div class="clearfix"></div>
			</h5>
			<nav class="list-group-flush w-100 collapse" id="catCollapse">
				<? foreach ($r['cat'] as $cat): ?>
					<a href="/shop/?cat=<?=$cat['id']?>&shop=<?=$r['lombard']['id']?>" class="list-group-item list-group-item-action text-truncate"><i class="fa-fw <?=$cat['ico']?>"></i> <?=$cat['name']?></a>
				<? endforeach ?>
			</nav>
		</div>
	</div>
	<div class="col-lg-9 py-4 container-fluid">
		<div class="row">
			<div class="col-lg-12 d-none d-sm-block">
				<div id="homeSlide" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<? for ($i=0; $i < count($r['poster']); $i++): ?>
							<? if ($i==0): ?>
								<li data-target="#homeSlide" data-slide-to="<?=$i?>" class="active"></li>
							<? else: ?>
								<li data-target="#homeSlide" data-slide-to="<?=$i?>"></li>
							<? endif ?>
						<? endfor ?>
					</ol>
					<div class="carousel-inner">
						<? for ($i=0; $i < count($r['poster']); $i++): ?>
							<a href="<?=$r['poster'][$i]['url']?>" class="carousel-item<?=($i==0)?' active':''?>">
								<img src="/src/img/poster/<?=$r['poster'][$i]['image']?>" class="d-block h-100" alt="<?=$r['poster'][$i]['image']?>">
								<div class="carousel-caption d-none d-md-block mad-caption pb-5">
									<p><?=$r['poster'][$i]['text']?></p>
								</div>
							</a>
						<? endfor ?>
					</div>
					<a class="carousel-control-prev" href="#homeSlide" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					</a>
					<a class="carousel-control-next" href="#homeSlide" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
					</a>
				</div><hr>
			</div>
			<!-- <pre><? print_r($r['items']) ?></pre> -->
			<? if (empty($r['items'])): ?>
				<div class="alert alert-warning alert-dismissible fade show w-100 mr-3" role="alert">
					Пусто<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
			<? else: ?>
				<? foreach ($r['items'] as $item): ?>
					<div class="card col-md-3 col-sm-4 p-0 pb-3 px-3 border-0 bg-transparent">
						<a href="/product/<?=$item['id']?>-<?=urify(translit($item['title']))?>" class="text-dark card-link mad-cards">
							<img src="/src/img/product/<?=$item['photo']?>" class="card-img-top">
							<div class="card-body">
								<h5 class="card-title"><?=$item['title']?></h5>
								<p class="card-text"><span class="btn btn-danger font-weight-bold"><?=$item['price']?> ₸</span></p>
							</div>
						</a>
					</div>
				<? endforeach ?>
			<? endif ?>
			<!-- ... -->
			<div class="col-lg-12">
				<hr>
<!-- 				<ul class="pagination justify-content-center">
					<li class="page-item disabled"><span class="page-link">Назад</span></li>
					<li class="page-item"><a class="page-link" href="#">1</a></li>
					<li class="page-item active" aria-current="page"><span class="page-link">2</span></li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item"><a class="page-link" href="#">Вперед</a></li>
				</ul> -->
			</div>
		</div>


	</div>
</div>