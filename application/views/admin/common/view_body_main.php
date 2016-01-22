<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="index.html">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <?php
                if (!empty($content['breadcrumb'])) {
                    echo $content['breadcrumb'];
                }
                ?>
            </ul>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="row">
            <div class="col-xs-12">
                <?php
                if (!empty($content['page_content'])) {
                    echo $content['page_content'];
                }
                ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- END CONTENT -->

