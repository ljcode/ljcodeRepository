/**
* JQuery.windswaterflow.js
* waterflow
* @author : winds
* @qq : 342377
* @version :v1.2
* @create :2012.04.25
* @update : 2012.04.26 
* 1、模版在firefox下报错是因为查找<script id='tpl'>的错误，具体原因暂不知道
* 2、增加boxTemplate参数，直接把模版传进来，用{参数}来表示参数
* 3、直接在里面通过match和replace简单替换，没有复杂的json数组替换
* 4、增加scroll通过settimeout响应，看起来效果好些，可以去掉
* 5、增加page参数，方便用户通过页数和num请求服务端拿box
* 6、增加maxPage参数，默认为0，设置为0时则可以无限滚动获取，设置为int值时则当页面达到最大值时不能滚动获取
* @update : 2012.05.19
* 1、修改当后台无数据返回时一直加载中的bug 
* 2、增加noSelector选择项，当无数据返回时显示,2秒后隐藏（例子为10页）
* 3、增加callback事件，当初次加载和滚动加载成功后回调事件，例子中为绑定鼠标经过事件显示喜欢和评论按钮
* 4、demo增加喜欢和评论按钮
*/
; (function($) {
    $.fn.windswaterflow = function(options) {
        //初始化状态
        var _init = 0, _isminCols = false, _isnoShow = false;
        var defaults = {
            itemSelector: '',
            loadSelector: '',
            noSelector: '',
            boxTemplate: '',
            columnWidth: 240,
            marginWidth: 14,
            marginHeight: 16,
            minCols: 3,
            maxPage: 0,
            align: 'center',
            ajaxServer: '',
            boxParam: '',
            pageParam: 'page',
            pageNumber: 1,
            init: false,
            initBoxNumber: 20,
            scroll: false,
            scrollBoxNumber: 10,
            callback: null
        };
        //参数合并
        var param = $.extend({}, defaults, options || {});
        //如果没有元素和TPL则返回
        if (param.itemSelector == '' || param.tplSelector == '') {
            return;
        }
        if (param.loadSelector != '') {
            $(param.loadSelector).hide();
        }
        if (param.noSelector != '') {
            $(param.noSelector).hide();
        }
        if ($(this).css('text-align') != undefined) {
            param.align = $(this).css('text-align');
        }
        function _min(_arr) {
            return Math.min.apply(Math, _arr);
        };
        function _max(_arr) {
            return Math.max.apply(Math, _arr);
        };

        function findShortIndex(_arr) {
            var index = 0, i;
            for (i in _arr) {
                if (_arr[i] < _arr[index]) {
                    index = i;
                }
            }
            return index;
        };

        function findLongIndex(_arr) {
            var index = 0, i;
            for (i in _arr) {
                if (_arr[i] > _arr[index]) {
                    index = i;
                }
            }
            return index;
        };
        if (param.init) {
            //如果有初始化，则清空原来的
            $(this).html('');
        }
        //BOX个数
        var _boxCount = $(param.itemSelector).length;
        //每个BOX的宽度
        var _boxWidth = param.columnWidth + param.marginWidth;
        //包含层的宽度
        var _containerWidth = $(this).width();
        //计算出列数
        var _showCols = Math.floor(_containerWidth / _boxWidth);
        //得到居中后的左边padding
        var _containerPadding = 0;
        if (param.align == 'left') {
            _containerPadding = 0;
        }
        else if (param.align == 'right') {
            _containerPadding = _containerWidth % _boxWidth;
        }
        else {
            _containerPadding = (_containerWidth % _boxWidth) / 2;
        }
        //如果小于最小列，则左边距为0
        if (_showCols < param.minCols) {
            _containerPadding = 0;
            _showCols = param.minCols;
            _isminCols = true;
        }
        //计算出行数
        var _tpRows = $(param.itemSelector).length / _showCols;
        var _showRows = Math.floor(_tpRows) == _tpRows ? _tpRows : _tpRows + 1;
        //记录每行当前的高度
        var _colsTopArr = [];
        //初始化为0
        for (var len = 0; len < _showCols; len++) {
            _colsTopArr.push(0);
        };
        var selector = $(this).selector;
        function setPosition(wrap, boxs, op) {
            //临时 最短列序号，左位置值，上位置值
            var _tpShortColIdx, _tpLeftPos, _tpTopPos, _tpLen = $(boxs).length;
            if (op == "resize" || op == "init") {
                $(wrap).width()
                _isminCols = false;
                _containerWidth = $(wrap).width();
                _showCols = Math.floor(_containerWidth / _boxWidth);
                //得到居中后的左边padding
                if (param.align == 'left') {
                    _containerPadding = 0;
                }
                else if (param.align == 'right') {
                    _containerPadding = _containerWidth % _boxWidth;
                }
                else {
                    _containerPadding = (_containerWidth % _boxWidth) / 2;
                }
                //如果小于最小列，则左边距为0
                if (_showCols < param.minCols) {
                    _containerPadding = 0;
                    _showCols = param.minCols;
                    _isminCols = true;
                }

                //计算出行数
                _tpRows = $(boxs).length / _showCols;
                _showRows = Math.floor(_tpRows) == _tpRows ? _tpRows : _tpRows + 1;
                //初始化为0
                _colsTopArr.length = 0;
                for (var len = 0; len < _showCols; len++) {
                    _colsTopArr.push(0);
                };
            }
            //在第一次加载时无高度的情况下
            //chrome不能自已加载 $.browser.safari && 
            if (op == null) {
                $(boxs).imagesLoaded(function() {
                    $(boxs).each(function(index) {
                        var _tpShortColIdx = index;
                        if (_tpShortColIdx < _showCols && op != "add") {
                            _tpLeftPos = _boxWidth * _tpShortColIdx + _containerPadding + "px";
                            $(this).css({ "top": "0", "left": _tpLeftPos, "width": param.columnWidth + "px", "margin": "0" });
                        }
                        else {
                            _tpShortColIdx = findShortIndex(_colsTopArr);
                            _tpLeftPos = _boxWidth * _tpShortColIdx + _containerPadding + "px";
                            _tpTopPos = _colsTopArr[_tpShortColIdx] + "px";
                            $(this).css({ "top": _tpTopPos, "left": _tpLeftPos, "width": param.columnWidth + "px", "margin": "0" });
                        }
                        if (op == "add") {
                            $(this).appendTo(wrap);
                        }
                        _colsTopArr[_tpShortColIdx] = _colsTopArr[_tpShortColIdx] + $(this).height() + param.marginHeight;

                        //全部加入后增加外框
                        if (index == _tpLen - 1) {
                            $(wrap).height(_max(_colsTopArr) + "px");
                            if (_isminCols) {
                                //设置以后回不去
                                //$(wrap).width((_boxWidth * _showCols + _containerPadding + param.marginWidth) + "px");
                            }
                            if (op == "add") {
                                if ($.browser.msie) {
                                    $(".hide").animate({ opacity: 'show' }, 2000);
                                }
                                else {
                                    $(".hide").animate({ opacity: 'show' }, 1000);
                                }
                                if (param.loadSelector != '') {
                                    $(param.loadSelector).hide();
                                }
                            }
                            _SolStatus = 0;
                        }

                    });
                });
            }
            else {
                //将所有元素放到各自己的位置
                $(boxs).each(function(index) {
                    var _tpShortColIdx = index;
                    if (_tpShortColIdx < _showCols && op != "add") {
                        _tpLeftPos = _boxWidth * _tpShortColIdx + _containerPadding + "px";
                        $(this).css({ "top": "0", "left": _tpLeftPos, "width": param.columnWidth + "px", "margin": "0" });
                    }
                    else {
                        _tpShortColIdx = findShortIndex(_colsTopArr);
                        _tpLeftPos = _boxWidth * _tpShortColIdx + _containerPadding + "px";
                        _tpTopPos = _colsTopArr[_tpShortColIdx] + "px";
                        $(this).css({ "top": _tpTopPos, "left": _tpLeftPos, "width": param.columnWidth + "px", "margin": "0" });
                    }
                    if (op == "add" || op == "init") {
                        $(this).appendTo(wrap);
                    }
                    _colsTopArr[_tpShortColIdx] = _colsTopArr[_tpShortColIdx] + $(this).height() + param.marginHeight; //parseInt($(this).css("marginTop")) * 2 + parseInt($(this).css("paddingTop")) + parseInt($(this).css("paddingBottom"));

                    //全部加入后增加外框
                    if (index == _tpLen - 1) {
                        $(wrap).height(_max(_colsTopArr) + "px");
                        if (_isminCols) {
                            //设置以后回不去
                            //$(wrap).width((_boxWidth * _showCols + _containerPadding + param.marginWidth) + "px");
                        }
                        if (op == "add") {
                            if ($.browser.msie) {
                                $(".hide").animate({ opacity: 'show' }, 2000);
                            }
                            else {
                                $(".hide").animate({ opacity: 'show' }, 1000);
                            }
                        }
                        else {
                            $(".hide").animate({ opacity: 'show' }, 0);
                        }
                        if (param.loadSelector != '') {
                            $(param.loadSelector).hide();
                        }
                        _SolStatus = 0;
                        if (op == "add" || op == "init") {
                            //每增加一次，页面加1
                            param.pageNumber++;
                        }
                    }

                });
            }
            if (param.callback) {
                param.callback();
            }
        };

        if (_boxCount > 0) {
            setPosition(selector, param.itemSelector);
        }
        //初始化完成
        _init = 1;

        //添加元素进去(JSON)
        function appendBox(data, op) {
            var newBox = [], len = Number(data.length), idx = 0;
            _boxCount += len;
            $.each(data, function(i) {
                //通过imgReady获取图片高度 
                imgReady(data[i].img, function() {
                    data[i].height = parseInt(this.height);   //?不知道高度值是否可靠
                    //这里模版化BOX edit by winds 2012.4.26
                    var temp = "";
                    var matchs = param.boxTemplate.match(/\{[a-zA-Z]+\}/gi);
                    for (var j = 0, mlen = matchs.length; j < mlen; j++) {
                        if (temp == "")
                            temp = param.boxTemplate;
                        var re_match = matchs[j].replace(/[\{\}]/gi, "");
                        temp = temp.replace(matchs[j], data[i][re_match]).replace(/[\r\t\n]/g, "");
                    }
                    newBox.push(temp);
                    //newBox.push('<div class="box hide"><a class="img" href="#"><img src="' + data[i].img + '" style="height:' + data[i].height + 'px;" alt="" /></a><span class="title">' + data[i].title + '</span></div>');
                    idx++;
                    if (idx == len) {
                        setPosition(selector, newBox.join(''), op);
                    }
                });
            });
        };

        //需要初始每一次添加元素
        if (param.init && param.ajaxServer != '' && param.boxParam != '' && parseInt(param.initBoxNumber) > 0) {
            var postPara = {};
            //初始化时参数为1
            param.pageNumber = 1;
            postPara[param.boxParam] = parseInt(param.initBoxNumber);
            postPara[param.pageParam] = parseInt(param.pageNumber);
            if (param.loadSelector != '') {
                $(param.loadSelector).show();
            }
            $.getJSON(param.ajaxServer, postPara, function(data) {
                if (data.length == 0) {
                    //无数据返回时则显示无数据提示
                    if (param.noSelector != '') {
                        if (param.noSelector) {
                            $(param.noSelector).fadeIn(1000).delay(2000).fadeOut(1000);
                        }
                    }
                    if (param.loadSelector != '') {
                        $(param.loadSelector).hide();
                    }
                    _isnoShow = true;
                    _SolStatus = 0;
                }
                else {
                    appendBox(data, 'init');
                }
            });
        }

        //支持滚动加载
        var _SolStatus = 0;
        if (param.scroll && param.ajaxServer != '' && param.boxParam != '' && parseInt(param.scrollBoxNumber) > 0) {
            $(window).scroll(function() {
                var scrollh = document.body.scrollHeight;
                var clienth = document.documentElement.clientHeight;
                var scrollt = document.documentElement.scrollTop + document.body.scrollTop;
                if (scrollt + clienth >= scrollh && _SolStatus == 0 && _init == 1 && !_isnoShow) {
                    if ((param.maxPage == 0 || param.pageNumber <= param.maxPage)) {
                        _SolStatus = 1;
                        if (param.loadSelector != '') {
                            $(param.loadSelector).show();
                        }
                        var postPara = {};
                        postPara[param.boxParam] = parseInt(param.scrollBoxNumber);
                        postPara[param.pageParam] = parseInt(param.pageNumber);
                        setTimeout(function() {
                            $.getJSON(param.ajaxServer, postPara, function(data) {
                                if (data.length == 0) {
                                    //无数据返回时则显示无数据提示
                                    if (param.noSelector != '') {
                                        if (param.noSelector) {
                                            $(param.noSelector).fadeIn(1000).delay(2500).fadeOut(1000);
                                        }
                                    }
                                    if (param.loadSelector != '') {
                                        $(param.loadSelector).hide();
                                    }
                                    _isnoShow = true;
                                    _SolStatus = 0;
                                }
                                else {
                                    appendBox(data, 'add');
                                }
                            });
                        }, 100);
                    }
                }
            });
        }

        //支持RESIZE
        var _ReStatus;
        $(window).wresize(function() {
            if (_ReStatus) {
                clearTimeout(_ReStatus);
            }
            _ReStatus = setTimeout(function() { setPosition(selector, param.itemSelector, "resize"); }, 200);
        });
    };

    /**
    * 图片头数据加载就绪事件 - 更快获取图片尺寸
    * @version	2011.05.27
    * @author	TangBin
    * @see		http://www.planeart.cn/?p=1121
    * @param	{String}	图片路径
    * @param	{Function}	尺寸就绪
    * @param	{Function}	加载完毕 (可选)
    * @param	{Function}	加载错误 (可选)
    * @example imgReady('http://www.google.com.hk/intl/zh-CN/images/logo_cn.png', function () {
    alert('size ready: width=' + this.width + '; height=' + this.height);
    });
    */
    var imgReady = (function() {
        var list = [], intervalId = null,

        // 用来执行队列
	    tick = function() {
	        var i = 0;
	        for (; i < list.length; i++) {
	            list[i].end ? list.splice(i--, 1) : list[i]();
	        };
	        !list.length && stop();
	    },

        // 停止所有定时器队列
	    stop = function() {
	        clearInterval(intervalId);
	        intervalId = null;
	    };

        return function(url, ready, load, error) {
            var onready, width, height, newWidth, newHeight,
			img = new Image();

            img.src = url;

            // 如果图片被缓存，则直接返回缓存数据
            if (img.complete) {
                ready.call(img);
                load && load.call(img);
                return;
            };

            width = img.width;
            height = img.height;

            // 加载错误后的事件
            img.onerror = function() {
                error && error.call(img);
                onready.end = true;
                img = img.onload = img.onerror = null;
            };

            // 图片尺寸就绪
            onready = function() {
                newWidth = img.width;
                newHeight = img.height;
                if (newWidth !== width || newHeight !== height ||
                // 如果图片已经在其他地方加载可使用面积检测
				newWidth * newHeight > 1024
			) {
                    ready.call(img);
                    onready.end = true;
                };
            };
            onready();

            // 完全加载完毕的事件
            img.onload = function() {
                // onload在定时器时间差范围内可能比onready快
                // 这里进行检查并保证onready优先执行
                !onready.end && onready();

                load && load.call(img);

                // IE gif动画会循环执行onload，置空onload即可
                img = img.onload = img.onerror = null;
            };

            // 加入队列中定期执行
            if (!onready.end) {
                list.push(onready);
                // 无论何时只允许出现一个定时器，减少浏览器性能损耗
                if (intervalId === null) intervalId = setInterval(tick, 40);
            };
        };
    })();


    //判断图片先加载完（网上找来的,masonry使用的这个）
    $.fn.imagesLoaded = function(callback) {
        var $this = this,
            $images = $this.find('img').add($this.filter('img')),
            len = $images.length,
            blank = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==',
            loaded = [];

        function triggerCallback() {
            callback.call($this, $images);
        }

        function imgLoaded(event) {
            var img = event.target;
            if (img.src !== blank && $.inArray(img, loaded) === -1) {
                loaded.push(img);
                if (--len <= 0) {
                    setTimeout(triggerCallback);
                    $images.unbind('.imagesLoaded', imgLoaded);
                }
            }
        }

        // if no images, trigger immediately
        if (!len) {
            triggerCallback();
        }

        $images.bind('load.imagesLoaded error.imagesLoaded', imgLoaded).each(function() {
            // cached images don't fire load sometimes, so we reset src.
            var src = this.src;
            // webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
            // data uri bypasses webkit log warning (thx doug jones)
            this.src = blank;
            this.src = src;
        });

        return $this;
    };

    //修复IE的resize问题（网上找来的）
    $.fn.wresize = function(f) {
        version = '1.1';
        wresize = { fired: false, width: 0 };

        function resizeOnce() {
            if ($.browser.msie) {
                if (!wresize.fired) {
                    wresize.fired = true;
                }
                else {
                    var version = parseInt($.browser.version, 10);
                    wresize.fired = false;
                    if (version < 7) {
                        return false;
                    }
                    else if (version == 7) {
                        //a vertical resize is fired once, an horizontal resize twice
                        var width = $(window).width();
                        if (width != wresize.width) {
                            wresize.width = width;
                            return false;
                        }
                    }
                }
            }

            return true;
        }

        function handleWResize(e) {
            if (resizeOnce()) {
                return f.apply(this, [e]);
            }
        }

        this.each(function() {
            if (this == window) {
                $(this).resize(handleWResize);
            }
            else {
                $(this).resize(f);
            }
        });

        return this;
    };
})(jQuery);

