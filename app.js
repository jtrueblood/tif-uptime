
var runner = require("child_process");


//app.use("/", php.cgi("/uptime")); 
setInterval(function(){
	var phpScriptPath = "logsites.php";
	var argsString = "value1,value2,value3";
	runner.exec("php " + phpScriptPath + " " +argsString, function(err, phpResponse, stderr) {
	 if(err) console.log(err); /* log error */
	console.log( phpResponse );
	});
}, 60000); // set timinterval of function 1000 = 1 second, 300000 = 5 min


console.log("TIF Uptime is Running"); 