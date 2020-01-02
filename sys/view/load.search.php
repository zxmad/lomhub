<div class="row py-4">
	<div class="col-lg-8 offset-lg-2">
		<? if (!empty($r['result'])): ?>
		<div class="list-group">
			<? foreach ($r['result'] as $result): ?>
				<div class="list-group-item list-group-item-action d-md-flex">
					<div><img src="/src/img/product/<?=$result['photo']?>" width="100px" class="rounded shadow-sm"></div>
					<div class="ml-3">
						<a href="/product/<?=$result['id']?>-<?=urify(translit($result['title']))?>" class="mad-decoration-none mb-1">
							<h5 class="mb-0"><?=$result['title']?> <span class="badge badge-pill badge-danger"><?=$result['price']?> ₸</span></h5>
							<p class="mb-0"><?=$result['info']?></p>
						</a>
						<a href="/shop/<?=$result['lombard']['id'].'-'.urify(translit($result['lombard']['name']))?>" class="badge badge-pill badge-success py-1 px-2"><?=$result['lombard']['name']?></a>
					</div>
				</div>
			<? endforeach ?>
		</div>
		<? else: ?>
			<div class="alert alert-info alert-dismissible fade show" role="alert">
				Ничего не найдено!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<a href="/" class="btn btn-outline-primary"><i class="fa fa-home"></i> На главную</a>
		<? endif ?>
	</div>
</div>