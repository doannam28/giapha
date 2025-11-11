<div id="container_content">
	<div class="container_width">
		<h1 class="title_search">Từ khóa tìm kiếm: <?= $keyword ? $keyword : ''; ?></h1>
		<?php if (!empty($data_product)) : ?>
			<section class="product_thumb deal_product">
				<div class="data sale_data">
					<?php foreach ($data_product as $key => $item) : ?>
						<?php $this->load->view($this->template_path . 'home/_oneProduct', ['item' => $item, 'type' => '']) ?>
					<?php endforeach; ?>
					<div class="clear"></div>
				</div>
			</section>
		<?php else: ?>
			<div class="tile is-vertical is-parent">
				<div class="warning-list box" style="
							background-color: #fbfafa;
							border-radius: 6px;
							box-shadow: 0 2px 3px rgba(10,10,10,.1), 0 0 0 1px rgba(10,10,10,.1);
							color: #4a4a4a;
							display: block;
							padding: 1.25rem;
							text-align: center;
							font-size: 24px;
							padding: 75px;
							">Xin lỗi, từ khóa trên không tìm thấy kết quả nào!!</div>
			</div>
		<?php endif; ?>

	</div>
</div>