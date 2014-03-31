var pubsub = _.extend(Backbone.Events);


var Space = Backbone.Model.extend({
    defaults : {
        type : 'other'
    }
});
Space.A = function (v) {
    return v.replace(/[^A-Z]/g,'').substr(0,2);
    console.log(v);
}
var SpaceCollection = Backbone.Collection.extend({model:Space});

var SpaceListingView = Backbone.View.extend({
    events : {
        'click': 'onClick'
    }    ,
    onClick : function(){
        pubsub.trigger('space:loaded', this.model);
    },
    render : function () {
        this.$el.html(this.model.get('abbr'));
        return this;
    }
});
var App = Backbone.View.extend({

    initialize: function () {
        pubsub.on('space:loaded', this.loadForm, this);
    var that = this;
        $.getJSON('spaces.json', function (json) {
            that.collection = new SpaceCollection(json.spaces);
            that.render();
        });

    },
    events : {
        'change #type' : 'typeChangeHandler',
        'blur #name' : 'nameBlurHandler'
    },
    nameBlurHandler : function (evt) {
        if (this.$el.find('#abbr').val().length > 0) {
            return;
        }
        this.$el.find('#abbr')[0].value = Space.A(evt.target.value);
        console.log('we need to generate an abbr for ' + evt.target.value);
    },
    typeChangeHandler : function (evt) {
        var method = evt.target.value === 'property' ? 'show': 'hide';
        this.$el.find('#price').closest('.form-group')[method]();
    },
    loadForm : function (model) {
        this.$el.find('#name').val(model.get('name'));;
        this.$el.find('#abbr').val(model.get('abbr'));
        this.$el.find('#price').val(model.get('price'));
        this.$el.find('#color').val(model.get('color'));
        this.$el.find('#type').val(model.get('type'));
    },
    render : function () {
        var $body= this.$el.find('.list').empty();
        var ret;
        
        this.collection.each(function (model) {
            var v = new SpaceListingView({model:model});
            $body.append(v.render().$el);
        });
        
//        $body.html('asf');
        return this;
    }
});

new App({el:$('body')});
