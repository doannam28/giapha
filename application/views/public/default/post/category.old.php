<div class="breadcrumbs_area">
    <div class="container">   
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <?= !empty($breadcrumb) ? $breadcrumb : ''; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="dev-category" class="pb-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 sidebar">
                <?php $this->load->view($this->template_path . 'block/sidebar_category') ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="title-bx-main mb-10">
                    <h1 class="name-ctgr-main"><?= $oneItem->title; ?></h1>
                </div>
                <div class="bx-list-ctgr all-sp" style="float: none;">
                    <ul class="list-post row"  id="ajax_content" >
                        <?php if (!empty($list_post)) foreach ($list_post as $key => $value) : ?>
                            <li class="col-12">
                                <div class="row">
                                    <div class="responsive-img col-12 col-sm-4 text-center">
                                        <a href="<?= get_url_post($value); ?>" title="<?= $value->title; ?>">
	                                        <img  src="<?= getWatermark($value,230,145,true);?>"  alt="<?= $value->title?>"/>
                                        </a>
                                    </div>
                                    <div class="info-itemprd col-12 col-sm-8">
                                        <h3 style="min-height: 50px;" class="text-left name tit-list-post pt-3">
                                            <a class="font-weight-bold" href="<?= get_url_post($value); ?>" title="<?= $value->title; ?>">
                                                <?= $value->title; ?>
                                            </a>
                                        </h3>
                                        <div class="">
                                            <i class="fa fa-calendar"></i> <?= getDayOfWeek($value->created_time) . ", " . date('d/m/Y', strtotime($value->created_time))?>
                                        </div>
                                        <p class="mota max-line-2 mt-3"><?= $value->description; ?></p>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="shop_toolbar t_bottom">
	                <div class="text-center mx-auto">
		                <button class="btn btn-primary mx-auto my-3 btnLoadMore" data-page="2" data-url="<?= get_url_category_post($oneItem) ?>" type="button">Xem thêm</button>
	                </div>
                </div>
            </div>
        </div>
    </div>
</section>