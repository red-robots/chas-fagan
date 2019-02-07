jQuery(document).ready(function($){

    var start_page = 1;
        loading  = false; 
        end_record = false;

    var $container = $('#results');

    
    function portfolio_contents(el) {
        var sel = el;
        $('#spinner').hide();
        var termID = $("input#termID").val();
        var tax = $("input#taxonomy").val();
        var pagenum = $("input#perpage").val();
        var node = $(".masonry");
        var imgLoaded = imagesLoaded(node);
        var isMounted = true;

        if(loading == false && end_record == false){
            loading = true; //set loading flag on
            $.ajax({
                type : "post",
                dataType : "json",
                async : false,
                url : ajax_url.ajaxurl,
                data : {
                    action: "load_more", 
                    page : start_page,
                    taxonomy: tax,
                    term_id : termID,
                    perpage : pagenum
                },
                beforeSend:function(response){
                    $('#spinner').show();

                },
                success: function(response) {
                    var html_content = response.content;
                    if(html_content) {
                        sel.append(html_content);
                        setTimeout(function(){
                            //sel.append(html_content);  //append content
                            $(".box").removeClass("newEntry");
                        },1000);

                        loading = false;  //set loading flag off
                        start_page ++; //page increment
                    } else {
                        $('#spinner').hide();
                        end_record = true;
                    }
                },
                complete:function(response){
                    click_action();
                    set_pop_up();
                    setTimeout(function(){
                        $('#spinner').hide();
                    },500);
                    var obj = response.responseJSON;
                    var content = obj.content;
                    if(content==false) {
                       end_record = true;
                    } 
                }
            });
        }

        if(end_record) {
            $('#spinner').hide();
        }
    }

    function set_pop_up() {
        $('.colorbox').colorbox({
            rel:'gal',
            maxWidth: '95%',
            maxHeight: '90%'
        });
    }

    function click_action() {
        $(".box-with-link").on("click",function(){
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
    }

    var screen_size = $("#page").outerWidth();

    load_more_entries(screen_size);

    function load_more_entries(screen_size) {
        if(screen_size>=780) {
            $(".tax-arttypes #page").on('scroll', function () {
                if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                    portfolio_contents( $("#results") );
                }
            });
        } else { 
            $(window).on('scroll', function() {
                if( $(window).scrollTop() >= $('#results').offset().top + $('#results').outerHeight() - window.innerHeight ) {
                    portfolio_contents( $("#results") );
                }
            });
        }
    }

     $(window).on('resize', function(){
        screen_size = $("#page").outerWidth();
        load_more_entries(screen_size);
    });

    

});
