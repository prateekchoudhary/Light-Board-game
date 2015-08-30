/**********************************************************/
/***************** JQUERY Plugin for basic grid ***********/
/***************** @author : prateek.choudhary ************/
/***************** ****************************************/
/**********************************************************/

(function ($) {
$.fn.lbgrid = function(options) {
self.display = $(this);
var defaults = {
    COLUMNLEN : 10,
    ROWLEN : 10,
    TDWIDTH : 25,
    TDHEIGHT : 25,
    TABLEBORDER : 0,
    ROWSPAN :0,
    COLSPAN :0,
    background :'white'
     
}
 
var opts = $.extend(defaults, options);     
init(opts);
}
 
function init(settings) {

    html = "<table id=\"mytable\" border="+settings.TABLEBORDER+">";
    for (i=0;i<settings.ROWLEN;i++) {

        html += "<tr class=\"tr_id\" id=\"row_"+i+"\">";
        for (j=0;j<settings.COLUMNLEN;j++) {
            html +="<td class=\"td_id\" id=\"row_"+i+"_col_"+j+"\">";
            //html +="<td rowspan="+settings.ROWSPAN+" class=\"td_id\" id=\"row_"+i+"_col_"+j+"\" style=\"background-color:"+settings.background+";height:"+settings.TDHEIGHT+";width:"+settings.TDWIDTH+"\"><a href=\"javascript:void(0);\"></a></td>";
        }
        html +="</tr>";
    }
    html +="</table>";
    self.display.html(html);
}
 
})(jQuery);

