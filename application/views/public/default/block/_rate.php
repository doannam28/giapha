<?php $rate = !empty($reviews->avg) ? $reviews->avg : 5 ?>
<div class="comment-area">
    <div class="form-group mb-0">
        <div class="send-comment__label">
            <div class="star-input">
                <?php for($i = 5; $i>= 1; $i--) : ?>
                    <input type="radio" name="rate" value="<?= $i?>" <?= $rate == $i ? 'checked' : ''?>>
                    <span></span>
                <?php endfor;?>
            </div>
            <span class="danhgia">
                <span class="avg-rate"><?= empty($reviews->avg) ? 5 : $reviews->avg ?></span> /<span>5</span> của
                <span class="count-rate"><?= !empty($reviews->count_vote) ? $reviews->count_vote : 1 ?></span> đánh giá</span>
            </span>
        </div>
    </div>
</div>


<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "AggregateRating",
        "ratingValue": "<?= empty($reviews->avg) ? 5 : $reviews->avg ?>",
        "bestRating": "5",
        "ratingCount": "<?= !empty($reviews->count_vote) ? $reviews->count_vote : 1 ?>",
        "itemReviewed": {
            "@type": "CreativeWorkSeries",
            "name": "<?= toNormalTitle($oneItem->title) ?>" }
    }
</script>