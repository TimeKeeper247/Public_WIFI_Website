function thumbgen(itemID, itemName){
var keyword = itemName;

$(document).ready(function(){

    $.getJSON("//api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
    {
        tags: keyword,
        tagmode: "any",
        format: "json"
    },
    function(data) {
        var rng = Math.floor(Math.random() * data.items.length);

        var image_src = data.items[rng]['media']['m'].replace('_m', '_b');

        $("#" + itemID).attr('src', image_src);

    });
});
}