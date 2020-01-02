<div class="row py-4">
	<div class="col-lg-8 offset-lg-2 shadow">
		<h5 class="m-0 clearfix bg-light-green p-3 my-3 rounded">
			<img src="<?=$r['user']['photo_big']?>" class="rounded-pill float-left" width="50px">
			<span class="align-middle pt-3 ml-2">
				<?=$r['user']['first_name']?> <?=$r['user']['last_name']?> 
				<small class="text-muted" style="font-size:small">
					/ <?=$r['user']['country']?>, <?=$r['user']['city']?> 
					/ <a href="/load/go/?url=<?=$r['user']['profile']?>" target="_blank"><i class="fab fa-vk text-success"></i></a>
				</small>
			</span>
		</h5>
		<ul class="nav nav-tabs">
			<li class="nav-item"><a class="nav-link active" href="/user/bookmark/"><i class="far fa-star"></i> Избранное</a></li>
			<li class="nav-item"><a class="nav-link" href="/user/settings/"><i class="fa fa-sliders-h"></i> Настройки</a></li>
			<li class="nav-item"><a class="nav-link" href="/user/sign_out/"><i class="fa fa-sign-out-alt"></i> Выйти</a></li>
		</ul>
		<div class="container-fluid">
			<div class="row mt-3">
				<!-- <pre><? print_r($r['items']) ?></pre> -->
				<? if (empty($r['items'])): ?>
					<div class="alert alert-warning alert-dismissible fade show w-100" role="alert">
						Пусто<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				<? else: ?>
					<? foreach ($r['items'] as $item): ?>
						<div class="card col-md-3 col-sm-4 p-0 pb-3 px-3 border-0">
							<a href="/product/<?=$item['item']['id']?>-<?=urify(translit($item['item']['title']))?>" class="text-dark card-link mad-cards">
								<img src="/src/img/product/<?=$item['item']['photo']?>" class="card-img-top">
								<div class="card-body">
									<h5 class="card-title"><?=$item['item']['title']?></h5>
									<p class="card-text"><span class="btn btn-danger font-weight-bold"><?=$item['item']['price']?> ₸</span></p>
								</div>
							</a>
						</div>
					<? endforeach ?>
				<? endif ?>
				<!-- ... -->
			</div>
		</div>
	</div>
</div>