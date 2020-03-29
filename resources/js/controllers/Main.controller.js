let config = require('../artist4artist.config');
let trans = require('../classes/Translation');

let Main = new (function(w) {

    this.init = function() {
        this.loadPlugins();
    };

    this.loadPlugins = function () {
        $.each($("[data-autoload='select2']"), function () {
            let $this = $(this);

            $this.select2({
                'tags': $this.attr('data-select2-tags') ? true : false
            });
        });
    }

})(window);

window.InterfaceController = Main;
