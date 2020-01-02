<div class="row py-4">
	<div class="col-lg-8 offset-lg-2">
		<div class="card border-0 shadow">
			<ul class="nav nav-tabs rounded bg-mad-gray">
				<li class="nav-item"><a class="nav-link" href="/shop/lombard/"><i class="far fa-id-card"></i> Ломбард</a></li>
				<li class="nav-item"><a class="nav-link active" href="/shop/item/"><i class="fa fa-shopping-bag"></i> Товары</a></li>
				<li class="nav-item"><a class="nav-link" href="/shop/poster/"><i class="far fa-images"></i> Постеры</a></li>
			</ul>
			<div class="card-body">
				<h6 class="card-title">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/"><i class="fa fa-home"></i></a></li>
						<? if (!empty($r['subtitle'])): ?>
							<li class="breadcrumb-item"><a href="/shop/item/"><?=$r['title']?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['subtitle']?></li>
						<? else: ?>
							<li class="breadcrumb-item active" aria-current="page"><?=$r['title']?></li>
						<? endif ?>
					</ol>
				</h6>
				<hr>
				<? if (!is_numeric($_GET['edit_item'])): ?>
					<div class="jumbotron p-3 m-0 mb-2">
						<h5 class="card-title">Добавить товар</h5><hr>
						<label><i class="far fa-list-alt"></i> Подкатегория</label>
						<div class="dropdown">
							<a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выберите подкатеогорию</a>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<? foreach ($r['subcat'] as $cat): ?>
									<small class="text-muted px-3 py-2 d-block">--- <?=$cat['id']?>. <?=$cat['name']?> ---</small>
									<? foreach ($cat['subcat'] as $subcat): ?>
										<a class="dropdown-item" href="/shop/item/?add_item=<?=$subcat['id']?>"><?=$subcat['name']?></a>
									<? endforeach ?>
									<div class="dropdown-divider"></div>
								<? endforeach ?>
							</div>
						</div>
					</div>
				<? endif ?>
				<? if ((!empty($_GET['add_item']) and is_numeric($_GET['add_item'])) or is_numeric($_GET['edit_item'])): ?>
					<div class="jumbotron p-3 m-0 bg-light shadow-sm">
						<h6><i class="fa-fw <?=$r['scat']['ico']?>"></i> <?=$r['scat']['name']?></h6><hr>
						<form action="" method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<label for="title"><i class="fa fa-fw fa-receipt"></i> Наименование</label>
								<input name="title" id="title" class="form-control" placeholder="Например: Apple iPhone 7, 32Гб" value="<?=$r['item']['title']?>">
							</div>
							<div class="form-group">
								<label for="tinymce"><i class="fa fa-fw fa-info-circle"></i> Описание</label>
								<textarea name="info" id="tinymce" class="form-control"><?=$r['item']['info']?></textarea>
							</div>
							<div class="input-group d-flex justify-content-between">
								<label for="number" class="d-block w-50 px-2"><i class="fa fa-fw fa-tenge"></i> Цена</label>
								<? if (!is_numeric($_GET['edit_item'])): ?>
									<label for="file" class="d-block w-50 px-2"><i class="fa fa-fw fa-image"></i> Фотографии</label>
								<? endif ?>
							</div>
							<div class="input-group mb-3">
								<input type="number" id="number" name="price" class="form-control mx-1 rounded" placeholder="0 тг" value="<?=$r['item']['price']?>">
								<? if (!is_numeric($_GET['edit_item'])): ?>
									<input type="file" id="file" name="photos[]" class="form-control mx-1 rounded" multiple="multiple" accept="image/jpeg,image/png">
								<? endif ?>
							</div>
							<div class="form-group clearfix">
								<? foreach ($r['scat']['filter'] as $filter): ?>
									<label class="btn btn-check float-left p-0 mx-1">
										<input type="checkbox" name="filter[]" value="<?=$filter['id']?>" 
										<?php if (is_numeric($_GET['edit_item'])): ?>
											
											<? foreach ($r['item']['filter'] as $f): ?><?=($filter['id']==$f['id'])?'checked':''?><? endforeach ?>
										<?php endif ?>> 
										<span class="p-1 rounded-pill shadow">
											<i class="fa fa-check"></i> 
											<?=$filter['name']?>
										</span>
									</label>
								<? endforeach ?>
							</div>
							<input type="hidden" name="lom_id" value="<?=$_SESSION['user']['lom_id']?>">
							<input type="hidden" name="subcat_id" value="<?=$_GET['add_item']?>">
							<div class="form-group">
								<button class="btn btn-primary" type="submit" name="add_item_btn"><i class="fa fa-check"></i> ОК</button>
							</div>
						</form>
					</div>
				<? endif ?>
			</div>
		</div>
	</div>
</div>