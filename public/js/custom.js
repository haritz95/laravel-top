// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('#category').select2({
    	theme: "classic"
    });
});

$("#tags").select2({
    tags: true,
    tokenSeparators: [',', ' '],
    maximumSelectionLength: 5,
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
    var url = 'http://top.test/sites/' + id;
    url = url.replace(':id', id);
    $("#deleteForm").attr('action', url);
  }

function formSubmitSite()
  {
    $("#deleteForm").submit();
  }

function deleteUser(id)
  {
    var id = id;
    var url = 'http://top.test/user/' + id;
    url = url.replace(':id', id);
    $("#deleteFormUser").attr('action', url);
  }

function formSubmitUser()
  {
    $("#deleteFormUser").submit();
  }

function deleteAd(id)
  {
    var id = id;
    var url = 'http://top.test/ad/' + id;
    url = url.replace(':id', id);
    $("#deleteFormAd").attr('action', url);
  }

function formSubmit()
  {
    $("#deleteFormAd").submit();
  }

function deleteCategory(id)
  {
    var id = id;
    var url = 'http://top.test/category/' + id;
    url = url.replace(':id', id);
    $("#deleteFormCategory").attr('action', url);
  }

function formSubmitCategory()
  {
    $("#deleteFormCategory").submit();
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
/*jQuery(document).ready(function(){
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
                     tittle: jQuery('#tittle').val(),
                     website: jQuery('#website').val(),
                     banner_link: jQuery('#banner_link').val(),
                     banner_upload: jQuery('#banner_upload').val()
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
            });*/


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

function banUser(id)
  {
    var id = id;
    var url = 'http://top.test/user/'+ id +'/ban';
    $("#ban_user").attr('action', url);
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   })
    $(document).ajaxStart(function() {
      $("#loading").show();
    }).ajaxStop(function() {
      $("#loading").hide();
    });

    $.ajax({
      method: 'POST', // Type of response and matches what we said in the route
      url: '/user/info/' + id, // This is the url we gave in the route
      data: {'id' : id}, // a JSON object to send back
      success: function(response){ // What to do if we succeed
        if($.trim(response)){
            $.each(response, function(index, element) {
                  var expire = new Date(element.expire_date);
                  var today = new Date($.now());
                  if(expire < today){
                    element.expire_date = "Never";
                  }

            $('#user_info').html("<div class='alert alert-danger'><center><h3 id='user_info'>This user is already banned. Expire in: <b>"+element.expire_date+"</b> Reason: <b>"+element.reason+"</b> If you ban again, will update the ban that is actually on.</h3></center></div>");
            });
        }else{
            $('#user_info').html("");
        }
      },
      error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
      }
  });

  }

function formBan()
  {
    $("#ban_user").submit();
  }

function display(id){
  if(id == 1){
    $('#premium_div').show();
  }else{
    $('#premium_div').hide();
  }
  
}


$( document ).ready(function() {
    $('.email-user').on('change', function() {
        //ajax request
        $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   })
        $.ajax({
            url: "http://top.test/user/emailcheck",
            method: "post",
            data: {
                'email' : $('#email').val()
            },
            success: function(data) {
              if(data){
                alert(data);
              } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});

$( document ).ready(function() {
    $('.user-view').on('click', function() {
        //ajax request
        id = $(this).data("id");
        //$(".title-modal").html("Update User");
        $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      $(document).ajaxStart(function() {
      $("#loading-update").show();
        }).ajaxStop(function() {
      $("#loading-update").hide();
      $("#user-form").show();
        });
        $.ajax({
            url: "http://top.test/user/"+id+"/info",
            method: "post",
            success: function(data) {
              if(data){
                display(data.premium);
                $("#name").val(data.name);
                $("#email").val(data.email);
                $("#role").val(data.role_id);
                $("#status").val(data.status_id);
                $("#premium").val(data.premium);
                $("#premium-date").val(data.end_premium);
                $('#user-form').attr('action', "/user/"+id);
              } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});

$( document ).ready(function() {
    $('.add-category').on('click', function(e) {
      var link = $("#banner_link").val();
      var category = $("#category-name").val();
      if(link == "" && $("#banner").get(0).files.length == 0 && category == ""){
        $("#banner_link").addClass("is-invalid");
        $("#banner").addClass("border-fail");
        $("#category-name").addClass("is-invalid");
        return false;
      }
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $.ajax({
            url: "/category/check",
            type: "POST",
            data: {
                'category' : $('#category-name').val()
            },
            success: function(data) {
              if(data){
                alert("That category already existst!");
              }else{
                $("#add-category").submit();
              }
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});

$( document ).ready(function() {
    $('.edit-category').on('click', function() {
      var name = $(this).data("name");
      var image = $(this).data("image");
      var id = $(this).data("id");

      $('#category-form').attr('action', 'http://top.test/category/update/' + id);

      $("#name-category").val(name);
      $("#image-category").val(image);
      $("#banner-image").attr("src", image);

    });
});

