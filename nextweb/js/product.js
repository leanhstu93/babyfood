var Product = function () {
    return Product.fn.init();
};

Product.fn = Product.prototype = {

    config: {
        viewBy: 'grid', // grid|list
        selectorSlidePrice: '#slider-range',
        selectorAmout: '#amount',
        selectorPriceMin: '.price_min',
        selectorPriceMax: '.price_max',
    },

    init: function () {
        var $body = $('body');
        this.rangerSlider();
    },
    addCommas : function (nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    },
    rangerSlider : function (){
        var self = this;
        var sliderrange = $(self.config.selectorSlidePrice);
        var amountprice = $(self.config.selectorAmout);
        var price_min   = Number($(self.config.selectorSlidePrice).data('min'));
        var price_max   = Number($(self.config.selectorSlidePrice).data('max'));
        var step        = Number($(self.config.selectorSlidePrice).data('step'));
        var price_min_val   = Number($(self.config.selectorSlidePrice).data('val-min'));
        var price_max_val   = Number($(self.config.selectorSlidePrice).data('val-max'));
        sliderrange.slider({
            range: true,
            min: price_min,
            max: price_max,
            values: [price_min_val, price_max_val],
            step: step,
            slide: function(event, ui) {
                amountprice.val(self.addCommas(ui.values[0]) + "đ"  + " - " + self.addCommas(ui.values[1]) + "đ");
                $(self.config.selectorPriceMin).val(ui.values[0]);
                $(self.config.selectorPriceMax).val(ui.values[1]);
            },
            stop: function(event, ui){
                sliderrange.closest('form').submit();
            }
        });
        amountprice.val(self.addCommas(sliderrange.slider("values", 0)) + "đ" +
            " - " + self.addCommas(sliderrange.slider("values", 1)) + "đ");
    }


};

var product = new Product();
