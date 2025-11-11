<div id="container_content">
    <div class="container_width">
        <div class="breadcrumb">
            <?= !empty($breadcrumb) ? $breadcrumb : ''; ?>
        </div>
        <div class="content-home" style="padding: 10px;">
            <h1 style="font-size: 16px;">TRUNG TÂM NỘI THẤT - KÉT SẮT GIA ĐỊNH </h1>
            <p>
                <b>Điện thoại: <span style="color: #fe3200">0933 481 979</span> - <span style="color: #fe3200">0283 995 3386</span></b> <span class="d-none d-md-inline-block"> |</span>
                <strong>Website:</strong>
                <a href="/">www.ketsatgiadinh.vn</a> -
                <strong>Email:&nbsp;ketgiadinh@gmail.com&nbsp;</strong>
            </p>
            <div class="row">
                <?php foreach ($this->_data_store as $k => $value) : ?>
                    <div class="col-12 col-md-6">
                        <p class="name-showroom"><i class="fa fa-fire"></i><?= $value->city_title; ?></p>
                        <p class="diachi" style="color: black; min-height: unset; margin: 0px;"><i class="fa fa-map-marker" aria-hidden="true"></i><?= $value->address; ?></p>
                        <?= (!empty($value->description)) ? '<i class="note" style="color: black; margin: 0px;">(' . $value->description . ')</i>' : ''; ?>
                        <p style="margin: 0px;">
                            <i class="fa fa-phone"></i> Điện thoại: <b><?= $value->phone ?></b> - <span><a rel="nofollow" target="_blank" style="font-weight: bold; color: #de2900; margin: 0px;" href="<?= !empty($value->address_maps) ? "$value->address_maps" : "/aa9_ban-do-cac-co-so.html" ?>"> Click Xem bản đồ </a></span>
                        </p>
                        <?= ($k < (count($this->_data_store) - 1)) ? '<hr style="width: 50%">' : '<br/>'; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <p style="text-align: center;">---------------------------------------------------------------------------</p>
            <form id="form_contact">
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12">
                        <input type="text" name="full_name" class="form-control" placeholder="Họ tên">
                    </div>
                    <div class="form-group col-lg-6 col-md-12">
                        <input type="text" name="email" class="form-control" placeholder="Email của bạn">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12">
                        <input type="text" name="phone" class="form-control number phone" placeholder="Số điện thoại">
                    </div>
                    <div class="form-group col-lg-6 col-md-12">
                        <input type="text" name="address" class="form-control" placeholder="Địa chỉ">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12">
                        <textarea class="form-control" name="content" rows="3" placeholder="Nội dung"></textarea>
                    </div>
                    <div class="form-group col-lg-6 col-md-12">
                        <button type="submit" class="btn btn-primary sendContact">Gửi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>