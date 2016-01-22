<!-- Main Column Start -->
<?php
$debug = 0;
if ($debug == CONST_ACTIVATE) {
    echo '<pre>';
    print_r($news);
    echo '</pre>';
}
?>
<div class="main_column">
    <div class="">
        <h2>Issue Topics</h2>
        <?php
        if (count($issue_topics) > 0) {
            foreach ($issue_topics as $row) {
                ?>
                <div class="list">
                    <h3><a href="<?php echo base_url() . FN_ISSUE_CATEGORY . $row['slug_alias']; ?>"><?php echo ucfirst(stripslashes($row['category_title'])); ?></a></h3>
                    <p class="date">Posted on <?php echo $row['created_on'] ?></p>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="list">

                <div class="news_content">
                    <p>No record found.</p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- Main Column End -->