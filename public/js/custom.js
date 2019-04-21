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
                  url: "{{URL::route('visit')}}",
                  method: 'post',
                  data: {
                     site: site[2],
                  },
              	});
               });
            });