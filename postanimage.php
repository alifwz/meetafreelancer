<?php
session_start();
$user_id = isset($_SESSION["SESS_MEMBER_ID"][0]) ? $_SESSION["SESS_MEMBER_ID"][0] : '';
if (!$user_id) {
    header("Location: index.php#login");
    die;
}
include "connection.php";
include "header.php";
include "auth.php";

// RESET IMAGE
if (isset($_GET['t']) && $_GET['t'] != '') {
    $image = mysql_query("SELECT image FROM freelancer_mmv_userimages WHERE id='" . trim($_GET['t']) . "'");
    $image_details = mysql_fetch_array($image);
    unlink($image_details['image']);
    mysql_query("DELETE from freelancer_mmv_userimages WHERE id='" . trim($_GET['t']) . "'");
}

if (isset($_POST[submitimage])) {
    $description = $_POST[description];
    $videolink = $_POST[videolink];
    $pcountry = $_POST[pcountry];
    $category = $_POST[category];
    $subcategory = $_POST[subcategory];
    $imageid = $_POST[imageid];
    $quee = mysql_query("UPDATE freelancer_mmv_userimages SET description='$description', countryid='$pcountry',category='$category',subcategory='$subcategory' WHERE id='$imageid'");

    if ($quee == 1) {
        $ppquery = mysql_query("SELECT * FROM freelancer_mmv_paypalsettings WHERE id='1'");
        $ppres = mysql_fetch_array($ppquery);
        $ppamount = $ppres['image'];
        if ($ppamount == '0' || $ppamount == '0.00') {

            $countquery = mysql_query("SELECT * FROM freelancer_mmv_userimages WHERE userid='$loginid' and status = 1");
            $count_res = mysql_num_rows($countquery);
            /* if ($count_res >= 9) {
              mysql_query("DELETE FROM freelancer_mmv_userimages WHERE userid='$loginid' and status = 1 ORDER BY id ASC LIMIT 1");
              } */

            mysql_query("UPDATE freelancer_mmv_userimages SET status='1' WHERE id='$imageid'");
            echo '<script>window.location.href="index.php?status=psuccess"</script>';
        } else {
            echo '<script>window.location.href="paypal.php?type=1&uid=' . $loginid . '&imgid=' . $imageid . '"</script>';
        }
    }
}
?>
<style>
    .login-main {
        padding: 10px 45px !important;
        top: 6px;
        position: relative;
    }
    .fancybox-slide {
        position: absolute;
        top: -40px !important;
    }
    ::placeholder{
        font-size: 15px
    }
</style>
<style>
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('images/wait.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: .8;
    }
</style>
<!--<script src="js/jquery.js"></script>--> 
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<link  href="js/cropper.min.css" rel="stylesheet">
<script src="js/cropper.min.js"></script>
<!--ALTER TABLE `freelancer_mmv_userimages` ADD `category` INT(110) NULL AFTER `website`, ADD `subcategory` INT(110) NULL AFTER `category`;-->
<div class="loa der"></div>
<div class="main">
    <div class="login-main">		
        <form name="login" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="freelanceserviceid" id="freelanceserviceid" value="<?php echo $freelanceserviceid; ?>">
            <div class="for gotpass-main">	
                <div class="form-group">
                    <div class="image_container" style="max-height:350px">
                        <div class="upload-demo-wrap" style="display:none">
                            <div id="upload-demo"></div>
                        </div>
                        <img data-type="0" class="zoombtn" id="zoombtn" src="images/zoom.png" alt="" />
                        <img style="display:none" id="blah" src="" alt="" />
                    </div>
                    <div id="cropped_result" style="display:none"></div> 
                </div>
                <br>
                <div class="form-group">
                    <!-- onchange="readURL(this);"-->
                    <input name="image" accept="image/*" type="file" id="image" required class="form-control " onchange="checkfile(this);"/>
                </div>
                <!--                <div class="form-group" style="display:none">						
                                    <input type="hidden" name="videolink" id="videolink" class="form-control text-align-center inputbg" placeholder="Website URL">
                                </div>-->
                <br>
                <div class="form-group" style="display:none">						
                    <select style="
                            font-size: 15px;
                            height: 60px;
                            " name="pcountry" id="pcountry" required class="form-control inputbg">							
                        <option value="">Select Country</option>								
                        <?php
                        $country_query = mysql_query("SELECT * FROM `freelancer_mmv_countries` ORDER BY `freelancer_mmv_countries`.`countries_id` ASC");
                        while ($country_res = mysql_fetch_array($country_query)) {
                            $selcountryid = $country_res[countries_id];
                            ?>
                            <option value="<?php echo $selcountryid ?>"><?php echo $country_res[countries_name]; ?></option>								
                        <?php } ?>				
                    </select>
                </div>
                <div class="col-md-4" style="">						
                </div>
                <div class="form-group">
                    <button id="crop_button" style="color:#000000" class="button loginbtn">Crop</button>						
                    <a href="postanimage.php?t=reset" id="resetbtn" class="button light-yellow">Reset</a> 						
                </div>
            </div>
        </form>
    </div>
</div>

<a data-fancybox="" data-type="inline" data-src="#invalidPass" href="javascript:void(0);" class="addcountry none"></a>
<div class="popbox">
    <div id="invalidPass" class="popupbox text-align-center">	
        <div class="login-main">		
            <form name="login" method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="imageid" id="imageid" value="">
                <div class="for gotpass-main">		
                    <div class="form-group">						
                        <textarea style="height:300px;" maxlength="800" name="description" id="description_textarea" class="form-control text-align-center inputbg" placeholder="Say something about this photo"></textarea>
                    </div>
                    <!--                    <div class="form-group">						
                                            <input type="text" name="videolink" id="videolink" class="form-control text-align-center inputbg" placeholder="Website URL" id="">
                                        </div>-->
                    <br>
                    <div class="form-group">						
                        <select style="
                                font-size: 15px;
                                height: 40px;
                                " name="pcountry" id="pcountry" required class="form-control inputbg">							
                            <option value="">Select Country</option>								
                            <?php
                            $country_query = mysql_query("SELECT * FROM `freelancer_mmv_countries` ORDER BY `freelancer_mmv_countries`.`countries_id` ASC");
                            while ($country_res = mysql_fetch_array($country_query)) {
                                $selcountryid = $country_res[countries_id];
                                ?>
                                <option value="<?php echo $selcountryid ?>"><?php echo $country_res[countries_name]; ?></option>								
                            <?php } ?>				
                        </select>
                    </div>

                    <div class="form-group">
                        <select style="
                                font-size: 15px;
                                height: 40px;
                                "  name="category" id="post-photo-category" required class="form-control inputbg">
                            <option value="">Select Category</option>
                            <?php
                            $banner_que = mysql_query("SELECT * from freelancer_mmv_filter where 1=1 AND parent_id=0 AND status='1'");
                            while ($banner_result = mysql_fetch_array($banner_que)) {
                                ?>
                                <option value="<?php echo $banner_result[filter_id] ?>"><?php echo $banner_result[title] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select style="
                                font-size: 15px;
                                height: 40px;
                                "  name="subcategory" required id="post-photo-subcategory" class="form-control inputbg"></select>
                    </div>
                    <div class="col-md-4" style="">						
                    </div>
                    <br>
                    <div class="form-group">
                        <button name="submitimage" class="button loginbtn">Submit</button>
                    </div>
                </div>
            </form>
            <form action="savecropimage.php" name="photo" id="imageUploadForm" enctype="multipart/form-data" method="post">
                <input type="hidden" val="" name="croppedImage" id="cimage" />
                <button style="display:none" type="submit" id="btnup" value="Upload" /></button>
            </form>
        </div>	
    </div>
</div>
<?php
$show_login_bar = 0;
?>
<script src="js/croppie.js"></script>
<link rel="stylesheet" href="css/croppie.css">
<style>
    .croppie-container {
        margin-left: 0 !important;
    }
    .bottom-holder{height:52px !important; }
</style>
<script type="text/javascript" defer>

                        $(document).ready(function () {

                            $('#post-photo-category').on("change", function () {
                                var categoryId = $(this).find('option:selected').val();
                                if (categoryId == '') {
                                    $("#post-photo-subcategory").html('');
                                } else {
                                    $.ajax({
                                        url: "subcatajax.php",
                                        type: "POST",
                                        data: "categoryId=" + categoryId,
                                        success: function (response) {
                                            // console.log(response);
                                            $("#post-photo-subcategory").html(response);
                                        },
                                    });
                                }
                            });
                        });
                        function checkfile(sender) {
                            var validExts = new Array(".jpeg", ".jpg", ".png");
                            var fileExt = sender.value;
                            fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
                            if (validExts.indexOf(fileExt) < 0) {
                                alert("Invalid file selected, valid files are of " +
                                        validExts.toString() + " types.");
                                $("#image").val('');
                                return false;
                            } else {
//                                $('#blah').remove();
//                                $('.image_container').append('<img style="display:none" id="blah" src="" alt="" />');
                                readURL(sender);
                            }
                        }

                        function createCroppie() {
                            $uploadCrop = $('#upload-demo').croppie({
                                viewport: {
                                    width: 350,
                                    height: 250,
                                    type: 'square'
                                },
                                boundary: {
                                    width: 350,
                                    height: 350
                                },
                                showZoomer: false,
                                enableExif: true,
                                setZoom: 0
                            });
                        }
                        createCroppie()


                        function lanscape() {
                            $uploadCrop.croppie({
                                viewport: {
                                    width: 350,
                                    height: 250,
                                    type: 'square'
                                },
                                boundary: {
                                    width: 350,
                                    height: 350
                                },
                                showZoomer: false,
                                enableExif: true,
                                setZoom: 0
                            });
                        }

                        function portrait() {
                            $uploadCrop.croppie({
                                viewport: {
                                    width: 250,
                                    height: 350,
                                    type: 'square'
                                },
                                boundary: {
                                    width: 350,
                                    height: 350
                                },
                                showZoomer: false,
                                enableExif: true,
                                setZoom: 0
                            });
                        }

                        function same() {
                            $uploadCrop.croppie({
                                viewport: {
                                    width: 350,
                                    height: 350,
                                    type: 'square'
                                },
                                boundary: {
                                    width: 350,
                                    height: 350
                                },
                                showZoomer: false,
                                enableExif: true,
                                setZoom: 0
                            });
                        }
                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    $('#blah').attr('src', e.target.result)
//                                    var someImg = null;
                                    setTimeout(function () {
                                        var someImg = $("#blah");
                                        $uploadCrop.croppie('destroy');
                                        $('#upload-demo').html('');
                                        $('.upload-demo').removeClass('ready');
                                        console.log(someImg.width())
                                        console.log(someImg.height())
                                        if (someImg.width() > someImg.height()) {
                                            //it's a landscape
                                            console.log('1')
                                            lanscape();
                                        } else if (someImg.width() < someImg.height()) {
                                            console.log('2')
                                            portrait()
                                            //it's a portrait
                                        } else if (someImg.width() == someImg.height()) {
                                            console.log('3')
                                            //image width and height are equal, therefore it is square.
                                            same()
                                        }

                                        $('.upload-demo').addClass('ready');
                                        $('.upload-demo-wrap').show()
                                        $('#zoombtn').show()

//                                    setTimeout(function () {
                                        $uploadCrop.croppie('bind', {
                                            url: e.target.result
                                        }).then(function () {
                                            $uploadCrop.croppie('setZoom', 0)
                                            console.log('jQuery bind complete');
                                        });

//                                    }, 6000);

                                    }, 500);
                                }

                                reader.readAsDataURL(input.files[0]);
                            } else {
                                swal("Sorry - you're browser doesn't support the FileReader API");
                            }
                        }

                        function zoomout() {
                            var someImg = $("#blah");
                            $uploadCrop.croppie('destroy');
                            $('#upload-demo').html('');
                            $('.upload-demo').removeClass('ready');
                            if (someImg.width() > someImg.height()) {
                                //it's a landscape
                                console.log('1')
                                lanscape();
                            } else if (someImg.width() < someImg.height()) {
                                console.log('2')
                                portrait()
                                //it's a portrait
                            } else if (someImg.width() == someImg.height()) {
                                console.log('3')
                                //image width and height are equal, therefore it is square.
                                same()
                            }

                            $('.upload-demo').addClass('ready');
                            $('.upload-demo-wrap').show()
                            var src = $('#blah').attr('src')
                            $uploadCrop.croppie('bind', {
                                url: src
                            }).then(function () {
                                $uploadCrop.croppie('setZoom', 0)
                                console.log('jQuery bind complete');
                            });
                        }

                        function zoomin() {
                            $uploadCrop.croppie('destroy');
                            $('#upload-demo').html('');
                            $('.upload-demo').removeClass('ready');
                            $uploadCrop.croppie({
                                viewport: {
                                    width: 350,
                                    height: 350,
                                    type: 'square'
                                },
                                boundary: {
                                    width: 350,
                                    height: 350
                                },
                                showZoomer: false,
                                enableExif: true,
                                setZoom: 0
                            });


                            $('.upload-demo').addClass('ready');
                            $('.upload-demo-wrap').show()
                            var src = $('#blah').attr('src')
                            $uploadCrop.croppie('bind', {
                                url: src
                            });
                        }
                        var distance = 0;
                        $('#upload-demo').on('touchstart', function (e) {
                            if (e.touches.length == 2) {
                                var dist = Math.hypot(
                                        e.touches[0].pageX - e.touches[1].pageX,
                                        e.touches[0].pageY - e.touches[1].pageY);
                                distance = dist;
                            }
                        })

                        $('#upload-demo').on('touchmove', function (e) {
                            if (e.touches.length == 2) {
                                var dist2 = Math.hypot(
                                        e.touches[0].pageX - e.touches[1].pageX,
                                        e.touches[0].pageY - e.touches[1].pageY);
                                if (dist2 > distance) {
                                    zoomin()
                                } else {
                                    zoomout()
                                }
                            }
                        })

                        $('#upload-demo').bind('DOMMouseScroll', function (e) {
                            if (e.originalEvent.detail > 0) {
                                zoomout()
                            } else {
                                zoomin()
                            }

                            //prevent page fom scrolling
                            return false;
                        });
                        $('#upload-demo').bind('mousewheel', function (e) {
                            if (e.originalEvent.wheelDelta < 0) {
                                zoomout()
                            } else {
                                zoomin()
                            }

                            //prevent page fom scrolling
                            return false;
                        });

                        // For mobile

                        $('#crop_button').on('click', function (ev) {
                            $uploadCrop.croppie('result', {
                                type: 'canvas',
                                size: 'viewport'
                            }).then(function (resp) {
                                $('#cimage').val(resp);
                                $("#btnup").trigger('click');
                            });
                        });


                        $('#zoombtn').on('click', function () {
                            var type = $(this).attr('data-type');
                            if (type == 0) {
                                $uploadCrop.croppie('setZoom', 1.5)
                                $(this).attr('data-type', 1);
                            } else {
                                $uploadCrop.croppie('setZoom', 0)
                                $(this).attr('data-type', 0);
                            }
                        })
                        $('#imageUploadForm').on('submit', (function (e) {
                            e.preventDefault();
                            var formData = new FormData(this);
                            $.ajax('savecropimage.php', {
                                method: "POST",
                                data: formData,
                                enctype: 'multipart/form-data',
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    if (data == 'failed') {
                                        $('.uploadfail').trigger('click');
                                    } else {
                                        document.getElementById("imageid").value = data;
                                        document.getElementById("resetbtn").href = 'postanimage.php?t=' + data;
                                        $('.addcountry').trigger('click');
                                    }
                                },
                                error: function () {
                                    console.log('Upload error');
                                }
                            });
                        }));
//                        function initCropper() {
//                            var image = document.getElementById('blah');
//                            var cropper = new Cropper(image, {
//                                aspectRatio: 1 / 1,
//                                crop: function (e) {
//
//                                }
//                            });
//
//                            // On crop button clicked
//                            document.getElementById('crop_button').addEventListener('click', function () {
//
//                                $(".loader").show();
//
//                                /*var wweburl = document.getElementById("videolink").value;
//                                 var eee = document.getElementById("pcountry");
//                                 var ppcountry = eee.options[eee.selectedIndex].value;*/
//                                var imgurl = cropper.getCroppedCanvas().toDataURL();
//                                var img = document.createElement("img");
//                                img.src = imgurl;
//                                document.getElementById("cropped_result").appendChild(img);
//
//                                /* ---------------- SEND IMAGE TO THE SERVER-------------------------*/
//                                cropper.getCroppedCanvas().toBlob(function (blob) {
//                                    console.log(blob)
//                                    var formData = new FormData();
//                                    formData.append('croppedImage', blob);
//                                    console.log(formData)
//                                    // Use `jQuery.ajax` method
//                                    $.ajax('savecropimage.php', {
//                                        method: "POST",
//                                        data: formData,
//                                        processData: false,
//                                        contentType: false,
//                                        success: function (data) {
//                                            if (data == 'failed') {
//                                                $('.uploadfail').trigger('click');
//                                            } else {
//                                                document.getElementById("imageid").value = data;
//                                                document.getElementById("resetbtn").href = 'postanimage.php?t=' + data;
//                                                $('.addcountry').trigger('click');
//                                            }
//                                        },
//                                        error: function () {
//                                            console.log('Upload error');
//                                        }
//                                    });
//                                });
//                                /* ----------------------------------------------------*/
//
//                            })
//                        }

                        function myFunction(data) {
                            window.location.href = "paypal.php?type=1&uid=<?php echo $loginid; ?>&imgid=" + data;
                            alert('Please wait..!!');
                        }
</script>	

<!--end main-->
<?php include "footer.php"; ?>