
var streamSource;
var cpuInfoCanvas, memInfoCanvas, diskInfoCanvas;
var cpuInfoDiv,memInfoDiv;
var uptimeTextField


//object that contains values of stuff that doesn't change a lot
var unchanging = {
    totalMem : null,
    disk : null
    
};
//objects that represent the canvas and textfield elements for updating CPU,memory and disk info  
var cpuField = {
    canvas : null,
    context : null,
    textfield: null,
    width : null,
    height : null
};
var memField = {
    canvas : null,
    context : null,
    textfield: null,
    width : null,
    height : null
};

var diskCanvas = {
    canvas : null,
    context : null,
    width : null,
    height : null
};

// runs when page is loaded
function onLoad() {
    
    //check if the browser supports Server-Sent Events 
    if (!!window.EventSource) {
        streamSource = new EventSource("streamer.php");
        setListeners();
    } else {
        alert("This browser doesn't support Server-Sent Events :-(");
    }
    
    
    //initialise elements
    cpuField.canvas = document.getElementById("cpuInfoCanvas");
    cpuField.textfield = document.getElementById("cputextdiv");
    cpuField.context = cpuField.canvas.getContext("2d");
    cpuField.width = cpuField.canvas.width; 
    cpuField.height = cpuField.canvas.height;
    
    
    memField.canvas = document.getElementById("memInfoCanvas");
    memField.textfield = document.getElementById("memtextdiv");
    memField.context = memField.canvas.getContext("2d");
    memField.width = memField.canvas.width; 
    memField.height = memField.canvas.height;
    
    
    diskCanvas.canvas = document.getElementById("diskInfoCanvas");
    diskCanvas.context = diskCanvas.canvas.getContext("2d");
    diskCanvas.width = diskCanvas.canvas.width;
    diskCanvas.height = diskCanvas.canvas.height;
    
    uptimeTextField = document.getElementById("uptimetext");
    
    
}

//set listener for data from the php script
function setListeners() {
    streamSource.addEventListener('message', function(e) {
        var data = e.data;
        handleMsg(data);
    }, false);

    streamSource.addEventListener("error", function(e) {
        if(e.readyState == EventSource.CLOSED) {
            console.log("Connection closed");     
        }
    }, false);
    
}

//check what type of update msg is and draw on the corresponding canvas
function handleMsg(msg) {
    var splitMsg = msg.split("=");
    var updateType = splitMsg[0];
    // String is in the same format regardless of whether it is a cpu or memory update 
    if(updateType == "cpuupdate" || updateType == "memupdate" || updateType == "totalmemory" || updateType == "uptime") { 
        var newVal = splitMsg[1];
        
        if(updateType == "cpuupdate") {
            drawCpuMeter(newVal);
        }
        else if(updateType == "memupdate") {
            drawMemMeter(newVal);
        }
        else if(updateType == "totalmemory") {
            unchanging.totalMem = parseInt(newVal);
        }
        else if(updateType == "uptime") {
            setUptime(newVal);
        }
    }
    
}


//draw an arc to show CPU and memory info, also, update the textfield
function drawCpuMeter(val) {
    var value = parseInt(val); 
    
    cpuField.textfield.innerHTML = val + "%";
    
    //draw arc that starts at 12 o'clock  
    cpuField.context.clearRect(0, 0, cpuField.width, cpuField.height);
    cpuField.context.beginPath();
    cpuField.context.arc((cpuField.width/2),(cpuField.height/2),(cpuField.height*0.4),(1.5*Math.PI),((value/100*2*Math.PI)+1.5*Math.PI));
    cpuField.context.stroke();
    
    }
//draw memory info
function drawMemMeter(val) {
    var value = parseFloat(val); 
    var memPercent = (value/unchanging.totalMem) * 100;
    
    memField.textfield.innerHTML = val + "/" + unchanging.totalMem.toString() + "GB (" + parseInt(memPercent) + "%)"; 
    
    memField.context.clearRect(0, 0, memField.width, memField.height);
    memField.context.beginPath();
    memField.context.arc((memField.width/2),(memField.height/2),(memField.height*0.4),(1.5*Math.PI),((memPercent/100*2*Math.PI)+1.5*Math.PI));
    memField.context.stroke();

}

//Parse data from server and update the textfield for system uptime
function setUptime(val){
    var strArr = val.split(" ");
    var uptimeText = "Uptime: "
    for(var i=0;i<strArr.length;i++) {
        if(!isNaN(strArr[i])) {
            uptimeText += strArr[i]+":";
           }
    }
    // uptimeText.slice(0,-1) is to remove the last ":"
    uptimeTextField.innerHTML = "<h4>"+uptimeText.slice(0,-1)+"</h4>";
    
} 

window.addEventListener("load", onLoad());