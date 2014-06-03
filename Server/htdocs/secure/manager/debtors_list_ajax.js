function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Кредитор:</td>'+
            '<td>'+d.creditor+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Дополнительная информация:</td>'+
            '<td>Заглушка для дополнительной информации...</td>'+
        '</tr>'+
    '</table>';
}

$(document).ready(function() {
    var table = $('#list').DataTable({
    	"ajax": "getTable.php",
    	"columns": [
    		{"data": null, "orderable": false, "defaultContent": '', "class": 'details-control'},
    		{"data" : "last_name"},
    		{"data" : "first_name"},
    		{"data" : "middle_name"},
    		{"data" : "passport"},
    		{"data" : "sum"},
    		{"data" : "residue"},
    		{"data" : "status"},
    		{"data" : "collector", "visible": false},
    		{"data" : "creditor", "visible": false}
    	],
        "order": [[ 8, 'asc' ]],
        "displayLength": 25,
        stateSave: true,
        "language": {
            "lengthMenu": "Показано _MENU_ записей на страницу",
            "zeroRecords": "Ничего не найдено",
            "info": "Показана страница _PAGE_ из _PAGES_",
            "infoEmpty": "Нет доступных записей",
            "infoFiltered": "(отфильтровано из _MAX_ записей)",
            "paginate": {
        		"first":      "Первая",
        		"last":       "Последняя",
        		"next":       "Следующая",
        		"previous":   "Предыдущая"
    		},
    		"search": "Поиск:"
        },
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(8, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="8">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
    
     $('#list tbody').on('click', 'td.details-control', function () {
        var tr = $(this).parents('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
 
    // Order by the grouping
    $('#list tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 8 && currentOrder[1] === 'asc' ) {
            table.order( [ 8, 'desc' ] ).draw();
        }
        else {
            table.order( [ 8, 'asc' ] ).draw();
        }
    } );
    
} );
