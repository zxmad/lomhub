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
			<li class="nav-item"><a class="nav-link" href="/user/bookmark/"><i class="far fa-star"></i> Избранное</a></li>
			<li class="nav-item"><a class="nav-link active" href="/user/settings/"><i class="fa fa-sliders-h"></i> Настройки</a></li>
			<li class="nav-item"><a class="nav-link" href="/user/sign_out/"><i class="fa fa-sign-out-alt"></i> Выйти</a></li>
		</ul>
		<div class="container-fluid">
			<div class="row mt-3">
				<form action="" method="post" class="col-lg-8 offset-lg-2">
					<div class="form-group">
						<label for="first_name"><i class="fa fa-user-tag"></i> Имя</label>
						<input class="form-control" value="<?=$r['usr']['first_name']?>" id="first_name" name="first_name" placeholder="Имя">
					</div>
					<div class="form-group">
						<label for="last_name"><i class="fa fa-file-signature"></i> Фамилия</label>
						<input class="form-control" value="<?=$r['usr']['last_name']?>" id="last_name" name="last_name" placeholder="Фамилия">
					</div>
					<div class="form-group">
						<label for="city"><i class="fa fa-city"></i> Город</label>
						<input class="form-control" value="<?=$r['usr']['city']?>" id="city" name="city" placeholder="Город">
					</div>
					<div class="form-group">
						<label for="email"><i class="fa fa-envelope"></i> Почта</label>
						<input class="form-control" value="<?=$r['usr']['email']?>" id="email" name="email" placeholder="E-mail">
					</div>
					<div class="form-group clearfix">
						<button type="submit" name="save" class="btn btn-success float-right"><i class="fa fa-check"></i> Сохранить</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>