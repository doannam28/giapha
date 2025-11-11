<div class="cart__wrap">
    <div class="cart_wrapper">
        <?php if (!empty($data_arr_bg)) : ?>
            <div class="cart_data has-data">
                <h2 class="card-header  text-light text-center">In báo giá sản phẩm</h2>
                <div class="cart_note">
                    <div class="center_content" style="clear: both;">
                        <div class="title-bx-main mb-10">
                            <div class="center_content" style="clear: both;">
                                <p><span style="font-weight: bolder;">Quý Khách hàng muốn in báo giá các sản phẩm vui lòng làm theo hướng dẫn sau:</span></p>
                                <p><span style="font-weight: bolder;">Bước 1:</span>&nbsp;chọn sản phẩm cần in báo giá</p>
                                <p>- Khi xem chi tiết 1 sản phẩm, muốn chọn sản phẩm vào danh sách sản phẩm cần in chỉ cần Click vào nút&nbsp;<span style="font-weight: bolder; color: rgb(255, 0, 0);">In báo giá</span></p>
                                <p>- Click nút&nbsp;<span style="font-weight: bolder; color: rgb(255, 0, 0);">Chọn in báo giá</span>&nbsp;trong Danh sách tất cả sản phẩm bên dưới</p>
                            </div>
                        </div>
                        <div class="title-bx-main mb-10">
                            <div class="center_content" style="clear: both;">
                                <p>- Nhấn chuyển sang các trang danh sách sản phẩm để chọn được các sản phẩm cần in</p>
                                <p><span style="font-weight: bolder;">Bước 2:</span>&nbsp;in báo giá các sản phẩm đã chọn</p>
                                <p>- Quý khách có thể nhập lại Số lượng SP cần báo giá và nhất nút&nbsp;<span style="font-weight: bolder; color: rgb(255, 0, 0);">CẬP NHẬT SỐ LƯỢNG</span></p>
                                <p>- Sau khi hoàn tất click vào nút&nbsp;<span style="font-weight: bolder; color: rgb(255, 0, 0);">IN BÁO GIÁ</span>&nbsp;ở danh sách sản phẩm đã chọn bên dưới</p>
                                <p>- Bản in hiện ra, quý khách dùng phím tắt&nbsp;<span style="font-weight: bolder; color: rgb(255, 0, 0);">CTRL+P</span>&nbsp;hoặc vào menu&nbsp;<span style="font-weight: bolder;">File</span>&nbsp;của trình duyệt rồi chọn&nbsp;<span style="font-weight: bolder;">Print.</span></p>
                                <div><span style="font-weight: bolder;"><br></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart_title">
                    <h3>Giỏ hàng của bạn</h3><a class="cart_back text_link_grey" href="/">Mua thêm sản phẩm khác</a>
                </div>
                <table class="cart_table">
                    <tbody>
                        <tr class="title">
                            <td>Stt.</td>
                            <td>Ảnh</td>
                            <td class="name">Tên sản phẩm</td>
                            <td>Giá</td>
                            <td>Số lượng</td>
                            <td>Xóa</td>
                        </tr>
                        <?php $total_price = 0; ?>

                        <?php $index = 1;
                        foreach ($data_arr_bg as $key => $value): $index++;
                            $data_product = getByIdProduct($value->id);
                            $total_price += $value->price * $value->quantity;
                        ?>
                            <tr class="data">
                                <td class="No"><?= $index - 1 ?></td>
                                <td class="picture"><a href="<?= get_url_product($data_product) ?>" title="<?= $data_product->title ?>">
                                        <img alt="<?= $data_product->title ?>" src="<?= getImageThumb($data_product->thumbnail, 120, 120); ?>"></a></td>
                                <td class="name"><a href="<?= get_url_product($data_product) ?>"><?= $data_product->title ?></a>
                                    <p><strong>Kích thước:</strong> <span style="text-transform: lowercase"><?= $data_product->size ?></span></p>
                                </td>
                                <td class="price"><strong class="subtotal"><?= number_format($data_product->price_sale * $value->quantity, 0, '', '.') . ' đ' ?></strong></td>
                                <td class="quantity_bg">
                                <select class="form_control">
                                        <?php  for ($x = 1; $x <= 9; $x++) :   ?>
                                        <option <?=$value->quantity == $x ? 'selected' : '' ?> value="<?=$x?>"><?=$x?></option>
                                        <?php endfor;?>
                                    </select>
                                </td>
                                <td class="delete"><a class="text_link remove_item_bg" href="javascript:;" data-id="<?= $value->id ?>"><i class="icm icm_x-circle"></i></a></td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart_total">Tổng tiền: <b class="price"><?= number_format($total_price, 0, '', '.') . ' đ'; ?></b></div>
                <div class="break_module"></div>
                <div class="print-footer" style="clear: both;">
                    <a style="background: #ff5722; color: white; padding: 4px 8px; margin: 5px; border: none;" href="<?= base_url('print_bao_gia.html?vat=1'); ?>" target="_blank" class="btn btn-order btn-next-order">
                        <i class="fa fa-print" aria-hidden="true"></i>&nbsp;In báo giá sau thuế
                        <br>
                        <span style="font-size: 13px; font-style: italic;">(Nếu bạn lấy hóa đơn VAT)</span>
                    </a>
                    <a style="background: #ff5722; color: white; padding: 4px 8px; margin: 5px; border: none;" href="<?= base_url('print_bao_gia.html'); ?>" target="_blank" class="btn btn-order btn-next-order"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;In báo giá trước thuế
                        <br>
                        <span style="font-size: 13px; font-style: italic;">(Nếu bạn không lấy hóa đơn VAT)</span>
                    </a>
                </div>


            </div>
        <?php else: ?>
            <div class="cart_data empty">
            <h2 class="card-header  text-light text-center">In báo giá sản phẩm</h2>
                <div class="cart_note">
                    <div class="center_content" style="clear: both;">
                        <div class="title-bx-main mb-10">
                            <div class="center_content" style="clear: both;">
                                <p><span style="font-weight: bolder;">Quý Khách hàng muốn in báo giá các sản phẩm vui lòng làm theo hướng dẫn sau:</span></p>
                                <p><span style="font-weight: bolder;">Bước 1:</span>&nbsp;chọn sản phẩm cần in báo giá</p>
                                <p>- Khi xem chi tiết 1 sản phẩm, muốn chọn sản phẩm vào danh sách sản phẩm cần in chỉ cần Click vào nút&nbsp;<span style="font-weight: bolder; color: rgb(255, 0, 0);">In báo giá</span></p>
                                <p>- Click nút&nbsp;<span style="font-weight: bolder; color: rgb(255, 0, 0);">Chọn in báo giá</span>&nbsp;trong Danh sách tất cả sản phẩm bên dưới</p>
                            </div>
                        </div>
                        <div class="title-bx-main mb-10">
                            <div class="center_content" style="clear: both;">
                                <p>- Nhấn chuyển sang các trang danh sách sản phẩm để chọn được các sản phẩm cần in</p>
                                <p><span style="font-weight: bolder;">Bước 2:</span>&nbsp;in báo giá các sản phẩm đã chọn</p>
                                <p>- Quý khách có thể nhập lại Số lượng SP cần báo giá và nhất nút&nbsp;<span style="font-weight: bolder; color: rgb(255, 0, 0);">CẬP NHẬT SỐ LƯỢNG</span></p>
                                <p>- Sau khi hoàn tất click vào nút&nbsp;<span style="font-weight: bolder; color: rgb(255, 0, 0);">IN BÁO GIÁ</span>&nbsp;ở danh sách sản phẩm đã chọn bên dưới</p>
                                <p>- Bản in hiện ra, quý khách dùng phím tắt&nbsp;<span style="font-weight: bolder; color: rgb(255, 0, 0);">CTRL+P</span>&nbsp;hoặc vào menu&nbsp;<span style="font-weight: bolder;">File</span>&nbsp;của trình duyệt rồi chọn&nbsp;<span style="font-weight: bolder;">Print.</span></p>
                                <div><span style="font-weight: bolder;"><br></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="text-align: center; margin: 80px 0;">
                    <div><span class="icm icm_shopping-cart" style="color: #e5e5e5; font-size: 5rem;"></span></div>
                    <div style="color: #666; font-size: 1.2rem; margin-top: 15px">Không có sản phẩm nào trong giỏ hàng</div>
                    <div style="margin-top: 15px;"><button class="form_button_5" style="text-transform: uppercase; width: 300px;" onclick="window.location.href='/'">Trở về trang chủ</button></div>
                    <div class="cart_hotline" style="margin-top: 25px;">Gọi Hotline <a class="text_link" href="tel:(024)33811188" rel="nofollow"><i class="icm icm_phone"></i>(024)33 811 188</a>
                        Hoặc <a class="text_link" href="tel:0971881886" rel="nofollow"><i class="icm icm_phone"></i>0971 881 886</a> để được tư vấn mua hàng.
                    </div>
                </div>
            </div>
        <?php endif; ?>



        <div class="cart_data">
            <div class="col-12 seclect-sp" style="clear: both;">
                <b>Chọn danh mục</b>
                <select class="sortBy" id="sort_category">
                    <?php if (!empty($list_category)) foreach ($list_category as $key => $value) : ?>
                        <option <?= $category_id == $value['id'] ? 'selected' : ''; ?> value="<?= get_url_bao_gia($oneItem) . '/page/' . $page . '?category=' . $value['id']; ?>"><?= $value['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <table class="table table-striped table-my">
                <thead>
                    <tr>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col" class="text-center">Đơn giá</th>
                        <th scope="col" class="text-center">Tùy chọn In</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list_product)) foreach ($list_product as $key => $value) : ?>
                        <tr>
                            <td>
                                <a href="<?= get_url_product($value); ?>" title="<?= $value->title ?>" class="titleprd"><?= $value->title ?></a>
                            </td>
                            <td>
                                <?= getThumbnail($value, 100, 100); ?>
                            </td>
                            <td class="text-center">
                                <?php if (!empty($value->price) && !empty($value->price_sale)) {
                                    echo number_format($value->price_sale, 0, '', '.') . '<sup>₫</sup>';
                                } elseif (!empty($value->price) && empty($value->price_sale)) {
                                    echo number_format($value->price, 0, '', '.') . '<sup>₫</sup>';
                                } else {
                                    echo 'Liên hệ';
                                } ?>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)" class="btn btn-block btn-tragop btn-print in_bao_gia" data-id="<?= $value->id; ?>" rel="nofollow">Chọn In báo giá</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="shop_toolbar t_bottom">
                <div class="pagination">
                    <?= !empty($pagination) ? $pagination : ''; ?>
                </div>
            </div>
        </div>

    </div>

</div>