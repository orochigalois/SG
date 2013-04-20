<?php
include_once('./common.php');
if(!$_SESSION['user'])
	die("user not found");
?>
<html>
    
    <head>
        <title>CHOOSE PICTURES FOR YOUR WORDS</title>
        <style type="text/css">
            #layout {
                height:500;
                overflow-y:scroll;
                border:1px solid #6E6E6E;
            }
            #layout ul {
                list-style: none;
                -webkit-padding-start: 20px;
            }
            #layout li {
                border:1px solid #6E6E6E;
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
                border:1px solid #FF0000;
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
        </style>
        <script type="text/javascript" src="js/jquery-latest.js"></script>
        <script type="text/javascript">
            var Dialog = function () {
                var options = arguments[0] || {};
                this.title = options.title || "new window",
                this.width = options.width || 740,
                this.height = options.height || 600,
                this.container = document.createElement("div"),
                this.id = "id" + Math.abs(new Date() * Math.random()).toFixed(0);
                this.page = 1;
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
                    builder.push('<form><div class="replaceable"></div>');

                    builder.push('<div class="submitable">');

                    builder.push('<a class="next" href="javascript:void(0)">Next</a>');
                    builder.push('<a class="page" href="javascript:void(0)">Page 1</a>');
                    builder.push('<a class="prev" href="javascript:void(0)">Prev</a>');

                    builder.push('</div></form>');
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
                    me.css(".popups form", "position:absolute;top:30px;left:10px;border:3px solid #68DFFB;width:" + (width - 26) + "px;height:" + (height - 51) + "px;background:#fff;");
                    me.css(".popups .submitable", "position:absolute;bottom:0;border-top:1px solid #c0c0c0;width:100%;height:40px;background:#f9f9f9;");
                    var buttoncss = 'display:block;float:right;margin: 0.7em 0.5em;padding:2px 7px;border:1px solid #dedede;' + 'background:#f5f5f5;color:#a9ea00;font:700 12px/130%  "SimSun","Times New Roman";text-decoration:none;';
                    var pagecss = 'display:block;float:right;margin: 0.7em 0.5em;padding:2px 7px;border:1px solid #dedede;' + 'background:#f5f5f5;color:#0000FF;font:700 12px/130%  "SimSun","Times New Roman";text-decoration:none;';
                    me.css("a.next", buttoncss);
                    me.css("a.prev", buttoncss);
                    me.css("a.page", pagecss);
                    me.css("a.prev", "color:#ff5e00;");
                    me.css("a.next:hover", "border:1px solid #E6EFC2;background:#E6EFC2;color:#529214;");
                    me.css("a.prev:hover", "border:1px solid #fbe3e4;background:#fbe3e4;color:#d12f19;");
                    me.css("a.next:active", "border:1px solid #529214;background:#529214;color:#fff;");
                    me.css("a.prev:active", "border:1px solid #d12f19;background:#d12f19;color:#fff;");
                    me.css("a", "outline: 0;");
                    me.css("a.next", "-webkit-border-radius:4px;");
                    me.css("a.prev", "-webkit-border-radius:4px;");


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
                    container.onclick = function () {
                        var ee = me.getEvent(),
                            node = ee[1],
                            tag = ee[2];
                        if (tag == "img") {
                            me.hide();
                            $.post("step3_save_picture_to_server.php", {
                                picName: me.currentWord,
                                picURL: ee[1].attributes[0].value
                            }, function (data, status) {
                                $("#" + me.currentImgID).attr("src", ee[1].attributes[0].value);
                            });

                        }
                        if (tag == "a") {
                            switch (node.className) {
                            case "closebtn":
                                me.hide();
                                break;
                            case "next":
                                me.page++;

                                $.post("step3_get_pic_from_bingAPI.php", {
                                    picName: me.currentWord,
                                    page: me.page

                                }, function (data, status) {

                                    document.getElementById("hide").innerHTML = data;

                                    me.content.innerHTML = "<table width=" + (me.width - 26) + " height=" +
                                        (me.height - 96) + "><tr><td style='text-align:center;'>" +
                                        document.getElementById("hide").innerHTML + "</td></tr></table>"
                                    $(".page").html("Page " + me.page.toString());


                                });


                                break;
                            case "prev":
                                if (me.page > 1) {
                                    me.page--;

                                    $.post("step3_get_pic_from_bingAPI.php", {
                                        //picName: $("#currentWord").html(),
                                        picName: me.currentWord,
                                        page: me.page

                                    }, function (data, status) {

                                        document.getElementById("hide").innerHTML = data;

                                        me.content.innerHTML = "<table width=" + (me.width - 26) + " height=" +
                                            (me.height - 96) + "><tr><td style='text-align:center;'>" +
                                            document.getElementById("hide").innerHTML + "</td></tr></table>"
                                        $(".page").html("Page " + me.page.toString());


                                    });
                                }
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
            };



            $(document).ready(function () {

                (function () {
                    var element = document.createElement('script');
                    element.setAttribute('src', 'http://dict.cn/hc/init.php');
                    document.body.appendChild(element);
                })();

                var myDialog = new Dialog({
                    width: 720,
                    height: 600,
                    title: "Select one picture"
                });
                myDialog.hide();

                $(".eachImg").click(function () {
                    
                    myDialog.currentWord=$(this)[0].parentNode.childNodes[0].innerHTML;
					myDialog.currentImgID=$(this)[0].parentNode.childNodes[1].children[0].id;

                    $('.eachLine').css('cursor', 'wait');
                    $.post("step3_get_pic_from_bing.php", {
                        word: myDialog.currentWord
                    }, function (data, status) {
                        $('.eachLine').css('cursor', 'default');
                        myDialog.page = 1;
                        $(".page").html("Page 1"); 
                        $(".caption").html(myDialog.currentWord);

                        document.getElementById("hide").innerHTML = data;
                        myDialog.show();

                        myDialog.content.innerHTML = "<table width=" + (myDialog.width - 26) + " height=" +
                            (myDialog.height - 96) + "><tr><td>" +
                            document.getElementById("hide").innerHTML + "</td></tr></table>"
                    });
                });
            });
        </script>
    </head>
    
    <body>
        
        
        <div style="display:none" id="hide"></div>
        <table cellspacing="0">
            <tr>
                <th>WORD</th>
                <th>PICTURE</th>
                <th>SENTENCE</th>
            </tr>
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
				echo '<tr class="eachLine"><td>'.$word_array1[0].
					'</td><td class="eachImg"><img id=img'.$i.
					' src="./userdata/'.$_SESSION['user'].
					'/picture/'.$word_array1[0].'"/></td><td>'.
					$word_array1[1]. '</td></tr>';
			}
			?>
        </table>
    </body>

</html>