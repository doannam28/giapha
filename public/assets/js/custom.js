
jQuery(function ($) {
    var APP = {
        select: function () {
            $(document).on('click', '.news #page-links', function (e) {
                e.preventDefault();
                let link = $(this).find('a').data('href');
                if (link) {
                    $.ajax({
                        url: link,
                        type: 'POST',
                        dataType: 'HTML',
                        data: {},
                        beforeSend: function () {
                            $(".news__item").addClass('animate');
                        }
                    }).done(function (response) {
                        let pagination = $(response).find('.pagination').html();
                        let news__list = $(response).find('.news__list').html();
                        $(".pagination").html(pagination);
                        $(".news__list").html(news__list);
                        if ($(".pagination_active").length > 0) {
                            $(".pagination_active").parent().addClass('active');
                        }
                    })
                }
            });

            $(document).on('click', '.status #page-links', function (e) {
                e.preventDefault();
                let link = $(this).find('a').data('href');
                if (link) {
                    $.ajax({
                        url: link,
                        type: 'POST',
                        dataType: 'HTML',
                        data: {},
                        beforeSend: function () {
                            $("tr").addClass('animate');
                        }
                    }).done(function (response) {
                        let status__table = $(response).find('.status__table').html();
                        $(".status__table").html(status__table);
                        if ($(".pagination_active").length > 0) {
                            $(".pagination_active").parent().addClass('active');
                        }
                    })
                }
            });

            $(document).on('click', '.job__table #page-links', function (e) {
                e.preventDefault();
                let link = $(this).find('a').data('href');
                if (link) {
                    $.ajax({
                        url: link,
                        type: 'POST',
                        dataType: 'HTML',
                        data: {},
                        beforeSend: function () {
                            $("tr").addClass('animate');
                        }
                    }).done(function (response) {
                        let job__table = $(response).find('.job__table').html();
                        $(".job__table").html(job__table);
                        if ($(".pagination_active").length > 0) {
                            $(".pagination_active").parent().addClass('active');
                        }
                    })
                }
            });

            $(document).on('click', '.post--table #page-links', function (e) {
                e.preventDefault();
                let link = $(this).find('a').data('href');
                if (link) {
                    $.ajax({
                        url: link,
                        type: 'POST',
                        dataType: 'HTML',
                        data: {},
                        beforeSend: function () {
                            $("tr").addClass('animate');
                        }
                    }).done(function (response) {
                        let post__table = $(response).find('.post--table').html();
                        $(".post--table").html(post__table);
                        if ($(".pagination_active").length > 0) {
                            $(".pagination_active").parent().addClass('active');
                        }
                    })
                }
            });
        },
        ready: function () {
            APP.select();
            if ($(".pagination_active").length > 0) {
                $(".pagination_active").parent().addClass('active');
            }
            new Treant(chart_config);
            /*custom here*/
            $('.nav__bar').click(function () {
                $('.header').toggleClass('open');
            });
            $('.nav__close').click(function () {
                $('.header').removeClass('open');
            });
            $(window).on('load resize', function () {
                sticky_banner();
            });
        },
    };
    APP.ready();
});
function sticky_banner() {
    if ($(".BannerStickyLeft_content, .BannerStickyRight_content").length > 0) {
        var window_width = $(window).width();
        $(".content-col-left, .content-col-right").trigger("sticky_kit:detach");
        $(".BannerStickyLeft_content, .BannerStickyRight_content").trigger("sticky_kit:detach");
        if (window_width > 980) {
            $(".content-col-left, .content-col-right").stick_in_parent({
                parent: ".main-content",
                offset_top: 150
            });
            $(".BannerStickyLeft_content , .BannerStickyRight_content").stick_in_parent({
                parent: "body",
                offset_top: 150
            });
            $(".col-md-2 > .block_banner").stick_in_parent({
                parent: "body",
                offset_top: 150
            });
        }
    }
}
function goBack() {
    window.history.back();
}