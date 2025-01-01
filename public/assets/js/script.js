$(function () {
    $(".wrapper").fadeOut(4000, function () {
        $("#loader_bg").fadeOut(1000)
    })
})

$("#checkbox").on("change", function () {
    if ($(this).is(":checked")) {
        $("html").addClass("dark");
        $("#logo").attr("src", "../../public/assets/imgs/logo light.svg")
    } else {
        $("html").removeClass("dark");
        $("#logo").attr("src", "../../public/assets/imgs/logo dark.svg")

    }

})