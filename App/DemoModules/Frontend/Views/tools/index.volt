<div id="drop_zone" style="border: 2px dashed #bbb;-moz-border-radius: 5px;-webkit-border-radius: 5px;border-radius: 5px;padding: 25px;text-align: center;font: 20pt bold 'Vollkorn';color: #bbb;">Drop files here</div>
<output id="list">


</output>

<script>
    function handleFileSelect(evt) {
        evt.stopPropagation();
        evt.preventDefault();

        var files = evt.dataTransfer.files; // FileList object.

        // files is a FileList of File objects. List some properties.
        var output = [];
        for (var i = 0, f; f = files[i]; i++) {
            output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
                    f.size, ' bytes, last modified: ',
                    f.lastModifiedDate.toLocaleDateString(), '</li>');




            var reader = new FileReader();
            //以二进制形式读取文件
            reader.readAsArrayBuffer(f);
            //文件读取完毕后该函数响应
            reader.onload = function loaded(evt) {
                var binaryString = evt.target.result;
                //发送文件
                ws.send(binaryString);
            }

        }
        document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';


    }

    function handleDragOver(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
    }

    // Setup the dnd listeners.
    var dropZone = document.getElementById('drop_zone');
    dropZone.addEventListener('dragover', handleDragOver, false);
    dropZone.addEventListener('drop', handleFileSelect, false);


    $(function () {
        // Check for the various File API support.
        if (window.File && window.FileReader && window.FileList
                && window.Blob) {
            // Great success! All the File APIs are supported.
        } else {
            alert('The File APIs are not fully supported in this browser.');
        }
    });



    var ws;
    var paragraph = 10485760;
    var fileList ;
    var file;
    var startSize,endSize = 0;
    var i = 0; j = 0;
    //连接服务器
    $(function() {

        ws = new WebSocket('ws://localhost:9999/asdf/gdfsdf');
        ws.onopen = function() {
            console.log("成功连接到");
        };

        //收到服务器消息后响应
        ws.onmessage = function(e) {

            console.log(e.data);
            //连接关闭后响应

            return false;
        };

        ws.onclose = function() {
            console.log("关闭连接");
            ws = null;
        }



    });
</script>