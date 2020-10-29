/**
 * 倒计时
 */
var downtime = function( t , func ) {
    t--;
    var result = func.call(func, t);
    if(result !== false && t > 0) {
        setTimeout(function() {
            downtime(t, func);
        }, 1000);
    }
};
