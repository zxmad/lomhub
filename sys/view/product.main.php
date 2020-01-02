<div class="row bg-grad">
	<aside class="col-lg-3 col-md-4 col-sm-6 py-4 order-first">
		<center class="card h-100 shadow border-0 rounded">
			<div id="itemSlide" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<? for ($i=1; $i <= count($r['item']['photos']); $i++): ?>
						<li data-target="#itemSlide" data-slide-to="<?=$i?>" class="bg-dark <?=($i==1)?'active':''?>"></li>
					<? endfor ?>
				</ol>
				<div class="carousel-inner">
					<? for ($i=1; $i <= count($r['item']['photos']); $i++): ?>
						<div class="carousel-item <?=($i==1)?'active':''?>"><img src="/src/img/product/<?=$r['item']['photos'][$i]?>" class="card-img " alt="<?=$r['item']['title']?>"></div>
					<? endfor ?>
				</div>
				<a class="carousel-control-prev" href="#itemSlide" role="button" data-slide="prev"><i class="fa fa-chevron-left text-dark"></i></a>
				<a class="carousel-control-next" href="#itemSlide" role="button" data-slide="next"><i class="fa fa-chevron-right text-dark"></i></a>
			</div>
			<h5 class="card-footer mb-0 bg-white">
				<? if (isset($_SESSION['user'])): ?>
					<? if ($r['item']['bookmark']): ?>
						<a class="btn btn-warning text-uppercase" href="/product/?del=<?=$r['item']['id']?>" data-toggle="tooltip" data-placement="bottom" title="Удалить из закладок"><i class="fa fa-heart fa-fw text-danger"></i> Сохранено</a>
					<? else: ?>
						<a class="btn btn-light text-uppercase shadow" href="/product/?save=<?=$r['item']['id']?>" data-toggle="tooltip" data-placement="bottom" title="Сохранить в закладки"><i class="far fa-heart fa-fw text-danger"></i> Сохранить</a>
					<? endif ?>
				<? endif ?>
				<? if ($_SESSION['user']['lom_id'] == $r['item']['lom_id']): ?>
					<a class="btn btn-info text-uppercase m-1" href="/shop/item/?edit_item=<?=$r['item']['id']?>" data-toggle="tooltip" data-placement="bottom" title="Редактировать товар"><i class="fa fa-pencil-alt fa-fw"></i></a>
					<a class="btn btn-danger text-uppercase m-1" href="/shop/item/?del_item=<?=$r['item']['id']?>" data-toggle="tooltip" data-placement="bottom" title="Удалить товар"><i class="fa fa-trash fa-fw"></i></a>
				<? endif ?>
			</h5>
		</center>
	</aside>
	<div class="col-lg-7 col-md-8 col-sm-12 py-4 order-md-2 order-sm-3">
		<div class="card h-100 shadow border-0 rounded">
			<div class="card-body">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb bg-white m-0 p-0 mb-1">
						<li class="breadcrumb-item"><a href="/" class="text-secondary"><i class="fa fa-home"></i></a></li>
						<li class="breadcrumb-item"><a href="/cat/<?=$r['item']['path']['url']?>/" class="text-secondary"><?=$r['item']['path']['name']?></a></li>
						<li class="breadcrumb-item"><a href="/cat/<?=$r['item']['path']['url']?>/<?=$r['item']['path']['subcat']['url']?>/" class="text-secondary"><?=$r['item']['path']['subcat']['name']?></a></li>
						<li class="breadcrumb-item"></li>
					</ol>
				</nav>
				<h2><?=$r['item']['title']?></h2>
				<p><?=$r['item']['info']?></p>
			</div>
			<div class="card-footer bg-white">
				<div class="btn btn-danger font-weight-bold"><?=$r['item']['price']?> ₸</div>
				<? if (!empty($r['item']['filters'])): ?>
					<? foreach ($r['item']['filters'] as $filter): ?>
						<a href="/cat/<?=$r['item']['path']['url']?>/<?=$r['item']['path']['subcat']['url']?>/<?=$filter['url']?>/" class="btn btn-secondary"><?=$filter['name']?></a>
					<? endforeach ?>
				<? endif ?>
			</div>
		</div>
	</div>
	<div class="col-lg-2 col-md-12 col-sm-6 py-4 order-md-3 order-sm-2">
		<div class="card h-100 shadow border-0 rounded">
			<img src="/src/img/photo/<?=$r['item']['lombard']['photo']?>" class="card-img rounded d-none d-lg-block ">
			<h5 class="card-header border-bottom-0"><?=$r['item']['lombard']['name']?></h5>
			<nav class="list-group">
				<a href="tel:<?=$r['item']['lombard']['phone']?>" target="_blank" class="list-group-item list-group-item-action"><i class="fa fa-fw fa-phone"></i> Позвонить</a>
				<a href="https://2gis.kz/almaty/search/<?=$r['item']['lombard']['address']?>" target="_blank" class="list-group-item list-group-item-action"><i class="fa fa-fw fa-map-marker-alt"></i> <?=$r['item']['lombard']['address']?></a>
				<a href="/shop/<?=$r['item']['lombard']['id'].'-'.urify(translit($r['item']['lombard']['name']))?>" class="list-group-item list-group-item-action"><i class="fa fa-fw fa-list"></i> Все товары</a>
			</nav>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-7 offset-lg-3 order-last">
		<!-- <pre><? print_r($r['item']) ?></pre> -->
		<h3 class="my-3"><i class="far fa-comments "></i> Комментарии</h3>
		<div id="vk_comments" class="mb-4 shadow"></div>
		<script type="text/javascript">
			VK.Widgets.Comments("vk_comments", {limit: 10, attach: "photo,video"}, '<?=$r['item']['id']?>');
		</script>
	</div>
</div>