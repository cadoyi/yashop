/**
 * 通用库.
 *
 * @author  zhangyang zhangyangcado@qq.com
 */

/**
 * 设置 cookie 值.
 * 
 * @param string name  名称
 * @param string value 值
 * @param int lifetime 过期时间,单位秒
 */
function setCookie(name, value, lifetime)
{
    var cookie = name + '=' + encodeURIComponent(value);
    if(!isNaN(lifetime)) {
        var d = new Date();
        if(lifetime < 0) {
            d.setTime(d.getTime() - 3600000);
            lifetime = -1;
            cookie += '; expires=' + d.toUTCString();
            console.log(cookie);
        } else {
            d.setTime(d.getTime() + lifetime * 1000); 
            cookie += '; expires=' + d.toUTCString() + '; max-age=' + lifetime;
        }
    }
    document.cookie = cookie;
}

/**
 * 获取所有 cookie 的值.
 * 
 * @return object
 */
function getCookies()
{
    var result = {};
    var cookies = (document.cookie || '').split('; ');
    var len = cookies.length,
    i = 0;
    for(;i<len; i++) {
        var cookie = cookies[i].split('=');
        var k = cookie[0];
        var v = decodeURIComponent(cookie[1] || '');
        result[k] = v;
    }
    return result;
}

/**
 * 获取 cookie 的值.
 * 
 * @param  string name  cookie 名称
 * @return mixed  cookie 值.
 */
function getCookie(name)
{
    var cookies = getCookies();
    if(name in cookies) {
        return cookies[name];
    }
    return null;
}

/**
 * 删除 cookie
 * 
 * @param  string name 
 */
function removeCookie(name)
{
    return setCookie(name, '', -3600);
}


/**
 * 是否支持存储.
 * 
 * @return {Boolean}
 */
function hasStorage(type)
{
    type = type || 'sessionStorage';
    try {
        var storage = window[type];
        var v = '__storage_test__';
        storage.setItem(v, v);
        storage.removeItem(v);
        return true;
    } catch(e) {
        return false;
    }
}



/**
 * 停止事件
 * 
 * @param  Event e  事件对象
 * @param  boolean immediate 是否立即停止
 */
function stopEvent(e, immediate) {
    e.preventDefault();
    e.stopPropagation();
    if(immediate) {
        e.stopImmediatePropagation();
    }
}



var ActiveFormHelper = function( formSelector ) {
    this.form = $(formSelector);
    this.data = this.form.yiiActiveForm('data');
};

ActiveFormHelper.prototype = {
    getAttribute: function( name ) {
        var attribute;
        $.each(this.data.attributes, function() {
            if(this.name === name) {
                 attribute = this;
                 return false;
            }
        });
        return attribute;
    }
}