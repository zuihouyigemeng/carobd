/**
 * layout方法扩展
 * @param {Object} jq
 * @param {Object} region
 */
$.extend($.fn.layout.methods, {  
	/**
	 * 移除header
	 * @param {Object} jq
	 * @param {Object} region
	 */
    removeHeader: function(jq, region){  
        return jq.each(function(){  
            var panel = $(this).layout("panel",region);
            if(panel){
                panel.panel('removeHeader');
				panel.panel('resize');
            }
        });  
    },
	/**
	 * 增加header
	 * @param {Object} jq
	 * @param {Object} params
	 */
    addHeader:function(jq, params){
        return jq.each(function(){  
            var panel = $(this).layout("panel",params.region);
			var opts = panel.panel("options");
            if(panel){
				var title = params.title?params.title:opts.title;
                panel.panel('addHeader',{title:title});
				panel.panel('resize');
            }
        });
    },
    /**  
     * 面板是否存在和可见  
     * @param {Object} jq  
     * @param {Object} params  
     */  
    isVisible: function(jq, params) {   
        var panels = $.data(jq[0], 'layout').panels;   
        var pp = panels[params];   
        if(!pp) {   
            return false;   
        }   
        if(pp.length) {   
            return pp.panel('panel').is(':visible');   
        } else {   
            return false;   
        }   
    },   
    /**  
     * 隐藏除某个region，center除外。  
     * @param {Object} jq  
     * @param {Object} params  
     */  
    hidden: function(jq, params) {   
        return jq.each(function() {   
            var opts = $.data(this, 'layout').options;   
            var panels = $.data(this, 'layout').panels;   
            if(!opts.regionState){   
                opts.regionState = {};   
            }   
            var region = params;   
            function hide(dom,region,doResize){   
                var first = region.substring(0,1);   
                var others = region.substring(1);   
                var expand = 'expand' + first.toUpperCase() + others;   
                if(panels[expand]) {   
                    if($(dom).layout('isVisible', expand)) {   
                        opts.regionState[region] = 1;   
                        panels[expand].panel('close');   
                    } else if($(dom).layout('isVisible', region)) {   
                        opts.regionState[region] = 0;   
                        panels[region].panel('close');   
                    }   
                } else {   
                    panels[region].panel('close');   
                }   
                if(doResize){   
                    $(dom).layout('resize');   
                }   
            };   
            if(region.toLowerCase() == 'all'){   
                hide(this,'east',false);   
                hide(this,'north',false);   
                hide(this,'west',false);   
                hide(this,'south',true);   
            }else{   
                hide(this,region,true);   
            }   
        });   
    },   
    /**  
     * 显示某个region，center除外。  
     * @param {Object} jq  
     * @param {Object} params  
     */  
    show: function(jq, params) {   
        return jq.each(function() {   
            var opts = $.data(this, 'layout').options;   
            var panels = $.data(this, 'layout').panels;   
            var region = params;   
  
            function show(dom,region,doResize){   
                var first = region.substring(0,1);   
                var others = region.substring(1);   
                var expand = 'expand' + first.toUpperCase() + others;   
                if(panels[expand]) {   
                    if(!$(dom).layout('isVisible', expand)) {   
                        if(!$(dom).layout('isVisible', region)) {   
                            if(opts.regionState[region] == 1) {   
                                panels[expand].panel('open');   
                            } else {   
                                panels[region].panel('open');   
                            }   
                        }   
                    }   
                } else {   
                    panels[region].panel('open');   
                }   
                if(doResize){   
                    $(dom).layout('resize');   
                }   
            };   
            if(region.toLowerCase() == 'all'){   
                show(this,'east',false);   
                show(this,'north',false);   
                show(this,'west',false);   
                show(this,'south',true);   
            }else{   
                show(this,region,true);   
            }   
        });   
    },
    /**
     * 设置某个region的宽度或者高度(不支持center)
     * @param {[type]} jq     [description]
     * @param {[type]} params [description]
     */
    setRegionSize:function(jq,params){
        return jq.each(function(){
            if(params.region=="center")
                return;
            var panel = $(this).layout('panel',params.region);
            var optsOfPanel = panel.panel('options');
            if(params.region=="north" || params.region=="south"){
                optsOfPanel.height = params.value;
            }else{
                optsOfPanel.width = params.value;
            }
            $(this).layout('resize');
        });
    },
    /**
     * 设置north south east west区域标题的图标
     * @param {[type]} jq     [description]
     * @param {[type]} params [description]
     */
    setHeaderIcon:function(jq,params){
        return jq.each(function(){
            if(params.region=="center")
                return;
            var panel = $(this).layout('panel',params.region);
            var title = panel.panel('header').find('>div.panel-title');
            var icon = panel.panel('header').find('>div.panel-icon');
            if(icon.length===0){
                if(title.length && params.iconCls != null){
                    $('<div class="panel-icon ' + params.iconCls + '"></div>').insertBefore(title);
                    title.addClass('panel-with-icon');
                }
            }else{
                if(params.iconCls == null){
                    icon.remove();
                    title.removeClass('panel-with-icon');
                }else{
                    icon.attr('class','').addClass('panel-icon ' + params.iconCls);
                }              
            }   
        });
    },
    /**
     * 设置north south east west的split是否可以拖动
     * @param {[type]} jq     [description]
     * @param {[type]} params [description]
     */
    setSplitActivateState:function(jq,params){
        return jq.each(function(){
            if(params.region=="center")
                return;
            $(this).layout('panel',params.region).panel('panel').resizable(params.disabled?'disable':'enable');
        });
    },
    /**
     * 设置north south east west的split是否显示
     * @param {[type]} jq     [description]
     * @param {[type]} params [description]
     */
    setSplitVisiableState:function(jq,params){
        return jq.each(function(){
            if(params.region=="center")
                return;
            var panel = $(this).layout('panel',params.region);
            panel.panel('options').split = params.visible;
            if(params.visible){
                panel.panel('panel').addClass('layout-split-north');
            }else{
                panel.panel('panel').removeClass('layout-split-north');
            }
            //panel.panel('resize');
            $(this).layout('resize');
        });
    },
    /**
     * 设置region的收缩按钮是否可见
     * @param {[type]} jq     [description]
     * @param {[type]} params [description]
     */
    setRegionToolVisableState:function(jq,params){
        return jq.each(function(){
            if(params.region=="center")
                return;
            var panels = $.data(this, 'layout').panels;
            var panel = panels[params.region];
            var tool = panel.panel('header').find('>div.panel-tool');
            tool.css({display:params.visible?'block':'none'});
            var first = params.region.substring(0,1);   
            var others = params.region.substring(1);   
            var expand = 'expand' + first.toUpperCase() + others;  
            if(panels[expand]){
                panels[expand].panel('header').find('>div.panel-tool').css({display:params.visible?'block':'none'});
            }
        });
    }
});