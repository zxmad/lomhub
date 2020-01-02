<div class="row py-4">
	<div class="col-lg-8 offset-lg-2">
		<div class="card shadow border-0">
			<div class="card-body">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><i class="fa fa-fw fa-home"></i></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?=$r['info']['title']?></li>
				</ol>
				<h1 class="card-title"><?=$r['info']['title']?></h1>
				<div class="card-text"><?=htmlspecialchars_decode($r['info']['text'])?></div>
			</div>
		</div>
	</div>
</div>