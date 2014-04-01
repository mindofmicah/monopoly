require.config({
    paths : {
        'jquery' : 'app/bower_components/jquery/dist/jquery',
        'underscore':'app/bower_components/underscore/underscore',
        'backbone':'app/bower_components/backbone/backbone'
    }
});

require (['jquery', 'underscore', 'backbone'], function ($, _, Backbone)  {
    'use strict';
    var pubsub = _.extend(Backbone.Events);


    var Space = Backbone.Model.extend({
        defaults : {
            type : 'other'
        }
    });
    Space.A = function (v) {
        return v.replace(/[^A-Z]/g,'').substr(0,2);

    };
    var SpaceCollection = Backbone.Collection.extend({model:Space});
    
    var SpaceListingView = Backbone.View.extend({
        tagName:'li',
        className:'list-group-item',
        events : {
            'click': 'onClick'
        }    ,
        initialize: function () {
            this.listenTo(this.model, 'change', this.render);
        },
        onClick : function(){
            this.$el.siblings('.list-group-item-info').removeClass('list-group-item-info');;
            this.$el.addClass('list-group-item-info');
            pubsub.trigger('space:loaded', this.model);
        },
        render : function () {
            this.$el.html(this.model.get('name'));
            if (this.model.get('price')) {
                this.$el.prepend($('<span class="badge">$'+this.model.get('price')+'</span>'));
            }
            return this;
        }
    });
    var App = Backbone.View.extend({
    
        initialize: function () {
            pubsub.on('space:loaded', this.loadForm, this);
            var that = this;
            this.collection = new SpaceCollection();
            $.getJSON('spaces.json', function (json) {
                that.collection = new SpaceCollection(json.spaces);
                
                that.listenTo(that.collection, 'change', that.reloadTextarea);
                that.render();

            });   
        },
        reloadTextarea : function (a,b,c) {
            this.$el.find('textarea').val(JSON.stringify({spaces:this.collection.toJSON()}));
        },
        events : {
            'change #type' : 'typeChangeHandler',
            'blur #name' : 'nameBlurHandler',
            'submit':'saveModel'
        },
        saveModel : function (evt) {
            evt.preventDefault();
            if (this.model) {
                this.model.set({
                    'name':this.$el.find('#name').val(),
                    'abbr':this.$el.find('#abbr').val(),
                    'price':this.$el.find('#price').val(),
                    'color':this.$el.find('#color').val(),
                    'type':this.$el.find('#type').val(),
                });
             }
        },
        nameBlurHandler : function (evt) {
            if (this.$el.find('#abbr').val().length > 0) {
                return;
            }
            this.$el.find('#abbr')[0].value = Space.A(evt.target.value);
        },
        typeChangeHandler : function (evt) {
            var method = evt.target.value === 'property' ? 'show': 'hide';
            this.$el.find('#price').closest('.form-group')[method]();
        },
        loadForm : function (model) {
            this.model = model;
            this.$el.find('#name').val(model.get('name'));
            this.$el.find('#abbr').val(model.get('abbr'));
            this.$el.find('#price').val(model.get('price'));
            this.$el.find('#color').val(model.get('color'));
            this.$el.find('#type').val(model.get('type'));
        },
        render : function () {
            var $body= this.$el.find('.list').empty();
            
            this.collection.each(function (model) {
                var v = new SpaceListingView({model:model});
                $body.append(v.render().$el);
            });
            
            return this;
        }
    });
    
    var app = new App({el:$('body')});
    app.render();
});
