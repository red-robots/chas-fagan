jQuery(document).ready(function($){

    var start_page = 1;
        loading  = false; 
        end_record = false;

    var $container = $('.project-container');
    var $autoload = 0;
    var $gallery_collapse = 0;

    trigger_gallery_click();
    set_fancybox();
    function set_fancybox() {
        $("a[class^='gallery-']").off();
        $("a[class^='gallery-']").fancybox({
                image : {
                        protect: true
                },
                afterLoad: function (slide) {
                        trigger_gallery_collapse_click();
                        $('.page-template-template-projects .fancybox-button').on('click',function(){
                                var state = $(this).data('state');


                                switch(state){
                                        case 1 :
                                        case undefined : 
                                                $(this).data('state', 2); 
                                                $('.fancybox-slider-wrap').css('width','68%');
                                                break;
                                        case 2 : 
                                                $(this).data('state', 1); 
                                                $('.fancybox-slider-wrap').css('width','80%');
                                                break;
                                }
                        });
                },
                setContent : function (slide, content) {
                        // console.log('set content');
                        // console.log(slide);
                        // console.log(content);
                },       
                afterMove : function (slide, content) {
                        //console.log('set content');
                        if($gallery_collapse == 1) {
                            $('.page-template-template-projects .fancybox-caption-wrap .content').css('display','block');
                            $('.gallery-collapse').html('Close Details');
                        }
                        else{
                            $('.gallery-collapse').html('View Details');
                        }
                        trigger_gallery_collapse_click();

                },       
        });
    }

    function trigger_gallery_click() {
        $('.project-gallery-thumb').off();
        $('.project-gallery-thumb').on('click', function(e){
            e.preventDefault();
            $(this).closest('.img-container').find('.parent').trigger('click');
        });
    }

    function trigger_gallery_collapse_click() {
        $('.gallery-collapse').off();
        $('.gallery-collapse').on('click', function(e){
            e.preventDefault();
            
            var state = $(this).data('state');
            switch(state){
                case 1 :
                case undefined : 
                        $(this).data('state', 2); 
                        if($gallery_collapse == 0) {
                            $('.fancybox-caption-wrap').css('top','0');
                            $('.page-template-template-projects .fancybox-caption-wrap .content').css('display','block');
                            $(this).html('Close Details');
                            $gallery_collapse = 1;
                        }
                        else {
                            $('.fancybox-caption-wrap').css('top','auto');
                            $('.page-template-template-projects .fancybox-caption-wrap .content').css('display','none');
                            $(this).html('View Details');
                            $gallery_collapse = 0;
                        }
                        break;
                case 2 : 
                        $(this).data('state', 1);
                        if($gallery_collapse == 0) {
                            $('.fancybox-caption-wrap').css('top','0');
                            $('.page-template-template-projects .fancybox-caption-wrap .content').css('display','block');
                            $(this).html('Close Details');
                            $gallery_collapse = 1;
                        }
                        else {
                            $('.fancybox-caption-wrap').css('top','auto');
                            $('.page-template-template-projects .fancybox-caption-wrap .content').css('display','none');
                            $(this).html('View Details');
                            $gallery_collapse = 0;
                        }
                        break;
            }
            $(this).closest('.img-container').find('.parent').trigger('click');
        });
    }

    function project_contents(el){
        var sel = el;
        var loading_gif_url = image_dir + "loader.gif";
        var load_img = '<div style="display:inline-block;padding:20px 0"><img src="'+loading_gif_url+'" class="loading" /> <i>LOADING IMAGES...</i></div>';
        $('#spinner').html(load_img);
    
        if(loading == false && end_record == false){
            loading = true; //set loading flag on
            $.ajax({
                type : "post",
                dataType : "json",
                async : false,
                url : ajax_url.ajaxurl,
                data : {
                    action: "load_more", 
                    page : start_page
                },
                beforeSend:function(){
                    $('#spinner').html(load_img);
                },
                success: function(response) {
                    var html_content = response.content;
                    if(html_content) {
                        sel.append(html_content);  //append content 
                        loading = false;  //set loading flag off
                        start_page ++; //page increment
                    } else {
                        $('#spinner').html("");
                        end_record = true;
                        return; //exit
                    }
                },
                complete:function(){
                    $('#spinner').html("");
                    trigger_gallery_click()
                }
            });
            //$('#spinner').html("");
        }
        if(end_record) {
            $('#spinner').html("");
        }
    }

    
    $(window).scroll(function() { //detact scroll
        project_contents( $("#results") ); //load content chunk 
    }); 

});
