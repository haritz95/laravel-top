// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('#category').select2({
    	theme: "classic"
    });
});

$("#tags").select2({
    tags: true,
    tokenSeparators: [',', ' ']
})

jQuery(document).ready(function(){
            jQuery('#visit').click(function(e){
            	var url = window.location.pathname;
            	var site = url.split("/");

               $.ajaxSetup({
                  headers: {
				    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				  }
              });
               jQuery.ajax({
                  url: "http://top.test/visit/add",
                  method: 'POST',
                  data: {
                     site: site[2],
                  },
              	});
               });
            });

function deleteData(id)
  {
    var id = id;
    var url = '{{ route("sites.destroy", ":id") }}';
    url = url.replace(':id', id);
    $("#deleteForm").attr('action', url);
  }

function formSubmit()
  {
    $("#deleteForm").submit();
  }
$(document).ready(function() {
  $('#summernote').summernote();
});  

/* CHANGE USER PASSWORD */
jQuery(document).ready(function(){
            jQuery('#update_account').click(function(e){
               e.preventDefault();
               $( ".alert-danger" ).html('');
               jQuery.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "http://top.test/dashboard/account/password_update",
                  method: 'post',
                  data: {
                     current: jQuery('#current-password').val(),
                     password: jQuery('#password').val(),
                     confirmation: jQuery('#password_confirmation').val()
                  },
                  success: function(data){
                    if (data instanceof Object) {
                      jQuery.each(data.errors, function(key, value){
                        jQuery('#pass_info').removeClass('alert-succes');
                        jQuery('#pass_info').addClass('alert-danger');
                        jQuery('.alert-danger').fadeIn();
                        jQuery('.alert-danger').append('<p>'+value+'</p>');
                        setTimeout(function() { $(".alert-danger").fadeOut(); }, 5000);
                      });
                    }else{
                      jQuery('#pass_info').removeClass('alert-danger');
                      jQuery('#pass_info').addClass('alert-success');
                      jQuery('.alert-success').fadeIn();
                      jQuery('.alert-success').append('<p>'+data+'</p>');
                      setTimeout(function() { $(".alert-success").fadeOut(); }, 2000);
                    }   
                  }
                    
                  });
               });
            });

/* CREATE A NEW ADD */
jQuery(document).ready(function(){
            jQuery('#create_ad').click(function(e){
               e.preventDefault();
               jQuery.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "http://top.test/dashboard/create_ad",
                  method: 'post',
                  data: {
                     spot: jQuery('#spot').val(),
                     days: jQuery('#days').val(),
                     website: jQuery('#website').val(),
                     banner_link: jQuery('#banner_link').val()
                  },
                  success: function(data){
                    if (data instanceof Object) {
               
                    }else{
                      alert("perfect");
                    }   
                  }
                    
                  });
               });
            });