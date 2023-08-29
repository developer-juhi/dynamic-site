$(document).ready(function () {
    $('#contactus_list').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [], 
    "ajax": {
        "url": "admin-inquiry-data",
        "dataType": "json",
        "type": "POST",
        },
    });
});

