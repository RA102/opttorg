$(document).ready(function(event) {
    $('tr[name*="addPartItem"]').on('click', function(event) {
        const addRow = $(this).prev();

        let cloneRow = addRow.clone();

        cloneRow.find('input').val('');

        $(this).before(addRow.clone());

    })
})