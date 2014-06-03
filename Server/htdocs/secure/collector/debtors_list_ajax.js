function format ( d ) {
    // `d` is the original data object for the row
    return '<form action=update.php method=post><table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Кредитор:</td>'+
            '<td>'+d.creditor+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Дополнительная информация:</td>'+
            '<td>Заглушка для дополнительной информации...</td>'+
        '</tr>'+
         '<tr>'+
            '<td>Новый остаток:</td>'+
            '<td><input type=text name=residue value="'+ d.residue + '"></td>'+
        '</tr>'+
         '<tr>'+
            '<td>Новый статус:</td>'+
            '<td><input list=statuses type=text name=status value="'+ d.status + '">' + 
            '<datalist id=statuses><option value="В ожидании"><option value="Поиск должника"><option value="Взыскивается">' +
			'<option value="Долг погашен"><option value="Дело в суде"><option value="Дело проиграно"><option value="Истёк срок контракта">'+
        '</datalist></td></tr>'+
         '<tr>'+
         	'<input type=hidden name=job_id value=' + d.id + '>' +
            '<td><input type=submit name=cancel value="Отменить":</td>'+
            '<td><input type=submit name=update value="ОК"></td>'+
        '</tr>'+
    '</table></form>';
}

function getId()
{
	var name = "id=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i].trim();
		if (c.indexOf(name)==0) return c.substring(name.length,c.length);
	}
	return "";
} 

$(document).ready(function() {
    var table = $('#list').DataTable({
    	"ajax": "getTable.php?id="+getId(),
    	"processing": true,
    	"serverside": true,
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
    		{"data" : "creditor", "visible": false},
    		{"data" : "id", "visible": false, "searchable": false}
    	],
        "order": [[ 1, 'asc' ]],
        "displayLength": 10,
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
    
} );
