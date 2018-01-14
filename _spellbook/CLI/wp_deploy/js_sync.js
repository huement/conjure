var sftp = require('node-sftp-deploy');

sftp({
    "host": "tenthmagnitude.sftp.wpengine.com",
    "port": "2222",
    "user": "tenthmagnitude-dscott",
    "pass": "BL$CKparad3",
    "remotePath": "/wp-content/themes/tenth-magnitude",
    "sourcePath": "/Users/derekscott/Code/10th_stage"
}, function(){
    //Success Callback
  console.log("YOU WIN!");
});

// //Support Promise
// sftp(sftpConfig).then(function(){
//     //Success Callback
//   console.log("YOU WIN!");
// });