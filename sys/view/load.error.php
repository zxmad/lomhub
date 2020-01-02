<div class="col-md-8 offset-md-2 my-4">
	<div class="card shadow">
		<? if (file_exists($_SERVER['DOCUMENT_ROOT'].'/src/img/'.$r['err']['url'].'.gif')): ?>
			<center><img src="/src/img/<?=$r['err']['url']?>.gif" class="card-img w-75"></center>
		<? endif ?>
		<div class="alert alert-danger alert-dismissible fade show m-3 mb-0" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="alert-heading"><?=$r['err']['title']?></h4>
			<hr><p class="mb-1"><?=$r['err']['text']?></p>
		</div>
		<form action="/load/search/" class="card-body d-sm-flex">
			<a class="btn btn-lg btn-light m-3 border border-secondary" href="/" style=""><i class="fa fa-home"></i> На главную</a>
			<div class="input-group m-3 border border-primary rounded-pill">
				<input class="form-control border-0 rounded-pill" placeholder="Что ищете?">
				<button class="btn btn-lg btn-primary ml-1"><i class="fa fa-search"></i></button>
			</div>
		</form>
	</div>
</div>