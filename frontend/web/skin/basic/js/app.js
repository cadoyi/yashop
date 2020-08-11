/**
 * app js
 * 
 */

/**
 * 停止事件执行
 * 
 * @param  Event e 
 * @param  boolean im  是否立即停止
 */
var stopEvent = function( e , im) {
    e.preventDefault();
    e.stopPropagation();
    if(im) {
        e.stopImmediatePropagation();
    }
}