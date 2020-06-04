<?php
	$items = get_field('testimonials');
	foreach($items as $item){
?>
<section class="section-full-width testimonial p1">
    <div class="container">
        <div class="row">
            <div class="col col-33 left_column_section">
               <div class="col-wrap">
                    <div class="quote">
                        <div class="widget-container">
                            <div class="elementor-text-editor">
                                <p>
                                    <i class="fa fa-quote-left"></i>
                                    <?php echo $item['content'];?>
                                    <i class="fa fa-quote-right"></i>
                                </p>
                                <hr>
                                <p class="testimonial-name" style="font-size:16px;">
                                    <em><?php echo $item['name'];?></em>
                                </p>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
            <div class="col col-66 p0">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="widget-image">
                            <div class="widget-container">
                                <div class="image">
                                    <img src="<?php echo $item['image']['url'];?>" alt="">
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