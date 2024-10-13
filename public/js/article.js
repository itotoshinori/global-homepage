$("#close").on("click", function () {
    $('input[id="nav-input"]').prop("checked", false);
});
$("#item1_link").on("click", function () {
    scrolle("#item1", 1);
});
$("#item1_link_hm").on("click", function () {
    scrolle("#item1", 2);
});
$("#item2_link").on("click", function () {
    scrolle("#item2", 1);
});
$("#item2_link_hm").on("click", function () {
    scrolle("#item2", 2);
});
$("#item3_link").on("click", function () {
    scrolle("#item3", 1);
});
$("#item3_link_hm").on("click", function () {
    scrolle("#item3", 2);
});
$("#item4_link").on("click", function () {
    scrolle("#item4", 1);
});
$("#item4_link_hm").on("click", function () {
    scrolle("#item4", 2);
});
$("#item5_link").on("click", function () {
    scrolle("#item5", 1);
});
$("#item5_link_hm").on("click", function () {
    scrolle("#item5", 2);
});
$("#item6_link").on("click", function () {
    scrolle("#item6", 1);
});
$("#item6_link_hm").on("click", function () {
    scrolle("#item6", 2);
});
$("#item7_link").on("click", function () {
    scrolle("#item7", 1);
});
$("#item7_link_hm").on("click", function () {
    scrolle("#item7", 2);
});
$("#contact_link").on("click", function () {
    scrolle("#contact", 1);
});
$("#contact_link_hm").on("click", function () {
    scrolle("#contact", 2);
});
$("#information_link").on("click", function () {
    scrolle("#information", 1);
});
$("#information_link_hm").on("click", function () {
    scrolle("#information", 2);
});
function scrolle(status, num) {
    $(window).scrollTop($(status).position().top - 150);
    if (num == 2) {
        $('input[id="nav-input"]').prop("checked", false);
    }
}
