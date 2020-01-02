<div class="row">
	<div class="col-md-8 offset-md-2 shadow py-4">
		<h1>Ломбарды</h1>
		<hr>
		<div class="list-group">
			<? foreach ($r['lom'] as $lom): ?>
				<a href="/shop/<?=$lom['id'].'-'.urify(translit($lom['name']))?>" class="list-group-item list-group-item-action clearfix">
					<div class="float-left"><img src="/src/img/photo/<?=$lom['photo']?>" width="100px" class="rounded"></div>
					<div class="float-left pl-3">
						<h5><?=$lom['name']?></h5>
						<p><?=$lom['phone']?></p>
						<p><?=$lom['address']?></p>
					</div>
				</a>
			<? endforeach ?>
		</div>
	</div>
</div>