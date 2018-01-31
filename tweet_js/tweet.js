/**
 * Created by sysy on 27/06/17.
 */
$(function () {
    /*var i = 1;
    function moveCaretToEnd(el) {
        if (typeof el.selectionStart == "number") {
            el.selectionStart = el.selectionEnd = el.html().length;
        } else if (typeof el.createTextRange != "undefined") {
            el.focus();
            var range = el.createTextRange();
            range.collapse(false);
            range.select();
        }
    }
    $("#tweet_box").append("<div contenteditable style='border: solid black 1px;height: 50px;' id='text' ></div><button id='send'>Envoyer</button>");
    var text = $("#text");
    var c = 0;
    text.on('keydown', function (e) {

        console.log(e.originalEvent.key);
        if(e.originalEvent.key === "@" || c === 1) {
            if (e.originalEvent.key === " ") {
                c = 0;
                for(var b = 0; b < i; b++) {
                    $("#da2").attr("href", "http://www.google.com");
                    text.focus();
                }
            } else {
                i++;
                c = 1;
                e.preventDefault();
                text.append("<a id='da" + i + "'></a>");
                var str = $('#da' + i);
                str.html(str.html() + e.originalEvent.key);
                //text.html(text.html().substr(0, text.html().length-1));
                console.log(text.html().length);
            }


        }
    });
*/
    (function( cursorManager ) {

        //From: http://www.w3.org/TR/html-markup/syntax.html#syntax-elements
        var voidNodeTags = ['AREA', 'BASE', 'BR', 'COL', 'EMBED', 'HR', 'IMG', 'INPUT', 'KEYGEN', 'LINK', 'MENUITEM', 'META', 'PARAM', 'SOURCE', 'TRACK', 'WBR', 'BASEFONT', 'BGSOUND', 'FRAME', 'ISINDEX'];

        //From: https://stackoverflow.com/questions/237104/array-containsobj-in-javascript
        Array.prototype.contains = function(obj) {
            var i = this.length;
            while (i--) {
                if (this[i] === obj) {
                    return true;
                }
            }
            return false;
        }

        //Basic idea from: https://stackoverflow.com/questions/19790442/test-if-an-element-can-contain-text
        function canContainText(node) {
            if(node.nodeType == 1) { //is an element node
                return !voidNodeTags.contains(node.nodeName);
            } else { //is not an element node
                return false;
            }
        };

        function getLastChildElement(el){
            var lc = el.lastChild;
            while(lc && lc.nodeType != 1) {
                if(lc.previousSibling)
                    lc = lc.previousSibling;
                else
                    break;
            }
            return lc;
        }

        //Based on Nico Burns's answer
        cursorManager.setEndOfContenteditable = function(contentEditableElement)
        {

            while(getLastChildElement(contentEditableElement) &&
            canContainText(getLastChildElement(contentEditableElement))) {
                contentEditableElement = getLastChildElement(contentEditableElement);
            }

            var range,selection;
            if(document.createRange)//Firefox, Chrome, Opera, Safari, IE 9+
            {
                range = document.createRange();//Create a range (a range is a like the selection but invisible)
                range.selectNodeContents(contentEditableElement);//Select the entire contents of the element with the range
                range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
                selection = window.getSelection();//get the selection object (allows you to change selection)
                selection.removeAllRanges();//remove any selections already made
                selection.addRange(range);//make the range you have just created the visible selection
            }
            else if(document.selection)//IE 8 and lower
            {
                range = document.body.createTextRange();//Create a range (a range is a like the selection but invisible)
                range.moveToElementText(contentEditableElement);//Select the entire contents of the element with the range
                range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
                range.select();//Select the range (make it the visible selection
            }
        }

    }( window.cursorManager = window.cursorManager || {}));
    $("#tweet_box").append("<div contenteditable style='border: solid black 1px;height: 50px;' id='text' ></div><button id='send'>Envoyer</button>");
    var text = $("#text"), b=0, test=" ", i=0;
    text.on('keydown', function (e) {
        console.log(e.originalEvent.key);
        if(e.originalEvent.key === "@" || e.originalEvent.key === "#") {
            b = 1;
            text.attr("contenteditable", "false");
            $("#text").append("<a style='display: inline-block' id='test"+i+"' href='http://www.google.com' ></a>");
            test = $("#test"+i);
            //console.log(text.last());
            test.attr("contenteditable", "true");
            test.focus();
            i++;
        }
        else if (e.originalEvent.key === "Backspace") {
            console.log(text.children()[0].nextSibling);
            if (text.children()[0].nextSibling === null) {
                text.attr("contenteditable", "false");
                test.attr("contenteditable", "true");
                test.focus();
                cursorManager.setEndOfContenteditable(test)
            }
            /*if (typeof $("#text a").last().prevObject.childNodes === undefined) {
                $("#text a").last().remove()
            }*/
            //console.log($("#text a").last());
        }
        test.on('keydown', function (e) {
            if (e.originalEvent.key === " ") {
                test.attr("href", "http://127.0.0.1/my_twitter/test.php?membre="+test.html().substr(1));
                text.attr("contenteditable", "true");
                test.attr("contenteditable", "false");
                text.focus();
                text.select();
            }
        });
        text.on('drop', function () {
            
        })
    });


});