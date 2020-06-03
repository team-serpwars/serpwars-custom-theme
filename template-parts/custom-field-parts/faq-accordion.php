<?php
    $items  = get_field('faq_items');
    
?>
<style>
    .faq-accordion .accordion-control{
        display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -webkit-flex-flow: row nowrap;
    -ms-flex-flow: row nowrap;
    flex-flow: row nowrap;
    -webkit-box-pack: start;
    -webkit-justify-content: flex-start;
    -ms-flex-pack: start;
    justify-content: flex-start;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    cursor: pointer;
    justify-content: flex-start;
    padding: 20px 20px 20px 20px;

    }
    .faq-accordion .accordion-control-label-text{
        color: #333333;
        font-size: 2vw;
        font-weight: 500;
        line-height: 28px;
    }    
    .faq-accordion .accordion-content-inner{
        font-size: 1.5vw;
        font-weight: 300;
        color: #7a7a7a;
    }
    .faq-accordion .accordion-label-icon{
        color: #df1c22;
        background-color: #f7f7fb;
        font-size: 14px;
        width: 32px;
        height: 32px;
        padding-top: 10px;
    }
    .faq-accordion .accordion-label-icon{
        display:flex;
    }
    .faq-accordion .accordion-content-inner{
        padding: 0px 40px 10px 40px;
    }
</style>
<section class="section-full-width faq-accordion">
    <div class="container">
        <div class="row">
            <div class="col col-100">
                <div class="col-wrap">
                    <div class="widget-wrap">
                        <div class="widget-text">
                            <div class="widget-container">
                                <div class="accordion">
                                    <div class="accordion-inner">
                                        <?php foreach($items as $item){  ?>
                                            <div class="accordion-item">
                                                <div class="accordion-control">
                                                    <div class="accordion-label-icon">
                                                        <i class="fa fa-chevron-right"></i>
                                                        <!-- <i class="fa fa-chevron-down"></i> -->
                                                    </div>
                                                    <div class="accordion-control-label-text">
                                                        <?php echo $item['question'];?>
                                                    </div>
                                                </div>
                                                <div class="accordion-content">
                                                    <div class="accordion-content-inner">
                                                        <?php echo $item['answer'];?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

