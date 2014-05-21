$(document).ready(function() {

    // $('#sidebar').affix({
    //     offset: {
    //         top: 235
    //     }

    // });

    var $body     = $(document.body);
    var navHeight = $('.navbar').outerHeight(true) + 10;

    $body.scrollspy({
        target: '#leftCol',
        offset: navHeight
    });

    /* smooth scrolling sections */
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top - 50
                }, 1000);
                return false;
            }
        }
    });

    hljs.configure({tabReplace: '    '}); // 4 spaces
    $('pre code').each(function(i, e) {hljs.highlightBlock(e)});


    $('body').on('click', '.remove-node', function() {
        $(this).parents('.form-group:first').remove();
    });

    $('body').on('click', '.availables .form-group:last input', function() {
        $('.availables > .form-group:first').clone()
                                            .find('input:eq(0)').val('').attr('placeholder', 'Key').end()
                                            .find('input:eq(1)').val('').attr('placeholder', 'Value').end()
                                            .appendTo('.availables');
    });

});

/**
 * Resize iFrame.
 *
 * @param  string id
 * @return void
 */
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
