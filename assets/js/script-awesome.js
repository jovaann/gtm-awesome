jQuery(document).ready(function($) {
    $(".add-new-code").click(function() {
        const codeType = $(this).data("type");
        const textarea = $("<textarea name='script_awesome_code_" + codeType + "[]' rows='8' cols='150'></textarea><br>");
        $(this).before(textarea);
    });

    // Function to remove empty textareas
    function removeEmptyTextareas() {
        $('textarea').each(function() {
            if ($(this).val() === '' && $('textarea').length > 2) {
                $(this).remove();
            }
        });
    }

    // Initialize by removing empty textareas
    removeEmptyTextareas();

    // After saving, remove empty textareas
    $('#post').submit(function() {
        removeEmptyTextareas();
    });

    $(".add-new-code-head").click(function() {
        const textarea = $("<textarea name='script_awesome_code_head[]' rows='4' style='width: 100%;'></textarea>");
        $(this).before(textarea);
    });

    $(".add-new-code-body").click(function() {
        const textarea = $("<textarea name='script_awesome_code_body[]' rows='4' style='width: 100%;'></textarea>");
        $(this).before(textarea);
    });
});
