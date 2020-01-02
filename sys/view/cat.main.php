<div class="row">
	<aside class="col-lg-3 py-4">
		<div class="card">
			<h5 class="card-header border-bottom-0">
				<i class="far fa-list-alt"></i> Категории
				<a class="border-0 float-right" type="button" data-toggle="collapse" data-target="#catCollapse" aria-controls="catCollapse" aria-expanded="true"><i class="fa fa-bars"></i></a>
				<div class="clearfix"></div>
			</h5>
			<nav class="list-group-flush w-100 collapse" id="catCollapse">
				<? foreach ($r['cat'] as $cat): ?>
					<a href="/cat/<?=$cat['url']?>/" class="list-group-item list-group-item-action text-truncate"><i class="fa-fw <?=$cat['ico']?>"></i> <?=$cat['name']?></a>
				<? endforeach ?>
			</nav>
		</div>

		<? if ($r['subcat']): ?>
			<div class="accordion mt-3" id="subCats">
				<? foreach ($r['subcat'] as $x): ?>
					<div class="card">
						<h6 class="card-header border-bottom-0" id="headCat<?=$x['id']?>" data-toggle="collapse" data-target="#cat<?=$x['id']?>" aria-expanded="true" aria-controls="cat<?=$x['id']?>">
							<a href="/cat/<?=$url[2]?>/<?=$x['url']?>/" class="text-success"><i class="fa-fw <?=$x['ico']?>"></i> <?=$x['name']?></a>
						</h6>
						<small class="collapse list-group-flush <?=($x['id']==$r['show'])?'show':''?>" id="cat<?=$x['id']?>" aria-labelledby="headCat<?=$x['id']?>" data-parent="#subCats">
							<? foreach ($x['filter'] as $y): ?>
								<a href="/cat/<?=$url[2]?>/<?=$x['url']?>/<?=$y['url']?>/" class="list-group-item list-group-item-action"><i class="fa fa-fw fa-chevron-right"></i> <?=$y['name']?></a>
							<? endforeach ?>
						</small>
					</div>
				<? endforeach ?>
			</div>
		<? endif ?>
	</aside>
	<div class="col-lg-9 container-fluid">
		<div class="row pt-4">
			<!-- <pre><? print_r($r['items']) ?></pre> -->
			<!-- ... -->
			<? if (empty($r['items'])): ?>
				<div class="alert alert-warning alert-dismissible fade show w-100 mr-3" role="alert">
					Пусто<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
			<? else: ?>
				<? foreach ($r['items'] as $item): ?>
					<div class="card col-md-3 col-sm-4 p-0 pb-3 px-3 border-0">
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