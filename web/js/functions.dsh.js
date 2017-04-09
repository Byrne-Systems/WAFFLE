(function() {

    /* Divider */
    var Divider = {
        fill: function(n,character) {
            d = Array(n).join(character);
            $('span.divider').html(d);
        }
    }

    /* Window */
    var Window = {
        getDimensions: function() {
            window.addEventListener("resize", function(){
                (window.innerWidth <= 320) ? Divider.fill(30, '/') : Divider.fill(44, '/');
            }, false);
        }
    }

    Window.getDimensions();                                                                         // init

})();