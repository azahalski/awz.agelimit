(function() {
    'use strict';
    if (!!window.AwzAgeLimitComponent) {
        return;
    }
    window.AwzAgeLimitComponent = function(options) {
        this.signedParameters = options.signedParameters;
        this.ajaxTimer = (!!options.ajaxTimer ? options.ajaxTimer : false) || 100;
        var parent = this;
        BX.bindDelegate(
            document.body, 'click', {className: 'awz_agelimit__close'},
            function(e){
                BX.remove(BX('awz_agelimit__message'));
                return BX.PreventDefault(e);
            }
        );
        BX.bindDelegate(
            document.body, 'click', {className: 'awz_agelimit__save'},
            function(e){
                parent.allow();
                return BX.PreventDefault(e);
            }
        );
    };
    window.AwzAgeLimitComponent.prototype = {
        allow: function(){
            var parent = this;
            BX.remove(BX('awz_agelimit__message'));
            setTimeout(function(){
                BX.ajax.runComponentAction('awz:window.agelimit', 'allow', {
                    mode: 'class',
                    data: {
                        signedParameters: parent.signedParameters,
                        method: 'POST'
                    }
                });
            },this.ajaxTimer);
        },
        resize: function(){}
    };
})();