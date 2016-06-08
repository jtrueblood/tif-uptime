
var runner = require("child_process");


//app.use("/", php.cgi("/uptime")); 
setInterval(function(){
	var phpScriptPath = "uptime.php";
	var argsString = "value1,value2,value3";
	runner.exec("php " + phpScriptPath + " " +argsString, function(err, phpResponse, stderr) {
	 if(err) console.log(err); /* log error */
	console.log( phpResponse );
	});
}, 3600000); // set timinterval of function 1000 = 1 second


console.log("TIF Uptime is Running"); 