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
                      var logout = function(){$.ajax
                      ({
                          type: 'POST',
                          url: '/logout',
                          success: function()
                          {
                              location.reload();
                          }
                      });}
                      setTimeout(logout, 3000);
                    }   
                  }
                    
                  });
               });
            });

/* CREATE A NEW ADD */
jQuery(document).ready(function(){
            jQuery('#create_ad').click(function(e){
              $( "#ad_info" ).html('');
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
                      jQuery.each(data.errors, function(key, value){
                        jQuery('#pass_info').removeClass('alert-succes');
                        jQuery('#pass_info').addClass('alert-danger');
                        jQuery('.alert-danger').fadeIn();
                        jQuery('.alert-danger').append('<p>'+value+'</p>');
                        setTimeout(function() { $(".alert-danger").fadeOut(); }, 5000);
                      });
                    }else{
                      jQuery('#ad_info').removeClass('alert-danger');
                      jQuery('#ad_info').addClass('alert-success');
                      jQuery('.alert-success').fadeIn();
                      jQuery('.alert-success').append('<p>'+data+'</p>');
                      $('#create_ad_form').trigger("reset");
                      setTimeout(function() { $(".alert-success").fadeOut(); }, 2000);
                    }   
                  }
                  });
               });
            });


$( '.ad-site' ).click(function(e) {;
  e.preventDefault; // Prevent the default behavior of the  element.
  var adId = $(this).data('id'); // Get the post ID from our data attribute
  registerPostClick(adId); // Pass that ID to our function. 
});

function registerPostClick(postId) {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  })
  $.ajax({
    type: 'post',
    dataType: 'JSON',
    url: '/ad/' + postId + '/click',
    error: function (xhr, ajaxOptions, thrownError) {
           console.log(xhr.status);
           console.log(JSON.stringify(xhr.responseText));
       }
  });
}