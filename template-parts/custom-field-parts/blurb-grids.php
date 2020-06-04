<style>

</style>
<?php 
    $loaded = get_field('image_grids');
    $items = set_items_per_row($loaded,4);

foreach($items as $item){ ?>
<section class="section-full-width image-grids">
    <div class="container">
        <div class="row">
        <?php foreach($item as $listing){ ?> 
            <div class="col col-25">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="blurb">
                            <a href="<?php echo $listing['link']['url'];?>" class="blurb">
                                <div class="blurb-bg-wrapper">
                                    <div class="blurb-bg" style="background-image:url('<?php echo $listing['image']['url'];?>');"></div>
                                    <div class="blurb-bg-overlay"></div>
                                </div>
                                <div class="blurb-content">
                                    <h3 class="blurb-content-item blurb-title"><?php echo $listing['title'];?></h3>
                                    <div class="blurb-content-item blurb-description"><?php echo $listing['content'];?></div>
                                    <div class="blurb-content-item button-wrapper">
                                    
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</section> 
<?php } ?>