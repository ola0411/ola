var $j = jQuery;
$j(document).ready(function(){
var cache = {};
$j(search_box).autocomplete({
source: function (request, response) {

var term = request.term;
if (term in cache) {
response(cache[term]);
return;
}
$j.getJSON(ajx_path,{action : 'autocompleteCallback',term: request.term},  function (data, status, xhr) {
cache[term] = data;
response(data);
});
},
minLength: min_Length,
}).data("uiAutocomplete")._renderItem = function (ul, item) {
var term = this.term.split(' ').join('|');
var re = new RegExp("(" + term + ")", "gi");
var t = item.title.replace(re, "<u>$1</u>");
var poster = item.post_author;
if (poster != '') {
t += '<span class="s"> by ' + poster + "</span>";
}
var slug = item.slug;

return $j("<li />")
.data("item.autocomplete", item)
.append("<a href=" + slug +" ><img src='" + item.post_img + "' onerror=\"this.src ='" + no_img + "';\"/><div>" + t + "</div><div class='s'>Posted on "+ item.pubdate +"</div></a>")
.appendTo(ul);
}; 
$j(search_box).focus(function () {
if (this.value.length > 0) $j('.ui-autocomplete').show();
});
});