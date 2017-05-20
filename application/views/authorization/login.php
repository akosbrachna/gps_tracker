<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?php echo favicon_path;?>?v=2">
    <meta name="viewport" content="width=device-width, user-scalable = no">
    <meta charset="utf-8">
    <script src="<?php echo base_url('web/js/libs/jsencrypt.min.js');?>"></script>
    <title>GPS Tracker</title>
    <style>
    body{
        background-color: rgb(245,245,245);
    }
    #login_start_page{
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -220px;
        margin-left: -160px;
        color: rgb(0,0,205);
        font-weight: bold;
        padding: 10px 30px 40px 50px;
        border: 2px rgb(200,200,255) solid;
        background-color: rgb(255,255,255);
    }
    #login_start_page input[type="checkbox"]{
        -ms-transform: scale(1.5); /* IE */
        -moz-transform: scale(1.5); /* FF */
        -webkit-transform: scale(1.5); /* Safari and Chrome */
        -o-transform: scale(1.5); /* Opera */
        padding: 10px;
        background-color: black !important;
    }
    #login_start_page a{
        margin-left: 40px;
    }
    #msie_no_support{
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -180px;
        margin-left: -380px;
        display: none;
        font-size: 20px;
        color: red;
    }
</style>
</head>
<body>
<div id="login_start_page">
    <h2 style="margin-left: -20px;">Welcome to GPS tracker</h2>
<h3>Login  <a href="<?php echo base_url('signup') ?>">Register</a></h3>

<?php echo form_open('', array('onsubmit' => "encrypt()")); ?>

<input name="pubkey" id="pubkey" value="<?php echo $pubkey; ?>" style="display: none;" />

Email address:<p><?php echo form_input('email', $this->input->post('email')); ?></p>

Password:<p> <?php echo form_password(array('name' => 'password',
                                             'id' => 'password',
                                             'value' => $this->input->post('email'))); ?></p>
<br/>
<label style="display: inline;" for="phone">
    Logging in on phone?
</label>
<?php echo form_checkbox('phone', '1', false, 'id="phone"'); ?></p>
<br/>
<?php echo form_submit('submit', 'Login'); ?>

<a href="<?php echo base_url('password_reset') ?>">Forgot password?</a>

<?php echo form_close(); ?>

<?php echo validation_errors(); ?>
<?php if (isset($message)) echo $message; ?>

</div>

<div id="msie_no_support">
    We are aware of the security issues on Internet Explorer, thus we do not support it. <br /><br />
    Please use some other browsers such as Firefox, Google Chrome, Safari etc. <br /><br />
    Thank you.
</div>
    
<script>
function encrypt()
{
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey(document.getElementById('pubkey').value);
    var encrypted = encrypt.encrypt(document.getElementById('password').value);
    document.getElementById('password').value = "superpassword";
    document.getElementById('pubkey').value = encrypted;
}
</script>
<script>
    var ua = window.navigator.userAgent
    var msie = ua.indexOf ( "MSIE " )
    if ( msie > 0 )
    {
       var login = document.getElementById('login_start_page');
       login.parentNode.removeChild(login);
       document.getElementById("msie_no_support").style.display = "block";
    }
</script>
</body>
</html>