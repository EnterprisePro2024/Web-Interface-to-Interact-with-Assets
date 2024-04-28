<?php require_once("includes/setup.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <Title>FAQs|Bradford Council</Title>
    <link rel="stylesheet" href="stylesheet.css">

    <style>
        .faq_container {
            max-width: 800px;
            margin: 0 auto 0 20px;
            padding: 20px;
        }

        .faq_question {
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .faq_answer_container {
            padding: 10px;
            border-left: 5px solid #007bff;
            margin-bottom: 20px;
        }

        .faq_answer {
            margin-top: 10px;
        }
    </style>
</head>

<body class="main">
    <?php require_once("includes/navbar.php"); ?>


    <div class="faq_container">
        
        <div class="faq">
            <div class="faq_question open">How do I log in to my account?</div>
            <div class="faq_answer_container" style="display: block;">
                <div class="faq_answer">To log in to your account, click on the "Log In" link in the navigation menu. Enter your username and password, then click the "Log In" button. You can only log in if you are a registered and approved user.</div>
            </div>
        </div>

        <div class="faq">
            <div class="faq_question">How do I upload assets with geographical data?</div>
            <div class="faq_answer_container">
                <div class="faq_answer">To upload assets, you first need to register and wait for approval from the admin. Once approved, log in to your account, click on the "Upload" tab at the top of the page, and then click the "Upload CSV File" button. Select the file containing the assets you want to upload.</div>
            </div>
        </div>

        <div class="faq">
            <div class="faq_question">Can I view assets belonging to other departments?</div>
            <div class="faq_answer_container">
                <div class="faq_answer">No, by default you can only view assets managed and uploaded by your department, however, exceptions apply to files that have been shared with your department.</div>
            </div>
        </div>

        <div class="faq">
            <div class="faq_question">Do I need to register to upload assets?</div>
            <div class="faq_answer_container">
                <div class="faq_answer">Yes, you need to register and wait for approval from the admin before you can upload assets. Registration ensures that only authorised users can upload assets to the system.</div>
            </div>
        </div>
    
        <div class="faq">
            <div class="faq_question">How long does it take for my registration to be approved?</div>
            <div class="faq_answer_container">
                <div class="faq_answer">The approval process may vary, but typically it takes a few business days. Once your registration is approved, you will be able to access your account.</div>
            </div>
        </div>

        <div class="faq">
            <div class="faq_question">Can I edit or delete assets after uploading them?</div>
            <div class="faq_answer_container">
                <div class="faq_answer">Yes, you can edit or delete assets after uploading them. Log in to your account, navigate to the "Assets" section, and you will find options to edit or delete your uploaded assets.</div>
            </div>
        </div>

        <div class="faq">
            <div class="faq_question">How can I contact the admin for assistance?</div>
            <div class="faq_answer_container">
                <div class="faq_answer">You can contact the admin by sending an email to admin@bradford.gov. Please include your username and a detailed description of your issue for faster assistance.</div>
            </div>
        </div>

        <div class="faq">
            <div class="faq_question">I forgot my password. How do I reset it?</div>
            <div class="faq_answer_container">
                <div class="faq_answer">If you forgot your password, you can reset it by clicking on the "Forgot Password" link on the login page. Follow the instructions to reset your password.</div>
            </div>
        </div>

    </div>
</body>

<?php require_once("includes/footer.php"); ?>

</html>
