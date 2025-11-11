// Dom Ready
function loadCategory(dataSelected) {
  let selector = $("select.category");
  selector.select2({
    placeholder: "Chọn danh mục",
    allowClear: !0,
    multiple: !1,
    data: dataSelected,
    ajax: {
      url: url_ajax_load_category,
      dataType: "json",
      delay: 250,
      data: function (e) {
        return {
          q: e.term,
          page: e.page,
        };
      },
      processResults: function (e, t) {
        return (
          (t.page = t.page || 1),
          {
            results: e,
            pagination: {
              more: 30 * t.page < e.total_count,
            },
          }
        );
      },
      cache: !0,
    },
  });
  if (typeof dataSelected !== "undefined")
    selector.find("> option").prop("selected", "selected").trigger("change");
}
let linksArray = [];


// Hàm cập nhật mảng và input kết quả
function updateArray() {
  const inputs = document.querySelectorAll("#input-list input");
  linksArray = Array.from(inputs).map((input) => input.value.trim());

  $("#banner").val(linksArray.filter((item) => item.trim() != '').join("; "));

}

$(document).ready(function () {
  $('.add-img').hide();
  $('.add-video').hide();
  // Lắng nghe sự kiện change trên select
  $('select[name="parent_id"]').on('change', function () {
    var selectedValue = $(this).val();
    if (selectedValue == 1) {
      $('.add-img').show();
      $('.add-video').hide();
    } else if (selectedValue == 2) {
      $('.add-img').hide();
      $('.add-video').show();
    } else {
      $('.add-img').hide();
      $('.add-video').hide();
    }
  });
});
