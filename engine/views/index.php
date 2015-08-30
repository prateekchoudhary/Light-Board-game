<?php
session_start();
require_once("header.php");


if(isset($_SESSION['userid'])){
	switch($_SESSION['userid']){
		case 'user1' :	$_SESSION['color_code'] = 'rgb(255, 17, 17)';
				break;
		case 'user2' :  $_SESSION['color_code'] = 'rgb(0, 0, 255)';
				break;
		default      :  $_SESSION['color_code'] = 'rgb(255, 255, 255)';
				break;
	}
}
?>
<?php if(isset($_SESSION['userid'])) :?>
<div class="logout"><a href="javascript:void(0)" class="quit">Quit Game</a></div>
<?php endif;?>
<h6>Light Board Application</h6>
<?php if(isset($_SESSION['userid'])) :?>
<input type="button" class="acq_lock" value="Aquire Lock"/>
<?php endif;?>
<div class="canvas_board">
	<div id="userOne" class="user">
		<?php if(!isset($_SESSION['userid'])) :?>
		<input type="button" class="usertab" value="User 1" id="user1"/><br /><br />
		<?php endif;?>
		<img src="<?php echo MEDIA;?>user-left.jpg" width="131">
	</div>
	<div id="table_con" class="board"></div>
	<div id="userTwo" class="user">
		<?php if(!isset($_SESSION['userid'])) :?>
		<input type="button" class="usertab" value="User 2" id="user2"/><br /><br />
		<?php endif;?>
		<img src="<?php echo MEDIA;?>user-right.jpg" width="131">
	</div>
</div>
<script type="text/javascript">
var start_time;
var mybuttonlocked = false;
$(document).ready(function (){
	$('#table_con').lbgrid({
    		background : 'white'
	});
	var userId = "<?php echo $_SESSION['userid'];?>";
	var color_code = 'rgb(255, 255, 255)';
	window.setInterval(poll, 1200);
	if(userId != ""){
		color_code = getcolor_code(userId);
		loadLightBoard(userId);
	}
	$('.td_id').click(function (){
		if(mybuttonlocked){
			var color = $(this).css("background-color");
			switch(color){
				case 'rgb(255, 255, 255)' : $(this).css("background-color", color_code);
							    action = 'add';
								break;
				default			  : $(this).css("background-color", 'rgb(255, 255, 255)');
								action = 'del';
								break;
			}
			loadLightBoard(userId, this.id, action);
		}
	});
	
	$('.usertab').click(function (){
		$.ajax({
				    url: '<?php echo RESOURCE;?>store.php',
				    type: 'GET',
				    timeout: 1000,
				    data: "bustcache="+new Date().getTime()+"&userId="+this.id,
				    error: function(){
					//alert('Error loading XML document');
				    },
				    success: function(data){
						window.location = "<?php echo $_SERVER['php_self'];?>?user="+data;
				    }
		});
	});
	
	$('.acq_lock').click(function (){
		$.ajax({
				    url: '<?php echo RESOURCE;?>status.php',
				    type: 'GET',
				    timeout: 1000,
				    data: "bustcache="+new Date().getTime()+"&userId=<?php echo $_SESSION['userid'];?>",
				    error: function(){
					//alert('Error loading XML document');
				    },
				    success: function(data){
				    		$('.acq_lock').attr("disabled", true);
				    		mybuttonlocked = true;
						start_time = setTimeout(releaseLock, 60000);
				    }
		});
	});
	
	function releaseLock(){
		$.ajax({
				    url: '<?php echo RESOURCE;?>release.php',
				    type: 'GET',
				    timeout: 1000,
				    data: "bustcache="+new Date().getTime()+"&userId=<?php echo $_SESSION['userid'];?>",
				    error: function(){
					//alert('Error loading XML document');
				    },
				    success: function(data){
				    		mybuttonlocked = false;
				    		$('.acq_lock').attr("disabled", false);
						clearTimeout(start_time);
				    }
		});
	}
	
	$('.quit').click(function (){
		$.ajax({
				    url: '<?php echo RESOURCE;?>quit.php',
				    type: 'GET',
				    timeout: 1000,
				    data: "bustcache="+new Date().getTime()+"&userId=<?php echo $_SESSION['userid'];?>",
				    error: function(){
					//alert('Error loading XML document');
				    },
				    success: function(data){
						window.location = "<?php echo DIR_SERVER_PATH;?>";
				    }
		});
	});
	function loadLightBoard(userId, cell, operation){
			if(!cell){
				action = 'read';
			}
			else{
				if(operation == 'add')
					action = 'add';
				else
					action = 'del';
			}
			$.ajax({
					    url: '<?php echo RESOURCE;?>play.php',
					    type: 'GET',
					    timeout: 1000,
					    data: "bustcache="+new Date().getTime()+"&userId="+userId+"&cell="+cell+"&action="+action,
					    error: function(){
						//alert('Error loading XML document');
					    },
					    success: function(data){
					    	if(data != ""){
					    		//$('.td_id').css("background-color", 'rgb(255, 255, 255)');
							if(data.indexOf(":") > 0){
								var response = data.split(':');
								for(i=0;i<response.length;i++){
									var createClass = "#"+response[i];
									if(response[i] != "")
									$(createClass).css("background-color", color_code);
								}	
					    		}
					    		else{
					    			var createClass = "#"+data;
					    			if(data != "")
					    			$(createClass).css("background-color", color_code);
					    		}
					    		releaseLock();
					    	}
					    }
			});
	}
	
	function poll(){
		$.ajax({
				    url: '<?php echo RESOURCE;?>refreshboard.php',
				    type: 'GET',
				    timeout: 1000,
				    data: "bustcache="+new Date().getTime()+"&userId=<?php echo $_SESSION['userid'];?>",
				    error: function(){
					//alert('Error loading XML document');
				    },
				    success: function(data){
						if(data != ""){
							if(data.indexOf("$") > 0){
								data_array = data.split("$");
								data = data_array[0];
								if(data_array[1] == '0'){
									if(mybuttonlocked){
										$('.acq_lock').attr("disabled", true);
									}
									else{
										$('.acq_lock').attr('disabled', false);
									}
								}
								else{
									
										$('.acq_lock').attr("disabled", true);
								}
							}
							if(data.indexOf("|") > 0){
								$('.td_id').css("background-color", 'rgb(255, 255, 255)');
								var response_data = data.split('|');
								
									for(k=0;k<response_data.length;k++){
										if(response_data[k] != ""){
											var users = response_data[k].split("=");
										
											var username = users[0];
											var userdata = users[1];
											
											if(userdata != "" || userdata != "undefined"){
												
												if(userdata.indexOf(":") > 0){
													color_code = getcolor_code(username);
													//alert("userid="+username+"&color="+color_code);
													var response = userdata.split(':');
													for(i=0;i<response.length;i++){
														var createClass = "#"+response[i];
														if(response[i] != "")	
														$(createClass).css("background-color", color_code);
													}	
										    		}
										    		else{
										    			color_code = getcolor_code(username);
										    			var createClass = "#"+userdata;
													if(userdata != "")	
														$(createClass).css("background-color", color_code);
												
										    		}
										    		
										    	}
										    	else{
										    		
										    	}
										   }
								    	}
						    	}
						    	else{
								
						    	}
					    	}
				    }
		});
	}
	
	function getcolor_code(userid){
		switch(userid){
			case 'user1' : color_code = 'rgb(255, 17, 17)';
					break;
			case 'user2' : color_code = 'rgb(0, 0, 255)';
					break;
			default      : color_code = 'rgb(255, 255, 255)';
					break; 
		}
		return color_code;
	}

});

</script>
<?php
require_once("footer.php");
?>



