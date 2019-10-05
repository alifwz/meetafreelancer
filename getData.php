<?php
//Include DB configuration file
session_start();
include "connection.php";
include "functions.php";
$loginid = end($_SESSION[SESS_MEMBER_ID]);

if ($_SESSION[countryid] == "") {
    $countryid = '';
} else {
    $countryid = $_SESSION[countryid];
}

if (!empty($_POST["id"])) {

//Get last ID
    $lastID = $_POST['id'];
    $catID = $_POST['catid'];
    $type = $_POST['type'];

//Limit on data display
    $showLimit = 5;

    if ($_SESSION[countryid] == "" && $catID == "") {
        $querysrting = '';
    } else if ($_SESSION[countryid] == "" && $catID != "" && $type == '') {
        $querysrting = "AND freelanceserviceid=$catID";
    } else if ($_SESSION[countryid] != "" && $catID == "" && $type == '') {
        $querysrting = "AND countryid='$countryid'";
    } else if ($_SESSION[countryid] == "" && $type != '') {
        $querysrting = "AND freelanceserviceid IN (" . $type . ")";
    } else if ($_SESSION[countryid] != "" && $type != '') {
        $querysrting = "AND countryid='$countryid' AND freelanceserviceid IN (" . $type . ")";
    } else {
        $querysrting = "AND freelanceserviceid=$catID AND countryid='$countryid'";
    }

//Get all rows except already displayed
    $queryAll = mysql_query("SELECT COUNT(*) as num_rows FROM freelancer_mmv_userimages WHERE userid!='' $querysrting AND status=1 AND id < " . $lastID . " ORDER BY id DESC");
    $rowAll = mysql_fetch_assoc($queryAll);
    $allNumRows = $rowAll['num_rows'];

//Get rows by limit except already displayed
    $query = mysql_query("SELECT * FROM freelancer_mmv_userimages WHERE userid!='' AND status=1 $querysrting AND id < " . $lastID . " ORDER BY id DESC LIMIT " . $showLimit);

    if (mysql_num_rows($query) > 0) {
        while ($about_res1 = mysql_fetch_array($query)) {
            $postID = $about_res1["id"];
            $idd = $about_res1[id];
            $idd1 = $about_res1[id];
            $uid = $about_res1[userid];
            $userinfo = getUserinfo($uid);
            $jobid = $userinfo[16];
            $jobdesc = getSubExperience($jobid);

            $postIDD = $idd;

            $like_que = mysql_query("SELECT * from freelancer_mmv_member_like where workid='$idd'");
            $count = mysql_num_rows($like_que);

            $userlikcount = mysql_query("SELECT * from freelancer_mmv_member_like where workid='$idd' AND user_id='$loginid'");
            $mycount = mysql_num_rows($userlikcount);
            ?>
            <div class="contenets">
                <div class="topbar">
                    <div class="container clearfix">
                        <?php
                        $web = $about_res1[website];
                        if (false === strpos($web, '://')) {
                            $url = 'http://' . $web;
                        }
                        if ($about_res1[website] != "") {
                            ?>
                            <a href="<?php echo $url; ?>" target="_blank" class="view-website">View website</a>
                        <?php } ?>
                        <div class="doted-main">
                            <?php if ($uid != $loginid && $loginid != "") { ?>
                                <a href="javascript:void(0);" name="abuse" data-index="<?php echo $idd ?>"  class="more-link" data-fancybox="" data-type="inline" data-src="#abuseOption"><img src="images/dotted-img.png" alt="More"/></a>
                            <?php } else if ($uid == $loginid && $loginid != "") { ?>						
                                <a href="javascript:void(0);" class="more-link" data-fancybox="" data-type="inline" data-src="#moreLinks<?php echo $idd1; ?>"><img src="images/dotted-img.png" alt="More"/></a>
                            <?php } else { ?>	
                                <a href="javascript:void(0);" class="more-link" data-fancybox="" data-type="inline" data-src="#loginPopup"><img src="images/dotted-img.png" alt="More"/></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="popbox">
                    <div id="moreLinks<?php echo $idd1; ?>" class="popupbox text-align-center abuseOption url-and-post">	
                        <p><a href="javascript:void(0);" data-fancybox="" data-src="#editUrl<?php echo $idd1; ?>" data-type="inline" class="button more-link">Edit URL</a></p>
                        <p><a href="deletecollection.php?id=<?php echo $idd1; ?>&type=delpost" class="button">Delete Post</a></p>
                    </div>
                </div>

                <div class="popbox">			
                    <div align="center" id="editUrl<?php echo $idd1; ?>" class="popupbox text-align-center abuseOption url-and-post">	
                        <form name="edits" method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="editid" value="<?php echo $idd1; ?>">	
                            <?php
                            $web_que = mysql_query("SELECT * from freelancer_mmv_userimages where id='$idd1' AND status=1");
                            $web_res = mysql_fetch_array($web_que);
                            ?>
                            <p align="center"><input type="text" name="weblink" value="<?php echo $web_res[website] ?>" required class="form-control text-align-center inputbg" placeholder="Website URL" id=""><br>
                                <button type="submit" name="submiturl" class="button loginbtn">Submit</button></p>
                        </form>	
                    </div>				
                </div>

                <?php
                $extension = strtolower(end(explode(".", $about_res1[image])));
                if ($extension == "mp4" || $extension == "mov") {
                    ?>			
                    <div class="contenets-img" align="center">
                        <video id="video" style="background-color:black" width="100%" controls="true" poster="<?php echo $urlpath . $filename ?>">
                            <source src="<?php echo $about_res1[image]; ?>" type="video/mp4">
                            <source src="<?php echo $about_res1[image]; ?>" type="video/ogg">
                            Your browser does not support the video tag.
                        </video>				
                    </div>			
                <?php } else { ?>
                    <div class="contenets-img">
                        <img src="<?php echo $about_res1[image]; ?>" ondblclick="mydoubleFunction(<?php echo $about_res1[id] ?>)"  height="430" alt="" />
                    </div>
                <?php } ?>


                <div class="btmbar">
                    <div class="container clearfix">
                        <table width="100%">
                            <tr>
                                <td class="job-posted-user">
                                    <?php if ($uid == $loginid) { ?>
                                        <a href="profile.php"><?php echo $userinfo[3] . '<br>' . $userinfo[4] ?></a>
                                    <?php } else { ?>
                                        <a href="viewclient.php?id=<?php echo $uid ?>"><?php echo $userinfo[3] . '<br>' . $userinfo[4] ?></a>
                                    <?php } ?>
                                </td>

                                <?php if ($uid == $loginid) { ?>
                                    <td align="center" class="job-title"><a href="profile.php"><?php echo $jobdesc ?></a></td>								
                                <?php } else { ?>
                                    <td align="center" class="job-title"><a href="viewclient.php?id=<?php echo $uid ?>"><?php echo $jobdesc ?></a></td>								
                                <?php } ?>

                                <?php
                                if ($loginid != '') {
                                    if ($mycount < 1) {
                                        ?>
                                        <td class="likes-div" style="cursor:pointer"><i id="delete_<?php echo $about_res1[id] ?>" class="fa">&#xf08a;</i> <a href="likers.php?id=<?php echo $idd; ?>"><span id="this<?php echo $about_res1[id] ?>"><?php echo $count; ?></span> likes</a></td>
                                    <?php } else { ?>
                                        <td class="likes-div" style="cursor:pointer"><i class="fa">&#xf08a;</i><a href="likers.php?id=<?php echo $idd; ?>"> <?php echo $count; ?> likes</a></td>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <td class="likes-div" style="cursor:pointer"><a href="#" data-fancybox data-type="inline" data-src="#loginPopup"><i class="fa">&#xf08a;</i> <?php echo $count; ?> likes</a></td>
                                <?php } ?>
                            </tr>
                        </table>					
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($allNumRows > $showLimit) { ?>
            <div class="load-more" lastID="<?php echo $postID; ?>" style="display: none;">
                <img src="loading.gif"/>
            </div>
        <?php } else { ?>
            <div class="load-more" lastID="0">

            </div>
            <?php
        }
    } else {
        ?>
        <div class="load-more" lastID="0">

        </div>
        <?php
    }
}
?>