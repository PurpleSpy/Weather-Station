<html>

	<head>
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
								bcont.children[i].innerHTML= parseInt(ob.humid) + " %";
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
				cont+="<div class=\"humid\">"+ parseInt(data.humid) + " %</div>";
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
