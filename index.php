<?php
$page_title = 'Meetfreelancers | Best Freelance Meeting Site';
$seo_title = 'Meetfreelancers | Best Freelance Meeting Site';
$seo_description = "Meetfreelancers.com is the world's best freelancing and marketplace to meet and invite freelancers around the world.";
$seo_keywords = 'meetfreelancers,jobs,meet,hire,work,employee,employer,freelancers,money,earn,influencer,register,new,webapp,rating,interested,invite,list,chat,date,friends,users,free,opportunity,experience,help,find,view,creative,web design';
session_start();
include "connection.php";
include "header.php";
include "functions.php";

$pid = $_REQUEST[pid];

if ($_SESSION[countryid] == "") {
    $countryid = '';
} else {
    $countryid = $_SESSION[countryid];
}

if (isset($_POST[abuse])) {
    if (!isset($_SESSION['SESS_MEMBER_ID']) || empty($_SESSION['SESS_MEMBER_ID'])) {
        echo "<script>window.location='index.php?status=failed'</script>";
        die;
    }
    if (!isset($_POST[postid]) || empty($_POST[postid])) {
        echo "<script>window.location='index.php?status=failed'</script>";
        die;
    }
    $content = $_POST[content];
    $postid = $_POST[postid];
    $postSql = mysql_query("select * from freelancer_mmv_userimages WHERE id=$postid");
    $imgcount = mysql_num_rows($postSql);
    if ($imgcount == 0) {
        echo "<script>window.location='index.php?status=failed'</script>";
        die;
    }
    $abuse_que = mysql_query("INSERT INTO freelancer_mmv_abuse(`id`, `abuserid`, `postid`, `content`, `date`) VALUES ('','$loginid','$postid','$content',NOW())");
    $emailquery = mysql_query("SELECT * FROM freelancer_mmv_aboutus WHERE id='3'");
    $emailres = mysql_fetch_array($emailquery);
    $adminemail = $emailres[content];
    $userinfo = getUserinfo($loginid);
    $fullname = $userinfo[3] . ' ' . $userinfo[4];
    $tou = $adminemail;
    $subjectu = "Freelancer - REPORT/ABUSE";
    $messageu = '<html>
		<head>
		<meta charset="utf-8">
		<title>Freelancer</title>
		<style type="text/css">
			a:hover{background:#ac5e2a!important;border:1px solid #ac5e2a!important }
		</style>
		</head>
		<body style="margin: 0px;padding: 0px">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr><td style="padding: 25px;background:#eee ">
		<table cellpadding="0" cellspacing="0" border="0" style="background: #ffffff">
			<tr>
				<td style="padding:10px 20px;"><div style="border-bottom:1px solid #d1b555;padding-bottom:15px "><img src="" alt="Freelancer" /></div></td>
			</tr>
			<tr>
				<td style="-moz-hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-ms-text-size-adjust: 100%;hyphens: none;font-family:Open Sans,Arial,Helvetica,sans-serif;font-size:20px;line-height: 25px;color: #000;border-collapse: collapse;padding: 15px;padding:10px 20px">Welcome to Freelancer</td>
			</tr>
			<tr>
				<td style="-moz-hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-ms-text-size-adjust: 100%;hyphens: none;font-family:Open Sans,Arial,Helvetica,sans-serif;font-size:20px;line-height: 25px;color: #ac5e2a;border-collapse: collapse;padding: 15px;padding:10px 20px">Dear Admin,</td>
			</tr>
			<tr>
				<td style="-moz-hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-ms-text-size-adjust: 100%;hyphens: none;font-family:Open Sans,Arial,Helvetica,sans-serif;font-size: 15px;line-height: 25px;color: #000;border-collapse: collapse;padding:10px 20px">
					You have received an REPORT/ABUSE from <h3>' . $fullname . '</h3> please login to Freelancer Admin and check for more information.
				</td>
			</tr>
			<tr>
				<td style="padding:10px 20px 15px 20px">
					<a target="_blank" href="' . $urlpath . 'meet-admin/reportabuse.php" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:Poppins,Open Sans,Arial,Helvetica,sans-serif;color:#ffffff;padding-top: 7px;padding-right:18px;padding-bottom:10px;padding-left:18px;display:inline-block;border:1px solid #red;text-decoration:none;cursor:pointer;background:red;font-size:16px">Check in CMS</a>
				</td>
			</tr>
			<tr>
				<td style="-moz-hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-ms-text-size-adjust: 100%;hyphens: none;font-family:Open Sans,Arial,Helvetica,sans-serif;font-size: 15px;line-height: 25px;color: #000;border-collapse: collapse;padding:10px 20px 10px 20px">
					Thanks,<br>Freelancer.
				</td>
			</tr>
		</table>
		</td></tr>
		</table>
		</body>
		</html>';

    smtpmailer($tou, $fullname, $from, $from_name, $subjectu, $messageu);

    if ($abuse_que == 1) {
        echo "<script>window.location='index.php?status=abusesuccess'</script>";
    }
}

if (isset($_POST['answer_submit'])) {
    if ($_POST['answer'] != '') {
        $answer = trim($_POST['answer']);
        $questions_id = $_POST['questions_id'];
        $abuse_que = mysql_query("INSERT INTO freelancer_mmv_answers(`questions_id`, `answer`, `answer_by`, `created`) VALUES ('$questions_id','$answer','$loginid',NOW())");
        if ($abuse_que == 1) {
            echo "<script>window.location='index.php?status=success'</script>";
        }
    }
}
if (isset($_POST[submiturl])) {
    $editid = $_POST[editid];
    $description = $_POST[description];
    $abuse_que = mysql_query("UPDATE freelancer_mmv_userimages SET `description`='$description' WHERE id=$editid");
    if ($abuse_que == 1) {
        echo "<script>window.location='index.php?status=usuccess'</script>";
    }
}
$filterCats = '';
if ($_REQUEST[cid] != "") {
    $id = $_REQUEST[cid];
    unset($_SESSION['SESS_SUBCAT_ID']);
    $_SESSION[SESS_SUBCAT_ID] = $_REQUEST[cid];
    $filterCats = " AND (q.subcategory_id = " . $_SESSION[SESS_SUBCAT_ID] . " OR q.category_id =" . $_SESSION[SESS_SUBCAT_ID] . ") ";
}

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'cat') {
    $inputs = mysql_query("SELECT * FROM freelancer_mmv_filter WHERE status='1' AND parent_id='$_SESSION[SESS_SUBCAT_ID]'");
    while ($inputs_res = mysql_fetch_array($inputs)) {
        $results[] = $inputs_res[filter_id];
    }
    $allcats = implode(",", $results);
    if ($allcats) {
        $filterid = "AND freelanceserviceid IN (" . $allcats . ")";
        $filterCats = " AND q.subcategory_id IN (" . $allcats . ")";
    } else
        $filterid = '';
} else {
    $filterid = '';
}
?>
<style>
    #video{object-fit: cover; height:430px;}
</style>
<!--start main-->
<div class="main" <?php
if ($incomplete_profile == 1 && basename($_SERVER["SCRIPT_FILENAME"], '.php') != 'make-profile') {
    ?> style="margin-top: 30px;" <?php } ?>>
    <section class="contenets-main">
        <?php
        if ($pid != "") {
            $about_que = mysql_query("SELECT * from freelancer_mmv_userimages where id='$pid' AND status=1 AND userid!='' ORDER BY id DESC");
            $about_res = mysql_fetch_array($about_que);
            $idd = $about_res[id];
            $uid = $about_res[userid];
            $userinfo = getUserinfo($uid);
            $jobid = $userinfo[16];
            $jobdesc = getSubExperience($jobid);
            $like_que = mysql_query("SELECT * from freelancer_mmv_member_like where workid='$idd'");
            $count = mysql_num_rows($like_que);
            $userlikcount = mysql_query("SELECT * from freelancer_mmv_member_like where workid='$idd' AND user_id='$loginid'");
            $mycount = mysql_num_rows($userlikcount);
            ?>
            <div class="contenets">
                <div class="topbar">
                    <div class="container clearfix">
                        <?php
                        $web = $about_res[website];
                        if (false === strpos($web, '://')) {
                            $url = 'http://' . $web;
                        }
                        if ($about_res[website] != "") {
                            ?>
                                                                                                                                                                                                                <!--<a href="<?php echo $url; ?>" target="_blank" class="view-website">View website</a>-->
                        <?php } ?>
                        <div class="doted-main">
                            <?php
                            if ($uid != $loginid && $loginid != "") {
                                $login_que = mysql_query("SELECT * from freelancer_mmv_member_master where member_id='$loginid'");
                                $login_result = mysql_fetch_array($login_que);
                                if ($login_result['first_name'] == '' || $login_result['last_name'] == '' || $login_result['country'] == '' || $login_result['nationality'] == '' || $login_result['expsectornew'] == '' || $login_result['hobby'] == '' || $login_result['mbti'] == '' || $login_result['area'] == '') {
                                    ?>
                                    <a href="javascript:void(0);" class="more-link incompleteprofile"><img src="images/dotted-img.png" alt="More"/></a>

                                <?php } else { ?>
                                    <a href="javascript:void(0);" name="abuse" data-index="<?php echo $idd ?>"  class="more-link" data-fancybox="" data-type="inline" data-src="#abuseOption"><img src="images/dotted-img.png" alt="More"/></a>
                                    <?php
                                }
                            } else if ($uid == $loginid && $loginid != "") {
                                ?>
                                <a href="javascript:void(0);" class="more-link" data-fancybox="" data-type="inline" data-src="#moreLinks<?php echo $idd1; ?>"><img src="images/dotted-img.png" alt="More"/></a>
                            <?php } else { ?>
                                <a href="javascript:void(0);" class="more-link" data-fancybox="" data-type="inline" data-src="#loginPopup"><img src="images/dotted-img.png" alt="More"/></a>
                            <?php } ?>
                        </div>
                        <?php
                        if ($about_res[description] != "") {
                            ?>
                            <span style="word-break: break-word; font-size: 13.5px">
                                <?php if (strlen($about_res[description]) > 196) { ?>
                                    <span style='color:black'><?= substr($about_res[description], 0, 196) ?><span style="display:none;color:black" id="full_text_<?= $idd1 ?>"><?= substr($about_res[description], 196, 900) ?></span>
                                    </span>
                                    <span class="dot_<?= $idd1 ?>">...</span>
                                    <br>
                                    <a class="read_more" style="color:grey;float:right" data-id="<?= $idd1 ?>" id="read_more_<?= $idd1 ?>" href="javascript:void(0);">
                                        Read More
                                    </a>
                                    <a style="color:grey;float:right;display: none;" class="less_more" data-id="<?= $idd1 ?>" id="less_more_<?= $idd1 ?>" href="javascript:void(0);">Show Less</a>
                                    <?php
                                } else {
                                    echo "<span style='color:black'>" . $about_res[description] . "</span>";
                                }
                                ?>
                            <?php } ?>
                    </div>
                </div>
                <?php
                if ($loginid) {
                    ?>
                    <div class="popbox">
                        <div id="moreLinks<?php echo $idd1; ?>" class="popupbox text-align-center abuseOption url-and-post">
                            <p><a href="javascript:void(0);" data-fancybox="" data-src="#editUrl<?php echo $idd1; ?>" data-type="inline" class="button more-link">Edit Description</a></p>
                            <p><a href="deletecollection.php?id=<?php echo $idd1; ?>&type=delpost" class="button">Delete Post</a></p>
                        </div>
                    </div>
                    <div class="popbox">
                        <div id="editUrl<?php echo $idd1; ?>" class="popupbox text-align-center abuseOption url-and-post">
                            <form name="edits" method="post" action="" enctype="multipart/form-data">
                                <input type="hidden" name="editid" value="<?php echo $idd; ?>">
                                <?php
                                $web_que = mysql_query("SELECT * from freelancer_mmv_userimages where id='$idd' AND status=1");
                                $web_res = mysql_fetch_array($web_que);
                                ?>
                                <p>
                                    <textarea required="" style="height:170px" maxlength="800" name="description" id="description_textarea" class="form-control text-align-center inputbg" placeholder="Say something about this photo"><?php echo $web_res[description] ?></textarea>

                                    <button type="submit" name="submiturl" class="button loginbtn">Submit</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
                <?php
                $extension = strtolower(end(explode(".", $about_res[image])));
                if ($extension == "mp4" || $extension == "mov") {
                    $filename = preg_replace('"\.(mp4|MP4|MOV|mov)$"', '.png', $about_res[image]);
                    ?>
                    <div class="contenets-img" align="center">
                            <!--<video style="background-color:black" width="425" height="430" preload="none" controls poster="https://meetfreelancers.com/beta/<?php echo $filename ?>">
                                    <source src="<?php echo $about_res[image]; ?>" type='video/mp4'>
                                    <source src="<?php echo $about_res[image]; ?>" type="video/ogg; codecs=theora, vorbis" />
                                    <source src="<?php echo $about_res[image]; ?>" type="video/webm; codecs=vp8, vorbis" />
                            <img src="https://meetfreelancers.com/beta/<?php echo $filename ?>" title="Your browser does not support the <video> tag">
                            </video>-->

                        <video id="video" style="background-color:black" width="100%" controls="true" poster="<?php echo $urlpath . $filename ?>" preload="metadata">

                            <source src="<?php echo $about_res[image]; ?>#t=0.5" type="video/mp4">

                            <source src="<?php echo $about_res[image]; ?>#t=0.5" type="video/ogg">

                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php } else { ?>
                    <div class="contenets-img">
                        <img src="<?php echo $about_res[image]; ?>" <?php if ($loginid != "") { ?> ondblclick="mydoubleFunction(<?php echo $about_res[id] ?>)" <?php } ?> alt=""/>
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
                                <?php
                                if ($about_res['subcategory'] != '') {
                                    $sc = mysql_query("SELECT * from freelancer_mmv_filter where filter_id=" . $about_res1['subcategory'] . " AND status='1'");
                                    $subcategory = mysql_fetch_array($sc);
                                    if ($subcategory['title']) {
                                        ?>
                                        <td align = "center" class = "job-title"><?php echo $subcategory['title']; ?></td>
                                        <?php
                                    }
                                }
                                ?>
                                <?php if ($uid == $loginid && $jobdesc) { ?>
                                    <td align="center" class="job-title"><a href="profile.php"><?php echo $jobdesc ?></a></td>
                                <?php } else if ($jobdesc) { ?>
                                    <td align="center" class="job-title"><a href="viewclient.php?id=<?php echo $uid ?>"><?php echo $jobdesc ?></a></td>
                                <?php } ?>

                                <?php
                                if ($loginid != '') {
                                    if ($incomplete_profile) {
                                        ?>
                                        <td class="likes-div incompleteprofile" style="cursor:pointer">
                                            <i class="fa">&#xf08a;</i> 
                                            <a href="likers.php?ccid=<?php echo $idd; ?>">
                                                <span id="this<?php echo $about_res1[id] ?>"><?php echo $count; ?></span> likes
                                            </a>
                                        </td>
                                    <?php } elseif ($mycount < 1) {
                                        ?>
                                        <td class="likes-div" style="cursor:pointer"><i id="delete_<?php echo $about_res[id] ?>" class="fa">&#xf08a;</i> <a href="likers.php?c$_=<?php echo $idd; ?>"><span id="this<?php echo $about_res[id] ?>"><?php echo $count; ?></span> likes</a></td>
                                    <?php } else { ?>
                                        <td class="likes-div" style="cursor:pointer"><i class="fa">&#xf08a;</i>
                                            <a href="likers.php?ccid=<?php echo $idd; ?>"> <?php echo $count; ?> likes</a></td>
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

        <!--start job contenets-->
        <div id="postList">
            <?php
            $all_contents = array();
            if (!isset($_GET['qanda']) || $_GET['qanda'] == 0) {
                // this is for home page QA
                $question_que = mysql_query("SELECT q.*,f.title as Subcategory,f.title_arabic, 'questions' as 'type' from freelancer_mmv_questions AS q 
                                        inner join freelancer_mmv_filter as f on (q.subcategory_id=f.filter_id)
                                        INNER JOIN (SELECT MAX(questions_id) as id FROM freelancer_mmv_questions GROUP BY user_id) last_updates 
                                        ON last_updates.id = q.questions_id
                                        where  q.status=1 AND q.user_id !='0' $filterCats ORDER BY q.questions_id DESC");
            } else {
                // this is for Q and A page... so no restriction per user single question.
                $question_que = mysql_query("SELECT q.*,f.title as Subcategory,f.title_arabic, 'questions' as 'type' from freelancer_mmv_questions AS q 
                                        inner join freelancer_mmv_filter as f on (q.subcategory_id=f.filter_id)
                                        where  q.status=1 AND q.user_id !='0' $filterCats ORDER BY q.questions_id DESC");
            }
            while ($question_row = mysql_fetch_array($question_que)) {
                $all_contents[] = $question_row;
            }
            if (!isset($_GET['qanda']) || $_GET['qanda'] == 0) {

                if ($_SESSION[countryid] == "" && $id == "" && $filterid == '') {
                    $about_que1 = mysql_query("SELECT *,'photos' as 'type',`date` AS created from freelancer_mmv_userimages where  userid!='' AND status=1 ORDER BY id DESC LIMIT 10");
                } else if ($_SESSION[countryid] == "" && $id != "" && $filterid == '') {
                    $about_que1 = mysql_query("SELECT *,'photos' as 'type',`date` AS created from freelancer_mmv_userimages where  userid!='' AND status=1 AND freelanceserviceid=$id ORDER BY id DESC LIMIT 10");
                } else if ($_SESSION[countryid] != "" && $id == "" && $filterid == '') {
                    $about_que1 = mysql_query("SELECT *,'photos' as 'type',`date` AS created from freelancer_mmv_userimages where  userid!='' AND status=1 AND countryid='$countryid' ORDER BY id DESC LIMIT 10");
                } else if ($_SESSION[countryid] == "" && $filterid != '') {
                    $about_que1 = mysql_query("SELECT *,'photos' as 'type',`date` AS created from freelancer_mmv_userimages where  userid!='' AND status=1 $filterid ORDER BY id DESC LIMIT 10");
                } else if ($_SESSION[countryid] != "" && $filterid != '') {
                    $about_que1 = mysql_query("SELECT *,'photos' as 'type',`date` AS created from freelancer_mmv_userimages where  userid!='' AND status=1 $filterid AND countryid='$countryid' ORDER BY id DESC LIMIT 10");
                } else {
                    $about_que1 = mysql_query("SELECT *,'photos' as 'type',`date` AS created from freelancer_mmv_userimages where  userid!='' AND status=1 AND freelanceserviceid=$id AND countryid='$countryid' ORDER BY id DESC LIMIT 10");
                }
                $imgcount = mysql_num_rows($about_que1);
                if ($imgcount == 0) {
                    echo '<div class="contenets">
					<div class="topbar">
						<div class="container">
							<p align="center" style="font-size:18px">No results!!</p>
						</div>
					</div>
				 </div>';
                } else {
                    while ($about_res1 = mysql_fetch_array($about_que1)) {
                        $all_contents[] = $about_res1;
                    }
                }
            }

            function date_compare($a, $b) {
                $t1 = strtotime($a['created']);
                $t2 = strtotime($b['created']);
                return $t2 - $t1;
            }

            usort($all_contents, 'date_compare');

            if (count($all_contents) > 0) {
                foreach ($all_contents as $about_res1) {
                    if ($about_res1['type'] == 'photos') {
                        $idd = $about_res1[id];
                        $idd1 = $about_res1[id];
                        $uid = $about_res1[userid];
                        $filter_id = $about_res1[filter_id];
                        $userinfo = getUserinfo($uid);
                        $jobdesc = getSubExperience($filter_id);
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
//                                $web = $about_res1[website];
//                                if (false === strpos($web, '://')) {
//                                    $url = 'http://' . $web;
//                                }
//                                if ($about_res1[website] != "") {
//                                    
                                    ?>
                                    <!--<a href="<?php echo $url; ?>" target="_blank" class="view-website">View website</a>-->
                                    <?php // }  ?>
                                    <div class="doted-main">
                                        <?php
                                        if ($uid != $loginid && $loginid != "") {
                                            if ($incomplete_profile) {
                                                ?>
                                                <a href="javascript:void(0);" class="more-link incompleteprofile"><img src="images/dotted-img.png" alt="More"/></a>

                                            <?php } else { ?>
                                                <a href="javascript:void(0);" name="abuse" data-index="<?php echo $idd ?>"  class="more-link" data-fancybox="" data-type="inline" data-src="#abuseOption"><img src="images/dotted-img.png" alt="More"/></a>
                                                <?php
                                            }
                                        } else if ($uid == $loginid && $loginid != "") {
                                            ?>
                                            <a href="javascript:void(0);" class="more-link" data-fancybox="" data-type="inline" data-src="#moreLinks<?php echo $idd1; ?>"><img src="images/dotted-img.png" alt="More"/></a>
                                        <?php } else { ?>
                                            <a href="javascript:void(0);" class="more-link" data-fancybox="" data-type="inline" data-src="#loginPopup"><img src="images/dotted-img.png" alt="More"/></a>
                                        <?php } ?>
                                    </div>
                                    <br>
                                    <?php
                                    if ($about_res1[description] != "") {
                                        ?>
                                        <span style="word-break: break-word; font-size: 13.5px">
                                            <?php if (strlen($about_res1[description]) > 196) { ?>
                                                <span style='color:black'><?= substr($about_res1[description], 0, 196) ?><span style="display:none;color:black" id="full_text_<?= $idd1 ?>"><?= substr($about_res1[description], 196, 900) ?></span>
                                                </span>
                                                <span class="dot_<?= $idd1 ?>">...</span>
                                                <br>
                                                <a class="read_more" style="color:grey;float:right" data-id="<?= $idd1 ?>" id="read_more_<?= $idd1 ?>" href="javascript:void(0);">
                                                    Read More
                                                </a>
                                                <a style="color:grey;float:right;display: none;" class="less_more" data-id="<?= $idd1 ?>" id="less_more_<?= $idd1 ?>" href="javascript:void(0);">Show Less</a>
                                                <?php
                                            } else {
                                                echo "<span style='color:black'>" . $about_res1[description] . "</span>";
                                            }
                                            ?>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            if ($loginid) {
                                ?>
                                <div class="popbox">
                                    <div id="moreLinks<?php echo $idd1; ?>" class="popupbox text-align-center abuseOption url-and-post">
                                        <p><a href="javascript:void(0);" data-fancybox="" data-src="#editUrl<?php echo $idd1; ?>" data-type="inline" class="button more-link">Edit Description</a></p>
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
                                            <p align="center">
                                                <textarea required="" style="height:170px" maxlength="800" name="description" id="description_textarea" class="form-control text-align-center inputbg" placeholder="Say something about this photo"><?php echo $web_res[description] ?></textarea>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <!--<input type="text" name="weblink" value="<?php echo $web_res[website] ?>" required class="form-control text-align-center inputbg" placeholder="Website URL" id=""><br>-->
                                                <button type="submit" name="submiturl" class="button loginbtn">Submit</button></p>
                                        </form>
                                    </div>
                                </div>

                                <?php
                            }
                            $extension = strtolower(end(explode(".", $about_res1[image])));
                            if ($extension == "mp4" || $extension == "mov") {
                                $filename = preg_replace('"\.(mp4|MP4|MOV|mov)$" ', '.png', $about_res1[image]);
                                ?>
                                <div class="contenets-img" align="center">
                                <!--<a id="anchor1" onclick="PlayVideo('anchor1','video1');"><img src ="https://meetfreelancers.com/beta/<?php echo $filename ?>" alt="trail" /></a>
                                <video  id="video1" controls="controls" style="display:none" poster="https://meetfreelancers.com/beta/<?php echo $filename ?>">
                                        <source src="<?php echo $about_res1[image]; ?>"    type="video/mp4" />
                                        <source src="<?php echo $about_res1[image]; ?>" type="video/ogg" />
                                        Your browser does not support the video element.
                                </video>
                                        <video style="background-color:black" width="425" height="430" controls >
                                          <source src="<?php echo $about_res1[image]; ?>" type="video/mp4">
                                        <img width="425" height="430" src="https://meetfreelancers.com/beta/<?php echo $filename ?>" title="Your browser does not support the <video> tag">
                                        </video>-->
                                    <video id="video" style="background-color:black" width="100%" controls="true" poster="<?php echo $urlpath . $filename; ?>">
                                        <source src="<?php echo $about_res1[image]; ?>" type="video/mp4">
                                        <source src="<?php echo $about_res1[image]; ?>" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            <?php } else { ?>
                                <div class="contenets-img">
                                    <img class="dbclickimage_<?php echo $about_res1[id]; ?>" id="<?php echo $about_res1[id]; ?>" src="<?php echo $about_res1[image]; ?>" alt=""/>
                                </div>
                            <?php } ?>


                            <div class="btmbar">
                                <div class="container clearfix">
                                    <table width="100%">
                                        <tr>
                                            <td class="job-posted-user">
                                                <?php if ($uid == $loginid) { ?>
                                                    <a href="profile.php"><?php echo $userinfo[3] . ' <br>' . $userinfo[4] ?></a>
                                                <?php } else { ?>
                                                    <a href="viewclient.php?id=<?php echo $uid ?>"><?php echo $userinfo[3] . ' <br>' . $userinfo[4] ?></a>
                                                <?php } ?>
                                            </td>
                                            <?php
                                            if ($about_res1['subcategory'] != '') {
                                                $sc = mysql_query("SELECT * from freelancer_mmv_filter where filter_id=" . $about_res1['subcategory'] . " AND status='1'");
                                                $subcategory = mysql_fetch_array($sc);
                                                if ($subcategory['title']) {
                                                    ?>
                                                    <td align = "center" class = "job-title"><?php echo $subcategory['title']; ?></td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php if ($uid == $loginid && $jobdesc) { ?>
                                                <td align="center" class="job-title"><a href="profile.php"><?php echo $jobdesc ?></a></td>
                                            <?php } else if ($jobdesc) { ?>
                                                <td align="center" class="job-title"><a href="viewclient.php?id=<?php echo $uid ?>"><?php echo $jobdesc ?></a></td>
                                            <?php } ?>

                                            <?php
                                            if ($loginid != '') {
                                                if ($incomplete_profile) {
                                                    ?>
                                                    <td class="likes-div incompleteprofile" style="cursor:pointer">
                                                        <i class="fa">&#xf08a;</i> 
                                                        <a href="likers.php?ccid=<?php echo $idd; ?>">
                                                            <span id="this<?php echo $about_res1[id] ?>"><?php echo $count; ?></span> likes
                                                        </a>
                                                    </td>
                                                <?php } else if ($mycount < 1) {
                                                    ?>
                                                    <td class="likes-div" style="cursor:pointer"><i id="delete_<?php echo $about_res1[id] ?>" class="fa">&#xf08a;</i> <a href="likers.php?ccid=<?php echo $idd; ?>"><span id="this<?php echo $about_res1[id] ?>"><?php echo $count; ?></span> likes</a></td>
                                                <?php } else { ?>
                                                    <td class="likes-div" style="cursor:pointer"><i class="fa">&#xf08a;</i><a href="likers.php?ccid=<?php echo $idd; ?>"> <?php echo $count; ?> likes</a></td>
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
                        <?php
                    } elseif ($about_res1['type'] == 'questions') {
                        $questions_id = $about_res1['questions_id'];
                        $question = $about_res1['question'];
                        $about_question = $about_res1['about_question'];
                        $user_id = $about_res1['user_id'];
                        $Subcategory = $about_res1['Subcategory'];

                        $userinfo = getUserinfo($user_id);

                        $ans_que = mysql_query("SELECT ans.answers_id,ans.answer,users.member_id,users.first_name,users.last_name,users.image FROM `freelancer_mmv_answers` as ans 
                                                INNER JOIN freelancer_mmv_member_master	as users ON (ans.answer_by = users.member_id)
                                                WHERE ans.`questions_id` = $questions_id AND ans.`status` = 1");
                        $ans_count = 0;
                        $all_ans = [];
                        while ($ans_row = mysql_fetch_array($ans_que)) {
                            $all_ans[] = $ans_row;
                            $ans_count++;
                        }

                        $like_que = mysql_query("SELECT * from  freelancer_mmv_que_ans_likes where questions_id='$questions_id'");
                        $count = mysql_num_rows($like_que);
                        ?>
                        <div class="contenets">
                            <div class="topbar">
                                <div class="container clearfix">
                                    <span style="display: block;font-size: 13px;text-align: left;"> Posted By: 
                                        <?php if ($user_id == $loginid) { ?>
                                            <a href="profile.php"><b><?php echo $userinfo[3] . ' ' . $userinfo[4] ?></b></a>
                                        <?php } else { ?>
                                            <a href="viewclient.php?id=<?php echo $user_id ?>"><b><?php echo $userinfo[3] . ' ' . $userinfo[4] ?></b></a>
                                        <?php } ?></span>
                                    <h6><?php echo $question; ?></h6>
                                    <label class="longtext" id="more_<?php echo $questions_id; ?>">
                                        <?php echo $about_question; ?>
                                    </label>
                                    <div class="clearfix mt-1">
                                        <?php
                                        if (strlen($about_question) > 100) {
                                            ?>
                                            <a class="readmore_btn float-right text-link" id="morebtn_<?php echo $questions_id; ?>" data-id="<?php echo $questions_id; ?>" href="javascript:void(0);">Read More</a>                                    
                                            <?php
                                        }
                                        ?>
                                        <span style="display: inline;font-size: 12px;text-align: left;"> Freelancer Service: </span><span style="color: black;font-size: 14px;"><?php echo $Subcategory; ?></span>

                                    </div>
                                    <div class="clearfix">
                                        <form  method="post" action="" class="mb-2 mt-2" enctype="multipart/form-data">
                                            <input type="hidden" name="questions_id" id="questions_id" value="<?php echo $questions_id; ?>">
                                            <div class="input-group_">
                                                <textarea class="form-control ans_input" style="border:1px solid #979797;height: 42px;" name="answer" placeholder="Please answer the question here" autocomplete="off"></textarea>
                                                <span class="input-group-btn_ ans_btn_div" style="display: none;clear: both;float: right;margin-top: 10px;">
                                                    <?php
                                                    if ($loginid != '') {
                                                        ?>
                                                        <button class="btn btn-default" style="cursor: pointer;background-color: #b8cc8d;" name="answer_submit" type="submit">Answer</button>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a href="#" class="btn btn-default" style="cursor: pointer;background-color: #b8cc8d;" data-fancybox data-type="inline" data-src="#loginPopup">Answer</a>
                                                        <?php
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="container clearfix mt-2">

                                    <div class="row clearfix mb-2 border-box">
                                        <div class="col-4 pr-0"><?php echo $ans_count; ?> Answer(s)</div>
                                        <div class="col-4 text-center p-0">
                                            <a data-show="0" class="text-link showhide_ans" id="answer_<?php echo $questions_id; ?>" style="color: #4eda65;" href="javascript:void(0);">View Answers</a>
                                        </div>
                                        <div class="col-4 text-right pl-0">
                                            <?php
                                            if ($loginid != '') {
                                                ?>
                                                <span class="likes-div" style="cursor:pointer"><i id="likeQue_<?php echo $questions_id; ?>" data-touser="<?php echo $userinfo['member_id']; ?>" class="fa">&#xf08a;</i> <a href="likers.php?queid=<?php echo $questions_id; ?>"><span id="qlikes<?php echo $questions_id; ?>"><?php echo $count; ?></span> likes</a></span>
                                            <?php } else {
                                                ?>
                                                <span class="likes-div" style="cursor:pointer"><a href="#" data-fancybox data-type="inline" data-src="#loginPopup"><i class="fa">&#xf08a;</i> <?php echo $count; ?> likes</a></span>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="row answer_<?php echo $questions_id; ?>" style="display: none;">
                                        <div class="col-12">

                                            <!--<h6>Answers : </h6>-->
                                            <?php
                                            if (count($all_ans) > 0) {
                                                foreach ($all_ans as $anss) {
                                                    $answers_id = $anss['answers_id'];
                                                    $like_ans = mysql_query("SELECT * from  freelancer_mmv_que_ans_likes where answers_id='$answers_id'");
                                                    $count = mysql_num_rows($like_ans);
                                                    ?>
                                                    <div class="clearfix mb-2" style="border-bottom: 1px solid #ddd;">
                                                        <div class="user-profile d-flex align-items-center">
                                                            <div class="ans_photo">
                                                                <?php if ($anss['member_id'] == $loginid) { ?>
                                                                    <a href="profile.php">
                                                                        <img src="<?php if ($anss['image'] && file_exists('uploads/users/' . $anss['image'])) { ?>uploads/users/<?php
                                                                            echo $anss['image'];
                                                                        } else {
                                                                            echo'images/avatar.png';
                                                                        }
                                                                        ?>" alt="<?php echo $anss['first_name'] . ' ' . $anss['last_name'] ?>" /></a>
                                                                    <?php } else { ?>
                                                                    <a href="viewclient.php?id=<?php echo $anss['member_id'] ?>">
                                                                        <img src="<?php if ($anss['image']) { ?>uploads/users/<?php
                                                                            echo $anss['image'];
                                                                        } else {
                                                                            echo'images/avatar.png';
                                                                        }
                                                                        ?>" alt="<?php echo $anss['first_name'] . ' ' . $anss['last_name'] ?>" /></a>
                                                                    <?php } ?>

                                                            </div>
                                                            <div class="ans_text">
                                                                <?php echo $anss['answer'] ?>
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <?php
                                                            if ($loginid != '') {
                                                                ?>
                                                                <span class="likes-div" style="cursor:pointer"><i id="likeAns_<?php echo $answers_id; ?>" data-touser="<?php echo $anss['member_id']; ?>" class="fa">&#xf08a;</i> <a href="likers.php?ansid=<?php echo $answers_id; ?>"><span id="alikes<?php echo $answers_id; ?>"><?php echo $count; ?></span> likes</a></span>
                                                            <?php } else {
                                                                ?>
                                                                <span class="likes-div" style="cursor:pointer"><a href="#" data-fancybox data-type="inline" data-src="#loginPopup"><i class="fa">&#xf08a;</i> <?php echo $count; ?> likes</a></span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } /* QUESTIONS : END */
                }
            } else {
                echo '<div class="contenets">
					<div class="topbar">
						<div class="container">
							<p align="center" style="font-size:18px">No results!!</p>
						</div>
					</div>
				 </div>';
            }
            ?>

            <div class="load-more" lastID="<?php echo $postIDD; ?>" style="display: none;">
                <img src="images/loading.gif"/>
            </div>
        </div>
        <!--end job contenets-->
    </section>
</div>
<!--end main-->
<!--start other popup boxes-->
<?php if ($loginid) { ?>
    <div class="popbox">
        <div id="abuseOption" class="popupbox text-align-center abuseOption">
            <form name="abuse" method="post" action="">
                <input type="hidden" name="postid" id="postid" value=""/>
                <h2>report/abuse</h2>
                <div class="form-group">
                    <textarea name="content" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" name="abuse" class="button">Submit</button>
                </div>
            </form>
        </div>

    </div>
<?php } ?>

<script>

    $("[class^='dbclickimage_']").dblclick(function () {
        var i = $(this).attr('class');
        var arr = i.split("_");
        var idim = arr[1];
        //var idim = $('.dbclickimage').attr('id');
        //alert(i);
        $.ajax({
            type: "POST",
            data: "id=" + idim,
            url: "likescript.php",
            success: function (data)
            {
                if (data != "")
                {
                    $('#this' + idim).text(data);
                }
            }
        });
    });

    /*function mydoubleFunction(myval) {	
     
     var i= myval;
     //alert(i);
     $.ajax({
     type:"POST",
     data:"id="+i,
     url:"likescript.php",
     success:function(data)
     {
     if(data!="")
     {
     $('#this'+i).text(data);
     }
     }
     });
     }*/
</script>

<script>
    $(function () {
        $("a[name=abuse]").on("click", function () {
            var abu = $(this).attr("data-index");
            document.getElementById("postid").value = abu;
        });

        $("[id^='delete_']").click(function () {
            var i = $(this).attr('id');
            var arr = i.split("_");
            var i = arr[1];
            $.ajax({
                type: "POST",
                data: "id=" + i,
                url: "likescript.php",
                success: function (data)
                {
                    if (data != "")
                    {
                        $('#this' + i).text(data);
                    }
                }
            });
        });
        $("[id^='likeQue_']").click(function () {
            var i = $(this).attr('id');
            var arr = i.split("_");
            var i = arr[1];

            $.ajax({
                type: "POST",
                data: "queid=" + i + "&touser=" + $(this).attr('data-touser'),
                url: "likescript_que.php",
                success: function (data)
                {
                    if (data != "")
                    {
                        $('#qlikes' + i).text(data);
                    }
                }
            });
        });
        $("[id^='likeAns_']").click(function () {
            var i = $(this).attr('id');
            var arr = i.split("_");
            var i = arr[1];
            $.ajax({
                type: "POST",
                data: "ansid=" + i + "&touser=" + $(this).attr('data-touser'),
                url: "likescript_que.php",
                success: function (data)
                {
                    if (data != "")
                    {
                        $('#alikes' + i).text(data);
                    }
                }
            });
        });


        var defaultHeight = 40;

        var button = $(".readmore_btn");
        $(".longtext").css({"max-height": defaultHeight, "overflow": "hidden"});

        button.on("click", function () {
            var qid = $(this).attr('data-id');

            var text = $("#more_" + qid);
            var btn = $("#morebtn_" + qid);
            var textHeight = text[0].scrollHeight;
            var newHeight = 0;
            if (text.hasClass("active")) {
                newHeight = defaultHeight;
                text.removeClass("active");
                btn.text('Read More');
            } else {
                newHeight = textHeight;
                text.addClass("active");
                btn.text('Read Less');
            }
            text.animate({
                "max-height": newHeight
            }, 500);
        });

        $('.ans_input').click(function () {
            $(this).animate({height: "95px"}, 500);
            $(this).next(".ans_btn_div").animate({opacity: "show"}, 500);
        });
        $('.ans_input').keyup(function () {
            $(this).animate({height: "95px"}, 500);
            $(this).next(".ans_btn_div").animate({opacity: "show"}, 500);
        });
        $('.ans_input').blur(function () {
            if ($(this).val().trim() == '') {
                $(this).animate({height: "42px"}, 500);
                $(this).next(".ans_btn_div").animate({opacity: "hide"}, 500);
            }
        });


    });
</script>
<?php include "footer.php"; ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script>
    $(window).on("scroll", function () {
        $.cookie("tempScrollTop", $(window).scrollTop());
        $.cookie("numclicks", 1);
    });
    $(function () {
        if ($.cookie("tempScrollTop")) {
            $(window).scrollTop($.cookie("tempScrollTop"));
        }
    });

    $(".home-link").click(function () {
        var $btn = $(this);
        var count = ($.cookie("numclicks", 2) || 0) + 1;
        $.cookie("numclicks", count);
        if (count == 1)
            alert(1);
        else if (count == 2)
            alert(2);
        else {
            removecookies();
            return true;
        }
        return false;
    });

    function removecookies() {
        $.cookie('tempScrollTop', 0);
    }
    $(document).on('click', '.showhide_ans', function () {
        var answerId = $(this).attr('id');
        if ($(this).attr('data-show') == 0) {
            $(this).html('Hide Answers');
            $(this).attr('data-show', 1)
        } else {
            $(this).html('Show Answers');
            $(this).attr('data-show', 0)
        }
        $('.' + answerId).toggle('slow');
    })

</script>

<script type="text/javascript">
    //$(document).ready(function(){
    $(window).scroll(function () {
        var lastID = $('.load-more').attr('lastID');
<?php if ($_SESSION[SESS_SUBCAT_ID] == "") { ?>
            var datastring = 'id=' + lastID;
    <?php
} else if ($filterid != '') {
    ?>
            var catid = <?php echo $_SESSION[SESS_SUBCAT_ID]; ?>;
            var datastring = 'id=' + lastID + '&catid=' + catid + '&type=' + '<?php echo $allcats ?>';
<?php } else {
    ?>
            var catid = <?php echo $_SESSION[SESS_SUBCAT_ID]; ?>;
            var datastring = 'id=' + lastID + '&catid=' + catid;
<?php } ?>
        if (($(window).scrollTop() == $(document).height() - $(window).height()) && (lastID != 0)) {

            $.ajax({
                type: 'POST',
                url: 'getData.php',
                data: datastring,
                beforeSend: function () {
                    $('.load-more').show();
                },
                success: function (html) {
                    $('.load-more').remove();
                    $('#postList').append(html);
                }
            });
        }
    });
    $(document).on('click', '.read_more', function () {
        var id = $(this).attr('data-id');
        $('#full_text_' + id).show();
        $('#less_more_' + id).show();
        $('.dot_' + id).hide();
        $(this).hide();
    })
    $(document).on('click', '.less_more', function () {
        var id = $(this).attr('data-id');
        $('#full_text_' + id).hide();
        $('#read_more_' + id).show();
        $('.dot_' + id).show();
        $(this).hide();
    })
//});

</script>