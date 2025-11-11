// Dom Ready
$(function() {
    datatables_columns = [{
        field: "checkID",
        title: "#",
        width: 50,
        sortable: !1,
        textAlign: "center",
        selector: {class: "m-checkbox--solid m-checkbox--brand"}
    },{
        field: "id",
        title: "STT",
        width: 50,
        textAlign: "center",
        sortable: 'asc',
        filterable: !1,
    }, {
        field: "order_home",
        title: "Thứ tự",
        width: 70,
        template: function (t) {
            return '<input type="number" name="order_home" class="updateSort" value="'+t.order_home+'" />'
        }
    }, {
        field: "title",
        title: "Tiêu đề",
        width: 150
    },  {
        field: "category",
        title: "Danh mục",
        width: 150,
        template: function (t) {
            return t.category;
        }
    }, {
        field: "code",
        title: "Mã",
        width: 70,
        template: function (t) {
            return '<strong>'+t.code+'</strong>'
        }
    }, {
        field: "thumbnail",
        title: "Hình ảnh",
        textAlign: "center",
        width: 100,
        template: function (t) {
            thumbnail = t.thumbnail ? FUNC.getImageThumb(t.thumbnail) : base_url+'public/default-thumbnail.webp';
            return '<img class="img-thumbnail" src="'+thumbnail+'">'
        }
    }, {
        field: "price",
        title: "Giá",
        textAlign: "center",
        width: 120,
        template: function (t) {
            return '<div class="text_price"><input type="text" class="form-control number price" data-type="price" value="'+t.price+'"/><input type="text" class="form-control number price_sale" data-type="price_sale" value="'+t.price_sale+'"/></div>'
        }
    }, {
        field: "quality",
        title: "Tình trạng",
        textAlign: "center",
        width: 80,
        template: function (t) {
            var e = {
                0: {title: "Hết hàng", class: "m-badge--danger"},
                1: {title: "Còn hàng", class: "m-badge--primary"},
            };

            var h = {
                0: {title: "Not Home", class: "m-badge--danger"},
                1: {title: "Home", class: "m-badge--primary"},
            }
            html = '<span data-field="quality" data-value="'+(t.quality == 1 ? 0 : 1)+'" class="m-badge ' + e[t.quality].class + ' m-badge--wide btnUpdateField">' + e[t.quality].title + "</span>";
            html += '<span data-field="is_home" data-value="'+(t.is_home == 1 ? 0 : 1)+'" class="m-badge ' + h[t.is_home].class + ' m-badge--wide btnUpdateField">' + h[t.is_home].title + "</span>";
            return html;

        }
    }];
    AJAX_DATATABLES.init();
    AJAX_CRUD_MODAL.init();
    loadCategory($('select.filter_category'));

    loadProductType($('select.filter_product_type'));

    $('.filter_category').on("change", function () {
        table.search($(this).val(), "category_id")
    }), $('.filter_category').selectpicker();

    $('.filter_product_type').on("change", function () {
        table.search($(this).val(), "product_type_id")
    }), $('.filter_product_type').selectpicker();
    
});

function loadCategory(selector, dataSelected) {
    selector.select2({
        placeholder: 'Chọn danh mục',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: url_ajax_load_category,
            dataType: 'json',
            delay: 250,
            data: function (e) {
                return {
                    q: e.term,
                    page: e.page
                }
            },
            processResults: function (e, t) {
                return t.page = t.page || 1, {
                    results: e,
                    pagination: {
                        more: 30 * t.page < e.total_count
                    }
                }
            },
            cache: !0
        }
    });
    if (typeof dataSelected !== 'undefined') selector.find('> option').prop("selected", "selected").trigger("change");
}

function loadProductType(selector, dataSelected) {
    selector.select2({
        placeholder: 'Chọn loại sản phẩm',
        allowClear: !0,
        multiple: !1,
        data: dataSelected,
        ajax: {
            url: url_ajax_load_product_type,
            dataType: 'json',
            delay: 250,
            data: function (e) {
                return {
                    q: e.term,
                    page: e.page
                }
            },
            processResults: function (e, t) {
                return t.page = t.page || 1, {
                    results: e,
                    pagination: {
                        more: 30 * t.page < e.total_count
                    }
                }
            },
            cache: !0
        }
    });
    if (typeof dataSelected !== 'undefined') selector.find('> option').prop("selected", "selected").trigger("change");
}


