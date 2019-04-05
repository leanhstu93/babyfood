var Product = function () {
    return Product.fn.init();
};

Product.fn = Product.prototype = {

    init: function () {
        var $body = $('body');

    },

    rangerSlider : function (){
        var sliderrange = $obj;
        var amountprice = $('#amount');
        var price_min   = Number($obj.data('min'));
        var price_max   = Number($obj.data('max'));
        var step        = Number($obj.data('step'));
        var price_min_val   = Number($obj.data('val-min'));
        var price_max_val   = Number($obj.data('val-max'));
        sliderrange.slider({
            range: true,
            min: price_min,
            max: price_max,
            values: [price_min_val, price_max_val],
            step: step,
            slide: function(event, ui) {
                amountprice.val(addCommas(ui.values[0]) + "Ä‘"  + " - " + addCommas(ui.values[1]) + "Ä‘");
                $('.price_min').val(ui.values[0]);
                $('.price_max').val(ui.values[1]);
            },
            stop: function(event, ui){
                if(!$('.frm-filter').length) {
                    return;
                }
                filter();
            }
        });
        amountprice.val(addCommas(sliderrange.slider("values", 0)) + "Ä‘" +
            " - " + addCommas(sliderrange.slider("values", 1)) + "Ä‘");
    }


};

var product = new Product();
