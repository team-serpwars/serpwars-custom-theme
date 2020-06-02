<?php 
    $loaded = get_field('why_choose_us_listings');
    $items = set_two_columns($loaded);
?>
<section class="section-full-width why-choose-us">
    <div class="container">
        <div class="row">
            <div class="col col-100">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="title-text">
                            <div class="widget-container">
                                <div class="heading-title">
                                    WHY CHOOSE US?
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php foreach($items as $item) { ?>
<section class="section-full-width why-choose-us-listings">
    <div class="container">
        <div class="row">
            <?php foreach($item as $listing){ ?>        
            <div class="col col-50">
                <div class="col-wrap">
                    <div class="widget-wrap">                    
                        <div class="cta-layout-image-left">                        
                            <div class="widget-container">
                                <div class="cta-blurb">
                                    <div class="cta-bg-wrapper" style="background-image:url('<?php echo $listing['image']['url'];?>')">
                                    </div>
                                    <div class="cta-content">  
                                        <h4 class="cta-title cta-content-item">
                                            <?php echo $listing["title"];?>
                                        </h4>
                                        <div class="cta-description cta-content-item">
                                            <?php echo $listing['description']; ?>
                                        </div>  
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
            <?php } ?>
        </div>
    </div>
</section>
<?php } ?>
