<?php
include_once('./common.php');
if(!$_SESSION['user'])
	die("user not found");
?>
<html>
    
    <head>   
        <meta charset='UTF-8'>
        <title>SG</title>
        <style>


th {
                font: bold 12px"Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
                color: #4f6b72;
                border-right: 1px solid #C1DAD7;
                border-bottom: 1px solid #C1DAD7;
                border-top: 1px solid #C1DAD7;
                letter-spacing: 2px;
                text-transform: uppercase;
                text-align: left;
                padding: 6px 6px 6px 12px;
                background: #CAE8EA no-repeat;
            }
            tr.eachLine:hover {
                background: #FFFF00;
                color: #ff0000;
            }
            tr.eachLine td {
                border-right: 1px solid #C1DAD7;
                border-bottom: 1px solid #C1DAD7;
                padding: 6px 6px 6px 6px;
            }


#layout {
    height: 150;
}

#layout ul {
    list-style: none;
    -webkit-padding-start: 2px;
}

#layout li {
    border: 1px solid #6E6E6E;
    float: left;
    width: 200px;
    margin-top: 0px;
    margin-right: 10px;
    margin-bottom: 10px;
    margin-left: 0px;
    text-align: center;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    -ms-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#layout li:hover {
    border: 1px solid #FF0000;
    float: left;
    width: 200px;
    margin-top: 0px;
    margin-right: 10px;
    margin-bottom: 10px;
    margin-left: 0px;
    text-align: center;
    -webkit-filter: brightness(130%);
    -webkit-transform: rotate(-5deg);
    -moz-transform: rotate(-5deg);
    -o-transform: rotate(-5deg);
    -ms-transform: rotate(-5deg);
    transform: rotate(-5deg);
}



#pool {
    position: absolute;
    top: 0;
    left: 0;
}

#noun {
    position: absolute;
    top: 0;
    right: 0;
}

#verb {
    position: absolute;
    top: 250px;
    right: 0;
    border-bottom: 1px solid black;
}

#adjective {
    position: absolute;
    top: 500px;
    right: 0;
}

#pool > div {
    color: white;
    background-color: #8f8;
    vertical-align: middle;
    display: table-cell;
    text-align: center;
    width: 900px;
    height: 750px;
    z-index: 10;
}

#noun > div {
    border-bottom: 1px solid black;
    color: white;
    background-color: #2a2;
    vertical-align: middle;
    display: table-cell;
    text-align: center;
    width: 300px;
    height: 250px;
    z-index: 10;
}

#verb > div {
    border-bottom: 1px solid black;
    color: white;
    background-color: #2a2;
    vertical-align: middle;
    display: table-cell;
    text-align: center;
    width: 300px;
    height: 250px;
    z-index: 10;
}

#adjective > div {
    color: white;
    background-color: #2a2;
    vertical-align: middle;
    display: table-cell;
    text-align: center;
    width: 300px;
    height: 250px;
    z-index: 10;
}

#playground {
    position: relative;
    border: 1px solid gray;
    background-color: #8f8;
    height: 750px;
    width: 1200px;
}

.draggable {
    position: absolute;
    top: 30px;
    z-index: 20;
}

#img0 {
    left: 0px;
    top: 50px;
}

#img1 {
    left: 200px;
    top: 50px;
}

#img2 {
    right: 400px;
    top: 50px;
}

#img3 {
    right: 600px;
    top: 50px;
}

#img4 {
    right: 800px;
    top: 50px;
}

#playground p {
    margin: 1em 2ex;
    z-index: 30;
}
</style>
        <script type="text/javascript" src="js/jquery-latest.js"></script>
        
        <script>
        var Dialog = function () {
                var options = arguments[0] || {};
                this.title = options.title || "new window",
                this.width = options.width || 740,
                this.height = options.height || 600,
                this.container = document.createElement("div"),
                this.id = "id" + Math.abs(new Date() * Math.random()).toFixed(0);
                
				this.currentWord="none";
				this.currentImgID="none";
                this.init();
            }
            Dialog.prototype = {
                constructor: Dialog,
                init: function () {
                    var me = this,
                        container = me.container,
                        width = me.width,
                        height = me.height,
                        id = me.id,
                        builder = [],
                        t = "getElementsByTagName",
                        bg = function (pic) {
                            var bgcolor = arguments[1] || 'transparent',
                                left = arguments[2] || 'left',
                                s = 'background:' + bgcolor + ' url(./pic/' + pic + ') no-repeat ' + left + ' center;';
                            return s;
                        };
                    if (typeof Dialog.z === "undefined") {
                        Dialog.zIndex = 999;
                    }
                    document.body.insertBefore(container, null);
                    container.id = id;
                    container.className = "popups";
                    builder.push('<div class="caption">' + me.title + '</div>');
                    builder.push('<div class="ff"><div class="replaceable"></div>');

                    builder.push('<div class="submitable">');
                    
                    builder.push('<a class="enter" href="javascript:void(0)">Enter</a>');
					builder.push("<input class='inputSentence' type='text'>");
                    
					builder.push('<a class="label" href="javascript:void(0)">Please Input Sentence</a>');

                    builder.push('</div></div>');
                    builder.push('<a class="closebtn" href="javascript:void(0)"></a>');
                    container.innerHTML = builder.join('');
                    var size = me.getBrowserWindowSize();
                    me.left = ((size.width - width) / 2) >> 0;
                    me.top = ((size.height - height) / 2) >> 0;

                    var divs = container[t]("div"),
                        k = divs.length;
                    while (--k >= 0) {
                        if (divs[k].className == "replaceable") {
                            me.content = divs[k]
                            break;
                        }
                    }
                    //set CSS style
                    me.css(".popups", "position:absolute;width:" + width + "px;height:" +
                        height + "px;left:" + me.left + "px;top:" + me.top + "px;"); //background:#68DFFB
                    container.style.zIndex = Dialog.zIndex++;
                    me.css(".popups .caption", 'position:absolute;top:10px;left:10px;width:' + (width - 50) + 'px;height:20px;' +
                        'padding-left:30px;font:700 14px/20px "SimSun","Times New Roman";color: #fff;' +
                        bg("o_icon.gif", "#68DFFB", "5px"));
                    me.css(".popups .closebtn", 'position:absolute;top:0;right:10px;display:block;width:28px; ' +
                        'height:17px;text-decoration:none;' + bg("o_dialog_closebtn.gif"));
                    me.css(".popups a.closebtn:hover", bg("o_dialog_closebtn_over.gif"));
                    me.css(".popups .ff", "position:absolute;top:30px;left:10px;border:3px solid #68DFFB;width:" + (width - 26) + "px;height:" + (height - 51) + "px;background:#fff;");
                    me.css(".popups .submitable", "position:absolute;bottom:0;border-top:1px solid #c0c0c0;width:100%;height:40px;background:#f9f9f9;");
                    var buttoncss = 'display:block;float:right;margin: 0.7em 0.5em;padding:2px 7px;border:1px solid #dedede;' + 'background:#f5f5f5;color:#a9ea00;font:700 12px/130%  "SimSun","Times New Roman";text-decoration:none;';
					var inputcss='display:block;width:800px;float:right;margin: 0.7em 0.5em;padding:2px 7px;border:1px solid #dedede;' + 'background:#f5f5f5;color:#a9ea00;font:700 12px/130%  "SimSun","Times New Roman";text-decoration:none;';
                    var labelcss = 'display:block;float:right;margin: 0.7em 0.5em;padding:2px 7px;border:1px solid #dedede;' + 'background:#f5f5f5;color:#0000FF;font:700 12px/130%  "SimSun","Times New Roman";text-decoration:none;';
                    me.css(".inputSentence", inputcss);
                    me.css("a.enter", buttoncss);
                    me.css("a.label", labelcss);
                    me.css("a.enter", "color:#ff5e00;");
                    me.css("input.inputSentence:hover", "border:1px solid #E6EFC2;background:#E6EFC2;color:#529214;");
                    me.css("a.enter:hover", "border:1px solid #fbe3e4;background:#fbe3e4;color:#d12f19;");
                    me.css("input.inputSentence:active", "border:1px solid #529214;background:#529214;color:#fff;");
                    me.css("a.enter:active", "border:1px solid #d12f19;background:#d12f19;color:#fff;");
                    me.css("a", "outline: 0;");
                    me.css("input.inputSentence", "-webkit-border-radius:4px;");
                    me.css("a.enter", "-webkit-border-radius:4px;");


                    var svg = me.createSVG("svg");
                    container.insertBefore(svg, container.firstChild);
                    me.attr(svg, {
                        width: me.width + 10 + "px",
                        height: me.height + 10 + "px"
                    });
                    var defs = me.createSVG("defs");
                    svg.appendChild(defs);
                    var filter = me.createSVG("filter");
                    defs.appendChild(filter);
                    me.attr(filter, {
                        id: "filter" + id
                    });
                    var feGaussianBlur = me.createSVG("feGaussianBlur");
                    filter.appendChild(feGaussianBlur)
                    me.attr(feGaussianBlur, {
                        "in": "SourceAlpha",
                        result: "blur-out",
                        stdDeviation: 1.5
                    });
                    var feOffset = me.createSVG("feOffset");
                    filter.appendChild(feOffset)
                    me.attr(feOffset, {
                        "in": "blur-out",
                        result: "the-shadow",
                        dx: 0,
                        dy: 2
                    });
                    var feBlend = me.createSVG("feBlend");
                    filter.appendChild(feBlend)
                    me.attr(feBlend, {
                        "in": "SourceGraphic",
                        "in2": "the-shadow",
                        mode: "normal"
                    });
                    var shadow = me.createSVG("rect");
                    svg.appendChild(shadow);
                    me.attr(shadow, {
                        x: "10px",
                        y: "10px",
                        width: me.width + "px",
                        height: me.height + "px",
                        rx: 10,
                        fill: "#333",
                        style: "opacity:0.2",
                        filter: "url(#filter" + id + ")"
                    });
                    var rect = me.createSVG("rect");
                    svg.appendChild(rect);
                    me.attr(rect, {
                        width: me.width + "px",
                        height: me.height + "px",
                        rx: 5,
                        fill: "#68DFFB",
                        style: "opacity:0.8"
                    });


                    //click event
                    container.onclick = function() {
					  var ee = me.getEvent(),
					  node = ee[1],
					  tag = ee[2];

					  if (tag == "a") {
					    switch (node.className) {
					    case "closebtn":
					      me.hide();
					      break;

					    case "enter":

					      var trInnerHTML = "<tr><td><img src=" + $('#' + word1).attr('src') + " width='100' height='75'>" + "<img src=" + $('#' + word2).attr('src') + " width='100' height='75'>" + "<img src=" + $('#' + word3).attr('src') + " width='100' height='75'>" + "<img src=" + $('#' + word4).attr('src') + " width='100' height='75'>" + "<img src=" + $('#' + word5).attr('src') + " width='100' height='75'>" + "</td><td>" + $('.inputSentence').val() + "</td></tr>";

					      $('#resultTable > tbody:last').append(trInnerHTML);
					      $('.inputSentence').val('');
					      word1 = adjective.random();
					      word2 = noun.random();
					      word3 = verb.random();
					      word4 = adjective.random();
					      word5 = noun.random();

					      me.content.innerHTML = "<table width=" + (me.width - 26) + " height=190><tr><td>" + "<div id='layout'><ul>" + "<li><img src=" + $('#' + word1).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word2).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word3).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word4).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word5).attr('src') + " width='200' height='150'></li>"

					      + "</ul></div></td></tr></table>";

					      break;

					    }
					  }
					}
                    container.onmousedown = function (e) {
                        e = e || window.event;
                        if (e.target.id != 'layout') {
                            container.offset_x = e.clientX - container.offsetLeft;
                            container.offset_y = e.clientY - container.offsetTop;
                            document.onmousemove = function (e) {
                                me.drag(e, me);
                            }
                            document.onmouseup = function () {
                                me.dragend(container);
                            }
                        }
                    }
                },
                drag: function (e, me) {
                    e = e || window.event;
                    var el = me.container;
                    var l = e.clientX - el.offset_x + "px",
                        t = e.clientY - el.offset_y + "px";
                    with(el.style) {
                        left = l;
                        top = t;
                        cursor = "move"
                    }

                    !+"\v1" ? document.selection.empty() : window.getSelection().removeAllRanges();
                },
                dragend: function (el) {
                    el.style.cursor = "";
                    document.onmouseup = document.onmousemove = null;
                },
                hide: function () {
                    this.container.style.display = "none";

                    this.mode(0, 0);
                    this.incss(document.body, {
                        width: "auto",
                        height: "auto",
                        overflow: "auto"
                    });
                    this.incss(document.documentElement, {
                        width: "auto",
                        height: "auto",
                        overflow: "auto"
                    });
                },
                show: function () {
                    this.container.style.display = "block";
                    var size = this.getBrowserWindowSize();

                    this.container.style.left = (document.body.clientWidth - 740) / 2;
                    this.container.style.top = document.body.scrollTop + (document.body.clientHeight - 600) / 2;

                    this.mode(screen.width, size.height + 20);
                },
                getBrowserWindowSize: function () {
                    return {
                        width: document.body.offsetWidth,
                        height: document.body.offsetHeight
                    }
                },
                createSVG: function (tag) {
                    return document.createElementNS("http://www.w3.org/2000/svg", tag);
                },
                attr: function (node, bag) {
                    for (var i in bag) {
                        if (bag.hasOwnProperty(i))
                            node.setAttribute(i, bag[i])
                    }
                },
                getEvent: function (e) {
                    e = e || window.event;
                    if (!e) {
                        var c = this.getEvent.caller;
                        while (c) {
                            e = c.arguments[0];
                            if (e && (Event == e.constructor || MouseEvent == e.constructor)) {
                                break;
                            }
                            c = c.caller;
                        }
                    }
                    var target = e.srcElement ? e.srcElement : e.target,
                        currentN = target.nodeName.toLowerCase(),
                        parentN = target.parentNode.nodeName.toLowerCase(),
                        grandN = target.parentNode.parentNode.nodeName.toLowerCase();
                    return [e, target, currentN, parentN, grandN];
                },
                mode: function (w, h) {
                    var mask = Dialog.mask,
                        me = this;
                    //this.incss(document.body, {width:"100%",height:"100%",overflow:"hidden"});
                    //this.incss(document.documentElement, {width:"100%",height:"100%",overflow:"hidden"});
                    this.incss(mask, {
                        position: "absolute",
                        background: "#fff",
                        top: 0,
                        left: 0,
                        width: w + "px",
                        height: h + "px",
                        "-moz-user-select": "none"
                    });
                    !+"\v1" ? (mask.style.filter = "alpha(opacity=0)") : (mask.style.opacity = "0");
                    mask.onselectstart = function (e) {
                        me.stopEvent(e);
                    }
                    mask.oncontextmenu = function (e) {
                        me.stopEvent(e);
                    }
                },
                stopEvent: function (e) {
                    e = e || window.event;
                    if (e.preventDefault) {
                        e.preventDefault();
                        e.stopPropagation();
                    } else {
                        e.returnValue = false;
                        e.cancelBubble = true;
                    }
                },
                incss: function (node, bag) {
                    var str = ";"
                    for (var i in bag) {
                        if (bag.hasOwnProperty(i))
                            str += i + ":" + bag[i] + ";"
                    }
                    node.style.cssText = str;
                },
                css: function (selector, declaration) {
                    if (typeof document.createStyleSheet === 'undefined') {
                        document.createStyleSheet = (function () {
                            function createStyleSheet() {
                                var element = document.createElement('style');
                                element.type = 'text/css';
                                document.getElementsByTagName('head')[0].appendChild(element);
                                var sheet = document.styleSheets[document.styleSheets.length - 1];
                                if (typeof sheet.addRule === 'undefined')
                                    sheet.addRule = function (selectorText, cssText, index) {
                                        if (typeof index === 'undefined')
                                            index = this.cssRules.length;
                                        this.insertRule(selectorText + ' {' + cssText + '}', index);
                                };
                                return sheet;
                            }
                            return createStyleSheet;
                        })();
                    }
                    if ( !! Dialog.sheet) {
                        if (!Dialog.memory.exists(selector, declaration)) {
                            Dialog.memory.set(selector, declaration);
                            Dialog.sheet.addRule(selector, declaration);
                        }
                    } else {
                        Dialog.sheet = document.createStyleSheet();
                        var memory = function () {
                            var keys = [],
                                values = [],
                                size = 0;
                            return {
                                get: function (k) {
                                    var results = [];
                                    for (var i = 0, l = keys.length; i < l; i++) {
                                        if (keys[i] == k) {
                                            results.push(values[i])
                                        }
                                    }
                                    return results;
                                },
                                exists: function (k, v) {
                                    var vs = this.get(k);
                                    for (var i = 0, l = vs.length; i < l; i++) {
                                        if (vs[i] == v)
                                            return true;
                                    }
                                    return false;
                                },
                                set: function (k, v) {
                                    keys.push(k);
                                    values.push(v);
                                    size++;
                                },
                                length: function () {
                                    return size;
                                }
                            }
                        }
                        Dialog.memory = memory();
                        Dialog.memory.set(selector, declaration);
                        Dialog.sheet.addRule(selector, declaration);
                        Dialog.mask = document.createElement("div");
                        document.body.insertBefore(Dialog.mask, this.container);
                    }
                }
            }




/////////////////////////////////////////////////////////////////////////////////////////////////
var beejdnd = (function() {

    /**
	 * Information about the drag state
	 */
    var dragInfo = {
        'element': null,
        // currently dragged element
        'offset': {
            'x': 0,
            'y': 0
        },
        // mouse offset within the element
        'parentOffset': null,
        // offset of the draggable's parent container
        'zindex': '',
        // stored CSS z-index, if any, of the dragged element
        'limited': false,
        // true if 'limit' should be applied to draggable motion
        'limit': {
            'x0': 0,
            'y0': 0,
            'x1': 0,
            'y1': 0
        },
        // in parent container space, if 'limited' is true
        'width': 0,
        // width of draggable
        'height': 0 // height of draggable
    };

  
    function dragstart(e) {
        var position;
        var draggableParent;
        var mxInParent, myInParent; // mouse coords in parent container
        var pageCoords = {};

        getPageCoords(e, pageCoords); // get touch info
        dragInfo.element = e.target;

        // get the mouse coordinates relative to the draggable's parent
        // container:
        dragInfo.parentOffset = $(dragInfo.element).parent().offset();
        mxInParent = pageCoords.pageX - dragInfo.parentOffset.left;
        myInParent = pageCoords.pageY - dragInfo.parentOffset.top;

        // Calculate and save the offset within the draggable element where
        // the mousedown occurred. This will be used later to keep the
        // relative positioning of the dragged object and the mouse during a
        // mouse move:
        position = $(dragInfo.element).position(); // .left and .top in parent container
        dragInfo.offset.x = mxInParent - position.left;
        dragInfo.offset.y = myInParent - position.top;

        // Store the original z-index:
        dragInfo.zindex = $(dragInfo.element).css('z-index');

        // Then set the z-index to something huge so the element appears on
        // top of everything else:
        $(dragInfo.element).css('z-index', '999999');

        // These are useful values to know later:
        dragInfo.width = $(dragInfo.element).width();
        dragInfo.height = $(dragInfo.element).height();

        // check to see if this element has class "stayinparent".
        // if, so, limit the draggable to inside the parent element:
        if ($(dragInfo.element).hasClass('stayinparent')) {
            dragInfo.limited = true;
            dragInfo.limit.x0 = 0;
            dragInfo.limit.y0 = 0;
            dragInfo.limit.x1 = $(dragInfo.element).parent().width() - dragInfo.width - 1;
            dragInfo.limit.y1 = $(dragInfo.element).parent().height() - dragInfo.height - 1;
        } else {
            dragInfo.limited = false;
        }

        return false;
    };

    /**
	 * Mousemove handler
	 */
    function drag(e) {
        var mxInParent, myInParent;
        var nx, ny;

        // This is bound to the window, so we have to test to make sure we're
        // currently dragging an object:
        if (dragInfo.element) {
            var pageCoords = {};

            getPageCoords(e, pageCoords); // get touch info
            // current mouse position on the page
            // get the mouse coordinates relative to the draggable's parent
            // container:
            mxInParent = pageCoords.pageX - dragInfo.parentOffset.left;
            myInParent = pageCoords.pageY - dragInfo.parentOffset.top;

            // subtract away the offset within the dragged object that we
            // got in the dragstart() function (comment this out to see what
            // happens when we don't take the offset into account):
            x = mxInParent - dragInfo.offset.x;
            y = myInParent - dragInfo.offset.y;

            // if we're restricting movement:
            if (dragInfo.limited) {
                x = Math.max(x, dragInfo.limit.x0);
                x = Math.min(x, dragInfo.limit.x1);
                y = Math.max(y, dragInfo.limit.y0);
                y = Math.min(y, dragInfo.limit.y1);
            }

            // set the actual position of the dragged element to the mouse
            // position (offset by the drag offset):
            $(dragInfo.element).css({
                'left': x + 'px',
                'top': y + 'px'
            });

            return false;
        }
    };

    /**
	 * Mouseup handler
	 */
    function drop(e) {
        var x, y, offset;

        if (dragInfo.element) {
            var pageCoords = {};

            getPageCoords(e, pageCoords); // get touch info
            // restore the z-index
            $(dragInfo.element).css('z-index', dragInfo.zindex);

            // test for a droptarget by comparing the mouse coordinates to
            // each droptarget's position and dimensions:
            $('.droptarget').each(function(index, Element) {

                // find the droptarget on the page
                offset = $(Element).offset();

                // convert mouse coordinates into "droptarget space"
                x = pageCoords.pageX - offset.left;
                y = pageCoords.pageY - offset.top;

                // see if it's inbounds:
                if (x > 0 && y > 0 && x < $(Element).width() && y < $(Element).height()) {

                    // trigger an event
                    $(Element).trigger('drop', [dragInfo.element]);
                }
            });

            // no longer dragging:
            dragInfo.element = null;

            return false;
        }
    };

    /**
	 * Internal helper function that looks at an event, and transfers
	 * the first touch coordinate to pageX and pageY.  It's a hackish
	 * way to support touches in the demo.
	 *
	 * @param ev the jQuery normalized event
	 * @param result will hold pageX and pageY
	 */
    function getPageCoords(ev, result) {
        var first;

        if (ev.originalEvent.changedTouches != undefined) {
            first = ev.originalEvent.changedTouches[0];
            result.pageX = first.pageX;
            result.pageY = first.pageY;
        } else {
            result.pageX = ev.pageX;
            result.pageY = ev.pageY;
        }
    };

    /**
	 * Init the drag-n-drop system
	 *
	 * Call this after the DOM has loaded--it looks for .draggable elements.
	 */
    function init() {
        // clear data
        dragInfo.element = null;

        // set up the mouse handlers on all the draggable objects
        $('.draggable').bind('mousedown', dragstart);
        $('.draggable').bind('touchstart', dragstart);

        // but we'll take mousemove and mouseup events from anywhere if
        // we're dragging:
        $(document).bind('mousemove', drag);
        $(document).bind('touchmove', drag);
        $(document).bind('mouseup', drop);
        $(document).bind('touchend', drop);
    };

    /**
	 * Call to shut down the system and unbind the handlers
	 */
    function shutdown() {
        $('.draggable').unbind('mousedown', dragstart);
        $('.draggable').unbind('touchstart', dragstart);
        $(document).unbind('mousemove', drag);
        $(document).unbind('touchmove', drag);
        $(document).unbind('mouseup', drop);
        $(document).unbind('touchend', drop);
    };

    // expose public functions
    return {
        'init': init,
        'shutdown': shutdown
    };

})(); // end of namespace wrapper

/**
 * Function to handle our demo drops
 */
function demodrop(e, draggable) {
    // delay a frame to make iDevices happier with events around the
    // alert():
    setTimeout(function() {
       // alert(draggable.id + " was just dropped on " + e.target.id);
		


		switch (e.target.id)
		{
		case "noun":
			verb.remove(draggable.id);
			adjective.remove(draggable.id);
			pool.remove(draggable.id);
			
			
			if($.inArray(draggable.id, noun)==-1)
		  		noun.push(draggable.id);
			
		  break;
		case "verb":
			noun.remove(draggable.id);
			adjective.remove(draggable.id);
			pool.remove(draggable.id);
			if($.inArray(draggable.id, verb)==-1)
		  		verb.push(draggable.id);
		  break;
		case "adjective":
			noun.remove(draggable.id);
			verb.remove(draggable.id);
			pool.remove(draggable.id);
			if($.inArray(draggable.id, adjective)==-1)
		    	adjective.push(draggable.id);
		  break;
		case "pool":
			noun.remove(draggable.id);
			adjective.remove(draggable.id);
			verb.remove(draggable.id);
		  if($.inArray(draggable.id, pool)==-1)
		  	pool.push(draggable.id);
		  break;
		}

		
    },
    5);
}
var pool = new Array();
var noun = new Array();
var verb = new Array();
var adjective = new Array();
var imageNum;

var word1;
var word2;
var word3;
var word4;
var word5;

Number.prototype.floor = function() {
    return Math.floor(this);
};
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
Array.prototype.random = function() {
    return this[(Math.random() * this.length).floor()];
};






$(function() {

  imageNum = parseInt(document.getElementById("imageNum").innerHTML);
  for (var i = 0; i < imageNum; i++) {
    pool.push("img" + i.toString());
  }

  // init the DnD system
  beejdnd.init();

  // set up the droptarget event handlers
  $('#pool').bind('drop', demodrop);
  $('#noun').bind('drop', demodrop);
  $('#verb').bind('drop', demodrop);
  $('#adjective').bind('drop', demodrop);

  var myDialog = new Dialog({
    width: 1095,
    height: 280,
    title: "Make sentence with these pictures"
  });
  myDialog.hide();

  $('#go').click(function() {
    myDialog.show();

    word1 = adjective.random();
    word2 = noun.random();
    word3 = verb.random();
    word4 = adjective.random();
    word5 = noun.random();

    myDialog.content.innerHTML = "<table width=" + (myDialog.width - 26) + " height=190><tr><td>" + "<div id='layout'><ul>" + "<li><img src=" + $('#' + word1).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word2).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word3).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word4).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word5).attr('src') + " width='200' height='150'></li>"

    + "</ul></div></td></tr></table>";

  });

  $('.inputSentence').keypress(function(event) {

    var keycode = (event.keyCode ? event.keyCode: event.which);
    if (keycode == '13') {
      var trInnerHTML = "<tr><td><img src=" + $('#' + word1).attr('src') + " width='100' height='75'>" + "<img src=" + $('#' + word2).attr('src') + " width='100' height='75'>" + "<img src=" + $('#' + word3).attr('src') + " width='100' height='75'>" + "<img src=" + $('#' + word4).attr('src') + " width='100' height='75'>" + "<img src=" + $('#' + word5).attr('src') + " width='100' height='75'>" + "</td><td>" + $('.inputSentence').val() + "</td></tr>";

      $('#resultTable > tbody:last').append(trInnerHTML);
	  $('.inputSentence').val('');
      word1 = adjective.random();
      word2 = noun.random();
      word3 = verb.random();
      word4 = adjective.random();
      word5 = noun.random();

      myDialog.content.innerHTML = "<table width=" + (myDialog.width - 26) + " height=190><tr><td>" + "<div id='layout'><ul>" + "<li><img src=" + $('#' + word1).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word2).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word3).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word4).attr('src') + " width='200' height='150'></li>" + "<li><img src=" + $('#' + word5).attr('src') + " width='200' height='150'></li>"

      + "</ul></div></td></tr></table>";
    }
    event.stopPropagation();
  });

});
        </script>
    </head>
    
    <body>
	    <div id='user' style="display:none"><?php 
		echo $_SESSION['user'];
		?></div>
	    <div id='score' style="display:none">
		<?php 
		$file="./userdata/".$_SESSION['user']."/score.txt";
		$fh = fopen($file, 'r');
		$theScore = fread($fh, filesize($file));
		fclose($fh);

		echo $theScore;

		?>
		</div>

		



		
        <div id="playground">
        
            <?php
            $myFile=$_GET["URL"];
			$fh=fopen($myFile, 'r');
			$theData=fread($fh, filesize($myFile));
			fclose($fh);
			$theData=trim($theData);
			$word_array=explode( "\n", $theData);
			for ($i=0 ; $i < count($word_array); $i++)
			{
				$word_array1=explode( "...", $word_array[$i]);
		

		echo '<img id="img'.$i.'" src="userdata/'.$_SESSION['user'].'/picture/'.$word_array1[0].
		'" style="left:'.($i*30).' ;top:'.($i*30).'" class="draggable stayinparent">';
	
			}
			?>


	<div id="pool" class="droptarget"><div>pool</div></div>
	<div id="noun" class="droptarget"><div>noun</div></div>
	<div id="verb" class="droptarget"><div>verb</div></div>
	<div id="adjective" class="droptarget"><div>adjective</div></div>
	
</div>
<p>Step1.Drag the pictures to the right region</p>
<p>Step2.<input type="submit" id="go" value="go!"></p>
<table id="resultTable">
<tbody>
<tr>
                <th>PICTURE</th>
                <th>SENTENCE</th>
            </tr>

</tbody>
</table>

<div id='imageNum' style="display:none"><?php 
		echo count($word_array);
		?></div>
    </body>

</html>
