<?php
    $items  = get_field('additional_listing');
    foreach($items as $item){
?>
<section class="section-full-width simple-listing">
    <div class="container">
        <div class="row">
            <div class="col col-100 column_section">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="widget-text">
                            <div class="widget-container">
                                <div class="heading-title">
                                    <?php echo $item['listing_heading'];?>
                                </div>
                            </div>
                        </div>
                        <div class="widget-text">
                            <div class="widget-container">
                                <div class="listing-content">
                                    <p><?php echo $item['listing_content'];?></p>  
                                </div>                                                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
