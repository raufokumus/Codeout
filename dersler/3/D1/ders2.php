<!DOCTYPE html>
<html lang="tr" manifest="cache.manifest">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Out</title>
    <link href="../../../csss/ders.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="icon.svg">

      <!-- CodeMirror -->
  <link rel="stylesheet" href="../../../codemirror/theme/monokai.css">

</head>
<body>
    <section id="menu">
        <div class="menu-sol">
            <a id="logo" href="../index.php">CodeOut</a>  
        </div>

    </section>

    <section id="anasayfa">
        <div id="dersler">
            <main>

                <div class="sol">
                   <form class="yazı"action="">
                        <h3 style="text-align: center;">Html ilk derse hoş geldiniz</h3>
                        <p>Bu derste html dosyası hakkında Temel Bilgileri öğreneceksiniz</p>
                        <p>asdasdasd</p>
                   </form>
                </div>  

                <div class="ort">   <!-- sağ -->
                    <iframe id="preview" width="100%" height= "10"></iframe>
                </div>

                <div class="sag">   <!-- orta -->

                <textarea id="codeMirrorDemo" class="p-3">
<div class="info-box bg-gradient-info">
  <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
  <div class="info-box-content">
    <span class="info-box-text">Bookmarks</span>
    <span class="info-box-number">41,410</span>
    <div class="progress">
      <div class="progress-bar" style="width: 70%"></div>
    </div>
    <span class="progress-description">
      70% Increase in 30 Days
    </span>
  </div>
</div>
              </textarea>

                    <!-- javascript -->
                    <script src="../../../codemirror/codemirror.js"></script>
                    <script src="../../../codemirror/mode/css/css.js"></script>
                    <script src="../../../codemirror/mode/xml/xml.js"></script>
                    <script src="../../../codemirror/mode/htmlmixed/htmlmixed.js"></script>
                   
                </div>

                         
            </main>
        </div>        
    </section>

    <script>
  $(function () {
    
    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>

 
    <script type="text/javascript">
    var editorPane =document.getElementById('codemirror-textarea'), 
        previewPane = document.getElementById('preview'),
        downloadLink = document.getElementById('download'),
        fileName = '';

    // Editor Interactions
    onload = editorPane.onkeyup = function() {
      refreshView();
      if(fileName == ''){ switchNote() };
      localStorage[fileName] = editorPane.value;
      document.body.id = 'tapZap';
      tapZap();
    };
    editorPane.onfocus= function() {
      this.style.webkitTransform = 'translate3D(0px, -10000px,0)';
      webkitRequestAnimationFrame(function() {
        this.style.webkitTransform = '';
      }.bind(this));
    };
    editorPane.onkeydown = function(event) {
      if(event.keyCode === 9) {
        softTab('  '); // tabs set at 2 spaces
        event.preventDefault();
      }
    }

    // Editor Functions
    function refreshView() {
      editorPane.style.height = (window.innerHeight - 110) + 'px';
      previewPane.style.height = (window.innerHeight - 110) + 'px';
      (previewPane.contentWindow.document).write(editorPane.value);
      (previewPane.contentWindow.document).close();
      editorPane.focus();
    }
    function softTab(spaces) {
      if(document.selection) {
        editorPane.focus();
        var tab = document.selection.createRange();
        tab.text = spaces;
        return;
      }
      else if(editorPane.selectionStart || editorPage.selectionStart == '0') {
        var startPos = editorPane.selectionStart,
            endPos = editorPane.selectionEnd,
            scrollTop = editorPane.scrollTop;
            editorPane.value = editorPane.value.substring(0, startPos) + spaces + editorPane.value.substring(endPos, editorPane.value.length);
            editorPane.focus();
            editorPane.selectionStart = startPos + spaces.length;
            editorPane.selectionEnd = startPos + spaces.length;
      } else {
        editorPane.value += textArea.value;
        editorPane.focus();
      }
    };
    function switchNote() {
      
      if(fileName == null || fileName == '') { fileName = 'scratchpad'; editorPane.value = localStorage[fileName] }
      if(localStorage[fileName] != ''){ editorPane.value = localStorage[fileName] }
      if(editorPane.value == 'undefined'){ editorPane.value = ''; }
      downloadLink.setAttribute('download', fileName + '.html');
      document.getElementById('filename').innerHTML = ': ' + fileName;
      document.title = 'Tinkerpad:' + fileName;
      refreshView();
    };
    function swingPane(reveal, conceal) {
      var revealPane = document.getElementById(reveal),
          concealPane = document.getElementById(conceal);
      if(revealPane.style.width != '100%') {
        concealPane.setAttribute('style', 'width: 0; margin: 0; padding: 0;');
        revealPane.setAttribute('style', 'width: 100%; margin-left: 0; opacity: 1;');
      } else {
        concealPane.setAttribute('style', 'width: 49.25%;');
        revealPane.setAttribute('style', 'width: 49.25%;');
      }
      refreshView();
    };
    function exportNote() {
      downloadLink.href = 'data:text/html;charset=utf-8,' + encodeURIComponent(editorPane.value);
      downloadLink.click();
    };

    // tapZap eliminates the 300ms standard delay added afer `touchstart` for mobile users, for quicker user interactions
    function tapZap(element, handler) {
      this.element = element;
      this.handler = handler;
      element.addEventListener('touchstart', this, false);
      element.addEventListener('click', this, false);
    };
    tapZap.prototype.handleEvent = function(event) {
      switch (event.type) {
        case 'touchstart': this.onTouchStart(event); break;
        case 'touchmove': this.onTouchMove(event); break;
        case 'touchend': this.onClick(event); break;
        case 'click': this.onClick(event); break;
      }
    };
    tapZap.prototype.onTouchStart = function(event) {
      event.preventDefault();
      event.stopPropagation();
      this.element.addEventListener('touchend', this, false);
      document.body.addEventListener('touchmove', this, false);
      this.startX = event.touches[0].clientX;
      this.startY = event.touches[0].clientY;
      isMoving = false;
    };
    tapZap.prototype.onTouchMove = function(event) {
      if(Math.abs(event.touches[0].clientX - this.startX) > 10 ||
          Math.abs(event.touches[0].clientY - this.startY) > 10) {
        this.reset();
      }
    };
    tapZap.prototype.onClick = function(event) {
      this.reset();
      this.handler(event);
      if(event.type == 'touchend') {
        preventGhostClick(this.startX, this.startY);
      }
    };
    tapZap.prototype.reset = function() {
      this.element.removeEventListener('touchend', this, false);
      document.body.removeEventListener('touchmove', this, false);
    };
    function preventGhostClick(x, y) {
      coordinates.push(x, y);
      window.setTimeout(ghostPop, 2500);
    };
    function ghostPop() {
      coordinates.splice(0, 2);
    };
    function ghostClick(event) {
      for (var i = 0; i < coordinates.length; i += 2) {
        var x = coordinates[i];
        var y = coordinates[i + 1];
        if(Math.abs(event.clientX - x) < 25 && Math.abs(event.clientY - y) < 25) {
          event.stopPropagation();
          event.preventDefault();
        }
      }
    };
    document.addEventListener('click', ghostClick.onClick, true);
    var coordinates = [];
    function initTapZap() {
      new tapZap(document.getElementbyId('tapZap'), goSomewhere);
    }
    function goSomewhere() {
      var theTarget = document.elementFromPoint(this.startX, this.startY);
      if(theTarget.nodeType == 3) theTarget = theTarget.parentNode;
      var theEvent = document.createEvent('MouseEvents');
      theEvent.initEvent('click', true, true);
      theTarget.dispatchEvent(theEvent);
    };
  </script>
    
</body>
</html>