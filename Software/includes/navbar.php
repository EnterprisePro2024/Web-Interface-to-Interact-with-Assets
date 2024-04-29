<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="assets/stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">
</head>

<nav>
    <a href="home.php">
        <img src="logo.png" class="logo" />
    </a>
    <div class="navbar-container">
    <ul>
        <?php
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>
            <li><a href="home.php">Home</a></li>
            <li><a href="upload.php">Upload</a></li>
            <li><a href="sharefile.php">Share Files</a></li>
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) { ?>
                <li><a href="admin.php">Admin</a></li>
            <?php } ?>
            <li><a href="logout.php">Logout</a></li>
        <?php } else { ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php } ?>
        <li><a href="faqs.php">FAQs</a></li>
    </ul>
    <div class="button-container">
        <!-- accessibility buttons -->
    <div class="dropdown-button">
        <button class="dropdown-btn">Font Size</button>
        <div class="dropdown-content">
            <!-- Dropdown content for font size -->
            <a href="#" onclick="changeFontSize('increase')">A+</a>
            <a href="#" onclick="changeFontSize('original')">A</a>
            <a href="#" onclick="changeFontSize('decrease')">A-</a>
        </div>
    </div>

    <div class="dropdown-button">
        <button class="dropdown-btn">Language</button>
        <div class="dropdown-content">
            <!-- Dropdown content for language -->
            <div id="google_translate_element"></div>
        </div>
    </div>

    <div class="dropdown-button">
        <button class="dropdown-btn">Text-to-Speech</button>
        <div class="dropdown-content">
            <!-- Dropdown content for text-to-speech -->
            <a href="#" onclick="startSpeech()">Play all text</a>
            <a href="#" onclick="speedUpSpeech()" aria-label="Increase Speed"><i class="fas fa-fast-forward"></i></a>
            <a href="#" onclick="playSpeech()" aria-label="Play"><i class="fa-solid fa-play"></i></a>
            <a href="#" onclick="pauseSpeech()" aria-label="Pause text"><i class="fa-solid fa-pause"></i></a>
            <a href="#" onclick="stopSpeech()" aria-label="Stop text"><i class="fa-solid fa-stop"></i></a>
            <a href="#" onclick="slowDownSpeech()" aria-label="Decrease Speed"><i class="fas fa-fast-backward"></i></a>
            <a href="#" onclick="speakSelectedText()">Play selected text</a>
        </div>
    </div>

    <div class="social-media">
        <a href="https://www.facebook.com/bradfordmdc"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="https://twitter.com/bradfordmdc"><i class="fab fa-twitter"></i></a>
        <a href="https://www.youtube.com/user/bradfordmdcvideo"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
  
    <div class="search-container">
    <div class="search">
        <form action="/search-results" method="get">
            <label id="searchLabel" for="query"></label>
            <input type="text" name="query" id="query" placeholder="search this site">
            <button type="submit">
                <i class="fa-solid fa-magnifying-glass fa-flip-horizontal"></i>
            </button>
        </form>
    </div>
    </div>
</div>
</nav>

<script>
    //function to change font size
    function changeFontSize(option) {
        var currentFontSize = parseInt(document.documentElement.style.fontSize) || 16; 
        var newFontSize;

        switch (option) {
            case 'increase':
                newFontSize = currentFontSize + 2;
                break;
            case 'decrease':
                newFontSize = currentFontSize - 2; 
                break;
            case 'original':
                newFontSize = 16;
                break;
            default:
                return; 
        }

        document.documentElement.style.fontSize = newFontSize + 'px';
    }

    //text-to-speech functions:

    var utterance;

    function speakText() {
        var textToSpeak = document.body.innerText;
        var speechSynthesis = window.speechSynthesis;
        utterance = new SpeechSynthesisUtterance(textToSpeak);
        speechSynthesis.speak(utterance);
    }

    function startSpeech() {
        stopSpeech(); 
        speakText(); 
        readButtonLabels();
    }

    function pauseSpeech() {
        if (utterance) {
            window.speechSynthesis.pause();
        }
    }

    function playSpeech() {
        if (utterance && window.speechSynthesis.paused) {
            window.speechSynthesis.resume(); 
        }
    }

    function stopSpeech() {
        if (utterance) {
            window.speechSynthesis.cancel();
        }
    }

    function speedUpSpeech() {
        if (utterance) {
            utterance.rate = utterance.rate * 2;
            window.speechSynthesis.cancel(); 
            window.speechSynthesis.speak(utterance); 
        }
    }

    function slowDownSpeech() {
            utterance.rate = utterance.rate * 0.5;
            window.speechSynthesis.cancel(); 
            window.speechSynthesis.speak(utterance); 
        }

    //Function to speak selected text
    function speakSelectedText() {
        var selectedText = getSelectedText();
        if (selectedText) {
            var utterance = new SpeechSynthesisUtterance();
            utterance.text = selectedText;
            window.speechSynthesis.speak(utterance);
        } else {
            alert("No text selected. Please select some text to speak.");
        }
    }

    //function to get selected text
    function getSelectedText() {
        var selectedText = "";
        if (window.getSelection) { 
            selectedText = window.getSelection().toString();
        } else if (document.selection && document.selection.type != "Control") {
            selectedText = document.selection.createRange().text;
        }
        return selectedText;
    }

    // Function to read aria labels of buttons 
    function readButtonLabels() {
        var buttons = document.querySelectorAll('a[aria-label]');
        // Loop through each button to check for label - reads label if found
        buttons.forEach(function(button) {
        var ariaLabel = button.getAttribute('aria-label');
        if (ariaLabel) {
            speakText(ariaLabel);
            }
        });
    }

    // function to translate website language
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({ 
            pageLanguage: 'en', 
            includedLanguages: 'ar,bn,zh-CN,zh-TW,cs,da,nl,en,fi,fr,de,el,hi,hu,id,it,ja,ko,ms,no,pl,pt,ro,ru,sk,es,sw,sv,th,tr,uk,ur,vi',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE 
        }, 'google_translate_element');
    }

    // function to toggle the display of dropdown content
    function toggleDropdown(event) {
    var dropdownContent = event.target.nextElementSibling;
    if (dropdownContent.classList.contains('dropdown-content')) {
        dropdownContent.classList.toggle('show');
        event.stopPropagation();
    }
    }

    // add event listener to button container
    document.getElementById("dropdown-button").addEventListener("click", function(event) {
    toggleDropdown(event);
    });
    </script>

<script async src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</html>
