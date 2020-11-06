
@extends('header')

@section('title')
    Category
@endsection

@section('content')
   
<!-- [ navigation menu ] end -->
    <div id="snackbar"></div>
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
            <div class="alert alert-success alert-dismissible fade show background-success " style="display: none;" id="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <p id="alert_message"></p>
            </div>
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fa fa-list-ul bg-c-blue"></i>
                        <div class="d-inline">
                            <h6>Category</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="{{ url('welcome') }}"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('/Category') }}">Categories</a> 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <!-- [ page content ] start -->
                        
                        <!-- [ page content ] end -->
                    <!-- </div>
                </div>

                <div class="page-wrapper">
                    <div class="page-body"> -->
                        <!-- [ page content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="padding-header">
                                        <div class="row">
                                          <div class="col-sm-8">
                                            <h6>Category List</h6>
                                          </div>
                                          
                                          <div class="col-sm-4">
                                              <button class="btn btn-md btn-primary" style="display: inline-block;float: right;" data-toggle="modal" data-target="#Add_cat_model">Add Category</button>
                                              <a href="{{route('sort_category')}}" class="btn btn-md btn-primary" style="float: right;margin-right: 10px;">Reoreder Categories</a>
                                            
                                          </div>
                                       </div>
                                    </div>
                                    <div class="padding-block">
                                        <div class="dt-responsive table-responsive">
                                            <table id="cat_tbl" class="table table-striped table-bordered nowrap tbl_font-13">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Category Image</th>
                                                        <th>Category Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cat_tbl_body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <!-- </div> -->

            </div>
        </div>
    </div>

    <div class="modal fade-scale" id="Add_cat_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            Add Category &nbsp;

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" id="add_cat_close">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-4"> 
                        <div class="form-group has-success"> 
                          <form method="post" action="{{URL::to('/add_category')}}" id="frm-insert" enctype="multipart/form-data" name="frm_insert">
                            {{csrf_field()}}
                            <div style="max-height: 380px;">
                              <input type="file" id="imgupload" name="image"/>
                                <img src="{{asset('public/assets/images/placeholder_square.png')}}" alt="" id="OpenImgUpload" style="width: 100%;object-fit: contain;max-height: 385px;"><span class="help-block" id="error_Image"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label for="cc-number" class="control-label mb-1">Category Name</label>
                            <input  name="cat_name" type="text" class="form-control" id="cat_name" placeholder="Enter Category Name" >
                            <span class="help-block"  id="error_cat_name"></span>
                        </div>
                        <div class="form-group">
                            <label for="cc-number" class="control-label mb-1">Description</label>
                            <textarea type="text" placeholder="Enter Description" class="form-control" id="cat_des" name="cat_des" rows="5"></textarea>
                            <span id="error_description" class="help-block"></span>
                        </div>
                        <div class="row">
                        
                         
                            <div class="col-12"><button class="confirm btn btn-md btn-inverse" tabindex="1" style="display: inline-block;" type="submit">Save</button>
                            <button class="cancel btn btn-md cancel_btn" tabindex="1" style="display: inline-block;" type="reset">Cancel</button>
                            </div>
                         
                        </div>
                    </div></form></div>
                </div>                            
            </div>
          </div>
        </div>
      </div>
    </div>


     <div class="modal fade-scale" id="edit_cat_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            Edit Category &nbsp;

            <button type="reset" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-4"> 
                        <div class="form-group has-success"> 
                          <form method="post" action="{{URL::to('/update_category')}}" id="frm-update" enctype="multipart/form-data" name="frm_update">
                            {{csrf_field()}}
                            <div style="max-height: 380px;">
                              <input type="file" id="edit_imgupload" name="edit_image"/>
                              <input type="hidden" id="edit_image_name" name="edit_image_name"/>
                              <input type="hidden" id="edit_id" name="edit_id"/>
                              
                                <img src="{{asset('public/assets/images/placeholder_square.png')}}" alt="" id="edit_OpenImgUpload" style="width: 100%;object-fit: contain;max-height: 385px;"><span class="help-block" id="edit_error_image"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label for="cc-number" class="control-label mb-1">Category Name</label>
                            <input  name="edit_name" type="text" class="form-control" id="edit_name" placeholder="Enter Category Name" >
                            <span class="help-block"  id="edit_error_cat_name"></span>
                        </div>
                        <div class="form-group">
                            <label for="cc-number" class="control-label mb-1">Description</label>
                            <textarea type="text" placeholder="Enter Description" class="form-control" id="edit_des" name="edit_des" rows="5"></textarea>
                            <span id="edit_error_description" class="help-block"></span>
                        </div>
                        <div class="row">
                        
                         
                            <div class="col-12"><button class="confirm btn btn-md btn-inverse" tabindex="1" style="display: inline-block;" type="submit">Update</button>
                            <button class="cancel btn btn-md btn-default cancel_btn" tabindex="2" style="display: inline-block;" type="reset">Cancel</button>
                            </div>
                         
                        </div>
                    </div></form></div>
                </div>                            
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
       
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            list_category();
         
        });

        $(document).on('click','#add_cat_close',function(e){
           
            $('#frm-insert').trigger('reset');
            document.getElementById('OpenImgUpload').src="{{asset('public/assets/images/placeholder_square.png')}}" ;
            $('.help-block').empty();
        });

        $(document).on('click','.cancel_btn',function(e){
            document.getElementById('OpenImgUpload').src="{{asset('public/assets/images/placeholder_square.png')}}";
            $('.help-block').empty();
        });

        var loading = $('#loading').hide();
        $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#error_Image').empty();
                    $('#OpenImgUpload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgupload").change(function(){ readURL(this); });

        var loading1 = $('#loading1').hide();
        $('#edit_OpenImgUpload').click(function(){ $('#edit_imgupload').trigger('click'); });
        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    
                    $('#edit_OpenImgUpload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#edit_imgupload").change(function(){ readURL1(this); });

        function list_category(){
            
            $.ajax({
               type:'POST',
               url: '{{ url("/view_category_list") }}',
               success:function(data){
                    var json_obj = $.parseJSON(data);
                    $("#cat_tbl_body").html(json_obj.user);
                    $('#cat_tbl').DataTable({
                        "searching": true,
                         "ordering": true,
                        columnDefs : [
                            { targets: [3], sortable: false},
                        ],
                        order: []
                    });
               }
            });
         }


        $( "#cat_name" ).keydown(function() {
            $('#error_cat_name').empty();
        });
        $( "#cat_des" ).keydown(function() {
             $('#error_description').empty();
        });

         $('#frm-insert').on('submit',function(e){
            e.preventDefault();
            if($('#cat_name').val()=="")
            {
                $('#error_cat_name').text('Category Name is required');
                return false;
            }
            else{
                $('#error_cat_name').empty();
            }
           
            if($('#cat_des').val()=="")
            {
                $('#error_description').text('Category Description is required');
                return false;
            }else{
                $('#error_description').empty();
            }
             if($('#imgupload').val()=="")
            {
                $('#error_Image').text('Choose Category thumb');
                return false;
            }else{
                $('#error_Image').empty();
            }
            var url=$(this).attr('action');
            var post=$(this).attr('method');
             $.ajax({

                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:post,
                url:url,
                data: new FormData( this ),
                processData: false,
                contentType: false,
                dataTy:'json',
                success:function(data)
                {
                  if(data == 0){
                    $('.help-block').empty();
                    $('#error_cat_name').text('Category Name already exists');
                  }
                  if(data == 1){
                    location.reload();
                  }
                  
                },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
              });
          });

         $(document).on('click','#edit',function(e){
        
            var id=$(this).data('id');
          
           
            $.ajax({ 
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '{{URL::to("/edit_category")}}', 
                data: {id:id, },
                dataType: 'json',
                success: function (data) 
                {
                    
                    $.each(data,function(i,value){
                    console.log(value);
                    $('#edit_id').val(value.category_id);
                    $('#edit_name').val(value.category_name);
                    $('#edit_image_name').val(value.category_image);
                    $('#edit_des').val(value.description);
                     
                    
                    document.getElementById('edit_OpenImgUpload').src=`{{asset('public/storage/images/category/${value.category_image}')}}`;
                   
                    })
                    
                }
                });

   
        })

         $('#frm-update').on('submit',function(e){
            e.preventDefault();
            if($('#edit_name').val()=="")
            {
                $('#edit_error_cat_name').text('Category Name is required');
                return false;
            }
            else{
                $('#edit_error_cat_name').empty();
            }
            if($('#edit_des').val()=="")
            {
                $('#edit_error_description').text('Category Description is required');
                return false;
            }else{
                $('#edit_error_description').empty();
            }
            var url=$(this).attr('action');
            var post=$(this).attr('method');
             $.ajax({

                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:post,
                url:url,
                data: new FormData( this ),
                processData: false,
                contentType: false,
                dataTy:'json',
                success:function(data)
                {
                  if(data == 0){
                    $('.help-block').empty();
                    $('#edit_error_cat_name').text('Category Name already exists');
                  }
                  if(data == 1){
                    location.reload();
                  }
                  
                },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
              });
          });


        function get_cat_id(id){

            swal({
                  title: "Are you sure?",
                  text: "You want to delete these Category!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  confirmButtonText: "Yes, delete it!",
                  cancelButtonText: "No, cancel it!",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    $.ajax({
                       type:'POST',
                       data:{id: id},
                       url: '<?php echo url('/category_delete'); ?>',
                       success:function(data){
                            console.log(data);

                            if(data == 0){
                              $("#tr_"+ id).remove();
                             // swal("Deleted!", "User has been deleted.", "success");
                             location.reload();
                            }else if(data == 1){
                                swal("Cancelled", "category can't delete.", "error");
                            }else{
                                swal("Cancelled", "Oops! Something went's Wrong.", "error");
                            }
                       },
                       error:function(data){
                          console.log(data);
                       }
                    });
                  } else {
                    swal("Cancelled", "Your data is safe.", "error");
                  }
            });
        }

        function showsnackbar(text){
            var x = document.getElementById("snackbar");
            x.innerHTML = text+"<button id='dismiss' type='button' onclick='hidesnackbar();' class='close' style='padding-left:20px'><span aria-hidden='true' class='fa fa-times' style='font-size: 20px;color:#fff'></span></button> ";
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", "");  x.innerHTML = "";}, 3000);
        }
        function hidesnackbar() {
           var x = document.getElementById("snackbar");
            x.innerHTML='';
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, -1);
        } 

    </script>
@endsection
