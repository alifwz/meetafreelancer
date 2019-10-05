<?php
session_start();
include "connection.php";
include "functions.php";
include "timezone.php";

$loginid = end($_SESSION[SESS_MEMBER_ID]);
$id=$_REQUEST[id];
$inv	= $_REQUEST[inv];

$query = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$id'");
$about_res = mysql_fetch_array($query);
$userinfo = getUserinfo($id);

mysql_query("UPDATE freelancer_mmv_chatmsgs SET readstatus='1' WHERE userid='$loginid' AND receiverid=$id");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Freelancer</title>
<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0" />
<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png" />
<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png" />
<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png" />
<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png" />
<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png" />
<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png" />
<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png" />
<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png" />
<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png" />
<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png" />
<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png" />
<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png" />
<link rel="manifest" href="favicon/manifest.json" />
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/selectric.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/responsive.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div class="main">		
	<div class="messages-dtl">
		<div class="messages-header">
			<div class="job-row">				
				<div class="arrow-left" onClick="location.href='messages.php'"><img src="images/arrow-left.png" alt="Star Wing"/></div>
				<div class="msgimg-holder-div" onClick="location.href='viewclient.php?id=<?php echo $id ?>'">
					<div class="msgimg-holder">
						<?php if($userinfo[11] ==""){ ?>
								<img src="images/user.png" alt=""/>
							<?php } else { ?>
								<img src="uploads/users/<?php echo $userinfo[11]?>" alt=""/>
							<?php } ?>
					</div>
					<h3 style="font-size:16px"><?php echo $userinfo[3].' <br>'.$userinfo[4] ; ?><span style="font-size:13px"><?php echo getSubExperience($userinfo[16]); ?></span></h3>
				</div>
			</div>
		</div>
		
		<div class="notification">
			<div class="messages-chat">
				<?php								
			$chat_que = mysql_query("SELECT * from freelancer_mmv_chatmsgs where userid='$loginid' AND receiverid=$id ORDER BY date DESC ");
			while($chat_result = mysql_fetch_array($chat_que))
			{
				$dbtimezone = $chat_result[timezone];	
				$chatdate1 = $chat_result[date];
				
				$chatdate = converToTz($chatdate1, $timezone, $dbtimezone);
					
				if($chatdate >date('Y-m-d 00:00:00',strtotime("-1 days")) && $chatdate < date('Y-m-d 23:59:59',strtotime("-1 days"))) {
					$chatday = "Yesterday";
				} else if($chatdate >date('Y-m-d 00:00:00') && $chatdate < date('Y-m-d 23:59:59')){
					$chatday = date('H:i A',strtotime($chatdate));
				} else {
					$now = time(); 
					$your_date = strtotime($chatdate);
					$datediff = $now - $your_date;
					$chatday = round($datediff / (60 * 60 * 24)).' day(s) ago';
				}
					
					
				if($loginid!=$chat_result[msgpostedby]){	
			?>	
			<div class="chat">
					<div class="bubble me">
						<p><?php echo $chat_result[message]; ?></p>
						<div class="msg-dt-tm text-right"><?php echo $chatday ?></div>	
					</div>
				</div> 
				
			<?php } else { ?>			
				
				<div class="chat">
					<div class="bubble you">
						<p><?php echo $chat_result[message]; ?></p>
						<div class="msg-dt-tm"><?php echo $chatday ?></div>						
					</div>
				</div>
			<?php } } ?>
			</div> 
		</div>
	</div>
</div>
<div class="type-message-main">
	<div class="container clearfix">
	<form name="myForm" id="myForm" action="chatsubmit3.php?id=<?php echo $id ?>" method="post">
	<input type="hidden" name="timezone" value="<?php echo $timezone ?>">
	<input type="hidden" name="invid" value="<?php echo $inv; ?>">
		<button type="submit" onclick="return check_val();" name="submit" class="send-btn"><img src="images/send-btn.png" alt="send"/></button>
		<div class="type-message">			
			<div class="type-input-div"><input type="text" required pattern="[أ-يa-zA-Z,. ]*" title="Numbers, Special Charaters are not allowed" name="msg" id="msg" class="input-msg" value="" placeholder="Type a message" /></div>			
		</div>
		</form>
	</div>
</div>
<script>
function check_val(){
	
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.msg.value))
	{
		alert("Email addresses are not allowed!");
		return false;
	} 
	var numericExpression = /^[0-9]+$/;
	if(msg.value.match(numericExpression)){
		alert("Numbers are not allowed!");
		return false;
	}
	
	var wordInput 	= document.getElementById("msg").value.toLowerCase();	
	// split the words by spaces (" ")
	var arr  = wordInput.split(" ");
		
	// bad words to look for
	var badWords = ['sex','ass','fuck','shit','asshole', 'cunt', 'fag', 'fuk','fck', 'fcuk', 'assfuck','assfucker','fucker','motherfucker','asscock', 'asshead','asslicker', 'asslick','assnigger', 'nigger','asssucker', 'bastard', 'bitch','bitchtits','bitches', 'bitch','brotherfucker', 'bullshit','bumblefuck', 'buttfucka','fucka', 'buttfucker','buttfucka', 'fagbag','fagfucker', 'faggit', 'faggot','faggotcock', 'fagtard','fatass', 'fuckoff','fuckstick','fucktard', 'fuckwad','fuckwit', 'dick', 'dickfuck','dickhead', 'dickjuice','dickmilk', 'doochbag','douchebag', 'douche','dickweed', 'dyke', 'dumbass','dumass', 'fuckboy','fuckbag', 'gayass', 'gayfuck','gaylord', 'gaytard', 'nigga','niggers', 'niglet', 'paki', 'piss','prick', 'pussy', 'poontang','poonany','porchmonkey','porchmonkey', 'poon', 'queer','queerbait', 'queerhole','queef', 'renob', 'rimjob','ruski', 'sandnigger', 'sandnigger','schlong', 'shitass','shitbag', 'shitbagger','shitbreath', 'chinc','carpetmuncher', 'chink','choad','clitface','clusterfuck', 'cockass','cockbite', 'cockface','skank', 'skeet', 'skullfuck','slut','slutbag', 'splooge','twatlips', 'twat', 'twats','twatwaffle', 'vaj', 'vajayjay','va-j-j', 'wank', 'wankjob','wetback', 'whore','whorebag', 'whoreface','horny' , 'viagra', 'porn','testicles','butt','penis','dick','tits' ,'suck','fart','porno','nude','nudes','nipple'];
	
	 var index , totalWordAmount = 0, totalWordsFoundList = '';
	 for(index=0;index<arr.length; ++index){
		 if(jQuery.inArray( arr[index], badWords ) > -1){
		   totalWordAmount = totalWordAmount + 1;
		   totalWordsFoundList = totalWordsFoundList+' '+ arr[index];		   
		   alert("Please use better words!");
			return false;
		 }	 
	 }		 	 
}
</script>

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/fontsmoothie.min.js"></script>
<script type="text/javascript" src="js/jquery.selectric.js"></script>
<script src="upload/jquery.form.js" type="text/javascript" language="javascript"></script>
<script src="upload/jquery.MetaData.js" type="text/javascript" language="javascript"></script>
<script src="upload/jquery.MultiFile.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="js/custom.js"></script>
</body>
</html>