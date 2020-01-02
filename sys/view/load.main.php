<div class="row">
	<aside class="col-lg-3 mt-4">
		<div class="card h-100">
			<nav class="navbar-expand-lg">
				<h5 class="card-header border-bottom-0 clearfix">
					<i class="far fa-list-alt"></i> Категории
					<a class="navbar-toggler border-0 float-right text-dark" href="#" data-toggle="collapse" data-target="#catCollapse" aria-controls="catCollapse" aria-expanded="false"><i class="fa fa-bars"></i></a>
				</h5>
				<div class="collapse navbar-collapse" id="catCollapse">
					<nav class="list-group-flush w-100">
						<? foreach ($r['cat'] as $cat): ?>
							<a href="/cat/<?=$cat['url']?>/" class="list-group-item list-group-item-action text-truncate"><i class="fa-fw <?=$cat['ico']?>"></i> <?=$cat['name']?></a>
						<? endforeach ?>
					</nav>
				</div>
			</nav>
		</div>
	</aside>
	<div class="col-lg-9 mt-4 d-none d-sm-block">
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
		</div>
	</div>

	<div class="col-lg-12 mb-4 container-fluid">
		<hr><h3 class="p-3">💖 Мы рекомендуем</h3>
		<div class="row px-md-5">
			<? foreach ($r['best'] as $best): ?>
				<div class="card col-xl-2 col-md-4 col-sm-6 p-0 pb-3 px-2 border-0">
					<a href="/product/<?=$best['id']?>-<?=urify(translit($best['title']))?>" class="shadow-sm text-dark card-link mad-cards h-100">
						<img src="/src/img/product/<?=$best['photo']?>" class="card-img-top" alt="<?=$best['title']?>">
						<div class="card-body">
							<h5 class="card-title"><?=$best['title']?></h5>
							<p class="card-text"><span class="btn btn-danger font-weight-bold"><?=$best['price']?> ₸</span></p>
						</div>
					</a>
				</div>
			<? endforeach ?>
			<? if (!empty($r['ad'])): ?>
				<div class="card col-xl-2 col-md-4 col-sm-6 p-0 pb-3 px-2 border-0 mad-ad">
					<a href="<?=$r['ad']['url']?>" class="shadow-sm text-dark card-link mad-cards h-100" target="_blank">
						<span class="badge badge-pill badge-warning m-2 text-white position-absolute"><i class="fa fa-ad"></i> РЕКЛАМА</span>
						<img src="/src/img/other/<?=$r['ad']['photo']?>" class="card-img h-100" alt="<?=$r['ad']['title']?>">
						<div class="card-img-overlay mx-2 mb-3 rounded text-white">
							<h5 class="card-title clearfix"><?=$r['ad']['title']?></h5>
							<hr>
							<p class="card-text"><?=$r['ad']['info']?></p>
						</div>
					</a>
				</div>
			<? endif ?>
		</div>
	</div>
	<div class="col-lg-12 mb-4 container-fluid">
		<hr><h3 class="p-3">🔥 Новинки</h3>
		<div class="row px-md-5">
			<? foreach ($r['new'] as $new): ?>
				<div class="card col-xl-2 col-md-4 col-sm-6 p-0 pb-3 px-2 border-0">
					<a href="/product/<?=$new['id']?>-<?=urify(translit($new['title']))?>" class="shadow-sm text-dark card-link mad-cards h-100">
						<img src="/src/img/product/<?=$new['photo']?>" class="card-img-top" alt="<?=$new['title']?>">
						<div class="card-body">
							<h5 class="card-title"><?=$new['title']?></h5>
							<p class="card-text"><span class="btn btn-danger font-weight-bold"><?=$new['price']?> ₸</span></p>
						</div>
					</a>
				</div>
			<? endforeach ?>
		</div>
	</div>
</div>