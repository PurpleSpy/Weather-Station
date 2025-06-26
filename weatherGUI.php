<html>

	<head>
			
			<link href="https://fonts.googleapis.com/css2?family=Caprasimo&family=Limelight&display=swap" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css2?family=Lacquer&display=swap" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
		<style>
		
			
			body{
				background:black;
			}
			.sensordata{
				border-radius:10%;
				border:white solid 1px;
				font-size:330%;
				color:lime;
				float:left;
				margin: 1.5%;
				padding:2%;
				filter:drop-shadow(2 2 white);
				text-align:center;
				font-family: "Oswald", system-ui;
				
			}
			
			.uid{
				font-family: "Caprasimo", serif;
			}
			.tempF{
				color:orange;
			}
			.baro{
				color:purple;
			}
			.humid{
				color:blue;
			}
			.headache{
				color:red;
			}
			
			
		</style>
		<script>
			currentWeather=Array();	
			
			function updateData(ob){
				try{
					bcont= document.getElementById(ob.uid);
					if(bcont.children.length>0){
						for(i=0;i<bcont.children.length;i++){
							if (bcont.children[i].className=="tempF"){
								bcont.children[i].innerHTML= parseInt(ob.tempF) + " F";
							}
							if (bcont.children[i].className=="baro"){
								bcont.children[i].innerHTML= ob.baro + " INinHG";
							}
							if (bcont.children[i].className=="humid"){
								bcont.children[i].innerHTML= parseInt(ob.humid) + "%";
							}
						}
						
					}
								
				}catch(err){
					genThermo(ob);
				}
			}
			
			function pullData(){
				datapull=new XMLHttpRequest();
				datapull.onload=function(){
					try{
					currentWeather=JSON.parse(datapull.responseText);
					currentWeather.forEach(genThermo,this);
					}catch(e){
						
					}
				}
				
				datapull.open("GET", "./weatherAPI.php?status");
				datapull.send();
			}
			function genThermo(data){
				ob=document.createElement("div");
				ob.className="sensordata";
				ob.id=data.uid;
				cont="<div class=\"uid\">" + data.uid + "</div>";
				cont+="<div class=\"tempF\">" + parseInt(data.tempF) + " F</div>";
				cont+="<div class=\"humid\">"+ parseInt(data.humid) + "%</div>";
				cont+="<div class=\"baro\">" + data.baro + " INinHG</div>";
				cont+="<div class=\"headache\">"+ data.headache +"</div>";
				
				ob.innerHTML=cont;
				if(document.getElementById(data["uid"]) != null){
					updateData(data);
				}
				
				else{
					document.body.appendChild(ob);
				}
					
			}
			
			setInterval(pullData,500);
			
		</script>
	</head>

	<body>

	</body>
</html>
