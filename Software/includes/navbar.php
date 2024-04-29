<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <a href="#" onclick="slowDownSpeech()">Slow Down</a>
            <a href="#" onclick="startSpeech()">Start</a>
            <a href="#" onclick="playSpeech()">Play</a>
            <a href="#" onclick="pauseSpeech()">Pause</a>
            <a href="#" onclick="stopSpeech()">Stop</a>
            <a href="#" onclick="speedUpSpeech()">Speed Up</a>
            <a href="#" onclick="speakSelectedText()">Selected Text</a>
        </div>
    </div>

    <div class="social-media">
        <a href="https://www.facebook.com/bradfordmdc"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="https://twitter.com/bradfordmdc"><i class="fab fa-twitter"></i></a>
        <a href="https://www.youtube.com/user/bradfordmdcvideo"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</div>
  
<div class="search-container">
    <div class="search">
        <form action="/search-results" method="get">
            <label id="searchLabel" for="query"></label>
            <input type="text" name="query" id="query" placeholder="Search this site">
            <button type="submit">
                <i class="fa-solid fa-magnifying-glass fa-flip-horizontal"></i>
            </button>
        </form>
    </div>
</div>
    </div>

</nav>



</div>

<style>


.navbar-container {
    display: flex;
    align-items: center;
}

.search form {
    display: flex;
    position: absolute;
    align-items: center; 
}

.search input[type="text"] {
    font-size: 1.6em;
    padding: 4px 8px;
    margin: 0; 
    border: 1px solid #ccc;
    border-right: none; 
    font-weight: 50;
    vertical-align: bottom;
    width: 320px;
    height: 45px;
}

.search button {
    background-color: #006871; 
    border: none; 
    cursor: pointer; 
    margin: 0;
    border: 1px solid #ccc;
}

.search button i {
    font-size: 3em; 
    color: white; 
    padding: 6px; 
}

.search{
    /* display: flex; */
    align-items: left;
    top: 95px;
    right: 500px;
    position: absolute;
}

.social-media a {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 23px; 
    height: 23px; 
    border-radius: 50%; 
    background-color: black; 
    margin-right: 16px; 
}

.social-media a i {
    font-size: 14px; 
    color: white; 
}

.button-container{
    display: flex;
    align-items: center;
    position: absolute;
    top: 5px; 
    right: 80px;
}
    
.dropdown-button {
    margin-right: 5px;
    position: relative;
    display: inline-block;
}

.dropdown-btn {
    background-color: transparent;
    color: black;
    padding: 15px;
    border: none;
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 130px;
    padding: 8px 10px;
    border-radius: 2px;
    left: 50%;
    transform: translateX(-50%);
    white-space: nowrap;
    text-align: center;
}

.dropdown-content a {
    display: inline-block; 
    margin-right: 15px; 
    color: black;
}

.dropdown-btn:hover {
    text-decoration: underline;
}

/* Show the dropdown content when hovering or clicking on the button */
.dropdown-button:hover .dropdown-content {
    display: block;
}
/* Hide Google Translate widget */
.goog-te-gadget-icon {
    display: none;
}

.goog-te-banner-frame.skiptranslate {
    display: none !important;
}
</style>


<script>
    //function to change font size
    function changeFontSize(option) {
        var currentFontSize = parseInt(document.documentElement.style.fontSize) || 16; // Default font size is 16px
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
            utterance.rate = defaultRate * 2;
            window.speechSynthesis.cancel(); 
            window.speechSynthesis.speak(utterance); 
        }
    }

    function slowDownSpeech() {
            utterance.rate = defaultRate * 0.5;
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


    //function to translate website language
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({ 
            pageLanguage: 'en', 
            includedLanguages: 'ar,bn,zh-CN,zh-TW,cs,da,nl,en,fi,fr,de,el,hi,hu,id,it,ja,ko,ms,no,pl,pt,ro,ru,sk,es,sw,sv,th,tr,uk,ur,vi',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE 
        }, 'google_translate_element');
    }

// Function to toggle the display of dropdown content
function toggleDropdown(event) {
    var dropdownContent = event.target.nextElementSibling;
    if (dropdownContent.classList.contains('dropdown-content')) {
        dropdownContent.classList.toggle('show');
    }
}

// Add event listener to the button container
document.querySelector('.button-container').addEventListener('click', toggleDropdown)
</script>

<script async src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</html>
