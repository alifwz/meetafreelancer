<?php
require_once('auth.php');
include "header.php";
?>
<link href="build/css/jquery.magnify.css" rel="stylesheet">
<!--<link rel="stylesheet" type="text/css" href="../css/jquery.simpleLens.css">
    <link rel="stylesheet" type="text/css" href="../css/jquery.simpleGallery.css">
<link href="production/css/lightbox.css" rel="stylesheet">-->
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Report/Abuse</h3>
            </div>             
        </div>

        <div class="clearfix"></div>
        <div class="row">             
            <div class="clearfix"></div>		  
            <div class="col-md-12 col-sm-12 col-xs-12">			  
                <div class="x_panel"> 								
                    <div class="x_content"> 				  
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">                            
                                        <th width="100" class="column-title">Sl. No </th>
                                        <th width="300" class="column-title">Abused By</th> 							
                                        <th width="300" class="column-title">Posted User </th> 							
                                        <th width="300" class="column-title">Post Name </th> 							
                                        <th width="300" class="column-title">Message</th> 							
                                        <th width="300" class="column-title">Image Posted Date</th>                           							
                                        <th width="300" class="column-title">Reported Date</th>                             							
                                        <th width="200" style="text-align:center" class="column-title no-link last"><span class="nobr">Action</span></th>
                                        <th class="bulk-actions" colspan="7">
                                            <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $banner_que = mysql_query("SELECT * from freelancer_mmv_abuse where 1=1 ORDER BY date DESC");
                                    while ($banner_result = mysql_fetch_array($banner_que)) {
                                        $abuserid = $banner_result[abuserid];
                                        $postid = $banner_result[postid];

                                        $about_query = mysql_query("SELECT * from freelancer_mmv_member_master where member_id=$abuserid");
                                        $about_res = mysql_fetch_array($about_query);
                                        $about_query1 = mysql_query("SELECT * from freelancer_mmv_userimages where id=$postid");
                                        $imagecount = mysql_num_rows($about_query1);
                                        if ($imagecount >= 1) {
                                            $about_res2 = mysql_fetch_array($about_query1);
                                            $postuserid = $about_res2[userid];
                                            $about_query2 = mysql_query("SELECT * from freelancer_mmv_member_master where member_id=$postuserid");
                                            $about_res22 = mysql_fetch_array($about_query2);
                                            $extension2 = strtolower(end(explode(".", $about_res2[image])));
                                            ?>
                                            <tr class="even pointer">                            
                                                <td class=""><?php echo $i ?></td>
                                                <td class=""><a style="text-decoration:underline;color:blue" href="viewuser_details.php?id=<?php echo $abuserid; ?>" target="_blank"><?php echo $about_res[first_name] . ' ' . $about_res[last_name] ?></a></td>					
                                                <td class=""><a style="text-decoration:underline;color:blue" href="viewuser_details.php?id=<?php echo $postuserid; ?>" target="_blank"><?php echo $about_res22[first_name] . ' ' . $about_res22[last_name] ?></a></td>					
                                                <td class="">
                                                    <?php if ($extension2 == "mp4" || $extension2 == "mov") { ?>
                                                        <video width="150" height="150" controls>
                                                            <source src="../<?php echo $about_res2[image]; ?>" type="video/mp4">
                                                            <source src="../<?php echo $about_res2[image]; ?>" type="video/ogg">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    <?php } else { ?>
                                                        <!--<img data-id="<?php echo $about_res2[id] ?>" width="150" height="150" src="../<?php echo $about_res2[image]; ?>">-->
                                                        <a data-magnify="gallery" data-caption="" href="../<?php echo $about_res2[image]; ?>">
                                                            <img width="150" height="150" src="../<?php echo $about_res2[image]; ?>" alt="">
                                                        </a> 
                                                    <?php }
                                                }
                                                ?>
                                                <?php /* $ext = pathinfo($about_res2[image], PATHINFO_EXTENSION); 
                                                  if($ext=="png" || $ext=="jpg" || $ext=="jpeg" || $ext=="gif"){
                                                  ?>
                                                  <a class="example-image-link" href="../<?php echo $about_res2[image] ?>" data-lightbox="example-1"><img class="example-image" width="150" height="150" src="../<?php echo $about_res2[image] ?>" alt="image-1" /></a>
                                                  <!--<div class="simpleLens-gallery-container" id="demo-1">
                                                  <div class="simpleLens-container">
                                                  <div class="simpleLens-big-image-container">
                                                  <a class="simpleLens-lens-image" data-lens-image="../<?php echo $about_res2[image] ?>">
                                                  <img width="150" height="150" src="../<?php echo $about_res2[image] ?>" class="simpleLens-big-image">
                                                  </a>
                                                  </div>
                                                  </div>
                                                  </div>-->

                                                  </td>
                                                  <?php } else { ?>
                                                  <video width="150" height="150" controls>
                                                  <source src="../<?php echo $about_res2[image]; ?>" type="video/mp4">
                                                  <source src="../<?php echo $about_res2[image]; ?>" type="video/ogg">
                                                  Your browser does not support the video tag.
                                                  </video>
                                                  <?php } */ ?>										
                                            <td class=""><?php echo $banner_result[content] ?></td>											
                                            <td class=""><?php echo $about_res2[date] ?></td>	
                                            <td class=""><?php echo $banner_result[date] ?></td>										
                                            <td style="text-align:center" class=" last">							
                                                <a class="btn btn-danger" href="#" id="delete_<?php echo $banner_result[id] ?>"><i class="fa fa-trash"></i></a>&nbsp;                           
                                            </td>
                                        </tr>				  

                                        <?php
                                        $i++;
                                    }
                                    ?>												
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<script>
    $(function () {
        $("[id^='delete_']").click(function () {
            var i = $(this).attr('id');
            var arr = i.split("_");
            var i = arr[1];
            var r = confirm("Are you sure?");
            if (r == true)
            {

                $.ajax({
                    type: "POST",
                    data: "id=" + i,
                    url: "deletecollection.php?type=abuse",
                    success: function (data)
                    {
                        if (data == "done")
                        {
                            alert("Data deleted Successfully");
                            location.reload();
                        }
                    }
                });
            } else
            {
                return false;
            }
        });
    });
</script>
<!--<script src="production/js/lightbox.js" ></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script type="text/javascript" src="../src/jquery.simpleGallery.js"></script>
<script type="text/javascript" src="../src/jquery.simpleLens.js"></script>

<script>
    $(document).ready(function(){
        $('#demo-1 .simpleLens-thumbnails-container img').simpleGallery({
            loading_image: '../demo/images/loading.gif'
        });

        $('#demo-1 .simpleLens-big-image').simpleLens({
            loading_image: '../demo/images/loading.gif'
        });
    });
</script>-->
<script src="build/js/jquery.magnify.js"></script>
<script>
    $('[data-magnify]').magnify({
        headToolbar: [
            'close'
        ],
        footToolbar: [
            'zoomIn',
            'zoomOut',
            'prev',
            'fullscreen',
            'next',
            'actualSize',
            'rotateRight'
        ],
        title: false
    });

</script>
<?php include "footer.php" ?>