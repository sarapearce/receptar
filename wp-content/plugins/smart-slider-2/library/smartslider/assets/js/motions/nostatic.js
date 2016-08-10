(function ($, scope, undefined) {

    scope.ssAnimationNoStatic = scope.ssAnimation.extend({
        init: function (layer, options) {
            this._super(layer, options);
        },
        _setInStart: function () {
        },
        _animateIn: function () {
            this.endFN = 'onAnimateInEnd';
            this.layer.css('left', 0);
            this['onAnimateInEnd']();
        },
        _animateOut: function () {
            this.endFN = 'onAnimateOutEnd';
            this.layer.css('left', '-1000%');
            this['onAnimateOutEnd']();
        }
    });

    scope.ssAnimationManager.addAnimation('nostatic', scope.ssAnimationNoStatic, {});

})(njQuery, window);