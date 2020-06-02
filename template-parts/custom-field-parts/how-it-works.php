<?php $steps = get_field('how_it_works_steps');?>
<section class="section-full-width how-it-works">
    <div class="container">
        <div class="row">
            <div class="col col-100">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="title-text">
                            <div class="widget-container">
                                <div class="heading-title">
                                    HOW IT WORKS
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-full-width how-it-works-steps">
    <div class="container">
        <div class="row">
            <?php foreach($steps as $index=>$step){ ?>        
            <div class="col col-33">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="cta-blurb">
                            <div class="widget-container">
                                <div class="cta-content">    
                                    <div class="cta-image cta-content-item">
                                        <img src="<?php echo $step['image']["url"];?>" alt="">
                                    </div>
                                    <h4 class="cta-title cta-content-item">
                                       <span class="step">STEP #<?php echo ($index+1);?></span><br>
                                        <?php echo $step["title"];?>
                                    </h4>
                                    <div class="cta-description cta-content-item">
                                        <?php echo $step['description']; ?>
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