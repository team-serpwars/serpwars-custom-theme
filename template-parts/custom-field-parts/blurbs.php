<?php  $items = get_field('call_to_action_blurbs');?>
<style>

</style>
<section class="section-full-width blurb-section">
    <div class="container">
        <div class="row">
            <?php foreach($items as $item){ ?>        
            <div class="col col-25">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="cta-blurb">
                            <div class="widget-container">
                                <div class="cta-content">
                                    <div class="cta-icon">
                                        <div class="icon">
                                            <i class="<?php echo $item['icon']; ?>"></i>
                                        </div>
                                    </div>
                                    <div class="cta-content-item"><?php echo $item['description']; ?>
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
