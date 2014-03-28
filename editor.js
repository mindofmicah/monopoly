var pubsub = _.extend(Backbone.Events);
console.log(pubsub);

var Space = Backbone.Model.extend();
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
//            for(var i =0; i < json.spaces.length; i++) {
            
  //          }
    //        console.log(json);
            that.render();
        });

    },
    loadForm : function (model) {

        this.$el.find('#abbr').val(model.get('abbr'));

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
