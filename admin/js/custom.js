$(document).ready(function(event) {
    $('tr[name*="addPartItem"]').on('click', function(event) {
        const addRow = $(this).prev();

        $(this).before(addRow.clone());

    })
})