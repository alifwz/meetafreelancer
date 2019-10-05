<?php
include "connection.php";
include "header.php";
?>
<script>
$(document).ready(function() {
$('#post-photo-upload').change(function(){
var file_data = $('#post-photo-upload').prop('files')[0];   
var form_data = new FormData();                  
form_data.append('file', file_data);
$.ajax({
    url: "pro-img-disk.php",
    type: "POST",
    data:  form_data,
    contentType: false,
    cache: false,
    processData:false,
    success: function(data){
        console.log(data);
    }
});
});
});
</script>
<input type='file' name='inputfile' id='post-photo-upload'>