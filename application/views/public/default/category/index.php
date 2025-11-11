<div id="container_content">
    <div class="container_width">
        <div class="breadcrumb">
            <?= !empty($breadcrumb) ? $breadcrumb : ''; ?>
        </div>

        <section class="warpper">
            <div class="title-bx-main mb-10">
                <h2 class="name-ctgr-main"><?= $oneItem->title; ?></h2>
            </div>
            <ul class="news_list">
                <?php if (!empty($list_post)) foreach ($list_post as $key => $value) :  ?>
                    <li class="wrapper">
                        <a href="<?= get_url_post($value); ?>" title="<?= $value->title; ?>">
                            <div class="picture"><?= getThumbnail($value, 150, 'auto'); ?></div>
                            <div class="information">
                                <h3><?= $value->title; ?></h3>
                                <div class="teaser"><?= $value->description; ?></div>
                                <div class="timepost"><?= date('d/m/Y', strtotime($value->created_time)) ?></div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        
        <div class="text-center"><?= !empty($pagination) ? $pagination : ''; ?></div>


        <?php if(!empty($oneItem->description)): ?>
        <div class="content-home" style="padding: 10px;">
            <?php
            $description = str_replace('/data/upload', 'public/media/upload', $oneItem->description);
            $description = str_replace('/data/images/product', 'public/media/upload/product', $oneItem->description);
            $description = str_replace('alt=""', 'alt="ketsatgiadinh.vn"', $description);
            $description = str_replace('alt=" "', 'alt="ketsatgiadinh.vn"', $description);
            echo $description;
            ?>
        </div>
        <?php endif;?>
    </div>
</div>