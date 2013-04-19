	$(document).ready(function () {		

		//load the web flowplayer
		
	flowplayer("player", "http://releases.flowplayer.org/swf/flowplayer-3.2.9.swf", {
    clip: {
       provider: 'rtmp',
       autoPlay: false,
       urlResolvers: 'brselect',
       // preserve aspect ratios
       scaling: 'fit',
       bitrates: [
         { url: "mp4:bbb-800",
                width: 480, bitrate: 400, isDefault: true
         },
         { url: "mp4:bbb-1600",
            width: 1080, bitrate: 1600, hd: true }
       ]
    },
    plugins: {
        brselect: {
            url: "http://releases.flowplayer.org/swf/flowplayer.bitrateselect-3.2.9.swf",
            
            // comment this out when using this in production
            onStreamSwitch: function (newItem) {
               $f().getPlugin('content').setHtml("Switched to: " + newItem.streamName);
            }
        },
        rtmp: {
            url: "http://releases.flowplayer.org/swf/flowplayer.rtmp-3.2.9.swf",
            netConnectionUrl: 'rtmp://s3b78u0kbtx79q.cloudfront.net/cfx/st'
        },
        content: {
            url: "http://releases.flowplayer.org/swf/flowplayer.content-3.2.8.swf",
            top: 0, left: 0, width: 400, height: 150,
            backgroundColor: 'transparent', backgroundGradient: 'none', border: 0,
            textDecoration: 'outline',
            style: {
                body: {
                    fontSize: 14,
                    fontFamily: 'Arial',
                    textAlign: 'center',
                    color: '#ffffff'
                }
            }
        }
    }
});


});				
