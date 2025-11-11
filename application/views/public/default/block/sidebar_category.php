<?php 
    $productType = getDataProductType();
    $home_left = getMenuParent(0,1);
?>
<ul class="dmsp">
    <?php if (!empty($home_left)) foreach ($home_left as $value) : 
        $child_home_left = getMenuParent($value->id,1);
    ?>
        <li class="menu_item_children">
            <a class="text-uppercase" href="<?= base_url($value->link); ?>" title="<?= $value->title ?>"><?= $value->title; ?></a>
            <?php if (!empty($child_home_left)): ?>
                <ul class="sub_menu">
                    <?php foreach ($child_home_left as $item): 
                        $child_home_left2 = getMenuParent($item->id,1);
                    ?>
                        <li>
                            <a class="text-uppercase" href="<?= base_url($item->link); ?>" title="<?= $item->title; ?>">
                                <?= $item->title; ?></a>
                        </li>
                        <?php if (!empty($child_home_left2)): ?>
	                    <li>
		                    <ul class="sub_menu">
                            <?php foreach ($child_home_left2 as $val): ?>
					                    <li>
						                    <a href="<?= base_url($val->link); ?>" title="<?= $val->title; ?>">
							                    <?= $val->title; ?>
						                    </a>
					                    </li>
                            <?php endforeach; ?>
		                    </ul>
	                    </li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    <li class="menu_item_children">
        <a href="<?= get_url_product_type(['id'=>76,'slug'=>'loai-ket-sat']); ?>" class="">Loại két sắt</a>
        <ul class="sub_menu">
            <?php if (!empty($productType)) foreach ($productType as $key => $value) : ?>
                <li><a title="<?= $value->title; ?>" href="<?= get_url_product_type($value); ?>"><?= $value->title ?></a></li>
            <?php endforeach; ?>
        </ul>
    </li>
</ul>