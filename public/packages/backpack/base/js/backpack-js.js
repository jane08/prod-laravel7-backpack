$(".coursesFile").each(function() {
    var block = $(this);
    var field = block.find(".courses_form__file-field");
    var text = block.find(".courses_form__file-text");
    field.change(function(e) {
        var fileName = e.target.files[0].name;
        text.text(fileName);
    });
});
