<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Moderator dodawanie zakładów</title>
<link rel="stylesheet" href="dist/bootstrap.min.css" type="text/css" media="all">
<link href="dist/jquery.bootgrid.css" rel="stylesheet" />
<script src="dist/jquery-1.11.1.min.js"></script>
<script src="dist/bootstrap.min.js"></script>
<script src="dist/jquery.bootgrid.min.js"></script>
</head>
<body>
	<div class="container">
      <div class="">
        <h1>Dodawanie nowych zakładów</h1>
        <div class="col-sm-8">
		<div class="well clearfix">
			<div class="pull-right"><button type="button" class="btn btn-xs btn-primary" id="command-add" data-row-id="0">
			<span class="glyphicon glyphicon-plus"></span>Dodaj zakład</button></div></div>
		<table id="user_grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
			<thead> 
				<tr>
					<th data-column-id="betsID" data-type="numeric" data-identifier="true">ID</th>
					<th data-column-id="category">Kategoria</th>
					<th data-column-id="rateX">Float X</th>
					<th data-column-id="rateY">Float Y</th>
					<th data-column-id="druzynaA">druzyna A</th>
					<th data-column-id="druzynaB">druzyna B</th>
					<th data-column-id="commands" data-formatter="commands" data-sortable="false">Usuń</th>
				</tr>
			</thead>
		</table>
    </div>
      </div>
    </div>
	
<div id="add_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Dodaj zakład</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_add">
				<input type="hidden" value="add" name="action" id="action">
                  <div class="form-group">
                    <label for="name" class="control-label">Kategoria:</label>
                    <input type="text" class="form-control" id="category" name="category"/>
                  </div>
                  <div class="form-group">
                    <label for="password" class="control-label">Float X:</label>
                    <input type="text" class="form-control" id="rateX" name="rateX"/>
                  </div>
				  <div class="form-group">
                    <label for="role" class="control-label">Float y:</label>
                    <input type="text" class="form-control" id="rateY" name="rateY"/>
                  </div>
				  <div class="form-group">
                    <label for="role" class="control-label">druzyna A:</label>
                    <input type="text" class="form-control" id="druzynaA" name="druzynaA"/>
                  </div>
				  <div class="form-group">
                    <label for="role" class="control-label">druzyna B:</label>
                    <input type="text" class="form-control" id="druzynaB" name="druzynaB"/>
                  </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                <button type="button" id="btn_add" class="btn btn-primary">Dodaj</button>
            </div>
			</form>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
$( document ).ready(function() {
	var grid = $("#user_grid").bootgrid({
		ajax: true,
		rowSelect: true,
		post: function ()
		{	},
		url: "dodajzaklad.php",
		formatters: {
		        "commands": function(column, row)
		        {
		            return "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.betsID + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
		        }
		    }
   }).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    grid.find(".command-edit").on("click", function(e)
    {
        //alert("You pressed edit on row: " + $(this).data("row-id"));
			var ele =$(this).parent();
			var g_id = $(this).parent().siblings(':first').html();
            var g_name = $(this).parent().siblings(':nth-of-type(2)').html();
console.log(g_id);
                    console.log(g_name);

		//console.log(grid.data());//
		$('#edit_model').modal('show');
					if($(this).data("row-id") >0) {
							
                                // collect the data
                                $('#edit_id').val(ele.siblings(':first').html()); // in case we're changing the key
                                $('#edit_login').val(ele.siblings(':nth-of-type(2)').html());
                                $('#edit_password').val(ele.siblings(':nth-of-type(3)').html());
                                $('#edit_role').val(ele.siblings(':nth-of-type(4)').html());
					} else {
					 alert('Now row selected! First select row, then click edit button');
					}
    }).end().find(".command-delete").on("click", function(e)
    {
	
		var conf = confirm('Delete ' + $(this).data("row-id") + ' items?');
					alert(conf);
                    if(conf){
                                $.post('dodajzaklad.php', { betsID: $(this).data("row-id"), action:'delete'}
                                    , function(){
                                        // when ajax returns (callback), 
										$("#user_grid").bootgrid('reload');
                                }); 
								//$(this).parent('tr').remove();
								//$("#user_grid").bootgrid('remove', $(this).data("row-id"))
                    }
    });
});

function ajaxAction(action) {
				data = $("#frm_"+action).serializeArray();
				$.ajax({
				  type: "POST",  
				  url: "dodajzaklad.php",  
				  data: data,
				  dataType: "json",       
				  success: function(response)  
				  {
					$('#'+action+'_model').modal('hide');
					$("#user_grid").bootgrid('reload');
				  }   
				});
			}
			
			$( "#command-add" ).click(function() {
			  $('#add_model').modal('show');
			});
			$( "#btn_add" ).click(function() {
			  ajaxAction('add');
			});
});
</script>
