<?php 
    $loaded = get_field('what_we_do_alternating');
    $listings = array();

    foreach($loaded as $index => $item){
        if($index % 2==0){

            array_push($listings,[
                'class'=>'image-left',
                'item'=>$item
            ]);
        }else{
            array_push($listings,[
                'class'=>'image-right',
                'item'=>$item
            ]);
        }       
    }
    // $items = set_two_columns($loaded);
?>
<style>


</style>
<section class="section-full-width what-we-do">
    <div class="container">
        <div class="row">
            <div class="col col-100">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="title-text">
                            <div class="widget-container">
                                <div class="heading-title">
                                    WHAT WE DO
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php foreach($listings as $listing){ ?>
    <?php if($listing['class']=='image-left'){ ?>
<section class="section-full-width what-we-do-listing-item <?php echo $listing['class'];?>">
    <div class="container">
        <div class="row">
            <div class="col col-100">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="blurb">
                            <a href="<?php echo $listing['item']['link'];?>" class="blurb">
                                <div class="blurb-bg-wrapper">
                                    <div class="blurb-bg" style="background-image:url('<?php echo $listing['item']['image']['url'];?>');"></div>
                                </div>
                                <div class="blurb-content">
                                    <h3 class="blurb-content-item blurb-title"><?php echo $listing['item']['title'];?></h3>
                                    <div class="blurb-content-item blurb-description"><?php echo $listing['item']['content'];?></div>
                                    <div class="blurb-content-item button-wrapper">
                                        <button class="btn">Learn More</button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
    <?php }else{ ?>
<section class="section-full-width what-we-do-listing-item <?php echo $listing['class'];?>">
    <div class="container">
        <div class="row">
            <div class="col col-100">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="blurb">
                            <a href="<?php echo $listing['item']['link'];?>" class="blurb">
                                <div class="blurb-content">
                                    <h3 class="blurb-content-item blurb-title"><?php echo $listing['item']['title'];?></h3>
                                    <div class="blurb-content-item blurb-description"><?php echo $listing['item']['content'];?></div>
                                    <div class="blurb-content-item button-wrapper">
                                        <button class="btn">Learn More</button>
                                    </div>
                                </div>
                                <div class="blurb-bg-wrapper">
                                    <div class="blurb-bg" style="background-image:url('<?php echo $listing['item']['image']['url'];?>');"></div>
                                </div>                                
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>     
    <?php } ?>
<?php } ?>
