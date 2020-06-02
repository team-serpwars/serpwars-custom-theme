
<?php $items = get_field('gallery'); ?>
<section class="section-full-width gallery-title">
    <div class="container">
        <div class="row">
            <div class="col col-100">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="title-text">
                            <div class="widget-container">
                                <div class="heading-title">
                                    RECENT WORK
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-full-width gallery">
    <div class="container">
        <div class="row">               
            <div class="col col-100" style="padding:0;">
                <div class="col-wrap">
                    <div class="widget-wrap">
                       <div class="image-gallery">
                           <div class="widget-container">
                               <div class="gallery gallery-4-cols">
                                    <?php foreach($items as $item){ ?> 
                                        <figure class="gallery-item">
                                            <div class="gallery-icon landscape">
                                                <img src="<?php echo $item['image']['url']; ?>" alt="">
                                            </div>
                                        </figure>
                                    <?php } ?>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>                
        </div>
    </div>
</section>

