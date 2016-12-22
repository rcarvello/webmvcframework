/**
 * Builds into the view an observer of controller state. Then compares controller state with
 * the view state to handle if data changes on server layer.
 * The observation is acted by  polling the built-in controller JSON service witch returns
 * all the necessary information about the controllers data.
 * If the comparison fails observer updates the view with content fetched from the controller.
 * The updating may be on the full page (by using page reload) or on part of it (by using
 * section replacement without page reloading).

 * @author Rosario Carvello - rosario.carvello@gmail.com
 * @version GIT:v1.0.0
 * @note none
 * @copyright (c) 2016 Rosario Carvello rosario.carvello@gmail.com- - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */


// Initializes global static variables
if (setup == undefined) {

    // Controls flags
    var debug = true;
    var setup = true;

    // The controllers observer array
    var observer = [];

    // The views content states array
    var viewState = [];

    // The controllers content states array
    var controllerState = [];

    // The controllers content array
    var controllerContent = [];

    // The contents url locations
    var refreshLocation = [];

    // The controller contents JSON service url
    var serviceLocation = [];

    // The polling interval array
    var pollingInterval = [];

    // The contents ID array
    var contentCheck = [];

    // The contents ID array
    var alertFlag = [];

    // The XHR object
    var xhr;

    // The initial index
    var currentIndex = -1;

    // The urlencode posted data of forms
    var postData;

    // The current url and parameters
    var protocol = window.location.protocol;
    var host = "//" + window.location.host;
    var path = window.location.pathname;
    var currentUrlParameters = window.location.search;

    // Creates Base64 object to handling controller content obtained from its JSON service
    var Base64= {
        _keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
        encode:function(e){
            var t="";
            var n,r,i,s,o,u,a;
            var f=0;
            e=Base64._utf8_encode(e);
            while(f<e.length){
                n=e.charCodeAt(f++);
                r=e.charCodeAt(f++);
                i=e.charCodeAt(f++);
                s=n>>2;o=(n&3)<<4|r>>4;
                u=(r&15)<<2|i>>6;
                a=i&63;
                if(isNaN(r)){
                    u=a=64}
                else if(isNaN(i)){
                    a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)
            }
            return t
        },
        decode:function(e){
            var t="";
            var n,r,i;
            var s,o,u,a;
            var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");
            while(f<e.length){
                s=this._keyStr.indexOf(e.charAt(f++));
                o=this._keyStr.indexOf(e.charAt(f++));
                u=this._keyStr.indexOf(e.charAt(f++));
                a=this._keyStr.indexOf(e.charAt(f++));
                n=s<<2|o>>4;
                r=(o&15)<<4|u>>2;
                i=(u&3)<<6|a;
                t=t+String.fromCharCode(n);
                if(u!=64){
                    t=t+String.fromCharCode(r)
                }
                if(a!=64){
                    t=t+String.fromCharCode(i)
                }
            }
            t=Base64._utf8_decode(t);
            return t
        },
        _utf8_encode:function(e){
            e=e.replace(/\r\n/g,"\n");
            var t="";
            for(var n=0;n<e.length;n++){
                var r=e.charCodeAt(n);
                if(r<128){
                    t+=String.fromCharCode(r)
                }else if(r>127&&r<2048){
                    t+=String.fromCharCode(r>>6|192);
                    t+=String.fromCharCode(r&63|128)
                }else{
                    t+=String.fromCharCode(r>>12|224);
                    t+=String.fromCharCode(r>>6&63|128);
                    t+=String.fromCharCode(r&63|128)
                }
            }
            return t
        },
        _utf8_decode:function(e){
            var t="";
            var n=0;
            var r=c1=c2=0;
            while(n<e.length){
                r=e.charCodeAt(n);
                if(r<128){
                    t+=String.fromCharCode(r);
                    n++
                }else if(r>191&&r<224){
                    c2=e.charCodeAt(n+1);
                    t+=String.fromCharCode((r&31)<<6|c2&63);
                    n+=2
                }else{c2=e.charCodeAt(n+1);
                    c3=e.charCodeAt(n+2);
                    t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);
                    n+=3
                }
            }
            return t
        }
    }

    // UTF8 encode/decode object to handling JSON content
    UTF8 = {
        encode: function(s){
            for(var c, i = -1, l = (s = s.split("")).length, o = String.fromCharCode; ++i < l;
                s[i] = (c = s[i].charCodeAt(0)) >= 127 ? o(0xc0 | (c >>> 6)) + o(0x80 | (c & 0x3f)) : s[i]
            );
            return s.join("");
        },
        decode: function(s){
            for(var a, b, i = -1, l = (s = s.split("")).length, o = String.fromCharCode, c = "charCodeAt"; ++i < l;
                ((a = s[i][c](0)) & 0x80) &&
                (s[i] = (a & 0xfc) == 0xc0 && ((b = s[i + 1][c](0)) & 0xc0) == 0x80 ?
                    o(((a & 0x03) << 6) + (b & 0x3f)) : o(128), s[++i] = "")
            );
            return s.join("");
        }
    };

}

// Creates a new unique index and assigns it to the observer to start
currentIndex = currentIndex + 1;
startObserver(currentIndex);

// Starts the observer
function startObserver(index) {
    setDynamicVariable(index);
    setUrls(index);
    observer[index] = setInterval(
        function () {
            getControllerState(index);
        },
        pollingInterval[index]
    );
}

// Initializes global dynamic variables
function setDynamicVariable(index) {
    // Sets the polling intervall for http request of the controller JSON service
    pollingInterval[index] = document.getElementById("observer_manager" + index).getAttribute("data-polling");
    // Set the content to request
    contentCheck[index] = document.getElementById("observer_manager" + index).getAttribute("data-content");
    // Set the alerting flag
    alertFlag[index] = document.getElementById("observer_manager" + index).getAttribute("data-alert");
    // Set the posted data if is a form
    postData = document.getElementById("observer_manager" + index).getAttribute("data-post");

    postData= Base64.decode(postData);
    if (postData != ""){
        postData = "&" + postData;
    }
    // Inizialize the client state
    viewState[index] = "";
}

// Gets the current view url location and the controller JSON getState() service location
function setUrls(index) {
    if (currentUrlParameters == "") {
        refreshLocation[index] = protocol + host + path;
        serviceLocation[index] = refreshLocation[index] + "?getState=" + contentCheck[index]  + postData;
    } else {
        refreshLocation[index] = protocol + host + path + currentUrlParameters;
        serviceLocation[index] = refreshLocation[index] + "&getState=" + contentCheck[index]  + postData;
    }
    refreshLocation[index] = refreshLocation[index] + postData;
}

// Calls the controller JSON services getState to gets controller state and content.
function getControllerState(index) {
    // console.log(serviceLocation[index]);
    xhr = new XMLHttpRequest();
    xhr.open('GET', serviceLocation[index] , true);
    xhr.timeout = 4000;
    xhr.send();
    xhr.onreadystatechange = function () {
        compareStates(index);
    };
}

// Compares view and controller state
function compareStates(index) {
    if (xhr.readyState == 4 && xhr.status == 200) {
        // console.log(xhr.responseText);
        var response = JSON.parse(xhr.responseText);
        controllerState[index] = response.controllerState;

        if (serverOSEncoding == "Linux") {
            controllerContent[index] = Base64.decode(response.controllerContent);
        } else {
            controllerContent[index] = UTF8.decode(Base64.decode(response.controllerContent));
        }

        if (viewState[index] == "") {
            // If first time of method execution: the view and the controller are
            // sets to the same value.
            viewState[index] = controllerState[index];
        } else {
            // Next time of method execution: verifies if are changes
            if (stateChanged(index)) {
                if (contentCheck[index] == "all") {
                    clearInterval(observer[index]);
                    updatePage(index);
                } else {
                    viewState[index] = controllerState[index];
                    updateContent(index);
                    var message = $("#Observer_Data_Changed_Alert_Message").val();
                    if (alertFlag[index] == "true" && message != null && message !== 'undefined') {
                        alert(message);
                    }
                }
            }
        }

        if (debug) {
            showStatus(index);
        }
    }
}

// Verifies if controller state is equal or not to the view state
function stateChanged(index) {
    if (controllerState[index] != viewState[index]) {
        return true;
    } else {
        return false
    }
}

// Updates the page by reloading it
function updatePage(index) {
    window.location.href = refreshLocation[index];
}

// Updates a specific content id of a page
function updateContent(index) {
    var viewElement = document.getElementById(contentCheck[index]);
    var swapElement = document.createElement('content');
    swapElement.innerHTML = controllerContent[index];
    var controllerElement = swapElement.firstChild;
    viewElement.innerHTML = controllerElement.innerHTML;
}

// Shows information about the observer
function showStatus(index){
    console.log('Index:' + index);
    console.log('Polling interval:' + pollingInterval[index]);
    console.log('Observes content:' + contentCheck[index]);
    console.log('Controller state:' + controllerState[index]);
    console.log('View State :'+ viewState[index]);
    console.log('JSON Service:'+ serviceLocation[index]);
    console.log('Alert mode:'+ alertFlag[index]);
    console.log("\n");
}



