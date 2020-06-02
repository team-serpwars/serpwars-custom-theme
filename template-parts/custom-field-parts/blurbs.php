<?php  $items = get_field('call_to_action_blurbs');?>
<style>
    .section-full-width .row{
        width:100%;
        display:flex;
    }
    .col{
        padding: 10px;
        min-height: 20vw;
        display:flex;
        position:relative;
    }
    .col-25{
        width:25%;    
    }
    .blurb-section .icon{
        color: #df1c22;
        border-color: #df1c22;
        font-size: 75px;
    }
    .blurb-section .cta-content-item{
        text-align: center;
        font-size: 2vw;
        font-weight: 900;
        text-transform: uppercase;
        color: #333333;
        font-size:27px;
    }
    .blurb-section .col{
        border: 3px solid #efefef;
        margin:10px 5px 10px 0px;
    }
    .blurb-section .cta-content .cta-icon{
        margin-bottom: 15px;
        width: 100%;
        text-align:center;
    }
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
