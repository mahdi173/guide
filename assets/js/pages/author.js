$( document ).ready(function() {
    var type=$("#searchType").val()
    if("journal"==type){
        $("#search-journal" ).css('backgroundColor','#F15A24')
        $("#search-author").css('backgroundColor','#A0A0A0')
        $("#search-author").css('opacity','0.9')
    }else{
        $("#search-author").css('backgroundColor','#F15A24')
        $("#search-journal").css('backgroundColor','#A0A0A0')
        $("#search-journal").css('opacity','0.9')
    }
});
$( "#search-journal" ).click(function() {
    $('#search').attr('placeholder','Full Title, word, ISSN');
    $(this).css('backgroundColor','#F15A24')
    $("#search-author").css('backgroundColor','#A0A0A0')
    $("#search-author").css('opacity','0.9')
    $("#searchType").val('journal')

});$( "#search-author" ).click(function() {
    $('#search').attr('placeholder','Author name');
    $(this).css('backgroundColor','#F15A24')
    $("#search-journal").css('backgroundColor','#A0A0A0')
    $("#search-journal").css('opacity','0.9')
    $("#searchType").val('author')

});
