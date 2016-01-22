
<script type="text/javascript" src="<?php echo base_url() . CONST_PATH_ASSETS_FRONT_SCRIPTS;?>jquery.bxslider.js"></script>
<script type="text/javascript">
    $('.bxslider').bxSlider({
        minSlides: 1,
        maxSlides: 5,
        slideWidth: 170,
        slideMargin: 0,
        pager: false
    });

    $(".nav_header h2 a").click(function (e) {
        e.preventDefault();
        $("nav ul").slideToggle();
        $("nav ul").toggleClass("show");
    });
</script>