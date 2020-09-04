@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Product</h1>
    </div>

         <section>
         	<div id="msg">
         		<h1 class="text-success">Successfully Added</h1>
         	</div>
        <div class="row justify-content-between">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <input type="text" naem="product_name" id="product_name" placeholder="Product Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Product SKU</label>
                            <input type="text" name="product_sku" id="product_sku" placeholder="Product Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" id="description" cols="30" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Media</h6>
                    </div>
                    <div class="card-body border">
                        
                       <input type="file" name="image[]" id="image" multiple>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Variants</h6>
                    </div>
                    <div class="card-body">

                    		<table class="table table-bordered table-hover table-sortable" id="tab_logic">
				<thead>
					<tr >
						<th class="text-center">
							Options
						</th>
						<th class="text-center">
							Variant
						</th>
        				<th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
						</th>
					</tr>
				</thead>
				<tbody>
    				<tr id='addr0' data-id="0" class="hidden">
    				    <td data-name="sel">
						    <select name="sel0" class="form-control">
        				        @foreach($variants as $variant)
                                    <option value="{{$variant->id}}">{{$variant->title}}</option>
                                @endforeach
						    </select>
						</td>
						<td data-name="name">
						    <input type="text" name='name0'  placeholder='Name' class="form-control"/>
						</td>
    					
                        <td data-name="del">
                            <button name="del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'><span aria-hidden="true">×</span></button>
                        </td>
					</tr>
				</tbody>
			</table>
                        {{-- <div class="row " id="">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Option</label>
                                    <select name="option" class="form-control">
                                    	@foreach($variants as $variant)
                                        <option value="">{{$variant->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                	<label for="">Enter Variants name</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div> --}}
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" id="add_row">Add another option</button>
                    </div>

                    <div class="card-header text-uppercase">Preview</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td>Variant</td>
                                    <td>Price</td>
                                    <td>Stock</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>rte5</td>
                                    <td>
                                        <input type="text" class="form-control" name="price" id="price">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="stoke" id="stoke">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        

        <button  type="submit" class="btn btn-lg btn-primary" id="save">Save</button>
        <button type="button" class="btn btn-secondary btn-lg">Cancel</button>
        </form>
    </section>
   
@endsection

@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
    $("#add_row").on("click", function() {
       
        var newid = 0;
        $.each($("#tab_logic tr"), function() {
            if (parseInt($(this).data("id")) > newid) {
                newid = parseInt($(this).data("id"));
            }
        });
        newid++;
        
        var tr = $("<tr></tr>", {
            id: "addr"+newid,
            "data-id": newid
        });
        
        // loop through each td and create new elements with name of newid
        $.each($("#tab_logic tbody tr:nth(0) td"), function() {
            var td;
            var cur_td = $(this);
            
            var children = cur_td.children();
            
            // add new td and element if it has a nane
            if ($(this).data("name") !== undefined) {
                td = $("<td></td>", {
                    "data-name": $(cur_td).data("name")
                });
                
                var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                c.attr("name", $(cur_td).data("name") + newid);
                c.appendTo($(td));
                td.appendTo($(tr));
            } else {
                td = $("<td></td>", {
                    'text': $('#tab_logic tr').length
                }).appendTo($(tr));
            }
        });
        
        // add delete button and td
        /*
        $("<td></td>").append(
            $("<button class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>")
                .click(function() {
                    $(this).closest("tr").remove();
                })
        ).appendTo($(tr));
        */
        
        // add the new row
        $(tr).appendTo($('#tab_logic'));
        
        $(tr).find("td button.row-remove").on("click", function() {
             $(this).closest("tr").remove();
        });
	});




    // Sortable Code
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
    
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        
        return $helper;
    };
  
    $(".table-sortable tbody").sortable({
        helper: fixHelperModified      
    }).disableSelection();

    $(".table-sortable thead").disableSelection();



    $("#add_row").trigger("click");
});


$(document).ready(function() {
    $('#save').on('click', function() {
    	 $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
    	var product_name = $('#product_name').val();
     	var product_sku = $('#product_sku').val();
     	var description = $('#description').val();
     	var price = $('#price').val();
     	var stoke = $('#stoke').val();
     var form_data = new FormData();

   // Read selected files
   var totalfiles = document.getElementById('image').files.length;
   var filesInfo = document.getElementById('image').files;
   console.log(document.getElementById('image').files[0]);
   for (var index = 0; index < totalfiles; index++) {
      form_data.append("image[]",filesInfo[index]);
   }
   form_data.append('product_name',product_name);
   form_data.append('product_sku',product_sku);
   form_data.append('description',description);
   form_data.append('price',price);
   form_data.append('stoke',stoke);
//    form_data.append('test',1);
//    // Display the key/value pairs
// for (var pair of form_data.entries()) {
//     console.log(pair[0]+ ', ' + pair[1]); 
// }





 
     
      	$.ajax({
              url: "{{route('product.store')}}",
              type: "POST",
              data:form_data,
              cache: false,
	           processData: false,
				contentType: false,
              success: function(dataResult){
                  $('#msg').html(data).fadeIn('slow');
				     //$('#msg').html("data insert successfully").fadeIn('slow') //also show a success message 
				     $('#msg').delay(5000).fadeOut('slow');
                  
              }
          });
      
    });
});
</script>
@endsection
