/**
 * Created by yiban on 16/5/23.
 *  author:liuchengbin
 *  desc:js<->oc js<->android
 */

/*
 鍑芥暟鍚嶇О锛歜rowser
 鍑芥暟浣滅敤锛氬垽鏂闂粓绔�
 鍙傛暟璇存槑锛氭棤
*/
var browser = {
    versions: function() {
        var u = navigator.userAgent,
        app = navigator.appVersion;
        return {
            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //鏄惁涓虹Щ鍔ㄧ粓绔�
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios缁堢
            android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1, //android缁堢
            iPhone: u.indexOf('iPhone') > -1, //鏄惁涓篿Phone鎴栬€匭QHD娴忚鍣�
            iPad: u.indexOf('iPad') > -1, //鏄惁iPad
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
}


/*
 鍑芥暟鍚嶇О锛歡etLocation
 鍑芥暟浣滅敤锛氳幏鍙栧湴鐞嗕綅缃�
 鍙傛暟璇存槑锛氭棤
 */
function gethtml5location_fun() {
    if (browser.versions.android) {
        //android 璋冪敤鏂瑰紡
        window.local_obj.yibanhtml5location();
    } else if (browser.versions.ios) {
        ios_yibanhtml5location();
    } else {
        onerror('璇ョ粓绔被鍨嬫殏涓嶆敮鎸佷娇鐢�');
    }
}

/*
 鍑芥暟鍚嶇О锛歽ibanhtml5location
 鍑芥暟浣滅敤锛氬鎴风鑾峰彇鍦扮悊浣嶇疆锛屽紓姝ヨ繑鍥炰綅缃俊鎭�,html鏍规嵁杩斿洖淇℃伅鍋氱晫闈㈠唴瀹瑰鐞�
 鍙傛暟璇存槑锛歱ostion  鏍煎紡:{"longitude": "","latitude": "","address": ""}
 */
function yibanhtml5location(postion) {
    var editedHTML = document.getElementById("yibanhtml5");
    editedHTML.textContent = postion.match("address.*");
}

/*
 鍑芥暟鍚嶇О锛歱hone
 鍑芥暟浣滅敤锛氭嫧鎵撶數璇�
 鍙傛暟璇存槑锛氱數璇濆彿鐮�
 */
function phone_fun(num) {
    var pre = /^1\d{10}$/;
    var tre = /^0\d{2,3}-?\d{7,8}$/;
    if (pre.test(num) || tre.test(num)) {
        if (browser.versions.android) {
            //android 璋冪敤鏂瑰紡
            window.local_obj.phone(num);
        } else if (browser.versions.ios) {
            phone(num);
        } else {
            onerror('璇ョ粓绔被鍨嬫殏涓嶆敮鎸佷娇鐢�');
        }
    } else {
        onerror('鎵嬫満鍙锋牸寮忛敊璇�');
    }
}

/*
 鍑芥暟鍚嶇О锛歮ail
 鍑芥暟浣滅敤锛氬彂閭欢
 鍙傛暟璇存槑锛歟mail鍦板潃
 */
function mail_fun(email) {
    var re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/
    if (re.test(email)) {
        if (browser.versions.android) {
            //android 璋冪敤鏂瑰紡
            window.local_obj.mail(email);
        } else if (browser.versions.ios) {
            mail(email);
        } else {
            onerror('璇ョ粓绔被鍨嬫殏涓嶆敮鎸佷娇鐢�');
        }
    } else {
        onerror('閭鍦板潃鏍煎紡閿欒');
    }
}

/*
 鍑芥暟鍚嶇О锛歟ncode
 鍑芥暟浣滅敤锛氭壂涓€鎵�
 鍙傛暟璇存槑锛歝ontent鍐呭
 */
function encode_fun() {
    if (browser.versions.android) {
        //android 璋冪敤鏂瑰紡
        window.local_obj.encode();
    } else if (browser.versions.ios) {
        encode();
    } else {
        onerror('璇ョ粓绔被鍨嬫殏涓嶆敮鎸佷娇鐢�');
    }
}

/*
 鍑芥暟鍚嶇О锛歜ack
 鍑芥暟浣滅敤锛氳繑鍥瀉pp
 鍙傛暟璇存槑锛歝ontent鍐呭
 */
function back_fun() {
    if (browser.versions.android) {
        //android 璋冪敤鏂瑰紡
        window.local_obj.back();
    } else if (browser.versions.ios) {
        back();
    } else {
        onerror('璇ョ粓绔被鍨嬫殏涓嶆敮鎸佷娇鐢�');
    }
}

/*
 鍑芥暟鍚嶇О锛歰nerror
 鍑芥暟浣滅敤锛氶潪瀹㈡埛绔殑閿欒澶勭悊
 鍙傛暟璇存槑锛歟rrorInfo  閿欒淇℃伅   鐢ㄦ埛鑷畾涔夋牸寮�
 */
function onerror(errorInfo) {
   var editedHTML = document.getElementById("yibanhtml5");
   editedHTML.textContent = errorInfo;
}