<section class="section-full-width blurb-image">
    <div class="container">
        <div class="row">
            <div class="col col-50 left_column_section ">
                <div class="col-wrap">
                    <div class="widget-wrap blog-info">
                        <div class="widget-heading">
                            <div class="widget-container">
                                <h1 class="heading-title">
                                    <?php echo get_field('heading');?>
                                </h1>
                            </div>
                            <div class="widget-container">
                                <p>
                                    <?php echo get_field('description');?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-50">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="widget-heading">
                            <div class="widget-container">
                                <div class="image">
                                    <img src="<?php echo get_field('image')['url']; ?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>