jQuery(function ($) {
  function getPanPosition() {
    return {
      scrollTop: elem.parentElement.scrollTop,
      scrollLeft: elem.parentElement.scrollLeft,
      transform: elem.style.transform
    };
  }
  var win = $(window),
    body = $("body"),
    doc = $(document);

  var UI = {
    updateSvg: function () {
      const svgEl = $(".Treant svg");
      const newEl = `<marker id="circle-marker" markerWidth="10" markerHeight="10" refX="5" refY="5" orient="auto"
    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
<circle cx="5" cy="5" r="3" fill="black" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" />
</marker>`;
      $(".Treant svg defs").append(newEl);
      const pathEls = $(".Treant svg>path");
      pathEls.attr("marker-start", "url(#circle-marker)");
    },
    scroll: function () {
      const $scrollable = $("#chart-genealogy");
      let isDragging = false;
      let startX, startY, scrollLeft, scrollTop;
      //   const $cursor = $('<div class="cursor"></div>');
      //   body.append($cursor);

      //   $(document).on("mousemove", function (e) {
      //     $cursor.css({
      //       left: e.pageX + "px",
      //       top: e.pageY + "px",
      //     });
      //   });

      //   $scrollable.on("mouseenter", function () {
      //     $cursor.addClass("active");
      //   });

      //   $scrollable.on("mouseleave", function () {
      //     $cursor.removeClass("active");
      //   });

      //   $scrollable.on("mousedown", function (e) {
      //     isDragging = true;
      //     $cursor.addClass("dragging");

      //     startX = e.pageX - $scrollable.offset().left;
      //     startY = e.pageY - $scrollable.offset().top;
      //     scrollLeft = $scrollable.scrollLeft();
      //     scrollTop = $scrollable.scrollTop();
      //   });

      $(document).on("mousemove", function (e) {
        if (!isDragging) return;
        const x = e.pageX - $scrollable.offset().left;
        const y = e.pageY - $scrollable.offset().top;
        const walkX = x - startX;
        const walkY = y - startY;
        $scrollable.scrollLeft(scrollLeft - walkX);
        $scrollable.scrollTop(scrollTop - walkY);
      });

      $(document).on("mouseup", function () {
        if (isDragging) {
          isDragging = false;
          $cursor.removeClass("dragging");
        }
      });

      $scrollable.on("mouseleave", function () {
        if (isDragging) {
          isDragging = false;
          $cursor.removeClass("dragging");
        }
      });
    },
    setLever: function () {
      const seenLevels = new Set();

      $(".node-lever").each(function () {
        const lever = $(this).text().trim();

        if (!seenLevels.has(lever)) {
          seenLevels.add(lever);
        }
      });

      return seenLevels;
    },
    handleClickNode: function () {
      $(".node-lever").removeClass("active");
      UI.setLever().forEach(function (lever) {
        const elements = $(".node-lever").filter(function () {
          return (
            $(this).text().trim() === lever &&
            $(this).css("visibility") !== "hidden"
          );
        });
        if (elements.length > 0) {
          $(elements[elements.length - 1]).addClass("active");
        }
      });

      $(".collapse-switch").click(function (e) {
        const clickedButton = $(this);

        const scrollContainer = document.getElementById('wraper-chart');
        const $scrollContainer = $(scrollContainer);

        const $node = clickedButton.closest('.node');
        const nodeId = $node.attr('id');

        $(".node-lever").removeClass("active");
        UI.setLever().forEach(function (lever) {
          const elements = $(".node-lever").filter(function () {
            return (
                $(this).text().trim() === lever &&
                $(this).css("visibility") !== "hidden"
            );
          });
          if (elements.length > 0) {
            $(elements[elements.length - 1]).addClass("active");
          }
        });

        setTimeout(function () {
          const $newNode = $('#' + nodeId);
          if ($newNode.length > 0) {
            const nodeOffset = $newNode.offset();
            const containerOffset = $scrollContainer.offset();

            const scrollTopTarget =
                nodeOffset.top - containerOffset.top +
                $scrollContainer.scrollTop() -
                ($scrollContainer.height() / 2) +
                ($newNode.outerHeight() / 2);

            const scrollLeftTarget =
                nodeOffset.left - containerOffset.left +
                $scrollContainer.scrollLeft() -
                ($scrollContainer.width() / 2) +
                ($newNode.outerWidth() / 2);

            scrollContainer.scrollTo({
              top: scrollTopTarget,
              left: scrollLeftTarget,
              behavior: 'smooth'
            });
          }
        }, 100);
      });

      $(document).on("mousemove", function (e) {
          console.log(e.pageX + "px");
          console.log(e.pageY + "px");
         });
    },
    select: function () {
      $(".select__button").click(function (e) {
        e.stopPropagation();
        $(".option").not($(this).siblings(".option")).hide();
        $(this).siblings(".option").toggle();
      });

      $(document).click(function (e) {
        if (!$(e.target).closest(".select").length) {
          $(".option").hide();
        }
      });

      $(".option__btn").click(function () {
        $(this).closest(".select").find(".option").hide();
      });
    },
    ready: function () {
      if ($("#chart-genealogy").length > 0) {
        UI.updateSvg();
        UI.scroll();
        UI.handleClickNode();
        UI.select();
      }
    },
  };
  UI.ready();
});